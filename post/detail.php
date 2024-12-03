<?php
session_start();

 $i=$_GET['post_id'];
 
function get_entity() {
    $jsonString = file_get_contents('./posts.json');
    $entity_array = json_decode($jsonString, true);
    return $entity_array;
}
?>

<html>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/journal/bootstrap.min.css">
	</head>
  	<!--This will be the page that displays the one page that the user has clicked on-->
  	
	<?php
	$post = get_entity();?>

	<body>
		<div class="d-flex justify-content-center align-items-center">
			<h1 class="bg-primary text-white p-3 w-100"><?=$post[$i]['prompt'];?></h1>
		</div>
		<div class="container text-center">
			<h3>
	  		Prompted by:
	  		<small class="text-body-secondary"><?=$post[$i]['author'];?></small>
			</h3>
			<h4><br /> <br /> The continuous story starts here: <br /></h4>
		</div>
		
		<div class="container">
			<?php
				foreach ($post[$i]['story'] as $addition){
					?>
					<div class="row">
						<div class="column" style="float:left;width: 50%;"><?=$addition['user']?></div>
						<div class="column" style="float:right;width: 50%;"><?=$addition['date']?></div>
						<hr>
					</div>
					<p text-align="center">
					<?=$addition['text']?>
					</p>
				<?php	
				}
				?>
			</div>
		</div>
	</body>
	<div class="mb-4">
		<a href="index.php" class="btn btn-primary m-4">Back to prompt index</a>
	</div>

	<?php
		if($_SESSION['username']!="guest"  && isset($_SESSION['username'])){ ?>
			<a href="edit.php?post_id=<?= $i ?>" class="btn btn-primary m-4">Add To This Story!</a>
	<?php } 
		if($_SESSION['username']==$post[$i]['author']){ ?>
			<form action="delete.php?id=<?= $i ?>" method="POST">
	    	<input type="submit" value="Delete" name="delete" class="btn btn-danger">
	    </form>
	<?php }?>

</html>
