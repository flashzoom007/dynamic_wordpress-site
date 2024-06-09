<?php
/* Template Name: Account Settings */

get_header();

if (!is_user_logged_in()) {
    wp_redirect(site_url('/login-page/')); // Replace '/login-page/' with your actual login page URL
    exit;
}

$current_user = wp_get_current_user();
?>

<form id="accountSettingsForm" method="post">
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo esc_attr($current_user->first_name); ?>" required>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo esc_attr($current_user->last_name); ?>" required>

    <label for="child_first_name">Child’s First Name:</label>
    <input type="text" id="child_first_name" name="child_first_name" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'child_first_name', true)); ?>" required>

    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" value="<?php echo esc_attr($current_user->user_email); ?>" required>

    <button type="submit">Update Profile</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('accountSettingsForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const nonce = '<?php echo wp_create_nonce('wp_rest'); ?>';

        fetch('<?php echo esc_url(rest_url('wp/v2/users/me/update')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': nonce
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
            } else {
                alert('Profile updated successfully!');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });
});
</script>

<?php
get_footer();
?>
