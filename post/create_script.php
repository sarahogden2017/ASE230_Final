<?php
    session_start();
	// add to database
	
	// connect to db
	require_once('../login_scripts/db.php');
	
	// make radio an int value for db
	if ($_POST['visibility'] == 'public') {
		$visibility = 1;
	} else {
		$visibility = 0;
	}
	
	// make sql command
	$sql = "INSERT INTO writing_prompts (prompt_id, user_id, prompt_text, responses, visibility, date_created, date_updated) 
			VALUES (NULL, :user_id, :prompt_text, :responses, :visibility, DEFAULT, DEFAULT)";    
	$stmt = $db->prepare($sql);
	$data = [
		':user_id' => $_SESSION['user_id'],
		':prompt_text' => $_POST['prompt'],
		':responses' => 0, //default value
		':visibility' => $visibility];
		
	$stmt->execute($data);
	$message = "Prompt Added";
?>

<!DOCTYPE html>
    <body>
        <script>
            var message = "<?php echo $message; ?>";
            if (message) {
                alert(message);
                window.location.href = './index.php';
			}
        </script>
    </body>
</html>
