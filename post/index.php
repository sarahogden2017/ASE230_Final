<?php
session_start();
require_once('../login_scripts/db.php');
$connection = $db;

function display_box($title, $author, $ID) {
    ?>
		  <div class="col">
		    <div class="card text-white bg-dark mb-3" style="max-width:30rem;">
			    <div class="card-body">
				    <h4 class="card-title"><?=$title?></h4>
				    <h6 class="card-text">Created by: <?=$author?></h6>
				    <p><a href="detail.php?post_id=<?=$ID?>" class="btn btn-light">Go to prompt</a></p>
			    </div>
		    </div>
		  </div>
		<?php 
}

function get_user_type($user_name, $db){
	$query = "SELECT * FROM `users` WHERE username = '$user_name';";
	$stmt = $db->query($query);
	$num = $stmt->rowCount();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($num == 0){
		return "guest";
	}	
	elseif ($row['is_admin']==0){
		return "unprivledged_user";
	}
	elseif ($row['is_admin']==1){
		return "admin_user";
	}
	else {
		return "unknown";
	}
}
function make_view($user_type, $user_name, $db_connect){
	 // check if user has any prompts   
	if ($user_type == "unprivledged_user"){ ?>
		<h3 class="bg-primary text-white p-3 w-100">Your Prompts</h3>
			<div class="container text-center">
			<div class="row"><?php 
				get_user_prompts($user_name, $db_connect);
			?>
			</div>
			</div>
			<?php
	}
	elseif ($user_type == "admin_user"){ ?>
		<h3 class="bg-primary text-white p-3 w-100">All Prompts</h3>
			<div class="container text-center">
			<div class="row"><?php 
				get_all_prompts($db_connect);
				goto here;
			?>
			</div>
			</div>
			<?php
	} ?>
	<h3 class="bg-primary text-white p-3 w-100">All Prompts</h3>
	<div class="container text-center">
    <div class="row">
      <?php 
	  get_public_prompts($db_connect);
       ?>
    </div>
    </div>
<?php
here:
}
function get_all_prompts($db){
	$query = 'SELECT username, prompt_text, prompt_id FROM users INNER JOIN writing_prompts ON users.user_id = writing_prompts.user_id;';
	$stmt = $db->query($query);
	$box_count = 0;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		display_box($row['prompt_text'], $row['username'], $row['prompt_id']);
		++$box_count;
		if ($box_count%3==0){
			echo "</div><div class='row'>";	
		}
	}
}

function get_public_prompts($db){	
	$query = "SELECT username, prompt_text, prompt_id FROM users INNER JOIN writing_prompts ON users.user_id = writing_prompts.user_id WHERE visibility = 1;";
	$stmt = $db->query($query);
	$box_count = 0;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		display_box($row['prompt_text'], $row['username'], $row['prompt_id']);
		++$box_count;
		if ($box_count%3==0){
			echo "</div><div class='row'>";	
		}
	}
}

function get_user_prompts($username, $db){ 
    // check if user has any prompts        
	$query = "SELECT username, prompt_text, prompt_id FROM users INNER JOIN writing_prompts ON users.user_id = writing_prompts.user_id WHERE username = '$username';";
	$stmt = $db->query($query);
	$num = $stmt->rowCount();
	$box_count = 0;
	if ($num == 0){
		echo "You have no prompts.";
	}
	else {
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			display_box($row['prompt_text'], $row['username'], $row['prompt_id']);
			++$box_count;
			if ($box_count%3==0){
				echo "</div><div class='row'>";	
			}
		}
	}
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prompt Index</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/journal/bootstrap.min.css">
</head>
<body>
<div class="d-flex justify-content-center align-items-center">
   <h1 class="bg-primary text-white p-3 w-100">Welcome to the Prompt Index, <?php echo $_SESSION['username'];?></h1>
</div>

<!-- Provide different views based on user role: guest, admin, or regular user -->
<?php
$username = $_SESSION['username'];
$type = get_user_type($username, $connection);
make_view($type, $username, $connection);
?>
  <div class="container">
    <?php if($_SESSION['username'] != "guest" || empty($_SESSION['username'])){ ?>
			<a href="create.php" class="btn btn-primary m-4">Create a New Story!</a>
    <?php } ?>
  </div> 
  <div class="container">
    <?php if($_SESSION['username'] != "guest" || empty($_SESSION['username'])){ ?>
      <a href="../login_scripts/logout.php" class="btn btn-danger m-4">Logout</a>
    <?php } ?>
  </div> 
</body>
</html>
