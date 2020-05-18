<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel = "stylesheet" href = "../assets/css/edit-form.css">
</head>
<div class="form-container">
    <form enctype="multipart/form-data" method="POST" action="/users/id<?php echo $user['id']; ?>">
        <div class="row">
            <h4>Edit user with id <?php echo $user['id']?></h4>
            <div class="input-group input-group-icon">
                <input name = "login" type="email" placeholder="New email Adress"/ value = <?php echo $user['login']?>>
                <div class="input-icon"><i class="fa fa-envelope"></i></div>
            </div>
            <div class="input-group input-group-icon">
                <input name = "password" type="password" placeholder="New password"/>
                <div class="input-icon"><i class="fa fa-key"></i></div>
            </div>
        </div>
        <div class="input-group">
            <input name = "editor" type="checkbox" <?php echo $user['editor'] ? "checked" : ""?> id="terms"/>
            <label for="terms">Set/unset editor's tag</label>
        </div>
        <div class="input-group">
            <label class="custom-file-label" for="inputGroupFile01">Choose image file .jpeg .png .gif</label>
            <input name="image" type="file">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Edit</button>
    </form>
    <a href = "/users?page=0"><button id = "deleteBtn">Delete user</button><a>
    <style>
        #deleteBtn {
            margin-left:75%;
            margin-top: 15px;
            width: 5em;
            height: 3em;
            color: white;
            font-size: 16px;
            background-color: darkred;
        }
    </style>
    <script>
        $('#deleteBtn').click(_ => {
                if(window.confirm("Are you sure?")) {
                    $.ajax({
                        url: "/users/id<?php echo $user['id']; ?>",
                        type: "DELETE",
                    })
                }
            }
        )
    </script>
</div>