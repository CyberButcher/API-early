<?php

function createToken($conn, $id){
    $token = bin2hex(random_bytes(16));

    $userID = $id;

    $query = "INSERT INTO `tokens`(`value`, `userID`, `valid_time`) VALUES (:value, :ID, :valid_time)";
    $queryPrep = $conn->prepare($query);
    $tokenInsertRes = $queryPrep->execute(['value'=>$token, 'ID'=>$userID, 'valid_time'=>'']);
    if (!$tokenInsertRes) {
        echo 'too bad (token)';//400
    }
    else {
        echo json_encode($token);
    }
}