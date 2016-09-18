<?php
session_start();
require_once 'class/Autoloader.php';
spl_autoload_register(['Autoloader','load']);
spl_autoload_register(['Autoloader','loadAndLog']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'auth') {
        if (isset($_POST['login']) && isset($_POST['pass'])) {
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $authId = User::login($pass, $login);
            if ($authId != null) {
                $_SESSION['authId'] = $authId;
            }
        }
    } elseif ($_POST['action'] == 'add') {
        if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['secret']) && isset($_POST['name'])) {
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $secret = $_POST['secret'];
            $name = $_POST['name'];
            $user = new User($login, $pass, $secret, $name);
            $user->registration();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <?php if (isset($_SESSION['authId']) == false) { ?>
        <form action="" method="post" style="border: 3px solid gray; border-radius: 15px; padding: 10px;">
            <input name="action" type="hidden" value="auth">
            <div class="form-group">
                <label for="login">Login:</label>
                <input name="login" type="text" class="form-control" id="login">
            </div>
            <div class="form-group">
                <label for="pass">Password:</label>
                <input name="pass" type="password" class="form-control" id="pass">
            </div>
            <button type="submit" class="btn btn-default">Login</button>
        </form>
    <?php } else { ?>
        <form action="" method="post" style="border: 3px solid gray; border-radius: 15px; padding: 10px;">
            <input name="action" type="hidden" value="add">
            <div class="form-group">
                <label for="login">Login:</label>
                <input name="login" type="text" class="form-control" id="login">
            </div>
            <div class="form-group">
                <label for="pass">Password:</label>
                <input name="pass" type="password" class="form-control" id="pass">
            </div>
            <div class="form-group">
                <label for="secret">Secret:</label>
                <input name="secret" type="text" class="form-control" id="secret">
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input name="name" type="text" class="form-control" id="name">
            </div>
            <button type="submit" class="btn btn-default">Registration</button>
        </form>
    <?php } ?>
</div>
</body>
</html>