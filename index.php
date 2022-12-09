<?php
$filename = 'todo.json';
$todo = '';
$error = '';
$todos = [];
if (file_exists($filename)) {
    $data = file_get_contents($filename);
    $todos = json_decode($data, true) ?? [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $todo = $_POST['todo'] ?? '';
    if (!$todo) {
        $error = "Votre to do est vide";
    } else if (mb_strlen($todo) < 5) {
        $error = "Votre to do est trop courte";
    }
    if (!$error) {
        $todos = [...$todos, [
            'name' => ucfirst($todo),
            'done' => false,
            'id' => time(),
        ]];
        file_put_contents($filename, json_encode($todos));
        header('location:/');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="header">
            <h1>To Do Liste</h1>
        </div>
    </header>
    <main>
        <div class="container">

            <div class="form_control">
                <form action="/" method="post">
                    <input type="text" name="todo">
                    <button>Ajouter</button>
                </form>
                <?php if ($error) : ?>
                    <p class="danger"><?= $error ?></p>
                <?php endif ?>
            </div>
            <div class="todo_container">
                <ul>
                    <?php foreach ($todos as $to) : ?>
                        <li class="<?= $to['done'] ? 'low-opacity' : '' ?>">
                            <?= $to['name'] ?>
                            <div class="btn_container">
                                <a class="btn green" href="edit.php?id=<?= $to['id'] ?>"> <?= $to['done'] ? "Valider" : "Annuler" ?></a>
                                <a class="btn blue" href="delete.php?id=<?= $to['id'] ?>"> Supprimer</a>
                            </div>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>

        </div>
    </main>
</body>

</html>