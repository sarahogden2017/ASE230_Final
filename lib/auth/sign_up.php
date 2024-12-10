<?php
    require_once('../db.php');

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
        $sql = "INSERT INTO users (user_id, username, email, date_joined, stories_contributed, password_hash, is_admin) 
                VALUES (NULL, :username, :email, DEFAULT, :stories_contributed, :password_hash, :is_admin)";        
        $stmt = $db->prepare($sql);
        $data = [
            ':username' => $username,
            ':email' => $email,
            ':stories_contributed' => 0, // Default value
            ':password_hash' => $password,
            ':is_admin' => 0 // Default value
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
                window.location.href = '../../app/index.php';
            }
        </script>
    </body>
</html>
