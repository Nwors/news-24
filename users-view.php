<link rel = "stylesheet" href = "assets/css/users-view.css">

<div class = "cards-container">
    <div class="grid">
<?php
forEach($users as $user) {
    echo " 
        <div class=\"grid__item\">
            <div class=\"card\"><img class=\"card__img\" src=\"",$uploadPath,"/",$user['image'],"\">
                <div class=\"card__content\">
                    <h1 class=\"card__header\">",$user['login'],"</h1>
                    <p class=\"card__text\"></p>
                    <a href =\"/users/id",$user['id'],"\"><button class=\"card__btn\">Edit</button></a>
                </div>
            </div>
        </div>
    ";
}
?>
    </div>
</div>
<div class="pagination">
    <a href=<?= $page > 0 ? buildQuery($page-1): ""?>>&laquo;</a>
    <a class = <?= $page == 0 ? "pactive" : "" ?>> <?= $page == 0 ? $page+1 : ($page == $totalPages-1 ? $page-1 : $page) ?> </a>
    <a class = <?= ($page > 0 && $page < $totalPages-1)  ? "pactive" : ""  ?>> <?= $page == 0 ? $page+2 : ($page == $totalPages-1 ? $page : $page+1) ?> </a>
    <a class = <?= $page == $totalPages-1 ? "pactive" : ""?>> <?= $page == 0 ? $page+3 : ($page == $totalPages-1 ? $page+1 : $page+2) ?> </a>
    <a href=<?= $page < $totalPages-1 ? buildQuery($page+1): ""?>>&raquo;</a>
</div>




