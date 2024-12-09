<?php
session_start();
require_once('../login_scripts/db.php');

$i = $_GET['post_id'];

function get_entity($db, $post_id) {
    $stmt = $db->prepare("SELECT * FROM writing_prompts WHERE prompt_id = :id");
    $stmt->execute(['id' => $post_id]);
    return $stmt->fetch();
}

function edit_entity($db, $post_id) {
    $usr = $_SESSION['username'];
    $txt = $_POST['content'];
    date_default_timezone_set('America/Kentucky/Louisville');
    $date = date("Y-m-d H:i:s");

    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare("INSERT INTO writing_posts (user_id, prompt_id, text, date_created) VALUES (:user_id, :prompt_id, :text, :date_created)");
    $stmt->execute([
        'user_id' => $user_id,
        'prompt_id' => $post_id,
        'text' => $txt,
        'date_created' => $date
    ]);

    $stmt = $db->prepare("UPDATE writing_prompts SET responses = responses + 1, date_updated = :date_updated WHERE prompt_id = :prompt_id");
    $stmt->execute([
        'date_updated' => $date,
        'prompt_id' => $post_id
    ]);
}

if (isset($_POST['content']) && ($_POST['content'] != "\0")) {
    edit_entity($db, $i);
    header("Location: ./detail.php?post_id=" . $i);
}

$post = get_entity($db, $i);
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/journal/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center">
        <h2><?= $post['prompt_text']; ?></h2>
        <h3>
            Prompted by:
            <small class="text-body-secondary"><?= $post['user_id']; ?></small>
        </h3>
        <h4><br /> <br /> The continuous story starts here: <br /></h4>

        <?php
        $stmt = $db->prepare("SELECT * FROM writing_posts WHERE prompt_id = :prompt_id ORDER BY date_created ASC");
        $stmt->execute(['prompt_id' => $i]);
        $story_additions = $stmt->fetchAll();

        foreach ($story_additions as $addition) { ?>
            <div class="row">
                <div class="column" style="float:left;width: 50%;"><?= $addition['user_id'] ?></div>
                <div class="column" style="float:right;width: 50%;"><?= $addition['date_created'] ?></div>
                <hr>
            </div>
            <p text-align="center"><?= $addition['text'] ?></p>
        <?php } ?>

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
    <?php if ($_SESSION['username'] == '') { ?>
        <script>
            alert("Error: You shouldn't be here...");
            window.location.href = '../index.php';
        </script>
    <?php } ?>
</body>
</html>
