<?php
$todos = [];

if (file_exists('todo.txt')) {
    $file = file_get_contents('todo.txt');
    $todos = unserialize($file);
}

if (isset($_POST['todo'])) {
    $data = $_POST['todo'];
    $todos[] = [
        'todo' => $data,
        'status' => 0
    ];
    saveData($todos);
};

if(isset($_GET['status'])){
    $todos[$_GET['key']]['status'] = $_GET['status'];
    saveData($todos);
};

if(isset($_GET['hapus'])){
    unset($todos[$_GET['key']]);
    saveData($todos);
};

function saveData($todos){
    file_put_contents('todo.txt', serialize($todos));
    header('Location: copy.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloning</title>
</head>
<body>
    <header>
        <center>
            <h3>Organize Your Things!</h3>
        </center>
    </header>

    <main>
        <form method="POST">
            <label for="todo">Belanja apa hari ini?</label>
            <input type="text" name="todo">
            <button type="submit">Simpan</button>
        </form>

        <ul>
            <?php foreach ($todos as $key => $value):?>
            <li>
                <input type="checkbox" name="todo" onclick="window.location.href='copy.php?status=<?php echo ($value['status']) ? '0' : '1'; ?> &key=<?php echo $key; ?>'" <?php if ($value['status'] == 1) echo 'checked'?>>
                <label>
                    <?php
                        if ($value['status'] == 1) {
                            echo '<del>' . $value['todo'] . '</del>';
                        } else {
                            echo $value['todo'];
                        };
                    ?>
                </label>
                <a href="copy.php?hapus=1&key=<?php echo $key; ?>" onclick="return confirm('Kamu yakin?')">Hapus</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>