<?php

class Authors {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAuthorsByBook($bookTitle) {
        $stmt = $this->conn->prepare("
            SELECT a.name 
            FROM authors a
            JOIN author_book ab ON a.id = ab.author_id
            JOIN books b ON b.id = ab.book_id
            WHERE b.title ILIKE ?");
        $stmt->execute(["%" . $bookTitle . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}