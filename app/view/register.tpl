<!DOCTYPE>
<html lang="ja">
{config_load file='smarty.config'}
<head>
<meta charset="UTF-8">
    <title>登録</title>
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
        <h2>登録</h2>
        <p>アカウントを作成するには、このフォームに入力してください。</p>
        <form method="post">
            <div class="form-group">
                <label>ユーザー名</label>
                <input type="text" name="name" class="form-control {(!empty($errors['name']|escape:"html")) ? 'is-invalid' : ''}" value="{$name}">
                <span class="invalid-feedback">{$errors['name']|escape:"html"}</span>
            </div>    
            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password" class="form-control {(!empty($errors['password']|escape:"html")) ? 'is-invalid' : ''}" value="{$password}">
                <span class="invalid-feedback">{$errors['password']|escape:"html"}</span>
            </div>
            <div class="form-group">
                <label>確認</label>
                <input type="password" name="confirm_password" class="form-control {(!empty($errors['confirm_password']|escape:"html")) ? 'is-invalid' : ''}" value="{$confirm_password}">
                <span class="invalid-feedback">{$errors['confirm_password']|escape:"html"}</span>
            </div>
            <div class="form-group">
                <input type="hidden" name="token" value="{$smarty.session.token|escape:"html"}">
                <input type="submit" name="add" class="btn btn-primary" value="Submit">
            </div>
            <p>すでにアカウントをお持ちですか? <a href="login">ログイン</a>.</p>
        </form>
    </div>    
</body>
</html>
