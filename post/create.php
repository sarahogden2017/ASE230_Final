<?php
    session_start();
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
            <form action="create_script.php" method="post">
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
                window.location.href = './index.php';
            </script>
        <?php } ?>        
    </body>
</html>
