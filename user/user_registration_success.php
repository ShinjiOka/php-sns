<?php
require_once('../dbconnect.php');
// フォームから送信されたデータを取得
$username = $_POST['username'];
$email = $_POST['email'];
$pass_word = $_POST['password'];
$profile_image = $_FILES['profile_image']['tmp_name'];

// バリデーション
$errors = [];
if (empty($username)) {
    $errors[] = 'ユーザー名が入力されていません。';
} else {
    // ユーザー名が一意であることを確認
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE user_name = :user_name');
    $stmt->bindValue(':user_name',$username,PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $errors[] = 'ユーザー名が既に存在します。';
    }
}
if (empty($email)) {
    $errors[] = 'メールアドレスが入力されていません。';
} else {
    // メールアドレスが一意であることを確認
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
    $stmt->bindValue(':email',$email,PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $errors[] = 'メールアドレスが既に存在します。';
    }
}
if (strlen($pass_word) < 4) {
    $errors[] = 'パスワードは4文字以上で入力してください。';
}

if (!empty($profile_image)) {
    // プロフィール画像を一時ファイルから読み込む
    $profile_image_data = file_get_contents($profile_image);
    // プロフィール画像をBase64エンコードする
    $profile_image_base64 = base64_encode($profile_image_data);
}

if (count($errors) > 0) {
    // エラーがある場合はエラーメッセージを表示して終了する
    foreach ($errors as $error) {
        echo $error . '<br>';
    }
    exit;
}

$currentDateTime = date('Y-m-d H:i:s');
$hashed_password = password_hash($pass_word, PASSWORD_DEFAULT);

// データベースにユーザーを登録する
$stmt = $pdo->prepare('INSERT INTO users (user_name, email, password, profile_image, created_at, updated_at) VALUES (:user_name, :email, :password, :profile_image, :created_at, :updated_at)');
$stmt->bindValue(':user_name',$username,PDO::PARAM_STR);
$stmt->bindValue(':email',$email,PDO::PARAM_STR);
$stmt->bindValue(':password',$hashed_password,PDO::PARAM_STR);
$stmt->bindValue(':profile_image',$profile_image_data,PDO::PARAM_LOB);
$stmt->bindValue(':created_at',$currentDateTime,PDO::PARAM_STR);
$stmt->bindValue(':updated_at',$currentDateTime,PDO::PARAM_STR);
$stmt->execute();

// ログイン画面に

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録完了</title>
</head>
<body>
    <h1>ユーザー登録が完了しました！</h1>
    <p>ユーザー登録が成功しました。</p>
    <p>ログインページからログインしてください。</p>
    <a href="../login/login.php">ログインページへ</a>
</body>
</html>
