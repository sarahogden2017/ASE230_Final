<?php
    require_once('db.php');

    $username = $_POST['username_signup'];
    $password = $_POST['password_signup'];
    $email = $_POST['email'];
    
    // check if user exists        
    $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(['username' => $username, 'email' => $email]);
    if ($stmt->rowCount() > 0) {
        $message = "User already exists.";
    }    
    // add user to database
    else {
        $sql = "INSERT INTO users (username, email, stories_contributed, password_hash) 
                VALUES (:username, :email, :stories_contributed, :password_hash)";        
        $stmt = $db->prepare($sql);
        $data = [
            ':username' => $username,
            ':email' => $email,
            ':stories_contributed' => 0, // Default value
            ':password_hash' => $password
        ];
        $stmt->execute($data);
        $message = "User created";
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