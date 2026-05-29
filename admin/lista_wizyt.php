<?php
session_start();

$zalogowany = isset($_SESSION["zalogowany"]) && $_SESSION["zalogowany"] === true;

require '../db.php';

$conn = mysqli_connect($host, $user, $password, $db)
    or die("Nie udało się połączyć z bazą danych");

if ($zalogowany && isset($_GET["usun"]) && is_numeric($_GET["usun"])) {
    $id = (int)$_GET["usun"];
    mysqli_query($conn, "DELETE FROM wizyty WHERE id = $id");
    header("Location: lista_wizyt.php");
    exit;
}

$sql = "SELECT * FROM wizyty ORDER BY data_wizyty ASC, godzina_wizyty ASC";
$wynik = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>System rezerwacji wizyt – Lista wizyt</title>
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
          <a class="menu-link active" href="lista_wizyt.php">Lista wizyt</a>
          <?php
          if ($zalogowany == true) {
          ?>
            <a class="menu-link" href="logout.php">Wyloguj</a>
          <?php
          } else {
          ?>
            <a class="menu-link" href="login.php">Logowanie</a>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container">
      <div class="main-box">
        <h1>Lista zarezerwowanych wizyt</h1>

        <?php
        if ($zalogowany == true) {
        ?>
          <p style="color: green;">Jesteś zalogowany jako administrator.</p>
        <?php
        }
        ?>

        <?php
        if (mysqli_num_rows($wynik) === 0) {
        ?>
          <p>Brak wizyt w systemie.</p>
        <?php
        } else {
        ?>
          <div style="overflow-x: auto;">
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Imię i nazwisko</th>
                  <th>Email</th>
                  <th>Data</th>
                  <th>Godzina</th>
                  <th>Usługa</th>
                  <?php
                  if ($zalogowany == true) {
                  ?>
                    <th>Akcja</th>
                  <?php
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($wizyta = mysqli_fetch_assoc($wynik)) {
                ?>
                  <tr>
                    <td><?= $wizyta["id"] ?></td>
                    <td><?= htmlspecialchars($wizyta["imie_nazwisko"]) ?></td>
                    <td><?= htmlspecialchars($wizyta["email"]) ?></td>
                    <td><?= htmlspecialchars($wizyta["data_wizyty"]) ?></td>
                    <td><?= htmlspecialchars($wizyta["godzina_wizyty"]) ?></td>
                    <td><?= htmlspecialchars($wizyta["usluga"]) ?></td>
                    <?php
                    if ($zalogowany == true) {
                    ?>
                      <td>
                        <a href="lista_wizyt.php?usun=<?= $wizyta["id"] ?>"
                           onclick="return confirm('Czy na pewno chcesz usunąć tę wizytę?')"
                           class="btn-usun">Usuń</a>
                      </td>
                    <?php
                    }
                    ?>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        <?php
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
<?php mysqli_close($conn); ?>