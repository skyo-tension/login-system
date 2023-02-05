<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ようこそ！</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body{ 
            font: 14px sans-serif;
            text-align: center; 
        }
    </style>
</head>
<body>
    <h1 class="my-5">こんにちは!<b>{$smarty.session.name|escape:"html"}</b>私たちのサイトへようこそ!</h1>
    <p>
        <a href="logout" class="btn btn-danger ml-3">アカウントからサインアウトする。</a>
    </p>
</body>
</html>