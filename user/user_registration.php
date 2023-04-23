<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
</head>
<body>
    <h1>ユーザー登録</h1>
    <form method="post" action="user_registration_success.php" enctype="multipart/form-data">
        <div>
            <label for="username">ユーザー名:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="email">メールアドレス:</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">パスワード:</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="profile_image">プロフィール画像:</label>
            <input type="file" name="profile_image" id="profile_image">
        </div>
        <div>
            <input type="submit" value="登録する">
        </div>
    </form>
</body>
</html>