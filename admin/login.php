<?php
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = trim($_POST["login"] ?? '');
    $haslo = trim($_POST["haslo"] ?? '');

    // dane logowania
    $poprawnyLogin = "admin";
    $poprawneHaslo = "admin123";

    if ($login === $poprawnyLogin && $haslo === $poprawneHaslo) {
        $_SESSION["zalogowany"] = true;
        header("Location: lista_wizyt.php");
        exit;
    } else {
        $error = "Niepoprawny login lub hasło.";
    }
}
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>System rezerwacji wizyt – Logowanie</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="page">

  <div class="header">
    <div class="container">
      <div class="top">
        <div class="logo">
          <div>
            <div class="logo-title">Korepetycje Online</div>
            <div class="logo-subtitle">System rezerwacji wizyt</div>
          </div>
        </div>

        <div class="menu">
          <a class="menu-link" href="../index.php">Strona główna</a>
          <a class="menu-link" href="../rezerwacja.php">Rezerwacja</a>
          <a class="menu-link" href="lista_wizyt.php">Lista wizyt</a>
          <a class="menu-link active" href="login.php">Logowanie</a>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container">
      <div class="main-box">
        <h1>Logowanie administratora</h1>

        <?php
        if ($error != '') {
        ?>
          <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php
        }
        ?>

        <form action="login.php" method="post">
          <label for="login">Login:</label>
          <input type="text" name="login" id="login">

          <label for="haslo">Hasło:</label>
          <input type="password" name="haslo" id="haslo">

          <input type="submit" value="Zaloguj się">
        </form>
      </div>
    </div>
  </div>

  <div class="footer">
    <div class="container">
      Korepetycje Online
    </div>
  </div>

</div>

</body>
</html>