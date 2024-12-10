<?php
    session_start();

    require_once('../../lib/db.php');
    
    function get_all_users($db){
        $query = 'SELECT * FROM users;';
        $stmt = $db->query($query);
        $box_count = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            display_box($row['user_id'], $row['username'], $row['is_admin']);
            ++$box_count;
            if ($box_count%3==0){
                echo "</div><div class='row'>";	
            }
        }
    }

    function display_box($user_id, $username, $is_admin) { ?>
              <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width:30rem;">
                    <div class="card-body">
                        <h4 class="card-title"><?= $username ?></h4>
                        <h6 class="card-text">User ID: <?= $user_id ?></h6>
                        <h6 class="card-text">Admin: <?= $is_admin ?></h6>
                        <p><a href="admin_user_details.php?id=<?=$user_id?>" class="btn btn-light">User Details</a></p>
                    </div>
                </div>
              </div>
    <?php } ?>

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
        <?php } ?>
        <div class='d-flex justify-content-center align-items-center'>
			<h1 class='bg-primary text-white p-3 w-100'>Admin Area for Users</h1>
        </div>
        <div class='row'>
            <?php get_all_users($db); ?>
        
        </div>
    </body>
</html>