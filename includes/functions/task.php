<?php


function insertTask($conn,  $taskname, $user_id)
{
    $sql = "INSERT INTO tasks (taskname, user_id, created) VALUES (?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bindValue(1, $taskname);
    $stmt->bindValue(2, $user_id);

    return $stmt->execute();
}


function getAll($conn, $user_id)
{

    $sql = "SELECT id, taskname FROM tasks WHERE user_id = ? AND situation = 'À FAZER'";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bindValue(1, $user_id);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


function getById($conn, $user_id, $id_task) {

    $sql = "SELECT (taskname, situation) FROM tasks WHERE user_id = ? AND id = ?";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bindValue(1, $user_id);
    $stmt->bindValu(2, $id_task);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);

}


function getBySituation($conn, $user_id, $situation) {

    $sql = "SELECT taskname, situation FROM tasks WHERE user_id = ? AND situation = ?";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bindValue(1, $user_id);
    $stmt->bindValue(2, $situation);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}



function updateSituation($conn, $user_id, $id_task, $new_situation)
{

    $sql = "UPDATE tasks SET situation = ?, modified = NOW() WHERE user_id = ? AND id = ?";
    $stmt = $conn->prepare($sql);
    

    $stmt->bindValue(1, $new_situation);
    $stmt->bindValue(2, $user_id);
    $stmt->bindValue(3, $id_task);
    
    return $stmt->execute();

}


