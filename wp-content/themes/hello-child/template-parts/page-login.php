<?php
/* Template Name: Login Template*/

get_header();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $credentials = array(
        'user_login'    => sanitize_text_field($_POST['username']),
        'user_password' => $_POST['password'],
        'remember'      => isset($_POST['remember']) ? true : false,
    );

    $user = wp_signon($credentials, false);

    if (is_wp_error($user)) {
        $error_message = $user->get_error_message();
        echo "<p class='error-login'>$error_message</p>";
    } else {
        wp_redirect(home_url());
        exit;
    }
}

?>

<form id="loginForm" method="post">
    <label for="username">Username or Email:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="remember">
        <input type="checkbox" id="remember" name="remember"> Remember Me
    </label>

    <button type="submit">Login</button>
</form>

<script>
document.getElementById('loginForm').addEventListener('submit', function(event) {
    let valid = true;
    
    // Get form values
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Clear previous error messages
    document.querySelectorAll('.error').forEach(el => el.remove());

    // Validate username
    if (username === '') {
        valid = false;
        showError('username', 'Username is required.');
    }

    // Validate password
    if (password === '') {
        valid = false;
        showError('password', 'Password is required.');
    }

    if (!valid) {
        event.preventDefault();
    }
});

function showError(id, message) {
    const inputField = document.getElementById(id);
    const error = document.createElement('span');
    error.className = 'error';
    error.style.color = 'red';
    error.textContent = message;
    inputField.parentNode.insertBefore(error, inputField.nextSibling);
}
</script>

<?php
get_footer();
?>
