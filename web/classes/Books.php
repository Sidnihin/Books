<?php

class Books {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getBooksByAuthor($authorName) {
        $stmt = $this->conn->prepare("
            SELECT b.title
            FROM books b
            JOIN author_book ab ON b.id = ab.book_id
            JOIN authors a ON a.id = ab.author_id
            WHERE a.name ILIKE ?");
        $stmt->execute(["%" . $authorName . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}