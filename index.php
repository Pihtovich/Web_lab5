<?php
$mysqli = new mysqli('db', 'root', 'helloworld', 'web');
if (mysqli_connect_errno()) {
    printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
    exit;
}
// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $mysqli->real_escape_string($_POST['email']);
    $title = $mysqli->real_escape_string($_POST['title']);
    $category = $mysqli->real_escape_string($_POST['categories']);
    $description = $mysqli->real_escape_string($_POST['text']);
    $mysqli->query("INSERT INTO ad (email, title, description, category) VALUES ('$email', '$title', '$description', '$category')");
}
$mas = [];
if ($result = $mysqli->query('SELECT * FROM ad ORDER BY created DESC')) {
    while ($row = $result->fetch_assoc()) {
        $mas[] = $row;
    }
    $result->close();
}
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lab 5</title>
</head>
<body>
<div>
    <form action="index.php" method="POST">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required><br />
        <label for="category">Categories</label>
        <select id="category" name="category" required>
            <option value="Cars">Cars</option>
            <option value="TypeofSport">Type of Sport</option>
            <option value="Music">Music</option>
        </select><br />
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required><br />
        <label for="description">Description:</label><br />
        <textarea rows="5" cols = "32" name="description"></textarea><br />
        <input type="submit" value="Add">
    </form>
</div>
<div>
    <table>
        <thead>
        <th>Email</th>
        <th>Category</th>
        <th>Title</th>
        <th>Description</th>
        </thead>
        <tbody>
        <?php
        if (!empty($ads)) {
            foreach ($ads as $ad) {
                echo "<tr>";
                echo "<td>" . ($ad['email']) . "</td>";
                echo "<td>" . ($ad['title']) . "</td>";
                echo "<td>" . ($ad['description']) . "</td>";
                echo "<td>" . ($ad['category']) . "</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
