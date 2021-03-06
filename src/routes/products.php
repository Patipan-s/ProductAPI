<?php
require '../../vendor/autoload.php';
$app = new Slim\App;


//Get All Products
$app->get('/api/products', function ($request, $response) {
    header("Content-Type: application/json");
    getProducts();
});

//GET Single Product
$app->get('/api/products/{id}', function ($request, $response, $args) {
    return '{"data":"' . $args['id'] . '"}'; 
});



function getProducts() {
    $sql = "select productID, title, pisture, description FROM product";
      try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($products);
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    }
function getConnection() {
    $dbhost="sql12.freemysqlhosting.net";
    $dbuser="sql12235819";
    $dbpass="HILAldVgjQ";
    $dbname="sql12235819";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);  
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
$app->run();

?>