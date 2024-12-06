<?php
    session_start();
    require_once('db.php');

    $username = $_POST['username_signin'];
    $password = $_POST['password_signin'];
    // check for user in database
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($sql);
    $stmt->execute(['username' => $username]);

    $stmt->execute(['username' => $username]);
    if ($stmt->rowCount() == 0) {
        $message = "User doesn't exists.";
    }
    // check if password is correct
    else {
        $user = $stmt->fetch();
        if ($user['password_hash'] == $password) {
            // Set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['stories_contributed'] = $user['stories_contributed'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: ../post/index.php");
            exit();
        }
        else {
            $message = "Incorrect password.";
        }
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