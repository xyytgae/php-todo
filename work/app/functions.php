<?php

require('../app/config.php');
require('../app/sql.php');
require('../app/EditingTodo.php');

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 追加ボタン
function addTodo($pdo)
{
    // POSTの値を受け取る
    $title = trim(filter_input(INPUT_POST, 'title'));
    if ($title === '') {
        return;
    }
    sqlAddTodo($title, $pdo);
}

// 編集ボタン
function updateEditingTodo($pdo)
{
    // POSTの値を受け取る
    $id = filter_input(INPUT_POST, 'id');
    sqlUpdateEditingTodo($id, $pdo);
}


// 削除ボタン
function deleteTodo($pdo)
{
    // POSTの値を受け取る
    $id = filter_input(INPUT_POST, 'id');
    sqlDeleteTodo($id, $pdo);
}

// 保存ボタン
function updateTodoTitle($pdo)
{
    // POSTの値を受け取る
    $id = filter_input(INPUT_POST, 'id');
    $title = trim(filter_input(INPUT_POST, 'title'));
    sqlUpdateTodoTitle($id, $title, $pdo);
}

// 戻るボタン
function cancelEditingTodo($pdo)
{
    sqlCancelEditingTodo($pdo);
}

// todosテーブルを取得
function getTodos($pdo)
{
    $stmt = sqlGetTodos($pdo);
    $todos = $stmt->fetchAll();

    return $todos;
}

// todosテーブルから編集中のレコードを取得
function getEditingTodo($pdo)
{
    $stmt = sqlGetEditingTodo($pdo);

    // 編集中のtodoがない場合、Classのインスタンスをreturn
    $count = $stmt->rowCount();
    if ($count > 0) {
        $todo = $stmt->fetch();
        return $todo;
    } else {
        $todo = new EditingTodo();
        return $todo;
    }
}
