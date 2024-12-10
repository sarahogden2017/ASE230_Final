<?php
    session_start();
    $i=$_GET['post_id'];

    $new = $_POST['prompt_text'];
    if (isset($_POST['edit'])) {
        $new = $_POST['prompt_text'];
        require_once('../../lib/db.php');

        $stmt = $db->prepare("UPDATE writing_prompts SET prompt_text = :new WHERE prompt_id = :i");
        $stmt->execute(['new' => $new, 'i' => $i]);
        header('Location: ../post/detail.php?post_id=' . $i);
    }
?>

<html>
    <script>
        if (<?php echo $_SESSION['is_admin'] ?> != 1) {
            alert("Error: You shouldn't be here...");
            window.location.href = '../index.php';
        }
    </script>
</html>