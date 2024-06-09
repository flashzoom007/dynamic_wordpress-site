<?php
/* Template Name: Register Template */

get_header();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // form submission code
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $child_first_name = sanitize_text_field($_POST['child_first_name']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // function to call the register the user
        $response = wp_remote_post(rest_url('wp/v2/users/register'), array(
            'method' => 'POST',
            'body' => json_encode(
                array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'child_first_name' => $child_first_name,
                    'email' => $email,
                    'password' => $password,
                )
            ),
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
        )
        );

        // Check the errors while registrtion
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            echo "Something went wrong: $error_message";
        } else {
            echo "<p class='successfull-user'>User registered successfully!</p>";
        }
    }
}
?>

<form id="registrationForm" method="post">
    <label for="first_name">Your First Name*:</label>
    <input type="text" id="first_name" name="first_name" maxlength="50" required>

    <label for="last_name">Your Last Name*:</label>
    <input type="text" id="last_name" name="last_name" maxlength="50" required>

    <label for="child_first_name">Your Child's First Name*:</label>
    <input type="text" id="child_first_name" name="child_first_name" maxlength="50" required>

    <label for="email">Your Email Address*:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password*:</label>
    <input type="password" id="password" name="password" minlength="8" required>

    <label for="confirm_password">Confirm Password*:</label>
    <input type="password" id="confirm_password" name="confirm_password" minlength="8" required>

    <button type="submit">Register</button>
</form>

<script>
    document.getElementById('registrationForm').addEventListener('submit', function (event) {
        let valid = true;
        const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

        // Get form values
        const firstName = document.getElementById('first_name').value;
        const lastName = document.getElementById('last_name').value;
        const childFirstName = document.getElementById('child_first_name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        // Clear previous error messages
        document.querySelectorAll('.error').forEach(el => el.remove());

        // Validate email
        if (!email.match(emailPattern)) {
            valid = false;
            showError('email', 'Invalid email address.');
        }

        // Validate password length
        if (password.length < 8) {
            valid = false;
            showError('password', 'Password must be at least 8 characters long.');
        }

        // Validate password match
        if (password !== confirmPassword) {
            valid = false;
            showError('confirm_password', 'Passwords do not match.');
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