<?php
header('Content-Type: application/json');

require_once 'classes/Database.php';
require_once 'classes/Authors.php';
require_once 'classes/Books.php';

try {
    $db = new Database('postgres_db', '5432', 'library', 'user', 'password');
    $conn = $db->getConnection();

    $authors = new Authors($conn);
    $books = new Books($conn);

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception("Метод не поддерживается");
    }

    if (!empty($_GET['book_title'])) {
        $result = $authors->getAuthorsByBook($_GET['book_title']);
        echo json_encode(["authors" => $result]);
        exit;
    }

    if (!empty($_GET['author_name'])) {
        $result = $books->getBooksByAuthor($_GET['author_name']);
        echo json_encode(["books" => $result]);
        exit;
    }

    throw new Exception("Некорректные параметры запроса");

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}