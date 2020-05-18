<!DOCTYPE html>
<html lang="en">
<body>
<head>
    <meta charset="UTF-8">
    <title>news-editor</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel = "stylesheet" href = "../assets/css/edit-form.css">
</head>
<div class="form-container">
    <form enctype="multipart/form-data" method="POST" action="/news-editor">
        <h4>Create new news</h4>
        <div class="input-group">
            <label class="custom-file-label" for="inputGroupFile01">Choose image file .jpeg .png .gif</label>
            <input name="image" type="file">
        </div>
        <div class="row">
            <div class="input-group input-group-icon">
                <input name = "title" type="text" placeholder="Title">
                <div class="input-icon"><i class="fa fa-envelope"></i></div>
            </div>
            <div class="input-group input-group-icon">
                <input name = "keywords" type = "text" placeholder="Keywords"/>
                <div class="input-icon"><i class="fa fa-key"></i></div>
            </div>
            <textarea id = "textInp" name = "text"> </textarea>
            <style> #textInp {
                    width:100%;
                    height:20em;
                    background-color: #f9f9f9;
                    margin-bottom: 3em;
                } </style>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
    </form>
</div>
</body>
</html>