<?php
    session_start();
    $i=$_GET['post_id'];

    function edit_prompt() {
        // TODO
    }

    function delete_prompt() {
        // TODO
    }

    function edit_post($i) {
        // TODO
    }
    
    function delete_post($i) {
        // TODO
    }
?>

<!DOCTYPE html>
    <body>
        <?php if ($_SESSION['is_admin'] != 1) { ?>
            <script>
                alert("Error: You shouldn't be here...");
                window.location.href = '../index.php';
            </script>
        <?php } ?>
    </body>
</html>