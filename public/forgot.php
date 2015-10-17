<html>
<head>
    <title>Restablecer contrasenia</title>
</head>

<body>
<?php
include("../core/config.php");
include(DIR_BOLLO . "/core/query.php");
if(isset($_POST['send'])) {
    if(
        isset($_POST['pw']) &&
        isset($_POST['pw-confirm']) &&
        isset($_POST['token'])
    ) {
        $pw = $_POST['pw'];
        $conf = $_POST['pw-confirm'];

        $token = $_POST['token'];

        if($pw != $conf) {
            //err
        } else {
            reset_password($pw, $token);
            echo "ready!";
        }
    }
} else {
    ?>
    <form action="forgot.php" method="post">
        <p>Nueva contrasenia: <input type="password" name="pw"></p>

        <p>Confirme contrasenia: <input type="password" name="pw-confirm"></p>
        <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
        <input type="submit" name="send" value="Restablecer">
    </form>
<?php } ?>

</body>
</html>
