<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" sizes="16x16" href="./img/logo.png">
    <title>Acceder</title>
</head>

<body>
    <?php
    session_start();
    $_SESSION["user"] = "";
    $_SESSION["usertype"] = "";

    // Set the new timezone
    date_default_timezone_set('America/Costa_Rica');
    $date = date('Y-m-d');
    $_SESSION["date"] = $date;

    // Import database connection
    include("connection.php");

    $error = '<label for="promter" class="form-label"></label>';

    if ($_POST) {
        $email = $_POST['useremail'];
        $password = $_POST['userpassword'];

        // Check if the user exists in webuser table
        $result = $database->query("SELECT * FROM webuser WHERE email='$email'");
        
        if ($result && $result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $utype = $user['usertype'];

            // Check user type and authenticate accordingly
            if ($utype == 'p') {
                $checker = $database->query("SELECT * FROM patient WHERE pemail='$email' AND ppassword='$password'");
                if ($checker && $checker->num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'p';
                    header('Location: patient/index.php');
                    exit();
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Credenciales incorrectas: correo electrónico o contraseña no válidos</label>';
                }
            } elseif ($utype == 'a') {
                $checker = $database->query("SELECT * FROM admin WHERE aemail='$email' AND apassword='$password'");
                if ($checker && $checker->num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'a';
                    header('Location: admin/index.php');
                    exit();
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Credenciales incorrectas: correo electrónico o contraseña no válidos</label>';
                }
            } elseif ($utype == 'd') {
                $checker = $database->query("SELECT * FROM doctor WHERE docemail='$email' AND docpassword='$password'");
                if ($checker && $checker->num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'd';
                    header('Location: doctor/index.php');
                    exit();
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Credenciales incorrectas: correo electrónico o contraseña no válidos</label>';
                }
            }
        } else {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">No podemos encontrar ninguna cuenta para este correo electrónico</label>';
        }
    } else {
        $error = '<label for="promter" class="form-label">&nbsp;</label>';
    }
    ?>

    <center>
        <div class="container">
            <table border="0" style="margin: 0;padding: 0;width: 60%;">
                <tr>
                    <td>
                        <p class="header-text">Hola de nuevo!</p>
                    </td>
                </tr>
                <div class="form-body">
                    <tr>
                        <td>
                            <p class="sub-text">Inicia sesión con tus datos para continuar</p>
                        </td>
                    </tr>
                    <tr>
                        <form action="" method="POST">
                            <td class="label-td">
                                <label for="useremail" class="form-label">Correo Electrónico: </label>
                            </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <input type="email" name="useremail" class="input-text" placeholder="Correo Electrónico" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <label for="userpassword" class="form-label">Contraseña: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <input type="Password" name="userpassword" class="input-text" placeholder="Contraseña" required>
                        </td>
                    </tr>
                    <tr>
                        <td><br>
                            <?php echo $error ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Acceder" class="login-btn btn-primary btn">
                        </td>
                    </tr>
                </div>
                <tr>
                    <td>
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Aún no tienes cuenta&#63; </label>
                        <a href="signup.php" class="hover-link1 non-style-link">Regístrate</a>
                        <br><br><br>
                    </td>
                </tr>
                </form>
            </table>
        </div>
    </center>
</body>

</html>
