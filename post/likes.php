<?php

// https://youtu.be/j2AO1XUUZoM?si=Txi-fF0cTlzPuvWP&t=4139 this is what i am referencing
session_start();
require_once('../login_scripts/db.php');
$user = $_SESSION['username'];
// Get user id
$sql = "SELECT user_id FROM users WHERE username = :username ";
$stmt = $db->prepare($sql);
$stmt->execute(['username' => $user]);
$result1 = $stmt->fetch();

$user_id = $result1['user_id'];

$post = 2; //$_GET['post_ID'];
$sql2 = 'SELECT date FROM post_likes WHERE post_ID=:post AND user_ID=:user';
$stmt2 = $db->prepare($sql2);
$stmt2->execute(['post' => $post, 'user' => $user_id]);
$result2 = $stmt2->rowCount();

if ($result2==0){
	query($db, 'INSERT INTO post_likes(user_ID, date, post_ID) VALUES(?, DEFAULT, ?)',[$post, $user_id]);
	query($db, 'UPDATE writing_posts SET likes=likes+1 WHERE writing_posts.post_id=?', [$post]);
} else {
	query($db, 'DELETE FROM post_likes WHERE post_id=? AND user_id=?',[$post, $user_id]);
	query($db, 'UPDATE writing_posts SET likes=likes-1 WHERE writing_posts.post_id=?', [$post]);
}

?>
