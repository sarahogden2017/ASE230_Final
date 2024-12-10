<?php
    session_start();
    require_once '../../lib/db.php';
    $i = $_GET['id'];

    function get_user($db, $i) {
        $sql = "SELECT * FROM users WHERE user_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $i]);
        $user = $stmt->fetch();
        return $user;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $sql = "DELETE FROM users WHERE user_name = :user_name";
        $stmt = $db->prepare($sql);
        $stmt->execute(['user_name' => $user_name]);
        header('Location: admin_users_index.php');
    }

?>


<!DOCTYPE html>
    <head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/journal/bootstrap.min.css">
	</head>
    <body>
        <?php if ($_SESSION['is_admin'] != 1) { ?>
            <script>
                alert("Error: You shouldn't be here...");
                window.location.href = '../index.php';
            </script>
        <?php } 
        $user = get_user($db, $i) ?>
        <div class='d-flex justify-content-center align-items-center'>
			<h1 class='bg-primary text-white p-3 w-100'>Admin Area for User: <? $user['user_id']?></h1>
        </div>
        <div class='container'>
            <p> This user will be deleted </p>
            <form action='' method='post'>
                <input type='hidden' name='user_name' value='<?= $user['user_name'] ?>'>
                <input class='btn btn-danger'type='submit' value='Delete'>
            </form>
        </div>
    </body>
</html>