<?php
session_start();
require_once('../login_scripts/db.php');

function delete_posts_by_prompt($db, $prompt_id) {
    $stmt = $db->prepare("DELETE FROM writing_posts WHERE prompt_id = :prompt_id");
    $stmt->execute(['prompt_id' => $prompt_id]);
}

function delete_prompt($db, $prompt_id) {
    $stmt = $db->prepare("DELETE FROM writing_prompts WHERE prompt_id = :prompt_id");
    $stmt->execute(['prompt_id' => $prompt_id]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $entity_id = $_GET['id'];

    $stmt = $db->prepare("SELECT * FROM writing_prompts WHERE prompt_id = :id");
    $stmt->execute(['id' => $entity_id]);
    $prompt = $stmt->fetch();

    if ($prompt && $_SESSION['user_id'] == $prompt['user_id']) {
        delete_posts_by_prompt($db, $entity_id);
        delete_prompt($db, $entity_id);
        header('Location: index.php');
        exit();
    } else {
        echo "You do not have permission to delete this prompt.";
    }
} else {
    echo "Invalid request.";
}
?>
