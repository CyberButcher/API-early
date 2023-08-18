<?php
require_once "connection_to_db.php";

function getUsers ($conn){

    $query = "SELECT * FROM test";
    $qer = $conn->query($query);
    $res = $qer->fetchAll();

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
}

function getUser ($conn, $id){
    $query = "SELECT * FROM test WHERE `id` = '$id'";
    $qer = $conn->query($query);
    $res = $qer->fetchAll();
    
    if(count($res) < 1){
        http_response_code(404);
        $messg = [
            "status" => false,
            "message" => "User not found"
        ];
        echo json_encode($messg);
    } else {

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}

function addUser($conn, $data){
    if(count($data) > 0){
    $name = $data['name'];
    $age = $data['age'];
    $login = $data['login'];
    $pass= $data['pass'];

    $query = "INSERT INTO `test`(`name`, `age`, `login`, `pass`) VALUES (:name, :age, :login, :pass)";
    $queryPrep = $conn->prepare($query);
    $queryPrep->execute(['name'=>$name, 'age'=>$age, 'login'=>$login, 'pass'=>$pass]);

    http_response_code(201);
    $messg = [
        "status" => true,
        "user_id" => $conn->lastInsertId()
    ];

    echo json_encode($messg, JSON_UNESCAPED_UNICODE);
    }
}

function updateUser($conn, $id, $data){
    $name = $data['name'];
    $age = $data['age'];
    $login = $data['login'];
    $pass= $data['pass'];
    $status = $data['status'];
    $adm= $data['adm'];

    $query = "SELECT `name`, `age`, `login`, `pass`, `status`, `adm` FROM `test` WHERE `id` = :id";
    $queryPrep = $conn->prepare($query);
    $queryPrep->execute(['id'=>$id]);
    $data2 = $queryPrep->fetchAll(PDO::FETCH_ASSOC);

    if(empty($name) && $name !== "0"){
        $name = $data2[0]['name'];
    }
    if(empty($age) && $age !== "0"){
        $age = $data2[0]['age'];
    }
    if(empty($login) && $login !== "0"){
        $login = $data2[0]['login'];        
    }
    if(empty($pass) && $pass !== "0"){
        $pass = $data2[0]['pass'];
    }
    if(empty($status) && $status !== "0"){
        $status = $data2[0]['status'];
    }
    if(empty($adm) && $adm !== "0"){
        $adm = $data2[0]['adm'];
    }

    $query = "UPDATE test SET name = :name, age = :age, login = :login, pass = :pass, status = :status, adm = :adm WHERE id = :id";
    $queryPrep = $conn->prepare($query);
    $queryPrep->execute(['name'=>$name, 'age'=>$age, 'login'=>$login, 'pass'=>$pass, 'status'=>$status, 'adm'=>$adm, 'id'=>$id]);

    http_response_code(200);
    $messg = [
        "status" => true,
        "message" => "User $name is updated"
    ];

    echo json_encode($messg, JSON_UNESCAPED_UNICODE);
}

function getProds ($conn){

    $query = "SELECT * FROM products";
    $qer = $conn->query($query);
    $res = $qer->fetchAll();

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
}

function getProd ($conn, $id){
    $query = "SELECT * FROM products WHERE `id` = '$id'";
    $qer = $conn->query($query);
    $res = $qer->fetchAll();
    
    if(count($res) < 1){
        http_response_code(404);
        $messg = [
            "status" => false,
            "message" => "Product not found"
        ];
        echo json_encode($messg);
    } else {

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}

function addProd($conn, $data){
    if(count($data) > 0){
        $name = $data['name'];
        $cost = $data['cost'];

        $query = "INSERT INTO `products`(`name`, `cost`) VALUES (:name, :cost)";
        $queryPrep = $conn->prepare($query);
        $queryPrep->execute(['name'=>$name, 'cost'=>$cost]);

        http_response_code(201);
        $messg = [
            "status" => true,
            "prod_id" => $conn->lastInsertId()
        ];

        echo json_encode($messg, JSON_UNESCAPED_UNICODE);
    }
}

function updateProd($conn, $id, $data){
    $name = $data['name'];
    $cost = $data['cost'];

    $query = "SELECT `name`, `cost` FROM `products` WHERE `id` = :id";
    $queryPrep = $conn->prepare($query);
    $queryPrep->execute(['id'=>$id]);
    $data2 = $queryPrep->fetchAll(PDO::FETCH_ASSOC);

    if(empty($name) && $name !== "0"){
        $name = $data2[0]['name'];
    }
    if(empty($cost) && $cost !== "0"){
        $cost = $data2[0]['cost'];
    }

    $query = "UPDATE products SET name = :name, cost = :cost WHERE id = :id";
    $queryPrep = $conn->prepare($query);
    $queryPrep->execute(['name'=>$name, 'cost'=>$cost, 'id'=>$id]);

    http_response_code(200);
    $messg = [
        "status" => true,
        "message" => "Product $name is updated"
    ];

    echo json_encode($messg, JSON_UNESCAPED_UNICODE);
}

function getAdrs ($conn){

    $query = "SELECT * FROM addresses";
    $qer = $conn->query($query);
    $res = $qer->fetchAll();

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
}

function getAdr ($conn, $id){
    $query = "SELECT * FROM addresses WHERE `id` = '$id'";
    $qer = $conn->query($query);
    $res = $qer->fetchAll();
    
    if(count($res) < 1){
        http_response_code(404);
        $messg = [
            "status" => false,
            "message" => "Address not found"
        ];
        echo json_encode($messg);
    } else {

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}

function addAdr($conn, $data){
    if(count($data) > 0){
        $street = $data['street'];
        $city = $data['city'];

        $query = "INSERT INTO `addresses`(`street`, `city`) VALUES (:street, :city)";
        $queryPrep = $conn->prepare($query);
        $queryPrep->execute(['street'=>$street, 'city'=>$city]);

        http_response_code(201);
        $messg = [
            "status" => true,
            "address_id" => $conn->lastInsertId()
        ];

        echo json_encode($messg, JSON_UNESCAPED_UNICODE);
    }
}

function updateAdr($conn, $id, $data){
    $street = $data['street'];
    $city = $data['city'];

    $query = "SELECT `street`, `city` FROM `addresses` WHERE `id` = :id";
    $queryPrep = $conn->prepare($query);
    $queryPrep->execute(['id'=>$id]);
    $data2 = $queryPrep->fetchAll(PDO::FETCH_ASSOC);

    if(empty($street) && $street !== "0"){
        $street = $data2[0]['street'];
    }
    if(empty($city) && $city !== "0"){
        $city = $data2[0]['city'];
    }

    $query = "UPDATE addresses SET street = :street, city = :city WHERE id = :id";
    $queryPrep = $conn->prepare($query);
    $queryPrep->execute(['street'=>$street, 'city'=>$city, 'id'=>$id]);

    http_response_code(200);
    $messg = [
        "status" => true,
        "message" => "Address $street is updated"
    ];

    echo json_encode($messg, JSON_UNESCAPED_UNICODE);
}

function ajax_echo(
    $title = '',
    $text = '',
    $error = false,
    $type = 'ERROR',
    $other = null
    ){
    return json_encode(array(
        "error" => $error,
        "type" => $type,
        "title" => $title,
        "desc" => $text,
        "other" => $other,
        "datetime" => array(
            'Y' => date('Y'),
            'm' => date('m'),
            'd' => date('d'),
            'H' => date('H'),
            'i' => date('i'),
            's' => date('s'),
            'full' => date('Y-m-d H:i:s'),
        )
    ), JSON_UNESCAPED_UNICODE);
}