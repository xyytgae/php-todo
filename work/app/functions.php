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

function getEditId($pdo)
{
    // return 99;
    // return filter_input(INPUT_POST, 'id');
    // return $_POST['edit']['id'] ? $_POST['edit']['id'] : 999;

    $stmt = $pdo->query("SELECT id FROM editTodo");
    $id = $stmt->fetch();

    // print_r($id);

    return $id->id;
}

function getEditTitle($pdo)
{
    $stmt = $pdo->query("SELECT title FROM editTodo");
    $title = $stmt->fetch();

    // print_r($title);

    return $title->title;
}

function getEditTodo($pdo)
{
    $stmt = $pdo->query("SELECT * FROM editTodo");
    $todo = $stmt->fetch();
    return $todo;
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

function editTodo($pdo)
{
    $id = filter_input(INPUT_POST, 'id');

    $pdo->query("DROP TABLE IF EXISTS editTodo");
    $sql = "CREATE TABLE editTodo SELECT * FROM todos WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function deleteTodo($pdo)
{
    $id = trim(filter_input(INPUT_POST, 'id'));

    $sql = "DELETE FROM todos WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function preserveTodo($pdo)
{
    $id = filter_input(INPUT_POST, 'id');
    $title = filter_input(INPUT_POST, 'title');
    $sql = "UPDATE todos SET title=:title  WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->execute();

    closeEdit($pdo);
}

function closeEdit($pdo)
{
    $id = filter_input(INPUT_POST, 'id');
    $sql = "UPDATE editTodo SET id = 0, title = null WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
