<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Login Vulnerabile Mysqli</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&family=Poppins:wght@300;500&display=swap" rel="stylesheet">
  <style>
    /* un po di codice per rendere piu carina la pagina web */
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5; 
      color: #000; 
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 100vh;
    }

    h2 {
      margin-top: 50px;
      font-size: 2.2em;
      color: #ff7f00; 
      font-family: 'Fredoka', sans-serif;
    }

    form {
      background-color: #ffffff;
      padding: 30px 35px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
      width: 280px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: 500;
      color: #333;
    }

    input[type="text"], input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1em;
      font-family: 'Poppins', sans-serif;
    }

    input[type="text"] {
      background-color: #fdfdfd;
      color: #000;
    }

    input[type="submit"] {
      background-color: #2ecc71; 
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #27ae60; 
    }

    .result {
      margin: 20px 0;
      padding: 15px;
      background-color: #e0e0e0; 
      border-radius: 10px;
      color: #000;
      font-size: 0.95em;
      width: 90%;
      max-width: 600px;
    }

    .field {
      margin: 6px 0;
    }

    .field-name {
      font-weight: 600;
      color: #ff7f00; 
      margin-right: 5px;
      font-family: 'Fredoka', sans-serif;
    }

    p {
      margin-top: 20px;
      font-size: 1em;
      color: #000;
    }

    .success {
      color: #2ecc71; 
      font-weight: bold;
    }

    .error {
      color: #e74c3c; 
      font-weight: bold;
    }

    .query {
      margin-top: 20px;
      font-size: 0.85em;
      color: #333;
    }
  </style>
</head>
<body>
  <!-- form per il login vulnerabile -->
  <h2>Login</h2>
  <form method="GET">
    <label>Username:
      <input type="text" name="username">
    </label>
    <label>Password:
      <input type="text" name="password">
    </label>
    <input type="submit" value="Login">
  </form>

<?php
// piu tentativi di connessione al database (massimo 5)
$tries = 5;
while ($tries > 0) {
  $conn = new mysqli("db", "root", "root", "testdb");
  if ($conn->connect_error) {
    echo "Tentativo fallito, ritento in 3s...<br>";
    sleep(3);
    $tries--;
  } else {
    break;
  }
}

// se la connessione fallisce definitivamente , allora si interrompe lo script 
if ($conn->connect_error) {
  die("Connessione fallita: " . $conn->connect_error);
}

// controllo se username e password sono stati forniti via richiesta Get
if (isset($_GET['username']) && isset($_GET['password'])) {
  $user = $_GET['username'];
  $pass = $_GET['password'];

  // query vulnerabile
  $sql = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
  echo "<p class='query'><strong>Query eseguita:</strong> " . htmlspecialchars($sql) . "</p>";

  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    echo "<p class='success'>Accesso consentito</p>";

    echo "<div class='result'>";
    echo "<table style='width:100%; border-collapse: collapse;'>";
    
    echo "<tr>";
    // cicla su tutti i campi restituiti dalla query (cioè le colonne)
    foreach ($result->fetch_fields() as $field) {
      echo "<th style='border: 1px solid #ccc; padding: 8px; background-color: #f0f0f0;'>" . htmlspecialchars($field->name) . "</th>";
    }
    echo "</tr>";

    // riporta il puntatore del risultato all'inizio per poter rileggere tutti i dati
    $result->data_seek(0); 
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      // cicla su ogni riga del valore
      foreach ($row as $value) {
        // stampa una cella della tabella con il valore, proteggendo l'output con htmlspecialchars
        echo "<td style='border: 1px solid #ccc; padding: 8px;'>" . htmlspecialchars($value) . "</td>";
      }
      echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
  } else {
    echo "<p class='error'>Accesso negato</p>";
  }
}
?>

</body>
</html>
