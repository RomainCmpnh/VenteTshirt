<?php
    // Inclus la connexion à la DB
    include_once("database.php");

    
    function getAllTshirtsOrderNew(){

        $sql = "SELECT * FROM Tshirts ORDER BY id_Tshirt DESC";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function getAllTshirtsOrderPriceA(){

        $sql = "SELECT * FROM Tshirts ORDER BY price ASC";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function getAllTshirtsOrderPriceB(){

        $sql = "SELECT * FROM Tshirts ORDER BY price DESC";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

   
    function getAllTshirtsBySearch($search){

        $search = "%".$search."%";

        $sql = "SELECT * FROM Tshirts  AS c JOIN models as m ON m.id_model = c.id_model WHERE m.name LIKE :search";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':search' => $search,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function getAllTshirtsOrderMarque(){

        $sql = "SELECT * FROM Tshirts AS c JOIN models as m ON m.id_model = c.id_model JOIN brands AS b ON b.id_brand = m.id_brand ORDER BY b.name";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

   
    function getAllTshirtsById($id){

        $sql = "SELECT * FROM Tshirts WHERE id_Tshirt = :id";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    function getAllModelsById($id){

        $sql = "SELECT * FROM models WHERE id_model = :id";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

   
    function getAllBrandsById($id){

        $sql = "SELECT * FROM brands WHERE id_brand = :id";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

 
    function getAllPagesProduct($nb_result_wanted){

        $sql = "SELECT * FROM Tshirts";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        $resultat = $query->fetchAll(PDO::FETCH_ASSOC);
        $nb_result = 0;
        foreach($resultat as $item){
            $nb_result +=1;
        }
        $number_of_page = ceil($nb_result / $nb_result_wanted);

        return $number_of_page;
    }

   
    function getAllProductParPagesDate($page_first_result, $results_par_page){

        $sql = "SELECT * FROM Tshirts ORDER BY id_Tshirt DESC LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function getAllTshirtsOrderPriceAPage($page_first_result, $results_par_page){

        $sql = "SELECT * FROM Tshirts ORDER BY price ASC LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

  
    function getAllTshirtsOrderPriceBPage($page_first_result, $results_par_page){

        $sql = "SELECT * FROM Tshirts ORDER BY price DESC LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

 
    function getAllTshirtsOrderMarquePage($page_first_result, $results_par_page){

        $sql = "SELECT * FROM Tshirts AS c JOIN models as m ON m.id_model = c.id_model JOIN brands AS b ON b.id_brand = m.id_brand ORDER BY b.name LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

  
    function addOrders($total, $date, $user){
        $sql = "INSERT INTO orders (total_price, order_date, id_user) VALUES (:total, :date, :user)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':total' => $total,
            ':date' => $date,
            ':user' => $user,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

  
    function addOrder_Tshirts($id_order, $id_Tshirt, $quantity, $price){
        $sql = "INSERT INTO order_Tshirts (id_order, id_Tshirt, quantity, unit_price) VALUES (:id_order, :id_Tshirt, :quantity, :price)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':id_order' => $id_order,
            ':id_Tshirt' => $id_Tshirt,
            ':quantity' => $quantity,
            ':price' => $price,
        ]);
        $id = connect()->lastInsertId();
        return $id;
    }

   
    function addFav($idUser, $idTshirt){
        $sql = "INSERT INTO favorite (id_user, id_Tshirt) VALUES (:id_user, :id_Tshirt)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':id_user' => $idUser,
            ':id_Tshirt' => $idTshirt,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

   
    function getAllFavByUserId($id){

        $sql = "SELECT * FROM favorite WHERE id_user = :id";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

   
    function getSpecificFav($idUser, $idTshirt){

        $sql = "SELECT * FROM favorite WHERE id_user = :idUser AND id_Tshirt = :idTshirt";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':idUser' => $idUser,
            ':idTshirt' => $idTshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

 
    function deleteFav($idUser, $idTshirt){
        $sql = "DELETE FROM favorite WHERE id_user = :id_user AND id_Tshirt = :id_Tshirt";

        $query = connect()->prepare($sql);

        $query->execute([
            ':id_user' => $idUser,
            ':id_Tshirt' => $idTshirt,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }


    function getAllTshirtsOrderFav($userid){

        $sql = "SELECT * FROM Tshirts AS c JOIN favorite as f ON f.id_Tshirt = c.id_Tshirt WHERE f.id_user = :id_user";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_user' => $userid,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

  
    function getAllTshirtsOrderFavPage($userid, $page_first_result, $results_par_page){

        $sql = "SELECT * FROM Tshirts AS c JOIN favorite as f ON f.id_Tshirt = c.id_Tshirt WHERE f.id_user = :id_user LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_user' => $userid,
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

   
    function getAllOrderdByUserId($userid){

        $sql = "SELECT * FROM orders WHERE id_user = :idUser";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':idUser' => $userid,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    function getAllOrderItemsdByOrderId($orderid){

        $sql = "SELECT * FROM order_Tshirts WHERE id_order = :orderId";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':orderId' => $orderid,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function updateQuantityTshirts($quantity, $TshirtId){

        $sql = "UPDATE Tshirts SET quantity=:quantity WHERE id_Tshirt = :TshirtId";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':quantity' => $quantity,
            ':TshirtId' => $TshirtId,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllOrders(){

        $sql = "SELECT * FROM orders";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function changeEtatOrder($idOrder, $etat){

        if($etat==true || $etat==false){
            if($etat==true){
                $sql = "UPDATE orders SET is_confirmed=1 WHERE id_order = :id_order";
            }
            else{
                $sql = "UPDATE orders SET is_confirmed=0 WHERE id_order = :id_order";
            }
        
            $query = connect()->prepare($sql);
    
            $query->execute([
                ':id_order' => $idOrder,
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }

    function delOrder($idOrder){
        $sql = "DELETE FROM orders WHERE id_order = :id_order";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_order' => $idOrder,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function delOrderItem($idOrder, $id_Tshirt){
        $sql = "DELETE FROM order_Tshirts WHERE id_order = :id_order AND id_Tshirt = :id_Tshirt";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_order' => $idOrder,
            ':id_Tshirt' => $id_Tshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function updateOrderPrice($idOrder, $price){
  
        $sql = "UPDATE orders SET total_price=:total_price WHERE id_order = :id_order";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':total_price' => $price,
            ':id_order' => $idOrder,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function delOrderItemByOrderId($idOrder){
        $sql = "DELETE FROM order_Tshirts WHERE id_order = :id_order";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_order' => $idOrder,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getBrandsByName($name){

        $sql = "SELECT * FROM brands WHERE name = :name";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':name' => $name,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function addBrand($marque){
        $sql = "INSERT INTO brands (name) VALUES (:name)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':name' => $marque,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

    function addModel($nom, $idMarque){
        $sql = "INSERT INTO models (name, id_brand) VALUES (:name, :idMarque)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':name' => $nom,
            ':idMarque' => $idMarque,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

    function addTshirt($id_model, $price, $description, $quantity){
        $sql = "INSERT INTO Tshirts (id_model, price, description, quantity) VALUES (:id_model, :price, :description, :quantity)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':id_model' => $id_model,
            ':price' => $price,
            ':description' => $description,
            ':quantity' => $quantity,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

    function updateTshirt($idTshirt, $price, $description, $quantity){

        $sql = "UPDATE Tshirts SET price=:price, description=:description, quantity=:quantity WHERE id_Tshirt = :id_Tshirt";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_Tshirt' => $idTshirt,
            ':price' => $price,
            ':description' => $description,
            ':quantity' => $quantity,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function updateModels($idModel, $nom, $marqueId){

        $sql = "UPDATE models SET name=:name, id_brand=:id_brand WHERE id_model = :id_model";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_model' => $idModel,
            ':name' => $nom,
            ':id_brand' => $marqueId,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function updatebrands($idBrand, $nom){

        $sql = "UPDATE models SET name=:name WHERE id_brand = :id_brand";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_brand' => $idBrand,
            ':name' => $nom,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function delTshirt($idTshirt){
        $sql = "DELETE FROM Tshirts WHERE id_Tshirt = :id_Tshirt";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_Tshirt' => $idTshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function delModel($idModel){
        $sql = "DELETE FROM models WHERE id_model = :id_model";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_model' => $idModel,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function delFavorisByIdTshirt($idTshirt){
        $sql = "DELETE FROM favorite WHERE id_Tshirt = :id_Tshirt";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_Tshirt' => $idTshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function delOrderTshirtByIdTshirt($idTshirt){
        $sql = "DELETE FROM order_Tshirts WHERE id_Tshirt = :id_Tshirt";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_Tshirt' => $idTshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
?>