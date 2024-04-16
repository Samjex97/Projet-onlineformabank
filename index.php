
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>

body {
    display: flex;
    justify-content: center;
}



    form{
        display: flex;
        flex-direction: column;
        width: 300px;
    }

    form > input {
        margin-bottom: 20px;
        padding: 20px;
    }

</style>

<?php
session_start();
?>

<body>
    <form action="register.php" method="POST" >
<h2>REGISTRATI</h2>
<label for="first_name" placeholder="Inserisci il tuo Username">First name</label>
<input type="text" name="first_name" id="first_name" required>

<label for="last_name" placeholder="Inserisci il tuo Username">last name</label>
<input type="text" name="last_name" id="last_name" required>

<label for="password" placeholder="Inserisci la tua password">Password</label>
<input type="password" name="password" id="password" required>

<label for="email" placeholder="Inserisci la tua email">Email</label>
<input type="text" name="email" id="email" required>


<input type="submit" value="invia">





<?php if (isset($_SESSION['message'])): ?>
            <p><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        

    </form>
</body>
</html>