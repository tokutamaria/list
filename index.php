<?php
require_once('function.php');

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = htmlspecialchars($name, ENT_QUOTES);

   $dbh = db_connect();

    $sql = 'INSERT INTO tasks (name,done) VALUES (?, 0)';

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $name,PDO::PARAM_STR);

    $stmt->execute();

    $dbh = null;

    unset($name);


    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";


}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todoリスト</title>
</head>
<h1>Todoリスト</h1>
<form action="index.php" method="post">
    <ul>
        <li><span>タスク名</span><input type="text" name="name"></li>
        <li><input type="submit" name="submit"></li>
    </ul>
</form>
<ul>
<?php
$dbh = db_connect();

$sql = 'SELECT id, name, done FROM tasks ORDER BY id DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$dbh =null;

while($task = $stmt->fetch(PDO::FETCH_ASSOC)){
    print '<li>';
    print $task["name"];

    print ' <form action="index.php" method="post>
    <input type="hidden" name="method" value="put">
    <input type="hidden" name="id" value="' . $task['id'] . '">
    <button type="submit">済んだ</button></form>' ;

    print '</li>';
}

?>
</ul>
<body>

</body>
</html>
