<?php
    session_start();
    $i=$_GET['post_id'];

    $new = $_POST['prompt_text'];
    if (isset($_POST['edit'])) {
        $new = $_POST['prompt_text'];
        require_once('../login_scripts/db.php');

        $stmt = $db->prepare("UPDATE writing_prompts SET prompt_text = :new WHERE prompt_id = :i");
        $stmt->execute(['new' => $new, 'i' => $i]);
        header('Location: detail.php?post_id=' . $i);
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
        <?php } ?>
        <div class='d-flex justify-content-center align-items-center'>
			<h1 class='bg-primary text-white p-3 w-100'>Admin Area for post #<?php echo $i ?></h1>
        </div>
        <div class='container'>
            <form action="delete.php?id=<?= $i ?>" method="POST">
                <input type="submit" value="Delete" name="delete" class="btn btn-danger">
            </form><br>
            <form action='' method='POST'>
                <input type='text' name='prompt_text' placeholder='Enter new prompt text' class='form-control'>
                <input type='submit' value='Edit Prompt Text' name='edit' class='btn btn-warning'>
            </form>
        </div>
    </body>
</html>