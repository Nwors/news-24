<?php
function addRoutes() {
    // Authentication routes
    Router::add("/default", function() {
        include "empty-page.html";
        die();
    });

    Router::add("/login", function() {
        include "start-page.php";
        die();
    });

    Router::add("/auth", function() {
        $login = filter_var($_POST["login"],FILTER_SANITIZE_STRING);
        $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);

        $pdo = getConnection();
        $statement = $pdo->prepare("select * from users where login = ?");
        $statement->execute([$login]);
        $user = $statement->fetch();

        if(password_verify($password,$user["password"])) {
            $_SESSION["currentUser"] = $user;
        }
        header("Location: /");
    });
////////////////////////////////////////////////////////////////////////////////////////
    //Registration, logout and main routes
    Router::add("/registration", function () {
        include "reg-form.html";
        die();
    });

    Router::add("/reg", function() {
        $login = filter_var($_POST["login"],FILTER_SANITIZE_STRING);
        $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);
        createUser($login,password_hash($password,PASSWORD_BCRYPT));
        header("Location: /login");
    });

    Router::add("/logout", function() {
        session_destroy();
        header("Location: /login");
        die();
    });

    Router::add("/", function() {
        $user = $_SESSION['currentUser'];
        include "nav.php";
        include "profile-page.php";
    });
//////////////////////////////////////////////////////////////////////////////
    // News Routes
    Router::add("/news",function() {
        $getPage = function($page,$newsSplited) {
            $totalPages = count($newsSplited);
            if (!$page) {$page = 0;}
            $news = $newsSplited[$page];
            include "news-view.php";
        };

        function buildQuery($page) {
            return "/news?".http_build_query(["page" => $page]);
        }

        $uri = getUri();
        $news = getAllNews();
        $newsSplited = array_chunk($news,10);
        $page = ltrim(end(explode('?',$_SERVER['REQUEST_URI'])),"page=");
        include "nav.php";
        $getPage($page,$newsSplited);
    });

    if($_SESSION['currentUser']['editor']) {
        Router::add("/news-editor", function() {
            include "nav.php";
            include "news-editor.php";

            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
                $keywords = filter_var($_POST['keywords'],FILTER_SANITIZE_STRING);
                $text = filter_var($_POST['text'],FILTER_SANITIZE_STRING);
                if(!($_FILES['image']['size'] == 0)) {
                    $fileName = upload_image($_FILES['image'],$_SERVER['DOCUMENT_ROOT']."/uploads");
                    $fileName = explode("/",$fileName);
                    $fileName = $fileName[count($fileName)-1];
                }
                createNews($title,$text,$keywords,$fileName);
                echo "News have been successfully published";
            }
        });
    }

    forEach(getAllNews() as $news) {
        Router::add("/news/id".$news['id'], function () {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $uri = getUri();
            $splitedUri = explode("/",$uri);
            $newsId = ltrim(end($splitedUri),"id");
            $news = getNewsById($newsId);

            if($requestMethod == "GET") {
                include "nav.php";
                include "news-page.php";
            }

            if($requestMethod == "DELETE" && ($_SESSION['currentUser']['moderator'] || $_SESSION['currentUser']['login'] == $news['author'])) {
                deleteNews($news['id']);
            }
        });
    }

///////////////////////////////////////////////////////////////////////////////
    // Users Routes
    if($_SESSION['currentUser']['moderator']) {
        Router::add("/users", function () {
            $getPage = function($page,$usersSplited) {
                $totalPages = count($usersSplited);
                if (!$page) {$page = 0;}
                $users = $usersSplited[$page];
                include "users-view.php";
            };

            function buildQuery($page) {
                return "/users?".http_build_query(["page" => $page]);
            }

            $uri = getUri();
            $users = getAllUsers();
            $uploadPath = getUploadPath();
            $usersSplited = array_chunk($users,10);
            $page = ltrim(end(explode('?',$_SERVER['REQUEST_URI'])),"page=");
            include "nav.php";
            $getPage($page,$usersSplited);
        });

        forEach(getAllUsers() as $user) {
            Router::add("/users/id".$user['id'], function () {
                $requestMethod = $_SERVER["REQUEST_METHOD"];
                $uri = getUri();
                $splitedUri = explode("/",$uri);
                $userId = ltrim(end($splitedUri),"id");
                $user = getUserById($userId);

                if($requestMethod == "GET") {
                    include "nav.php";
                    include "edit-form.php";
                }

                if($requestMethod == "POST") {
                    $login = filter_var($_POST["login"],FILTER_SANITIZE_STRING);
                    $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);
                    if(!($_FILES['image']['size'] == 0)) {
                        $fileName = upload_image($_FILES['image'],getUploadPath());
                        $fileName = explode("/",$fileName);
                        $fileName = $fileName[count($fileName)-1];
                    }
                    $editor = filter_var($_POST["editor"],FILTER_SANITIZE_STRING) == "on" ? true : false;
                    editUser($user, ["login" => $login,"password" => $password,"editor" => $editor,"image" => $fileName]);
                    header("Location: /users?page=0");
                }

                if($requestMethod == "DELETE") {
                    deleteUser($user['id']);
                }
            });
        }
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}