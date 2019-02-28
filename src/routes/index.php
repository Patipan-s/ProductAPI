<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
require '../config/db.php';
$app = new \Slim\App;

//Get All Products
$app->get('/api/products/', function(Request $request, Response $response){

    return 'Connected';
    
    // // $sql = "SELECT productID,title,description,price,pic FROM product";
    // $sql = "SELECT * FROM product";

    // try{
    //     //Get DB Object
    //     $mysql = new db();
    //     //Connect
    //     $db = $mysql->connect();

    //     $stmt = $db->prepare($sql);
    //     $stmt.execute();
    //     $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    //     return json_encode($products);

    //     $db = null;
    //     // var_dump($products);
        

    // }catch(PDOException $e){
    //     return '{"error": {"text": '.$e->getMessage().'}';
    // }
});

//GET Single Product
$app->get('/api/product/{productID}',function(Request $request, Response $response){
    $id = $request ->getAttribute('productID');
    $sql = "SELECT * FROM product WHERE productID = $id";
    
    try {
        $db = new db();
        $db = $db->connect();

         $stmt =$db->query($sql);

        $product = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($product);
    }catch(PDOException $e){
        echo'{"error":{"text":}'.$e->getMessage().'}';
    }
});

//Add Products

$app->post('/api/product/add',function(Request $request, Response $response) {

    $productID = $request->getParam('productID') ;
    $title = $request->getParam('title') ;
    $picture = $request->getParam('picture') ;
    $description = $request->getParam('description') ;
    $price = $request->getParam('price') ;
    



    $sql ="INSERT INTO product (productID,title,picture,description,price) VALUES (:productID,:title,:picture,:description,:price)" ;

    try {

        //get DB object

        $db = new db() ;

        //connect

        $db = $db->connect() ;



        $stmt = $db->prepare($sql) ;


        $stmt->bindParam(':productID',    $productID) ;
        $stmt->bindParam(':title',     $title) ;
        $stmt->bindParam(':picture',    $picture) ;
        $stmt->bindParam(':description',    $description) ;
        $stmt->bindParam(':price',    $price) ;



        $stmt->execute() ;

        echo '{"notice: {"text": "Product Add"}' ;



    } catch(PDOExcaption $e) {

            echo '{"error":{"text": '.$e->getMessage().'}' ;

    }

});



//Update Products

$app->put('/api/product/update/{id}',function(Request $request, Response $response) {

    $productID = $request->getParam('productID') ;
    $title = $request->getParam('title') ;
    $picture = $request->getParam('picture') ;
    $description = $request->getParam('description') ;
    $price = $request->getParam('price') ;
    



    $sql = "UPDATE product SET

            title = :title,

            description = :description,

            price = :price,
            pic = :pic

            WHERE productID=$id" ;

    try{

        //Get DB Object

        $db = new db() ;

        // Connect

        $db = $db->connect() ;



        $stmt = $db->prepare($sql) ;



        $stmt->bindParam(':productID',    $productID) ;

        $title = $request->getParam('title') ;
        $picture = $request->getParam('picture') ;
        $description = $request->getParam('description') ;
        $price = $request->getParam('price') ;



        $stmt->execute() ;

        echo '{"notice": {"text": "Product Update"}' ;



    } catch(PODExution $e) {

        echo '{"error": {"text": '.$e->getMessage().'}' ;

    }();

});



//Delete Product

$app->delete('/api/product/delete/{productID}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    $sql = "DELETE FROM product WHERE productID=$id";

    try{

        //Get DB Object

        $db = new db();

        //connect

        $db = $db->connect();



        $stmt = $db->prepare($sql);

        $stmt->execute();

        $db = null;

        echo '{"notice": {"text": "Product Deleted"}';



    }  catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';

    }



});

$app->run();

?>