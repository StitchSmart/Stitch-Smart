<?php
require_once __DIR__ . '/../../config/database.php';

class Category {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Get all categories for listing
    public function getAllCategories(){
        $query = "SELECT * FROM category ORDER BY c_id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get all categories in a hierarchical structure for dropdowns
    public function getHierarchicalCategories() {
        $query = "SELECT c_id, c_name, parent_id FROM category ORDER BY parent_id ASC, c_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        
        return $this->buildHierarchy($categories);
    }

    private function buildHierarchy(array $elements, $parentId = 0, $level = 0) {
        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $element['level'] = $level;
                $branch[] = $element;
                $children = $this->buildHierarchy($elements, $element['c_id'], $level + 1);
                if ($children) {
                    foreach ($children as $child) {
                        $branch[] = $child;
                    }
                }
            }
        }
        return $branch;
    }

    // Get parent categories for add form (legacy support or simple list)
    public function getParentCategories(){
        return $this->getHierarchicalCategories();
    }

    // Create new category
    public function createCategory($data){
        $query = "INSERT INTO category 
        (c_name, c_description, parent_id, c_img2, c_image, meta_title, meta_description, meta_keywords) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "ssisssss",
            $data['name'],
            $data['desc'],
            $data['parent'],
            $data['banner'],
            $data['image'],
            $data['meta_title'],
            $data['meta_desc'],
            $data['meta_keywords']
        );
        return $stmt->execute();
    }

// Get single category
public function getCategoryById($id){
    $query = "SELECT * FROM category WHERE c_id=?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Update category
public function updateCategory($data){
    $query = "UPDATE category SET c_name=?, c_description=?, parent_id=?, c_img2=?, c_image=?, meta_title=?, meta_description=?, meta_keywords=? WHERE c_id=?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param(
        "ssisssssi",
        $data['name'],
        $data['desc'],
        $data['parent'],
        $data['banner'],
        $data['image'],
        $data['meta_title'],
        $data['meta_desc'],
        $data['meta_keywords'],
        $data['id']
    );
    return $stmt->execute();
}

    // Delete category
    public function deleteCategory($id){
        $query = "DELETE FROM category WHERE c_id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    // get main categories
    public function getMainCategories(){

        $sql = "SELECT * FROM category 
                WHERE parent_id IS NULL OR parent_id = 0
                ORDER BY c_name ASC";

        $result = $this->conn->query($sql);

        $categories = [];

        while($row = $result->fetch_assoc()){
            $categories[] = $row;
        }

        return $categories;
    }


    // get sub categories
    public function getSubCategories($parent_id){

        $stmt = $this->conn->prepare(
            "SELECT * FROM category WHERE parent_id=? ORDER BY c_name ASC"
        );

        $stmt->bind_param("i",$parent_id);

        $stmt->execute();

        $result = $stmt->get_result();

        $categories = [];

        while($row = $result->fetch_assoc()){
            $categories[] = $row;
        }

        return $categories;
    }

    // Get full tree for frontend navigation
    public function getCategoriesTree() {
        $main = $this->getMainCategories();
        foreach ($main as &$parent) {
            $parent['subs'] = $this->getSubCategories($parent['c_id']);
        }
        return $main;
    }

    // Search categories
    public function searchCategories($keyword) {
        $keyword = "%".$keyword."%";
        $query = "SELECT * FROM category WHERE c_name LIKE ? OR c_description LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $categories = [];
        while($row = $result->fetch_assoc()){
            $categories[] = $row;
        }
        return $categories;
    }
}

?>