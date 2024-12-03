<?php
session_start();
$i=$_GET['post_id'];
 
function get_entity() {
    $jsonString = file_get_contents('./posts.json');
    $entity_array = json_decode($jsonString, true);
    return $entity_array;
}

function edit_entity($num) {
	$prev_content = get_entity();
	// values
	$usr = $_SESSION['username'];
	$txt = $_POST['content'];
	date_default_timezone_set('America/Kentucky/Louisville');
	$date = date("F jS, y | g:i A | T");
	$new_content = array();
	$new_content = $prev_content;
	$new_content[$num]['story'][] = ["user" => $usr,"text" => $txt,"date" => $date];
	
	file_put_contents('./posts.json', json_encode($new_content));
}

if (isset($_POST['content']) && ($_POST['content'] != "\0")){
	edit_entity($i);
	header("Location: ./detail.php?post_id=".$i);
}
?>

<html>
	<head>
		<link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/journal/bootstrap.min.css" rel="stylesheet">
	</head>

	<?php $post = get_entity();?>
 	
	<body>
		<div class="container text-center">
			<h2><?=$post[$i]['prompt'];?></h2>
			<h3>
	  		Prompted by:
	  		<small class="text-body-secondary"><?=$post[$i]['author'];?></small>
			</h3>
	 		<h4><br /> <br /> The continuous story starts here: <br /></h4>
			
	 		<?php foreach ($post[$i]['story'] as $addition){ ?>
				<div class="row">
					<div class="column" style="float:left;width: 50%;"><?=$addition['user']?></div>
					<div class="column" style="float:right;width: 50%;"><?=$addition['date']?></div>
					<hr>
				</div>
				<p text-align="center"><?=$addition['text']?></p>
			<?php	} ?>

			<div>
				<form method="POST">
					<fieldset>
						<legend>EDIT MODE</legend>
						<label for="exampleTextarea" class="form-label mt-4">Your contribution...</label>
						<textarea name="content" class="form-control" id="exampleTextarea" style="height: 300px;" required></textarea>
						<button type="submit" class="btn btn-primary">Submit</button>
					</fieldset>
				</form>
			</div>
			<div class="mb-4">
				<a href="index.php" class="btn btn-primary m-4">Back to prompt index</a>
			</div>
		</div>
	</body>
</html>
