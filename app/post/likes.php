<?php
session_start();
require_once('../../lib/db.php');

if (!isset($_SESSION['user_id'])) {
    echo 'not_logged_in';
    exit;
}

$user_id = $_SESSION['user_id'];
$post_id = $_GET['id'];

// Check if the user has already liked the post
$stmt = $db->prepare("SELECT * FROM post_likes WHERE user_id = :user_id AND post_id = :post_id");
$stmt->execute(['user_id' => $user_id, 'post_id' => $post_id]);
$liked = $stmt->fetch();

if ($liked) {
    // Unlike the post (delete from post_likes table)
    $stmt = $db->prepare("DELETE FROM post_likes WHERE user_id = :user_id AND post_id = :post_id");
    $stmt->execute(['user_id' => $user_id, 'post_id' => $post_id]);

    // Decrement the like count
    $stmt = $db->prepare("UPDATE writing_posts SET likes = likes - 1 WHERE post_id = :post_id");
    $stmt->execute(['post_id' => $post_id]);

    echo 'unliked';
} else {
    // Like the post (insert into post_likes table)
    $stmt = $db->prepare("INSERT INTO post_likes (user_id, post_id) VALUES (:user_id, :post_id)");
    $stmt->execute(['user_id' => $user_id, 'post_id' => $post_id]);

    // Increment the like count
    $stmt = $db->prepare("UPDATE writing_posts SET likes = likes + 1 WHERE post_id = :post_id");
    $stmt->execute(['post_id' => $post_id]);

    echo 'liked';
}
?>
