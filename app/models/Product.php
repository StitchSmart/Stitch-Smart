<?php
require_once __DIR__ . '/../../config/database.php';
class Product {

    private $conn;
    private $table = "product";

    public function __construct($db){
        $this->conn = $db;
    }


  public function getCategories($parent_id = 0){
    $stmt = $this->conn->prepare(
        "SELECT * FROM category WHERE parent_id=? ORDER BY c_name ASC"
    );
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $categories = [];
    while($row = $result->fetch_assoc()){
        // recursively get children
        $row['children'] = $this->getCategories($row['c_id']);
        $categories[] = $row;
    }
    return $categories;
}

    // get child categories
    public function getSubCategories($parent_id){

        $stmt = $this->conn->prepare(
            "SELECT * FROM category WHERE parent_id=? ORDER BY c_name ASC"
        );

        $stmt->bind_param("i",$parent_id);
        $stmt->execute();

        $result = $stmt->get_result();

        $cats = [];

        while($row = $result->fetch_assoc()){
            $cats[] = $row;
        }

        return $cats;
    }

   
// get single product
public function getProductById($id){
    $stmt = $this->conn->prepare("SELECT * FROM product WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
//get product by categories
public function getProductsByCategory($category_id){

    $stmt = $this->conn->prepare(
        "SELECT * FROM product WHERE parent_cat=? ORDER BY id ASC"
    );

    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}
public function getCategoryName($category_id){

    $stmt = $this->conn->prepare(
        "SELECT c_name FROM category WHERE c_id = ?"
    );

    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        return $row['c_name'];
    }

    return null;
}
// update product
public function updateProduct($data){
    $stmt = $this->conn->prepare("
        UPDATE product SET
        article_number=?, name=?, description=?, details=?, image_url=?, size=?, price=?, parent_cat=?,
        meta_title=?, meta_description=?, meta_keywords=?, slug=?, quantity=?
        WHERE id=?
    ");
    $stmt->bind_param(
        "sssssssissssii",
        $data['article_number'],
        $data['name'],
        $data['description'],
        $data['details'],
        $data['image_url'],
        $data['size'],
        $data['price'],
        $data['parent_cat'],
        $data['meta_title'],
        $data['meta_description'],
        $data['meta_keywords'],
       
        $data['slug'],
        $data['quantity'],
        $data['id']
    );
    ApiService::syncProduct($data);
    return $stmt->execute();

}

public function createProduct($data){
    $stmt = $this->conn->prepare("
        INSERT INTO product
        (article_number,Fabric_Type, name, description, details, image_url, size, price, parent_cat,
        meta_title, meta_description, meta_keywords,  slug, Designing, quantity)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?)
    ");

    if(!$stmt){
        die("Prepare failed: " . $this->conn->error);
    }

    // Bind parameters (s = string, i = int)
    $stmt->bind_param(
        "sssssssssissssi",
        $data['article_number'],
         $data['Fabric_Type'],
        $data['name'],
        $data['description'],
        $data['details'],
        $data['image_url'],
        $data['size'],
        $data['price'],
        $data['parent_cat'],
        $data['meta_title'],
        $data['meta_description'],
        $data['meta_keywords'],
       
        $data['slug'],
         $data['Designing'],
          $data['quantity']
    );

    return $stmt->execute();
}

public function isArticleNumberUnique($article_number) {
    $stmt = $this->conn->prepare("SELECT id FROM product WHERE article_number = ? LIMIT 1");
    $stmt->bind_param("s", $article_number);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows === 0;
}
public function toggleFeatured($id, $status)
{
    $stmt = $this->conn->prepare("
        UPDATE product 
        SET featured = ? 
        WHERE id = ?
    ");

    $stmt->bind_param("ii", $status, $id);
    return $stmt->execute();
}
public function getFeaturedProducts($limit, $offset){

    $stmt = $this->conn->prepare(
        "SELECT * FROM product WHERE featured = 1 ORDER BY id DESC LIMIT ? OFFSET ?"
    );

    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();

    $result = $stmt->get_result();

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}

public function getFeaturedProductsCount(){

    $result = $this->conn->query(
        "SELECT COUNT(*) as total FROM product WHERE featured = 1"
    );

    $row = $result->fetch_assoc();

    return $row['total'];
}
    public function getAllProductsForAI(){

    $sql = "SELECT 
                p.id,
                p.article_number,
                p.name,
                p.description,
                p.details,
                p.price,
                p.size,
                p.image_url,
                p.Fabric_Type as fabric_type,
                p.Designing as designing,
                p.parent_cat,
                p.slug,
                p.quantity,
                c.c_name as category
            FROM product p
            LEFT JOIN category c ON p.parent_cat = c.c_id
            ORDER BY p.id ASC";

    $result = $this->conn->query($sql);

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}

public function getAllProductsPaginated($limit, $offset){

    $stmt = $this->conn->prepare(
        "SELECT * FROM product ORDER BY id DESC LIMIT ? OFFSET ?"
    );

    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();

    $result = $stmt->get_result();

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}


public function getAllProductsCount(){

    $result = $this->conn->query(
        "SELECT COUNT(*) as total FROM product"
    );

    $row = $result->fetch_assoc();

    return $row['total'];
}
public function getProductBySlug($slug){

    $stmt = $this->conn->prepare("SELECT id FROM product WHERE slug=? LIMIT 1");
    $stmt->bind_param("s", $slug);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}
    // delete product
public function deleteProduct($id){

    $stmt = $this->conn->prepare("DELETE FROM product WHERE id=?");
    $stmt->bind_param("i",$id);

    return $stmt->execute();
}
public function searchProducts($keyword, $sort = null){

    $keyword = "%".$keyword."%";

    $order = "p.id ASC";

    if($sort == "low"){
        $order = "p.price ASC";
    } elseif($sort == "high"){
        $order = "p.price DESC";
    }

    $stmt = $this->conn->prepare(
        "SELECT p.* FROM product p
         LEFT JOIN category c ON p.parent_cat = c.c_id
         LEFT JOIN category parent_c ON c.parent_id = parent_c.c_id
         WHERE p.name LIKE ? OR p.description LIKE ? OR c.c_name LIKE ? OR parent_c.c_name LIKE ?
         ORDER BY $order"
    );

    $stmt->bind_param("ssss", $keyword, $keyword, $keyword, $keyword);
    $stmt->execute();

    $result = $stmt->get_result();

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}
public function getAllProducts($sort = null){

    $order = "id ASC";

    if($sort == "low"){
        $order = "price ASC";
    } elseif($sort == "high"){
        $order = "price DESC";
    } elseif($sort == "stock"){
        $order = "stock DESC"; // assuming column exists
    }

    $sql = "SELECT * FROM product ORDER BY $order";

    $result = $this->conn->query($sql);

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}
// Fetch related products
public function getRelatedProducts($category_id, $exclude_id, $limit = 4){
    $stmt = $this->conn->prepare(
        "SELECT * FROM product WHERE parent_cat=? AND id != ? ORDER BY RAND() LIMIT ?"
    );
    $stmt->bind_param("iii", $category_id, $exclude_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $related = [];
    while($row = $result->fetch_assoc()){
        $related[] = $row;
    }

    return $related;
}
    public function reduceStock($productId, $qty)
    {
        $stmt = $this->conn->prepare(
            "UPDATE product SET quantity = quantity - ? WHERE id = ? AND quantity >= ?"
        );

        $stmt->bind_param("iii", $qty, $productId, $qty);

        return $stmt->execute();
    }

    public function increaseStock($productId, $qty)
    {
        $stmt = $this->conn->prepare(
            "UPDATE product SET quantity = quantity + ? WHERE id = ?"
        );
        $stmt->bind_param("ii", $qty, $productId);
        return $stmt->execute();
    }

    public function getProductByArticleNumber($articleNumber) {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE article_number = ?");
        $stmt->bind_param("s", $articleNumber);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    private function ensureReviewTableExists() {
        $result = $this->conn->query("SHOW TABLES LIKE 'product_reviews'");
        if ($result && $result->num_rows === 0) {
            $this->conn->query("CREATE TABLE product_reviews (
                id INT(11) NOT NULL AUTO_INCREMENT,
                user_id INT(11) NOT NULL,
                product_id INT(11) NOT NULL,
                rating TINYINT(1) NOT NULL,
                comment TEXT,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                PRIMARY KEY(id),
                KEY idx_product_id (product_id),
                KEY idx_user_product (user_id, product_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
    }

    public function getProductReviews($productId) {
        $this->ensureReviewTableExists();
        $stmt = $this->conn->prepare(
            "SELECT pr.*, u.name AS reviewer_name
             FROM product_reviews pr
             LEFT JOIN users u ON u.id = pr.user_id
             WHERE pr.product_id = ?
             ORDER BY pr.created_at DESC"
        );
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        return $reviews;
    }

    public function getProductReviewSummary($productId) {
        $this->ensureReviewTableExists();
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) AS review_count, IFNULL(AVG(rating), 0) AS average_rating
             FROM product_reviews
             WHERE product_id = ?"
        );
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return [
            'count' => (int)$row['review_count'],
            'average' => round((float)$row['average_rating'], 1)
        ];
    }

    public function userHasReviewedProduct($userId, $productId) {
        $this->ensureReviewTableExists();
        $stmt = $this->conn->prepare(
            "SELECT id FROM product_reviews WHERE user_id = ? AND product_id = ? LIMIT 1"
        );
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function addProductReview($userId, $productId, $rating, $comment) {
        $this->ensureReviewTableExists();
        $stmt = $this->conn->prepare(
            "INSERT INTO product_reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iiis", $userId, $productId, $rating, $comment);
        return $stmt->execute();
    }

    public function userHasPurchasedProduct($userId, $productId) {
        $stmt = $this->conn->prepare(
            "SELECT oi.id
             FROM orders o
             INNER JOIN order_items oi ON o.id = oi.order_id
             WHERE o.user_id = ? AND oi.product_id = ?
             LIMIT 1"
        );
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
