<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <!-- bootstrap読み込み -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body{
            font: 14px sans-serif;
        }
        .wrapper{
            width: 400px;
            padding: 20px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>ログイン</h2>
        <p>ログインするには、資格情報を入力してください。</p>

        {if !empty($loginErr)}
            <div class="alert alert-danger">{$loginErr}</div>
        {/if}

        <form method="post">
            <div class="form-group">
                <label>ユーザー名</label>
                <input type="text" name="name" class="form-control {(!empty($errors['name']|escape:"html")) ? 'is-invalid' : ''}" value="{$name}">
                <span class="invalid-feedback">{$errors['name']|escape:"html"}></span>
            </div>    
            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password" class="form-control {(!empty($errors['password']|escape:"html")) ? 'is-invalid' : ''}" value="{$password}">
                <span class="invalid-feedback">{$errors['password']|escape:"html"}></span>
            </div>
            <div class="form-group">
                <input type="hidden" name="token" value="{$smarty.session.token|escape:"html"}">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>アカウントをお持ちでない場合? <a href="register">今すぐ登録</a></p>
        </form>
    </div>
</body>
</html>