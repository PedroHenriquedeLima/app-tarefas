<?php


function insertUser($conn, $username, $email, $password)
{

    // Hash da senha do usuário 

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query SQL

    $sql = "INSERT INTO users (username, email, pass, created) VALUES (?, ?, ?, NOW())";

    // Preparação da Query

    $stmt = $conn->prepare($sql);

    // Vinculando parâmetros

    $stmt->bindValue(1, $username);
    $stmt->bindValue(2, $email);
    $stmt->bindValue(3, $hashed_password);

    // Executando

    return $stmt->execute();
}


function getUserId($conn, $email)
{

    $sql = "SELECT id FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(1, $email);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function verifyIfExists($conn, $email)
{

    $sql = "SELECT email FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(1, $email);

    $stmt->execute();

    return $stmt->fetch();
}


function verifyPassword($conn, $email, $password)
{

    $sql = "SELECT pass FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(1, $email);

    $stmt->execute();

    $pass_hashed = $stmt->fetch(PDO::FETCH_COLUMN);

    if (password_verify($password, $pass_hashed)) {
        return true;
    } else {
        return false;
    }

}
