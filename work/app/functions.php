<?php
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function getTodos($pdo)
{
    $stmt = $pdo->query("SELECT * FROM todos ORDER BY id ASC");
    $todos = $stmt->fetchAll();
    return $todos;
}

function addTodo($pdo)
{
    // POSTの値を受け取る
    $title = trim(filter_input(INPUT_POST, 'title'));
    if ($title === '') {
        return;
    }

    $sql = "INSERT INTO todos (title) VALUES (:title)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->execute();
}

function editTodo($updateId, $updateTitle)
{
    $updateId = filter_input(INPUT_POST, 'id');
    $updateTitle = filter_input(INPUT_POST, 'updateTitle');
}

function deleteTodo($pdo)
{
    $id = trim(filter_input(INPUT_POST, 'id'));

    $sql = "DELETE FROM todos WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function preserveTodo()
{
}
