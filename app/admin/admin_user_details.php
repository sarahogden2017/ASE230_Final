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
            <div class='row'>
                <div class='col-md-6'>
                    <h2>User Information</h2>
                    <table class='table table-striped'>
                        <tr>
                            <th>Username</th>
                            <td><?php echo $user['username'] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo $user['email'] ?></td>
                        </tr>
                        <tr>
                            <th>Is Admin</th>
                            <td><?php echo $user['is_admin'] ?></td>
                        </tr>
                        <tr>
                            <th>Joined</th>
                            <td><?php echo $user['date_joined'] ?></td>
                        </tr>
                        <tr>
                            <th>Stories Contributed</th>
                            <td><?php echo $user['stories_contributed'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class='col-md-6'>
                    <h2>Actions</h2>
                    <a href='admin_user_edit.php?id=<?=$user["user_id"]?>' class='btn btn-primary'>Edit User</a>
                    <a href='admin_user_delete.php?id=<?=$user["user_id"]?>' class='btn btn-danger'>Delete User</a>
                </div>
            </div>
            
        </div>
    </body>
</html>