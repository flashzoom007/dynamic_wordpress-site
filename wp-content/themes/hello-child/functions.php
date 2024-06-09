<?php

function register_child_theme_styles() {
    wp_register_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'style' );
}
add_action( 'wp_enqueue_scripts', 'register_child_theme_styles' );

// For widgets filter
add_filter( 'use_widgets_block_editor', '__return_false' );

// WordPress classic editor
add_filter('use_block_editor_for_post', '__return_false');


// Register Page 
function custom_user_registration() {
    register_rest_route('wp/v2/users', '/register', array(
        'methods' => 'POST',
        'callback' => 'handle_user_registration',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'custom_user_registration');

function handle_user_registration($request) {
    $first_name = sanitize_text_field($request->get_param('first_name'));
    $last_name = sanitize_text_field($request->get_param('last_name'));
    $child_first_name = sanitize_text_field($request->get_param('child_first_name'));
    $email = sanitize_email($request->get_param('email'));
    $password = $request->get_param('password');

    if (username_exists($email) || email_exists($email)) {
        return new WP_Error('registration_failed', 'Email already exists', array('status' => 400));
    }

    $user_id = wp_create_user($email, $password, $email);

    if (is_wp_error($user_id)) {
        return new WP_Error('registration_failed', $user_id->get_error_message(), array('status' => 400));
    }

    wp_update_user(array(
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
    ));

    update_user_meta($user_id, 'child_first_name', $child_first_name);

    return new WP_REST_Response(array('message' => 'User registered successfully'), 200);
}

// add style.css file 
function add_custom_styles() {
    // Enqueue your custom CSS file
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . './css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'add_custom_styles' );


// Account page go to direct login page if user is not register 
function register_user_update_endpoint() {
    register_rest_route('wp/v2/users', '/me/update', [
        'methods' => 'POST',
        'callback' => 'update_user_profile',
        'permission_callback' => function() {
            return is_user_logged_in();
        },
    ]);
}
add_action('rest_api_init', 'register_user_update_endpoint');

function update_user_profile($request) {
    $user_id = get_current_user_id();
    $first_name = sanitize_text_field($request->get_param('first_name'));
    $last_name = sanitize_text_field($request->get_param('last_name'));
    $child_first_name = sanitize_text_field($request->get_param('child_first_name'));
    $email = sanitize_email($request->get_param('email'));

    $errors = [];

    if (!is_email($email)) {
        $errors[] = 'Invalid email address.';
    } elseif (email_exists($email) && $email !== wp_get_current_user()->user_email) {
        $errors[] = 'Email already in use.';
    }

    if (!empty($errors)) {
        return new WP_Error('update_failed', implode(', ', $errors), ['status' => 400]);
    }

    wp_update_user([
        'ID' => $user_id,
        'user_email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
    ]);

    update_user_meta($user_id, 'child_first_name', $child_first_name);

    return new WP_REST_Response(['message' => 'Profile updated successfully...!'], 200);
}
