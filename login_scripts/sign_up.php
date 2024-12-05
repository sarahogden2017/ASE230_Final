<?php
    if (strlen($_POST['username_signup']) > 0 && strlen($_POST['password_signup']) > 0) {
        $username = $_POST['username_signup'];
        $password = $_POST['password_signup'];
        echo $username;
        // check if user exists
        
        // add user to database
    }
    // throw error for invalid user info
    else {
        $message = "Please enter a username and password.";
    }
?>

<!DOCTYPE html>
    <body>
        <script>
            var message = "<?php echo $message; ?>";
            if (message) {
                alert(message);
                window.location.href = '../index.php';
            }
        </script>
    </body>
</html>