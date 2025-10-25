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

/**
 * Plugin Name: RMW Leasing Endpoint
 * Description: REST endpoint for Commercial Leasing inquiries; validates, rate-limits, emails.
 * Version: 1.0.0
 */

defined('ABSPATH') || exit;

add_action('rest_api_init', function () {
  register_rest_route('rmw/v1', '/leasing', [
    'methods'             => 'POST',
    'callback'            => 'rmw_handle_leasing_inquiry',
    'permission_callback' => '__return_true', // we'll verify nonce manually
    'args' => [
      'submission_date'    => ['required' => false, 'type' => 'string'],
      'first_name'         => ['required' => true,  'type' => 'string'],
      'last_name'          => ['required' => true,  'type' => 'string'],
      'phone_number'       => ['required' => false, 'type' => 'string'],
      'email'              => ['required' => true,  'type' => 'string'],
      'business_name'      => ['required' => false, 'type' => 'string'],
      'business_type'      => ['required' => true,  'type' => 'string'],
      'preferred_unit_size'=> ['required' => true,  'type' => 'string'],
      'move_in_timeline'   => ['required' => true,  'type' => 'string'],
      'notes'              => ['required' => false, 'type' => 'string'],
      'referral_source'    => ['required' => false, 'type' => 'string'],
      'website'            => ['required' => false, 'type' => 'string'], // honeypot
    ],
  ]);
});

/**
 * Handle POST /wp-json/rmw/v1/leasing
 */
function rmw_handle_leasing_inquiry(WP_REST_Request $req) {
  // 1) Nonce (sent as X-WP-Nonce)
  $nonce = $req->get_header('X-WP-Nonce');
  if (!wp_verify_nonce($nonce, 'wp_rest')) {
    return new WP_REST_Response(['success' => false, 'message' => 'Invalid security token.'], 403);
  }

  // 2) Honeypot — quietly accept to avoid tipping bots
  $hp = trim((string) ($req['website'] ?? ''));
  if ($hp !== '') {
    return new WP_REST_Response(['success' => true], 200);
  }

  // 3) Basic rate limit by IP (max 5/hour)
  $ip  = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
  $key = 'rmw_leasing_count_' . md5($ip);
  $count = (int) get_transient($key);
  if ($count >= 5) {
    return new WP_REST_Response(['success' => false, 'message' => 'Rate limit exceeded. Try again later.'], 429);
  }
  set_transient($key, $count + 1, HOUR_IN_SECONDS);

  // 4) Sanitize fields
  $submission_date     = sanitize_text_field($req['submission_date'] ?? '');
  $first_name          = sanitize_text_field($req['first_name'] ?? '');
  $last_name           = sanitize_text_field($req['last_name'] ?? '');
  $phone_number        = sanitize_text_field($req['phone_number'] ?? '');
  $email_raw           = sanitize_email($req['email'] ?? '');
  $business_name       = sanitize_text_field($req['business_name'] ?? '');
  $business_type       = sanitize_text_field($req['business_type'] ?? '');
  $preferred_unit_size = sanitize_text_field($req['preferred_unit_size'] ?? '');
  $move_in_timeline    = sanitize_text_field($req['move_in_timeline'] ?? '');
  $notes               = trim(wp_kses_post($req['notes'] ?? ''));
  $referral_source     = sanitize_text_field($req['referral_source'] ?? '');

  // Required validation
  if (
    !$first_name ||
    !$last_name ||
    !$email_raw ||
    !is_email($email_raw) ||
    !$business_type ||
    !$preferred_unit_size ||
    !$move_in_timeline
  ) {
    return new WP_REST_Response(['success' => false, 'message' => 'Validation failed.'], 422);
  }

  // 5) Compose email
  $to = apply_filters('rmw_leasing_to', get_option('admin_email')); // override via filter
  $subject_prefix = apply_filters('rmw_leasing_subject_prefix', '[Leasing Inquiry]');
  $subject = sprintf('%s %s %s', $subject_prefix, $first_name, $last_name);

  $lines = [
    'Submission Date: ' . ($submission_date ?: current_time('Y-m-d')),
    'Name: ' . $first_name . ' ' . $last_name,
    'Email: ' . $email_raw,
    'Phone: ' . $phone_number,
    'Business Name: ' . $business_name,
    'Business Type: ' . $business_type,
    'Preferred Unit Size: ' . $preferred_unit_size,
    'Move-in Timeline: ' . $move_in_timeline,
    'Referral Source: ' . $referral_source,
    'IP: ' . $ip,
    'Time: ' . current_time('mysql'),
    '',
    'Notes:',
    $notes ?: '(none)',
  ];
  $body = implode("\n", $lines);

  $headers = [
    'Content-Type: text/plain; charset=UTF-8',
    sprintf('Reply-To: %s %s <%s>', $first_name, $last_name, $email_raw),
  ];

  // 6) Send
  $sent = wp_mail($to, $subject, $body, $headers);
  if (!$sent) {
    return new WP_REST_Response(['success' => false, 'message' => 'Mail failed.'], 500);
  }

  /**
   * Action hook for logging/CRM/etc.
   * @param array $payload sanitized submission
   */
  do_action('rmw_leasing_received', [
    'submission_date'      => $submission_date,
    'first_name'           => $first_name,
    'last_name'            => $last_name,
    'phone_number'         => $phone_number,
    'email'                => $email_raw,
    'business_name'        => $business_name,
    'business_type'        => $business_type,
    'preferred_unit_size'  => $preferred_unit_size,
    'move_in_timeline'     => $move_in_timeline,
    'notes'                => $notes,
    'referral_source'      => $referral_source,
    'ip'                   => $ip,
    'timestamp'            => current_time('mysql'),
  ]);

  return new WP_REST_Response(['success' => true], 200);
}

