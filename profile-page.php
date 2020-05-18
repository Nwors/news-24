<link rel = "stylesheet" href = /assets/css/profile-page.css>
<h1>Welcome <?=$user ['login'] ?> </h1>
<h2>Your current profile image: </h2>
<image id = "profile-image" src = <?= "/uploads/".$user['image']?>></image>
<?php if($user['editor']): ?>
    <h4>You've have editor's tag!</h4>
    </a href = "/news-editor"><button>Go to news editor!</button>
<?php endif; ?>
