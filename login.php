<?php 
session_start();
?>

<!DOCTYPE html><html lang="es">

<head>
    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>    
</head>

<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>

    <br/><br/><br/><br/>


    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
    
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        
                        <div class="card-body">
                        <form name="login" action="./funciones/login.php" role="form" method="post">
    
                            <div class="row">
                                
                                <div class="col-md-12 mb-3">                                    
                                    <h2>Acceso</h2>
                                    <p>Por favor ingresa tus credenciales..</p>                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Usuario</label>
                                        <input type="text" class="form-control" id="usuario" name="usuario"  tabindex="1">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" placeholder="..." id="pass" name="pass"  tabindex="2">
                                    </div>
                                </div>                                
                                <div class="col-12">
                                    <div class="mb-4">
                                        <!-- <button class="btn btn-secondary w-100">Ingresar</button> -->
                                        <button name="btn" value="Ingresar"  class="btn btn-secondary w-100"  tabindex="3"> Ingresar </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0">Más que software, una solución inteligente para tu crecimiento... 
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                        
                        </form>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>
    
    

</body>
</html>