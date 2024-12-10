<?php
	session_start();
	

	$i=$_GET['post_id'];

	require_once('../../lib/db.php');
	$connection = $db;
	
	function get_prompt($prompt_id, $db) {
		$sql = 'SELECT * FROM users INNER JOIN writing_prompts ON users.user_id = writing_prompts.user_id WHERE prompt_id=:prompt_id;';
		$stmt = $db->prepare($sql);
    	$stmt->execute(['prompt_id' => $prompt_id]);
		$prompt = $stmt->fetch(PDO::FETCH_ASSOC);
		return $prompt;
	}

	function display_prompt($prompt) {
		echo "
			<div class='d-flex justify-content-center align-items-center'>
				<h1 class='bg-primary text-white p-3 w-100'>{$prompt['prompt_text']}</h1>
			</div>
			<div class='container text-center'>
				<h3>Prompted by: <small class='text-body-secondary'>{$prompt['username']}</small></h3>
				<h4><br /><br />The continuous story starts here:<br /></h4>
			";
	}

	function get_posts($prompt_id, $db) {
		$stmt = $db->prepare("SELECT * FROM users INNER JOIN writing_posts ON users.user_id = writing_posts.user_id WHERE prompt_id = :prompt_id ORDER BY date_created ASC");
        $stmt->execute(['prompt_id' => $prompt_id]);
        $story_additions = $stmt->fetchAll();
		return $story_additions;
	}

	function display_posts($posts) {
		foreach($posts as $post) {
			echo "
				<div class='row'>
					<div class='column' style='float:left;width: 50%;'>{$post['username']}</div>
						<div class='column' style='float:right;width: 50%;'>{$post['date_created']}</div>
						<hr>
						<p>{$post['text']}</p>
				</div>";
		}
	}

?>

<html>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/journal/bootstrap.min.css">
	</head>
  	<!--This will be the page that displays the one page that the user has clicked on-->
  	
	<header><?php $prompt = get_prompt($i, $connection); ?></header>

	<body>
		<?php display_prompt($prompt)?>
		
		<div class="container">
			<?php 
				$post = get_posts($i, $connection);
				if (count($post) == 0) {
					echo "<h3>No posts yet!</h3>";
				}
				else {
					display_posts($post);
				}
			?>
		</div>
	
		<div class="mb-4">
			<a href="index.php" class="btn btn-primary m-4">Back to prompt index</a>
		</div>

		<?php if($_SESSION['username']!="guest"  && $_SESSION['username'] != ''){ ?>
				<a href="edit.php?post_id=<?= $i ?>" class="btn btn-primary m-4">Add To This Story!</a>
		<?php } if($_SESSION['username']==$prompt['username']){ ?>
			<form action="delete.php?id=<?= $i ?>" method="POST">
				<input type="submit" value="Delete" name="delete" class="btn btn-danger">
			</form>
		<?php } ?>
		<!-- admin area -->
		<?php if ($_SESSION['is_admin'] == 1) { ?>
		<a href="../admin/admin.php?post_id=<?= $i ?>" class="btn btn-warning m-4">Admin Area</a>
		<?php } ?>
	</body>
</html>
