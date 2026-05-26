<?php
require_once __DIR__ . '/../../config/database.php';

class Page {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Fetch all pages
    public function getAllPages(){
        $sql = "SELECT * FROM pages ORDER BY id ASC";
        $result = $this->conn->query($sql);

        $pages = [];
        if($result){
            while($row = $result->fetch_assoc()){
                $pages[] = $row;
            }
        }
        return $pages;
    }

    // Find page by ID
    public function getPageById($id){
        $stmt = $this->conn->prepare("SELECT * FROM pages WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Create new page
    public function createPage($data){
        $slug = $this->createSlug($data['title']);
        $stmt = $this->conn->prepare("INSERT INTO pages 
            (title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param(
            "ssssss",
            $data['title'],
            $slug,
            $data['content'],
            $data['meta_title'],
            $data['meta_description'],
            $data['meta_keywords']
        );
        return $stmt->execute();
    }
public function getPageBySlug($slug){
    $stmt = $this->conn->prepare("SELECT * FROM pages WHERE slug=? AND is_published=1");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
    // Update page
    public function updatePage($data){
        $slug = $this->createSlug($data['title']);
        $stmt = $this->conn->prepare("UPDATE pages SET 
            title=?, slug=?, content=?, meta_title=?, meta_description=?, meta_keywords=?, updated_at=NOW() 
            WHERE id=?");
        $stmt->bind_param(
            "ssssssi",
            $data['title'],
            $slug,
            $data['content'],
            $data['meta_title'],
            $data['meta_description'],
            $data['meta_keywords'],
            $data['id']
        );
        return $stmt->execute();
    }

    // Delete page
    public function deletePage($id){
        $stmt = $this->conn->prepare("DELETE FROM pages WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Helper to create slugs
    private function createSlug($string){
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return rtrim($slug, '-');
    }
}
?>