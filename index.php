<?php
header("Content-type: application/json; charset=UTF-8");
require_once "connection_to_db.php";
require_once "func.php";
//require_once "token_func.php";

$method = $_SERVER['REQUEST_METHOD'];

if (isset($_GET['q'])){
$q = $_GET['q'];} else {$q = '';}
$params = explode('/', $q, 3);
$parts = explode('/', $_GET['q']);

if (isset($params[0]) && $params[0] !== '')
{
    $token = $params[0];
    if (isset($params[1])){
        $type = $params[1];
        if(isset($params[2])){
            $id = $params[2];
        }
    }
}
else if($params[0] === ''){
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Вы не указали token", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}
if(empty($parts[1])){
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Вы не указали type", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

// Check if the token is in the database
$query = "SELECT * FROM tokens WHERE value = :token";
$stmt = $conn->prepare($query);
$stmt->bindValue(':token', $token);
$stmt->execute();
$result = $stmt->fetchAll();

if (empty($result)) {
    // header("HTTP/1.1 401 Unauthorized");
    // exit();
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Неверный токен", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

switch ($method) {
    case 'GET':
        if($type === 'users'){
            if(isset($id)){
                getUser($conn, $id);
            } else {
                getUsers($conn);
            }
        }
        if($type === 'products'){
            if(isset($id)){
                getProd($conn, $id);
            } else {
                getProds($conn);
            }
        }
        if($type === 'address'){
            if(isset($id)){
                getAdr($conn, $id);
            } else {
                getAdrs($conn);
            }
        }
        break;
    case 'POST':
        if($type === 'users'){
            addUser($conn, $_POST);
        }
        if($type === 'products'){
            addProd($conn, $_POST);
        }
        if($type === 'address'){
            addAdr($conn, $_POST);
        }
        break;
    case 'PATCH':
        if($type === 'users'){
            if(isset($id)){
                $data = file_get_contents('php://input'); // only JSON raw
                $data = json_decode($data, true);
                updateUser($conn, $id, $data);
            }
        }
        if($type === 'products'){
            if(isset($id)){
                $data = file_get_contents('php://input'); // only JSON raw
                $data = json_decode($data, true);
                updateProd($conn, $id, $data);
            }
        }
        if($type === 'address'){
            if(isset($id)){
                $data = file_get_contents('php://input'); // only JSON raw
                $data = json_decode($data, true);
                updateAdr($conn, $id, $data);
            }
        }
        break;
}