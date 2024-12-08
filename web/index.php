<?php
$conn = new PDO("pgsql:host=postgres_db;port=5432;dbname=library", "user", "password");

function getAuthorsByBook($title) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT a.name 
        FROM authors a
        JOIN author_book ab ON a.id = ab.author_id
        JOIN books b ON b.id = ab.book_id
        WHERE b.title ILIKE ?");
    $stmt->execute(["%$title%"]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        throw new Exception("К сожалению, авторы для книги с таким названием не найдены.");
    }
    return $result;
}

function getBooksByAuthor($name) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT b.title
        FROM books b
        JOIN author_book ab ON b.id = ab.book_id
        JOIN authors a ON a.id = ab.author_id
        WHERE a.name ILIKE ?");
    $stmt->execute(["%$name%"]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        throw new Exception("К сожалению, книги этого автора не найдены.");
    }
    return $result;
}

$authors = $books = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!empty($_POST['book_title'])) {
            $authors = getAuthorsByBook($_POST['book_title']);
        }
        if (!empty($_POST['author_name'])) {
            $books = getBooksByAuthor($_POST['author_name']);
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Библиотека</title>
</head>
<body>
<h1>Поиск в библиотеке</h1>
<form method="POST">
    <label>Найти авторов по названию книги:</label>
    <input type="text" name="book_title" placeholder="Введите название книги">
    <button type="submit">Найти</button>
    <br><br>
    <label>Найти книги по имени автора:</label>
    <input type="text" name="author_name" placeholder="Введите имя автора">
    <button type="submit">Найти</button>
</form>

<?php if ($error): ?>
    <h2 style="color: red;"><?= htmlspecialchars($error) ?></h2>
<?php endif; ?>

<h2>Результаты:</h2>
<?php if (!empty($authors)): ?>
    <h3>Авторы:</h3>
    <ul>
        <?php foreach ($authors as $author): ?>
            <li><?= htmlspecialchars($author['name']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($books)): ?>
    <h3>Книги:</h3>
    <ul>
        <?php foreach ($books as $book): ?>
            <li><?= htmlspecialchars($book['title']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>