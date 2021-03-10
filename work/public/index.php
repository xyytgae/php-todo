<?php
require('../app/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // どのボタンをクリックしたのかを判定
    $action = filter_input(INPUT_GET, 'action');

    switch ($action) {
            // 追加ボタン
        case 'add':
            addTodo($pdo);
            break;

            // 編集ボタン
        case 'edit':
            updateEditingTodo($pdo);
            break;

            // 削除ボタン
        case 'delete':
            deleteTodo($pdo);
            break;

            // 保存ボタン
        case 'preserve':
            updateTodoTitle($pdo);
            break;

            // 戻るボタン
        case 'back':
            cancelEditingTodo($pdo);
            break;
    }
    header('Location: /');
    exit;
}

// todoの一覧を取得
$todos = getTodos($pdo);

// 編集中のtodoを取得
$editTodo = getEditingTodo($pdo);

include('../app/_parts/_header.php');
?>

<!-- 追加ボタン -->
<form action="?action=add" method="post">
    <input type="text" name="title" placeholder="Todoのタイトルを記入">
    <button <?= $editTodo->id > 0 ? 'disabled' : '' ?>>追加</button>
</form>
</div>
<!-- wrapper : todoの一覧を内包するラッパー -->
<div class="wrapper">
    <!-- container : todoの詳細を内包するコンテナ -->
    <?php foreach ($todos as $todo) : ?>
        <div class="container">
            <div class="todo-id">
                ID:
                <?= $todo->id  ?>
            </div>
            <div class="todo-title">
                Title:
                <?= h($todo->title)  ?>
            </div>

            <!-- 削除ボタン -->
            <form action="?action=delete" method="post">
                <button name="delete" value="<?= $todo->id ?>" <?= $editTodo->id > 0 ? 'disabled' : '' ?>>削除</button>
                <input type="hidden" name="id" value="<?= $todo->id ?>">
            </form>

            <!-- 編集ボタン -->
            <form action="?action=edit" method="post">
                <button <?= $editTodo->id > 0 ? 'disabled' : '' ?>>編集</button>
                <input type="hidden" name="id" value="<?= $todo->id ?>">
            </form>
        </div>
    <?php endforeach ?>
</div>

<!-- 編集フォーム -->
<?php if ($editTodo->id > 0) : ?>
    <div class="update-todo-form">

        <!-- 保存ボタン -->
        <form action="?action=preserve" method="post">
            ID :
            <?= $editTodo->id ?>
            <input type="hidden" name="id" value="<?= $editTodo->id ?>">
            <input name="title" placeholder="Todoのタイトルを記入" value="<?= $editTodo->title ?>">
            <button>保存</button>
        </form>

        <!-- 戻るボタン -->
        <form action="?action=back" method="post">
            <button>戻る</button>
            <input type="hidden" name="id" value="<?= $editTodo->id ?>">
        </form>
    </div>
<?php endif ?>
</main>

<?php include('../app/_parts/_footer.php');
