<?php
    session_start();
    function save_entity($entity) {
        $jsonString = file_get_contents('./posts.json');
        $entity_array = json_decode($jsonString, true);
        $entity_array[] = $entity;
        file_put_contents('./posts.json', json_encode($entity_array, JSON_PRETTY_PRINT));

        // add to database
        require_once('../login_scripts/db.php');

        $sql = "INSERT INTO writing_prompts (user_id, prompt_text, responses, visibility) 
                VALUES (:user_id, :prompt_text, :responses, :visibility)";    
        $stmt = $db->prepare($sql);
        $data = [
            ':user_id' => $_SESSION['user_id'],
            ':prompt_text' => $entity['prompt'],
            ':responses' => 0, //default value
            ':visibility' => $entity['visibility']
        ];
        try {
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['visibility'] == 'public') {
            $visibility = 1;
        } else {
            $visibility = 0;
        }
        $entity = [
            'prompt' => $_POST['prompt'],
            'story' => [],
            'author' => $_SESSION['username'],
            'visibility' => $visibility
        ];
        save_entity($entity);
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Story</title>
        <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/journal/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="d-flex justify-content-center align-items-center">
        <h1 class="bg-primary text-white p-3 w-100">Create New Story</h1>
        </div>
        <div class="container justify-content-center align-items-center">
            <form action="create.php" method="post">
                <label class="h2" for="new_story">Prompt</label>
                <input type="text" class="form-control" id="prompt" name="prompt" required><br>
                <h4>Visibility</h4>
                <input type="radio" id="visibility" name="visibility" value="public" checked>
                <label for="visibility">Public</label><br>
                <input type="radio" id="visibility" name="visibility" value="private">
                <label for="visibility">Private</label><br>
                <input type="submit" class="btn btn-primary m-4">
            </form>
        </div>
        <!-- security check -->
        <?php if ($_SESSION['username'] == '') { ?>
            <script>
                alert("Error: You shouldn't be here...");
                window.location.href = '../index.php';
            </script>
        <?php } ?>        
    </body>
</html>
