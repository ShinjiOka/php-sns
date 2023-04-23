<?php
session_start();
require_once('../dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // 入力値のバリデーション
  if (empty($username)) {
    $errors['username'] = 'ユーザー名を入力してください。';
  }
  if (empty($email)) {
    $errors['email'] = 'メールアドレスを入力してください。';
  }
  if (empty($password)) {
    $errors['password'] = 'パスワードを入力してください。';
  }

  // DBと照合し、認証する。
  $sql = 'SELECT * FROM users WHERE user_name = :username AND email = :email';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':username', $username, PDO::PARAM_STR);
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user && password_verify($password, $user['password'])) {
    // 認証成功
    $_SESSION['user'] = $user;
    header('Location: ../profile/profile.php');
    exit;
  } else {
    // 認証失敗
    $errors['login'] = 'ユーザー名、メールアドレスまたはパスワードが違います。';
  }

  $username = htmlspecialchars($username, ENT_QUOTES);
  $email = htmlspecialchars($email, ENT_QUOTES);
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ログイン画面</title>
</head>
<body>
  <h1>ログイン</h1>

  <?php if (isset($errors['login'])): ?>
    <p style="color: red;"><?php echo $errors['login']; ?></p>
  <?php endif; ?>

  <form method="post">
    <div>
      <label for="username">ユーザー名</label>
      <input type="text" name="username" value="<?php echo $username ?>" id="username">
      <?php if (isset($errors['username'])): ?>
        <p style="color: red;"><?php echo $errors['username']; ?></p>
      <?php endif; ?>
    </div>
    <div>
      <label for="email">メールアドレス</label>
      <input type="email" name="email" value="<?php echo $email; ?>" id="email">
      <?php if (isset($errors['email'])): ?>
        <p style="color: red;"><?php echo $errors['email']; ?></p>
      <?php endif; ?>
    </div>
    <div>
      <label for="password">パスワード</label>
      <input type="password" name="password" value="" id="password">
      <?php if (isset($errors['password'])): ?>
        <p style="color: red;"><?php echo $errors['password']; ?></p>
      <?php endif; ?>
    </div>
    <div>
      <input type="submit" value="ログイン">
    </div>
  </form>
</body>
</html>
