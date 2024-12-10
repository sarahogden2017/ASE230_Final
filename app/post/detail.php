<?php
session_start();

$i = $_GET['post_id'];

require_once('../../lib/db.php');
$connection = $db;

// Fetch prompt details
function get_prompt($prompt_id, $db) {
    $sql = 'SELECT * FROM users 
            INNER JOIN writing_prompts ON users.user_id = writing_prompts.user_id 
            WHERE prompt_id = :prompt_id;';
    $stmt = $db->prepare($sql);
    $stmt->execute(['prompt_id' => $prompt_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Display prompt details
function display_prompt($prompt) {
    echo "
    <div class='d-flex justify-content-center align-items-center'>
        <h1 class='bg-primary text-white p-3 w-100'>{$prompt['prompt_text']}</h1>
    </div>
    <div class='container text-center'>
        <h3>Prompted by: <small class='text-body-secondary'>{$prompt['username']}</small></h3>
        <h4><br /><br />The continuous story starts here:<br /></h4>
    </div>";
}

// Fetch posts for the prompt
function get_posts($prompt_id, $db) {
    $stmt = $db->prepare("SELECT writing_posts.*, users.username 
                          FROM writing_posts 
                          INNER JOIN users ON writing_posts.user_id = users.user_id 
                          WHERE prompt_id = :prompt_id 
                          ORDER BY date_created ASC");
    $stmt->execute(['prompt_id' => $prompt_id]);
    return $stmt->fetchAll();
}

// Display posts with like buttons
function display_posts($posts, $db) {
    foreach ($posts as $post) {
        echo "
        <div class='row'>
            <div class='column' style='float:left;width: 50%;'>{$post['username']}</div>
            <div class='column' style='float:right;width: 50%;'>{$post['date_created']}</div>
            <hr>
            <p>{$post['text']}</p>
        </div>";

        // Check if the user has already liked this post
        $stmt = $db->prepare("SELECT * FROM post_likes WHERE user_id = :user_id AND post_id = :post_id");
        $stmt->execute(['user_id' => $_SESSION['user_id'], 'post_id' => $post['post_id']]);
        $liked = $stmt->fetch();

        // Render the like button
        echo '<button class="btn-post-like btn btn-primary m-2" data-id="' . $post['post_id'] . '">' . 
             ($liked ? 'Unlike' : 'Like') . '</button>';
        echo '<p>Likes: ' . $post['likes'] . '</p>';
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/journal/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.btn-post-like', function () {
            var el = $(this);
            $.get('likes.php?id=' + el.attr('data-id'), function (data, status) {
                if (data === 'liked') {
                    el.text('Unlike');
                    // Optionally, update the likes count dynamically
                    var likesCount = parseInt(el.next('p').text().split(': ')[1]);
                    el.next('p').text('Likes: ' + (likesCount + 1));
                } else if (data === 'unliked') {
                    el.text('Like');
                    var likesCount = parseInt(el.next('p').text().split(': ')[1]);
                    el.next('p').text('Likes: ' + (likesCount - 1));
                } else if (data === 'not_logged_in') {
                    alert('You need to log in to like posts.');
                }
            });
        });
    </script>
</head>

<body>
    <?php $prompt = get_prompt($i, $connection); ?>
    <?php display_prompt($prompt); ?>

    <div class="container">
        <?php 
            $posts = get_posts($i, $connection);
            if (count($posts) == 0) {
                echo "<h3>No posts yet!</h3>";
            } else {
                display_posts($posts, $connection);
            }
        ?>
    </div>

    <div class="mb-4">
        <a href="index.php" class="btn btn-primary m-4">Back to prompt index</a>
    </div>

    <?php if ($_SESSION['username'] != "guest" && !empty($_SESSION['username'])) { ?>
        <a href="edit.php?post_id=<?= $i ?>" class="btn btn-primary m-4">Add To This Story!</a>
    <?php } ?>
    
    <?php if ($_SESSION['username'] == $prompt['username']) { ?>
        <form action="delete.php?id=<?= $i ?>" method="POST">
            <input type="submit" value="Delete" name="delete" class="btn btn-danger">
        </form>
    <?php } ?>

    <?php if ($_SESSION['is_admin'] == 1) { ?>
        <a href="../admin/admin_post.php?post_id=<?= $i ?>" class="btn btn-warning m-4">Admin Area</a>
    <?php } ?>
</body>
</html>
