<?php

function createNews($name,$text,$keywords,$image) {
    $pdo = getConnection();
    $statement = $pdo->prepare("insert into news (author,name,text,keywords,image) values (?,?,?,?,?)");

    try {
        $statement->execute([$_SESSION['currentUser']['login'],$name,$text,$keywords,$image]);
    } catch (PDOException $exception) {
        throw new InvalidArgumentException("Wrong news format");
    }
}

function getAllNews() {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from news order by id");
    $statement->execute();
    return $statement->fetchAll();
}

function getNewsById($id) {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from news where id = ?");
    $statement->execute([$id]);
    return $statement->fetch();
}

function getNewsByName($name) {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from news where name = ?");
    $statement->execute([$name]);
    return $statement->fetch();
}

function deleteNews($id) {
    $pdo = getConnection();
    $statement = $pdo->prepare("delete from news where id = ?");
    $statement->execute([$id]);

}
