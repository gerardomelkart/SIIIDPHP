
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inicio de Sesión</title>

    <link rel="stylesheet" href="public/css/styleLogin.css">
    <link rel="shortcut icon" href="https://www.gob.mx/resources/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="public/js/funciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="public/font-awesome-4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>  
    <script src="public/js/jquery.min.js"></script>
    <script src="public/js/loadingoverlay.js"></script>
 
 

</head>



<body>

    <div class="divLogos">
        <img src="public/img/LogoSEGURIDAD.png">
    </div>


    <div class="formularioLogin">
        <h1>Inicio de Sesión</h1>
        <div style="text-align: center;"><h5>Ver. 2.1</h5></div>
        <br>


        <form  id="loginform">
            <div class="username">
                <input type="text" name="txtusuario" id="txtusuario" required>
                <label>Nombre de Usuario</label>
            </div>
            <div class="contrasena">
                <input type="password" name="txtcontrasena" id="txtcontrasena" required>
                <label>Contraseña</label>
            </div>
            <!-- <div class="recordar">¿Olvido su Contraseña?</div> -->
            
            <button type="button" class="botonIngresar" id="btnEntrar">Entrar</button>
            <div class="registrarse">
                <!-- Quiero hacer mi <a href="#">Registro</a> -->
            </div> 
            <div id="respuestaValidaUsuario"></div>
            <span id="loaderLogin"></span>
        </form>
        
    </div>

    


</body>
</html>


<script>

    $("#btnEntrar").on("click", function() {    

       ejecutaPeticionAjaxGenericaLogin("POST","../ConAutenticacion/sesionIniciada","respuestaValidaUsuario","loaderLogin","btnEntrar","loginform","Validando")  
                
    })

   
</script>