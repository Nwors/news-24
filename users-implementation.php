<?php

function createUser($login, $password) {
    $pdo = getConnection();
    $statement = $pdo->prepare("insert into users (login,password) values (?,?)");
    try {
        $statement->execute([$login, $password]);
    } catch (PDOException $exception) {
        throw new InvalidArgumentException("User with this login is already exist");
    }
}

function getAllUsers() {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from users order by id");
    $statement->execute();
    return $statement->fetchAll();
}

function getUserById($id) {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from users where id = ?");
    $statement->execute([$id]);
    return $statement->fetch();
}

function getUserByLogin($login) {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from users where login = ?");
    $statement->execute([$login]);
    return $statement->fetch();
}

function deleteUser($id) {
    $pdo = getConnection();
    $statement = $pdo->prepare("delete from users where id = ?");
    $statement->execute([$id]);

}

function editUser($user, $params) {

    $pdo = getConnection();
    $statement = $pdo->prepare("update users set login = ?, password = ?, editor = ?, image = ?, updated_at = now() where id = ?");
    try {
        $statement->execute(
            [$params['login'],
            !empty($params['password']) ? password_hash($params['password'],PASSWORD_BCRYPT) : $user['password'],
            $params['editor'] ? "1":"0",
            !is_null($params['image']) ? $params['image'] : $user['image'],
            $user['id']]);
    } catch(PDOException $exception) {
        echo "This login is already exist";
        die();
    }
}

