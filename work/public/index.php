<?php
require('../app/config.php');
require('../app/functions.php');

$updateId = null;
$updateTitle = null;

$editId = null;
$editTitle = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // どのボタンをクリックしたのかを判定
    $action = filter_input(INPUT_GET, 'action');

    switch ($action) {
        case 'add':
            addTodo($pdo);
            break;

        case 'edit':
            // $updateId = filter_input(INPUT_POST, 'id');
            // $updateTitle = filter_input(INPUT_POST, 'title');
            // editTodo($updateId, $updateTitle);
            editTodo($pdo);
            break;

        case 'delete':
            deleteTodo($pdo);
            break;

        case 'preserve':
            preserveTodo($pdo);
            break;

        case 'back':
            closeEdit($pdo);
            break;
    }
    header('Location: /');
    exit;
}

// TODO: Todoの追加
// if (!empty($_POST['title'])) {
//     // if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//     // POSTの値を受け取る
//     $title = trim(filter_input(INPUT_POST, 'title'));

//     $sql = "INSERT INTO todos (title) VALUES (:title)";
//     $stmt = $pdo->prepare($sql);
//     // $stmt->execute(array(':title' => $title));

//     $stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
//     $stmt->execute();
// }

// TODO: Todoの削除
// if (isset($_POST['delete'])) {
//     $id = $_POST['delete'];

//     $sql = "DELETE FROM todos WHERE id=:id";
//     $stmt = $pdo->prepare($sql);

//     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//     $stmt->execute();
// }

// TODO: Todoの編集
// $updateId = null;
// $updateTitle = null;
if (isset($_POST['edit'])) {
    // $updateId = filter_input(INPUT_POST, 'id');
    // $updateTitle = filter_input(INPUT_POST, 'title');

    // $updateId = $_POST['edit']['id'];
    // $updateTitle = $_POST['edit']['title'];
}

// if (isset($_POST['update'])) {
//     $updateId = $_POST['update']['id'];
//     $updateTitle = $_POST['update']['title'];
// }
// $_POST['update'] = [];
// var_dump($_POST['update']);


$todos = getTodos($pdo);
// $editId = getEditId($pdo);
// $editTitle = getEditTitle($pdo);

$editTodo = getEditTodo($pdo);

// echo $_POST['edit']['id'];
// echo $_POST['edit'];

// echo $todos;
// print_r($todos);

foreach ($todos as $key => $value) {
    # code...
}
// echo $editId;

include('../app/_parts/_header.php');
?>

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
                <?= $todo->title  ?>
            </div>

            <form action="?action=delete" method="post">
                <button name="delete" value="<?= $todo->id ?>" <?= $editTodo->id > 0 ? 'disabled' : '' ?>>削除</button>
                <input type="hidden" name="id" value="<?= $todo->id ?>">
            </form>
            <form action="?action=edit" method="post">
                <!-- <form action="?action=edit" method="post"> -->
                <!-- <form method="post"> -->
                <button <?= $editTodo->id > 0 ? 'disabled' : '' ?>>編集</button>
                <input type="hidden" name="edit[id]" value="<?= $todo->id ?>">
                <input type="hidden" name="id" value="<?= $todo->id ?>">
                <!-- <input type="hidden" name="title" value=""> -->
                <input type="hidden" name="edit[title]" value="<?= $todo->title ?>">
            </form>
        </div>
    <?php endforeach ?>
</div>

<!-- 編集フォーム -->
<?php if ($editTodo->id > 0) : ?>
    <div class="update-todo-form">
        <form action="?action=preserve" method="post">
            ID :
            <?= $editTodo->id ?>
            <input type="hidden" name="id" value="<?= $editTodo->id ?>">
            <input name="title" placeholder="Todoのタイトルを記入" value="<?= $editTodo->title ?>">
            <button>保存</button>
        </form>

        <form action="?action=back" method="post">
            <button>
                <?= $editId ?>
                戻る</button>
            <input type="hidden" name="id" value="<?= $editTodo->id ?>">
        </form>
    </div>
<?php endif ?>
</main>

<?php include('../app/_parts/_footer.php');
