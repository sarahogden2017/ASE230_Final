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
        $user_id = $_POST['user_id'];
        $is_admin = $_POST['is_admin'];
        if ($is_admin == 1) {
            $is_admin = 0;
        } else {
            $is_admin = 1;
        }
        $sql = "UPDATE users SET is_admin = :is_admin WHERE user_id = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['is_admin' => $is_admin, 'user_id' => $user_id]);
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
            <?php if ($user['is_admin'] == 1) { ?>
                <p>This user is an admin. Change permissions will remove admin status.</p>  
            <?php } else { ?>
                <p>This user is not an admin. Change permissions will grant admin status.</p>
            <?php } ?>
            <form action='' method='post'>
                <input type='hidden' name='user_id' value='<?= $user['user_id'] ?>'>
                <input type='hidden' name='is_admin' value='<?= $user['is_admin'] ?>'>
                <input class='btn btn-danger'type='submit' value='Change Permissions'>
            </form>
        </div>
    </body>
</html>