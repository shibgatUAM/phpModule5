<?php
session_start([
    'cookie_lifetime' => 300,
]);

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}

$error = false;
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$fp = fopen("./users.txt", "r");

if ($username && $password) {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = false;
    $_SESSION['role'] = false;

    while ($data = fgetcsv($fp)) {
        if ($data[0] == $username && $data[1] == sha1($password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $data[2];
            header('location:auth.php');
            exit();
        }
    }

    if (!$_SESSION['loggedin']) {
        $error = true;
    }
}

if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    header('location:auth.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="login-page">
        <div class="form">
            <form method="POST" action="register.php" class="register-form">
                <input type="text" name="new_username" placeholder="username">
                <input type="password" name="new_password" placeholder="password">
                <input type="text" name="email" placeholder="email address">
                <button type="submit">create</button>
                <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
            <?php
            if (isset($_SESSION['registration_status']) && $_SESSION['registration_status'] === 'exists') {
                echo "<p style='color: red;'>Username or Email already exists. Please choose a different one.</p>";
            }
            unset($_SESSION['registration_status']);
            ?>
    

            <?php
            if ($_SESSION['loggedin']) {
                echo "Hello " . $_SESSION['username'] . ", Welcome! <br>";
                echo "<a href='index.php'>View Employee List<a>";
            }

            if ($error) {
                echo "<blockquote>Username and Password didn't match</blockquote>";
            }
            
            if (!$_SESSION['loggedin']) {
            ?>

                <form method="POST" class="login-form">
                    <input type="text" name="username" id="username" placeholder="username">
                    <input type="password" name="password" id="password" placeholder="password">
                    <button>login</button>
                    <p class="message">Not registered? <a href="#">Create an account</a></p>
                </form>
            <?php } else { ?>
                <a href="auth.php?logout=1" class="button-primary">Log Out (<?php echo $_SESSION['role'] ?>)</a>
            <?php } ?>
        </div>
    </div>

    <script>
        $('.message a').click(function(){
            $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
    </script>
</body>
</html>
