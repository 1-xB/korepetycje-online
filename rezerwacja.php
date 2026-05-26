<?php

$errors = [];

?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>System rezerwacji wizyt – Korepetycje online</title>
  <link rel="stylesheet" href="css/style.css">
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
          <a class="menu-link active" href="index.php">Strona główna</a>
          <a class="menu-link" href="rezerwaja.php">Rezerwacja</a>
          <a class="menu-link" href="admin/lista_wizyt.php">Lista wizyt</a>
          <a class="menu-link" href="admin/login.php">Logowanie</a>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container">
      <div class="main-box">
        <?php 
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                
                $imieNazwisko = trim($_POST["imie_nazwisko"] ?? '');
                $email = trim($_POST["email"] ?? '');
                $data = $_POST["data"] ?? '';
                $godzina = $_POST["godzina"] ?? '';
                $usluga = $_POST["usluga"] ?? '';
        
                $errors = [];
        
                if (empty($imieNazwisko)) {
                    $errors[] = "Podaj imię i nazwisko.";
                }
        
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Niepoprawny email.";
                }
        
                if (empty($data)) {
                    $errors[] = "Wybierz datę.";
                }
        
                if (empty($godzina)) {
                    $errors[] = "Wybierz godzinę.";
                }
        
                $dozwoloneUslugi = [
                    "korepetycje matematyka",
                    "korepetycje fizyki",
                    "korepetycje z informatyki"
                ];
        
                if (!in_array($usluga, $dozwoloneUslugi)) {
                    $errors[] = "Niepoprawna usługa.";
                }

                
        
            }
        ?>
        <?php
            if (!empty($errors) || $_SERVER["REQUEST_METHOD"] === "GET") {
        ?>
        <form action="rezerwacja.php" method="post">
            <label for="imie_nazwisko">Imię i nazwisko: </label>
            <input type="text" name="imie_nazwisko" id="imie_nazwisko"> <br>
            <label for="email">Email: </label>
            <input type="email" name="email" id="email"> <br>
            <label for="data">Data: </label>
            <input type="date" name="data" id="data"> <br>
            <label for="godzina">godzina: </label>
            <input type="time" name="godzina" id="godzina"> <br>
            <label for="usluga">Usługa: </label>
            <select name="usluga" id="usluga">
                <option value="korepetycje matematyka">Korepetycje z matematyki</option>
                <option value="korepetycje fizyki">Korepetycje z fizyki</option>
                <option value="korepetycje z informatyki">Korepetycje z informatyki</option>
            </select>
            <br>
            <input type="submit" value="Zarezerwuj">
            <?php
                foreach ($errors as $error) {
                    echo "<p style='color:red;'>$error</p>";
                }
            ?>
            
        </form>
        <?php
            }
            else {
                require 'db.php';

                $conn = mysqli_connect($host, $user, $password, $db)
                    or die("Nie udało połączyć się z bazą danych");

                $sql = "INSERT INTO wizyty 
                VALUES (
                    NULL,
                    '$imieNazwisko',
                    '$email',
                    '$data',
                    '$godzina',
                    '$usluga'
                )";

                $query = mysqli_query($conn, $sql);

                if (!$query) {
                    echo "Błąd: " . mysqli_error($conn);
                } else {
                    echo "Dodano rezerwację!";
                }

                mysqli_close($conn);
                echo "<h2>Rezerwacja została przyjęta</h2>";

                echo "Imię i nazwisko: " . htmlspecialchars($imieNazwisko) . "<br>";
                echo "Email: " . htmlspecialchars($email) . "<br>";
                echo "Data: " . htmlspecialchars($data) . "<br>";
                echo "Godzina: " . htmlspecialchars($godzina) . "<br>";
                echo "Usługa: " . htmlspecialchars($usluga) . "<br>";
            }
        ?>

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