add_action('rest_api_init', function () {
  register_rest_route('rmw/v1', '/residential-leasing', [
    'methods'             => 'POST',
    'callback'            => 'rmw_handle_residential_leasing',
    'permission_callback' => '__return_true', // verify nonce manually
    'args' => [
      'submission_date' => ['required' => false, 'type' => 'string'],
      'first_name'      => ['required' => true,  'type' => 'string'],
      'last_name'       => ['required' => true,  'type' => 'string'],
      'phone_number'    => ['required' => false, 'type' => 'string'],
      'email'           => ['required' => true,  'type' => 'string'],
      'unit_type'       => ['required' => true,  'type' => 'string'], // studio | 1br | 2br | 3br | all
      'pets'            => ['required' => true,  'type' => 'string'], // yes | no
      'comments'        => ['required' => false, 'type' => 'string'],
      'website'         => ['required' => false, 'type' => 'string'], // honeypot
    ],
  ]);
});

function rmw_handle_residential_leasing(WP_REST_Request $req) {
  // 1) Nonce (X-WP-Nonce)
  $nonce = $req->get_header('X-WP-Nonce');
  if (!wp_verify_nonce($nonce, 'wp_rest')) {
    return new WP_REST_Response(['success' => false, 'message' => 'Invalid security token.'], 403);
  }

  // 2) Honeypot — quietly accept
  $hp = trim((string) ($req['website'] ?? ''));
  if ($hp !== '') {
    return new WP_REST_Response(['success' => true], 200);
  }

  // 3) Rate limit (5/hour per IP)
  $ip  = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
  $key = 'rmw_res_leasing_count_' . md5($ip);
  $count = (int) get_transient($key);
  if ($count >= 5) {
    return new WP_REST_Response(['success' => false, 'message' => 'Rate limit exceeded. Try again later.'], 429);
  }
  set_transient($key, $count + 1, HOUR_IN_SECONDS);

  // 4) Sanitize
  $submission_date = sanitize_text_field($req['submission_date'] ?? '');
  $first_name      = sanitize_text_field($req['first_name'] ?? '');
  $last_name       = sanitize_text_field($req['last_name'] ?? '');
  $phone_number    = sanitize_text_field($req['phone_number'] ?? '');
  $email           = sanitize_email($req['email'] ?? '');
  $unit_type       = sanitize_text_field($req['unit_type'] ?? '');
  $pets            = sanitize_text_field($req['pets'] ?? '');
  $comments        = trim(wp_kses_post($req['comments'] ?? ''));

  // 5) Validate
  $valid_unit = in_array($unit_type, ['studio','1br','2br','3br','all'], true);
  $valid_pets = in_array($pets, ['yes','no'], true);

  if (!$first_name || !$last_name || !$email || !is_email($email) || !$valid_unit || !$valid_pets) {
    return new WP_REST_Response(['success' => false, 'message' => 'Validation failed.'], 422);
  }

  if ($pets === 'yes' && $comments === '') {
    return new WP_REST_Response(['success' => false, 'message' => 'Please include pet details in comments.'], 422);
  }

  // 6) Email
  $to = apply_filters('rmw_res_leasing_to', get_option('admin_email')); // override via filter
  $subject_prefix = apply_filters('rmw_res_leasing_subject_prefix', '[Residential Leasing]');
  $subject = sprintf('%s %s %s', $subject_prefix, $first_name, $last_name);

  $lines = [
    'Submission Date: ' . ($submission_date ?: current_time('Y-m-d')),
    'Name: ' . $first_name . ' ' . $last_name,
    'Email: ' . $email,
    'Phone: ' . $phone_number,
    'Unit Type: ' . strtoupper($unit_type),
    'Pets: ' . strtoupper($pets),
    'IP: ' . $ip,
    'Time: ' . current_time('mysql'),
    '',
    'Comments:',
    $comments ?: '(none)',
  ];
  $body = implode("\n", $lines);

  $headers = [
    'Content-Type: text/plain; charset=UTF-8',
    sprintf('Reply-To: %s %s <%s>', $first_name, $last_name, $email),
  ];

  $sent = wp_mail($to, $subject, $body, $headers);
  if (!$sent) {
    return new WP_REST_Response(['success' => false, 'message' => 'Mail failed.'], 500);
  }

  /**
   * Hook for logging/CRM/etc.
   */
  do_action('rmw_residential_leasing_received', [
    'submission_date' => $submission_date,
    'first_name'      => $first_name,
    'last_name'       => $last_name,
    'phone_number'    => $phone_number,
    'email'           => $email,
    'unit_type'       => $unit_type,
    'pets'            => $pets,
    'comments'        => $comments,
    'ip'              => $ip,
    'timestamp'       => current_time('mysql'),
  ]);

  return new WP_REST_Response(['success' => true], 200);
}


