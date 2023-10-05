<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- link css -->
    <link rel="stylesheet" href="registration-style.css">

    <!-- link font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <img src="images/logo.svg" alt="">
        </div>
    </header>
    <h1>Crea il tuo account</h1>
    <div class="form-container">
        <form action="registration.php" method="post">
            <label for="name">Inserisci il nome</label><br>
            <input type="text" id="name" name="name" placeholder="Mario" required><br>
            <label for="surname">Inserisci il cognome</label>
            <input type="text" id="surname" name="surname" placeholder="Rossi" required><br>
            <label for="email">Inserisci l' email</label>
            <input type="email" id="email" name="email" placeholder="name@example.com" required><br>
            <label for="password">Inserisci la Password</label>
            <input type="password" id="password" name="password" placeholder="Scrivila qui" required><br>
            <input type="submit" value="REGISTRATI" class="btn">
        </form>
        <div class="link-button">
            <a href="user_login.php">Hai già un account? <strong>Accedi</strong>.</a>
        </div>
    </div>
</body>

</html>