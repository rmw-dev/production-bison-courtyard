<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf('...');
});


add_filter( 'excerpt_length', function () { return 30; }, 999 );

add_filter('rmw_contact_to', function ($to) {
    // Get the ACF option field (Options Page context = 'option')
    $custom_email = get_field('contact_email_to', 'option');

    // If it's set and looks like a valid email, use it
    if (!empty($custom_email) && is_email($custom_email)) {
        return $custom_email;
    }

    // Otherwise fall back to whatever was passed in (admin_email)
    return $to;
});

add_filter('rmw_parking_to', function ($to) {
    // Get the ACF option field (Options Page context = 'option')
    $custom_email = get_field('contact_email_to', 'option');

    // If it's set and looks like a valid email, use it
    if (!empty($custom_email) && is_email($custom_email)) {
        return $custom_email;
    }

    // Otherwise fall back to whatever was passed in (admin_email)
    return $to;
});

add_filter('rmw_leasing_to', function ($to) {
    // Get the ACF option field (Options Page context = 'option')
    $custom_email = get_field('contact_email_to', 'option');

    // If it's set and looks like a valid email, use it
    if (!empty($custom_email) && is_email($custom_email)) {
        return $custom_email;
    }

    // Otherwise fall back to whatever was passed in (admin_email)
    return $to;
});

add_filter('rmw_leasing_res_to', function ($to) {
    // Get the ACF option field (Options Page context = 'option')
    $custom_email = get_field('contact_email_to', 'option');

    // If it's set and looks like a valid email, use it
    if (!empty($custom_email) && is_email($custom_email)) {
        return $custom_email;
    }

    // Otherwise fall back to whatever was passed in (admin_email)
    return $to;
});
