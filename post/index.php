<?php
  session_start(); 
  // connect to db
	
  function get_entity() {
    // connect to db
    require_once('../login_scripts/db.php');   

    // make sql command
    if ($_SESSION['username'] == "guest" || $_SESSION['username'] == '') {
      $sql = "SELECT wp.*, u.username FROM writing_prompts wp 
              LEFT JOIN users u ON wp.user_id = u.user_id 
              WHERE visibility = 1";
      $stmt = $db->prepare($sql);
      $stmt->execute();
  } elseif ($_SESSION['is_admin'] != 1) {
      $sql = "SELECT wp.*, u.username FROM writing_prompts wp 
              LEFT JOIN users u ON wp.user_id = u.user_id 
              WHERE visibility = 1 OR (visibility = 0 AND wp.user_id = :user_id)";
      $stmt = $db->prepare($sql);
      $stmt->execute([':user_id' => $_SESSION['user_id']]);
  } else {
      $sql = "SELECT wp.*, u.username FROM writing_prompts wp 
              LEFT JOIN users u ON wp.user_id = u.user_id";
      $stmt = $db->prepare($sql);
      $stmt->execute();
    }
    $entity_array = $stmt->fetchAll();
    return $entity_array;
  }

  function display_entity($entity_array) {
      for($i=0;$i<count($entity_array);$i++) { ?>
        <div class="col">
          <div class="card text-white bg-dark mb-3" style="max-width:30rem;">
            <div class="card-body">
              <h4 class="card-title"><?= htmlspecialchars($entity_array[$i]['prompt_text']) ?></h4>
              <h6 class="card-text">Created by: <?= htmlspecialchars($entity_array[$i]['username']) ?></h6>
              <?php if ($_SESSION['username'] != "guest" || $_SESSION['username'] != ''){ ?>
                <em><p>Visibility: <?= $entity_array[$i]['visibility'] == 1 ? 'Public' : 'Private' ?></p></em>
              <?php } ?>
              <h8 class="card-text">Created by: <?= htmlspecialchars($entity_array[$i]['username']) ?></h6>
              <p><a href="detail.php?post_id=<?= $entity_array[$i]['prompt_id'] ?>" class="btn btn-light">Go to prompt</a></p>
            </div>
          </div>
        </div>
      <?php if ($i%3==0 && $i != 0){ 
        echo "</div><div class='row'>";
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
    <h1 class="bg-primary text-white p-3 w-100">Welcome to the Prompt Index</h1>
  </div>
  <div class="container text-center">
    <div class="row">
      <?php 
        $entity_array = get_entity();
        display_entity($entity_array); 
       ?>
    </div>
  </div>
  <div class="container">
    <?php if($_SESSION['username'] != "guest" || $_SESSION['username'] != ''){ ?>
			<a href="create.php" class="btn btn-primary m-4">Create a New Story!</a>
    <?php } ?>
  </div> 
  <div class="container">
    <?php if($_SESSION['username'] != "guest" || $_SESSION['username'] != ''){ ?>
      <a href="../login_scripts/logout.php" class="btn btn-danger m-4">Logout</a>
    <?php } ?>
  </div> 
</body>
</html>
