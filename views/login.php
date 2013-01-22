<html>
	<head>
		<title><?php echo $nom_sistema ?></title>
		<link rel="stylesheet" href="css/login.css" type="text/css" />
		<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#usrLogin').focus();
		});
		</script>
	</head>
	<body>
		<div id="login">
        
        <div ><img src="images/logoproyecto.jpg"></div>
        <form action="<?php echo $accion_form ?>"  method="post">

			<input type="hidden" name="empLogin" id="empLogin"  value="<?php //echo  $_SESSION["empLogin_default"]?>"/>
			<input type="hidden" name="ProyectoLogin" id="ProyectoLogin"  value="<?php //echo  $_SESSION["Proyecto_default"]?>"/>

			<label for="usrLogin">Usuario:</label>
			<input type="text" name="usrLogin" id="usrLogin" />
			
			<label for="passLogin">Contrase&ntilde;a:</label>
			<input type="password" name="passLogin" id="passLogin" />
			
			<div class="espacio"></div>
			<input type="submit" class="boton" value="Iniciar Sesi&oacute;n" />
			</form>
		</div>
	</body>
</html>
