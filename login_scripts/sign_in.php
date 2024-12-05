<?php
    if (strlen($_POST['username_signin']) > 0 && strlen($_POST['password_signin']) > 0) {
        $username = $_POST['username_signin'];
        $password = $_POST['password_signin'];
        // check for user in database

        // check if password is correct
        
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