<?php 
session_start();
include('conecion.php');

if (isset($POST[usuario]) && (isset($POST[clave]) ) ) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $usuario = validate($POST['usuario']);
    $clave = validate($POST['clave']);

    if (empty($usuario)) {
        header("Location: login.php?error=El usuario es requerido");
        exit();
    } elseif (empty($clave)) {
        header("Location: login.php?error=La clave es requerida "); 
        exit();
    } else {

       // $clave= md5($clave);

        $sql = "SELECT * FROM datos WHERE usuario= '$usuario' AND  clave='$clave'"; 
        $result = mysqli_query($conexion, $sql);

        if (mysqli_mun_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['usuario'] === $usuario && $row['clave'] === $clave) {
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['nom_completo'] = $row['nom_completo'];
                $_SESSION['id'] = $row['id'];
                header("Location: diseño.html");
                exit();
            }else {
                header("Location: login.php?error=El usuario o la clave son incorrectos");
                exit();
            }
        }else {
            header("Location: login.php?error=El usuario o la clave son incorrectos");
                exit();
        }
    }
}else {
    header("Location: login.php");
        exit();
}
?>