<?php
header('Content-Type: application/json');

try {
    $conn = new PDO("pgsql:host=postgres_db;port=5432;dbname=library", "user", "password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception("Метод не поддерживается");
    }

    if (!empty($_GET['book_title'])) {
        $stmt = $conn->prepare("
            SELECT a.name 
            FROM authors a
            JOIN author_book ab ON a.id = ab.author_id
            JOIN books b ON b.id = ab.book_id
            WHERE b.title ILIKE ?");
        $stmt->execute(["%" . $_GET['book_title'] . "%"]);
        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["authors" => $authors]);
        exit;
    }

    if (!empty($_GET['author_name'])) {
        $stmt = $conn->prepare("
            SELECT b.title
            FROM books b
            JOIN author_book ab ON b.id = ab.book_id
            JOIN authors a ON a.id = ab.author_id
            WHERE a.name ILIKE ?");
        $stmt->execute(["%" . $_GET['author_name'] . "%"]);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["books" => $books]);
        exit;
    }

    throw new Exception("Некорректные параметры запроса");

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}