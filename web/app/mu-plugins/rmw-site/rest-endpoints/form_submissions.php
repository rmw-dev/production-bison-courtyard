<?php
/**
 * Plugin Name: RMW Contact Endpoint
 * Description: REST endpoint for contact form submissions; validates, rate-limits, emails.
 * Version: 1.0.0
 */

add_action('rest_api_init', function () {
  register_rest_route('rmw/v1', '/contact', [
    'methods'  => 'POST',
    'callback' => 'rmw_handle_contact',
    'permission_callback' => '__return_true',
    'args' => [
      'first_name'     => ['required' => true,  'type' => 'string'],
      'last_name'      => ['required' => true,  'type' => 'string'],
      'email'          => ['required' => true,  'type' => 'string'],
      'contact_number' => ['required' => false, 'type' => 'string'],
      'message'        => ['required' => true,  'type' => 'string'],
      'website'        => ['required' => false, 'type' => 'string'], // honeypot
    ],
  ]);
});

function rmw_handle_contact(WP_REST_Request $req) {
  // 1) Nonce (matches X-WP-Nonce from JS)
  $nonce = $req->get_header('X-WP-Nonce');
  if (!wp_verify_nonce($nonce, 'wp_rest')) {
    return new WP_REST_Response(['success' => false, 'message' => 'Invalid security token.'], 403);
  }

  // 2) Honeypot (quietly drop)
  if (trim($req->get_param('website') ?? '') !== '') {
    return new WP_REST_Response(['success' => true], 200);
  }

  // 3) Basic rate limit by IP (5 per hour)
  $ip  = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
  $key = 'rmw_contact_count_' . md5($ip);
  $count = (int) get_transient($key);
  if ($count >= 5) {
    return new WP_REST_Response(['success' => false, 'message' => 'Rate limit exceeded. Try again later.'], 429);
  }
  set_transient($key, $count + 1, HOUR_IN_SECONDS);

  // 4) Sanitize & validate
  $first = sanitize_text_field($req['first_name'] ?? '');
  $last  = sanitize_text_field($req['last_name'] ?? '');
  $email = sanitize_email($req['email'] ?? '');
  $phone = sanitize_text_field($req['contact_number'] ?? '');
  $msg   = trim(wp_kses_post($req['message'] ?? ''));

  if (!$first || !$last || !$msg || !$email || !is_email($email)) {
    return new WP_REST_Response(['success' => false, 'message' => 'Validation failed.'], 422);
  }

  // 5) Compose & send email
  $to = apply_filters('rmw_contact_to', get_option('admin_email')); // override via filter if desired
  $subject = sprintf('New Contact: %s %s', $first, $last);
  $body = implode("\n", [
    "Name: $first $last",
    "Email: $email",
    "Contact Number: $phone",
    "IP: $ip",
    "Time: " . current_time('mysql'),
    "",
    "Message:",
    $msg,
  ]);

  $headers = [
    'Content-Type: text/plain; charset=UTF-8',
    "Reply-To: {$first} {$last} <{$email}>",
  ];

  $sent = wp_mail($to, $subject, $body, $headers);

  if (!$sent) {
    return new WP_REST_Response(['success' => false, 'message' => 'Mail failed.'], 500);
  }

  return new WP_REST_Response(['success' => true], 200);
}
