
<?php
session_start();
require_once('config.php');
 
if(isset($_POST['submit']))
{
	if(isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']))
	{
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
 
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$sql = "select * from users where email = :email ";
			$handle = $pdo->prepare($sql);
			$params = ['email'=>$email];
			$handle->execute($params);
			if($handle->rowCount() > 0)
			{
				$getRow = $handle->fetch(PDO::FETCH_ASSOC);
				if(password_verify($password, $getRow['password']))
				{
					unset($getRow['password']);
					$_SESSION = $getRow;
					header('location:diseño.html');
					exit();
				}
				else
				{
					$errors[] = "Error en  Email o Password";
				}
			}
			else
			{
				$errors[] = "Error Email o Password";
			}
			
		}
		else
		{
			$errors[] = "Email no valido";	
		}
 
	}
	else
	{
		$errors[] = "Email y Password son requeridos";	
	}
 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="card-header">
    <h3 class="text-center font-weight-light my-4">Inicio de Sesion</h3>
    <hr> 
</div>
<div class="card-body">
<div class="val">
<?php
    if (isset($errors) && count($errors) > 0) {
        foreach ($errors as $error_msg) {
            echo '<div class="alert alert-danger">' . $error_msg . '</div>';
        }
    }
?>
 </div>   
        <div class="form-group">
		<i class="fa-solid fa-envelope"></i>
            <label class="small mb-1" for="inputEmailAddress">Email</label>
            <input class="form-control py-4" name="email" id="inputEmailAddress"
                type="email" placeholder="Correo" />
        </div>
        <div class="form-group">
		<i class="fa-solid fa-unlock"></i>
            <label class="small mb-1" for="inputPassword">Contraseña</label>
            <input class="form-control py-4" name="password" id="inputPassword"
                type="password" placeholder="Contraseña" />
        </div>
        <hr> 
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" id="rememberPasswordCheck"
                    type="checkbox" />
                <label class="custom-control-label" for="rememberPasswordCheck">
                    Recordar contraseña </label>
            </div>
        </div>
        <div
            class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
            <a class="small" href="password.html">¿Ha olvidado tu contraseña?</a>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </div>
    
</div>
<div class="card-footer text-center">
    <div class="small"><a href="register.php">Registrese!</a></div>
    </form>
</div>
</body>
</html>