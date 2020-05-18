<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <title>News24</title>
    <link rel = "stylesheet" href = <?php echo (explode("/",$uri)[1] == 'users' || explode("/",$uri)[1] == 'news')  ? '"../assets/css/nav.css"' : '"assets/css/nav.css"'?>>
</head>
<body>
<header>
    <div class = "container">
        <div id = "companyName">
            <h1>News 24</h1>
        </div>
        <nav>
            <ui>
                <li class = <?php echo $uri == '/' ? '"current"' : "" ?>><a href = "/">Home</a></li>
                <li class = <?php echo $uri == '/news' ? '"current"' : "" ?>><a href = "/news?page=0">news</a></li>
                <?php if($_SESSION['currentUser']['moderator']) : ?>
                <li class = <?php echo $uri == '/users' ? '"current"' : "" ?>><a href = "/users?page=0" > users </a></li>
                <?php endIf ?>
                <li><a href = "/logout">logout</a></li>
            </ui>
        </nav>
    </div>
</header>
</body>
</html>