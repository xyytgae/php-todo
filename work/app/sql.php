<?php

// todosテーブルに追加
function sqlAddTodo($title, $pdo)
{
    $sql = "INSERT 
            INTO todos (title) 
            VALUES (:title)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->execute();
}

// todosテーブルのis_editingをtrueに更新
function sqlUpdateEditingTodo($id, $pdo)
{
    $sql = "UPDATE todos 
            SET is_editing=true 
            WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// todosからレコードを削除
function sqlDeleteTodo($id, $pdo)
{
    $sql = "DELETE 
            FROM todos 
            WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// todosテーブルのtitleを更新
function sqlUpdateTodoTitle($id, $title, $pdo)
{
    $sql = "UPDATE todos 
            SET title=:title 
            WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->execute();

    sqlCancelEditingTodo($pdo);
}

// todosテーブルのis_editingをfalseに更新
function sqlCancelEditingTodo($pdo)
{
    $sql = "UPDATE todos 
            SET is_editing=false 
            WHERE is_editing=true";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

// todosテーブルを取得
function sqlGetTodos($pdo)
{
    $stmt = $pdo->query(
        "SELECT *
         FROM todos 
         ORDER BY id ASC"
    );
    return $stmt;
}

// todosテーブルから編集中のレコードを取得
function sqlGetEditingTodo($pdo)
{
    $stmt = $pdo->query(
        "SELECT * 
         FROM todos 
         WHERE is_editing=true"
    );
    return $stmt;
}
