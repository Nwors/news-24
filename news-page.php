<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class = "news-container">
    <image src = <?= "".$serverName."/uploads/".$news['image']?>></image>
        <div><?=$news['text'] ?></div>
        <div id = 'publishedBy'>Published by <?=$news['author']?></div>
        <style>
            .news-container  {
                margin: 1% 1% 1% 35%;
            }
            #publishedBy {
                font-weight: bold;
                font-style: italic;
            }
        </style>
        <?php if($_SESSION['currentUser']['moderator'] || $_SESSION['currentUser']['login'] == $news['author']) :?>
    <a href = "/news?page=0"><button id = "delete-article">delete article</button></a>
            <script>
                $('#delete-article').click(_ => {
                        if(window.confirm("Are you sure?")) {
                            $.ajax({
                                url: "/news/id<?php echo $news['id']; ?>",
                                type: "DELETE",
                            })
                        }
                    }
                )
            </script>
        <?php endif; ?>
</div>
