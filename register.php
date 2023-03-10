<?php
session_start();
require_once('config.php');
 
if(isset($_POST['submit']))
{
    if(isset($_POST['nombre'],$_POST['apellido'],$_POST['email'],$_POST['password']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['email']) && !empty($_POST['password']))
    {
        $firstName = trim($_POST['nombre']);
        $lastName = trim($_POST['apellido']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $hashPassword = $password;
        $options = array("cost"=>4);
        $hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);
        $date = date('Y-m-d H:i:s');
 
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $sql = 'select * from users where email = :email';
            $stmt = $pdo->prepare($sql);
            $p = ['email'=>$email];
            $stmt->execute($p);
            
            if($stmt->rowCount() == 0)
            {
                $sql = "insert into users (nombre, apellido, email, `password`, created_at,updated_at) values(:vnombre,:vapellido,:email,:pass,:created_at,:updated_at)";
            
                try{
                    $handle = $pdo->prepare($sql);
                    $params = [
                        ':vnombre'=>$firstName,
                        ':vapellido'=>$lastName,
                        ':email'=>$email,
                        ':pass'=>$hashPassword,
                        ':created_at'=>$date,
                        ':updated_at'=>$date
                    ];
                    
                    $handle->execute($params);
                    
                    $success = 'Usuario creado correctamente!!';
                    
                }
                catch(PDOException $e){
                    $errors[] = $e->getMessage();
                }
            }
            else
            {
                $valFirstName = $firstName;
                $valLastName = $lastName;
                $valEmail = '';
                $valPassword = $password;
 
                $errors[] = 'El Email ya esta registrado';
            }
        }
        else
        {
            $errors[] = "El Email no es valido";
        }
    }
    else
    {
        if(!isset($_POST['nombre']) || empty($_POST['nombre']))
        {
            $errors[] = 'El Nombre es requerido';
        }
        else
        {
            $valFirstName = $_POST['apellido'];
        }
        if(!isset($_POST['apellido']) || empty($_POST['apellido']))
        {
            $errors[] = 'El Apellido es requerido';
        }
        else
        {
            $valLastName = $_POST['apellido'];
        }
 
        if(!isset($_POST['email']) || empty($_POST['email']))
        {
            $errors[] = 'El Email es requerido';
        }
        else
        {
            $valEmail = $_POST['email'];
        }
 
        if(!isset($_POST['password']) || empty($_POST['password']))
        {
            $errors[] = 'La Contraseña es requerida';
        }
        else
        {
            $valPassword = $_POST['password'];
        }
        
    }
 
}
?>
 
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="stylesheet" href="estilos.css">
        <title>Page Title - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Registrese</h3></div>
                                    <hr> 
                                    <div class="card-body">
                                    <div class="val">
                                    <?php 
                                        if(isset($errors) && count($errors) > 0)
                                        {
                                            foreach($errors as $error_msg)
                                            {
                                                echo '<div class="alert alert-danger">'.$error_msg.'</div>';
                                            }
                                        }
                                        
                                        if(isset($success))
                                        {
                                            
                                            echo '<div class="alert alert-success">'.$success.'</div>';
                                        }
                                    ?>
                                    </div>
                                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <i class="fa-solid fa-user"></i>
                                                        <label class="small mb-1" for="inputFirstName">Nombre</label>
                                                        <input class="form-control py-4" name="nombre" id="inputFirstName" type="text" placeholder="Nombre" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <i class="fa-solid fa-user"></i>
                                                        <label class="small mb-1" for="inputLastName">Apellido</label>
                                                        <input class="form-control py-4" name="apellido" id="inputLastName" type="text" placeholder="Apellido" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <i class="fa-solid fa-envelope"></i>
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Correo" />
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <i class="fa-solid fa-unlock"></i>
                                                        <label class="small mb-1" for="inputPassword">Contraseña</label>
                                                        <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Contraseña" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <i class="fa-solid fa-unlock"></i>
                                                        <label class="small mb-1" for="inputConfirmPassword">Confirme la Contraseña</label>
                                                        <input class="form-control py-4" name="repassword" id="inputConfirmPassword" type="password" placeholder="Confirmar Contraseña" />
                                                    </div>
                                                    <hr> 
                                                </div>
                                            </div>
                                            <button type="submit" name="submit" class="btn-primary">Registrarse</button>
                                            
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.php">¿Tienes una cuenta? Ve a iniciar sesión</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                           
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
