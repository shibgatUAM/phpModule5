<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = filter_input(INPUT_POST, 'new_username', FILTER_SANITIZE_SPECIAL_CHARS);
    $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($new_username && $new_password && $email) {
        $hashed_password = sha1($new_password);

        $users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $username_exists = false;
        $email_exists = false;

        foreach ($users as $user) {
            list($existing_username, $existing_password, $existing_email) = explode(',', $user);
            if ($existing_username === $new_username) {
                $username_exists = true;
            }
            if ($existing_email === $email) {
                $email_exists = true;
            }
        }

        if ($username_exists || $email_exists) {
            $_SESSION['registration_status'] = 'exists';
        } else {
            $user_data = "$new_username,$hashed_password,$email" . PHP_EOL;
            file_put_contents('users.txt', $user_data, FILE_APPEND);
            $_SESSION['registration_status'] = 'success';
        }
    } else {
        $_SESSION['registration_status'] = 'failure';
    }

    header('Location: auth.php');
    exit();
}
?>