/**
 * Plugin Name: RMW Parking Inquiry Endpoint
 * Description: REST endpoint for Parking inquiries; validates, rate-limits, emails.
 * Version: 1.0.0
 */

defined('ABSPATH') || exit;

add_action('rest_api_init', function () {
  register_rest_route('rmw/v1', '/parking-inquiry', [
    'methods'             => 'POST',
    'callback'            => 'rmw_handle_parking_inquiry',
    'permission_callback' => '__return_true', // verify nonce inside
    'args' => [
      'submission_date' => ['required' => false, 'type' => 'string'],
      'first_name'      => ['required' => true,  'type' => 'string'],
      'last_name'       => ['required' => true,  'type' => 'string'],
      'email'           => ['required' => true,  'type' => 'string'],
      'phone_number'    => ['required' => false, 'type' => 'string'],
      'website'         => ['required' => false, 'type' => 'string'], // honeypot
    ],
  ]);
});

function rmw_handle_parking_inquiry(WP_REST_Request $req) {
  // 1) Nonce
  $nonce = $req->get_header('X-WP-Nonce');
  if (!wp_verify_nonce($nonce, 'wp_rest')) {
    return new WP_REST_Response(['success' => false, 'message' => 'Invalid security token.'], 403);
  }

  // 2) Honeypot — quietly accept
  $hp = trim((string) ($req['website'] ?? ''));
  if ($hp !== '') {
    return new WP_REST_Response(['success' => true], 200);
  }

  // 3) Rate limit (5/hour per IP)
  $ip  = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
  $key = 'rmw_parking_count_' . md5($ip);
  $count = (int) get_transient($key);
  if ($count >= 5) {
    return new WP_REST_Response(['success' => false, 'message' => 'Rate limit exceeded. Try again later.'], 429);
  }
  set_transient($key, $count + 1, HOUR_IN_SECONDS);

  // 4) Sanitize
  $submission_date = sanitize_text_field($req['submission_date'] ?? '');
  $first_name      = sanitize_text_field($req['first_name'] ?? '');
  $last_name       = sanitize_text_field($req['last_name'] ?? '');
  $email           = sanitize_email($req['email'] ?? '');
  $phone_number    = sanitize_text_field($req['phone_number'] ?? '');

  // 5) Validate
  if (!$first_name || !$last_name || !$email || !is_email($email)) {
    return new WP_REST_Response(['success' => false, 'message' => 'Validation failed.'], 422);
  }

  // 6) Email
  $to = apply_filters('rmw_parking_to', get_option('admin_email'));
  $subject_prefix = apply_filters('rmw_parking_subject_prefix', '[Parking Inquiry]');
  $subject = sprintf('%s %s %s', $subject_prefix, $first_name, $last_name);

  $lines = [
    'Submission Date: ' . ($submission_date ?: current_time('Y-m-d')),
    'Name: ' . $first_name . ' ' . $last_name,
    'Email: ' . $email,
    'Phone: ' . $phone_number,
    'IP: ' . $ip,
    'Time: ' . current_time('mysql'),
  ];
  $body = implode("\n", $lines);

  $headers = [
    'Content-Type: text/plain; charset=UTF-8',
    sprintf('Reply-To: %s %s <%s>', $first_name, $last_name, $email),
  ];

  $sent = wp_mail($to, $subject, $body, $headers);
  if (!$sent) {
    return new WP_REST_Response(['success' => false, 'message' => 'Mail failed.'], 500);
  }

  do_action('rmw_parking_inquiry_received', [
    'submission_date' => $submission_date,
    'first_name'      => $first_name,
    'last_name'       => $last_name,
    'email'           => $email,
    'phone_number'    => $phone_number,
    'ip'              => $ip,
    'timestamp'       => current_time('mysql'),
  ]);

  return new WP_REST_Response(['success' => true], 200);
}
