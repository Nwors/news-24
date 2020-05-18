<?php


session_start();

include "util.php";
include "Router.php";
include "db.php";
include "users-implementation.php";
include "news-implementation.php";
include "routes.php";

function getUri () {
    $requestUri = $_SERVER["REQUEST_URI"];
    $requestUri = explode("?", $requestUri);
    $requestUri = $requestUri[0];
    return $requestUri;
}

addRoutes();

if(!Router::execute(getUri())) {
    Router::executeDefault();
};

if(is_null($_SESSION['currentUser'])) header("Location: /login");

