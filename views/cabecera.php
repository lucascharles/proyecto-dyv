<html>
	<head>
		<title><?php echo $nom_sistema ?></title>
	
	</head>
	<body>
    	<table border="0" align="center" width="100%" height="70" cellpadding="0" cellspacing="0" class="cabecera" >
        	<tr>
            	<td height="66" align="left" valign="bottom">
                	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                    	<tr>
                        	<td>
                			<font class="tituloSistema"><?php echo $nom_sistema ?></font>
                    		</td>
                            <td align="right">
                            <div class="userlogin" onClick="cambiarClave()">	<? echo($_SESSION["idusuario"]) ?></div>
                            </td>
                            <td align="right" width="25">
                            <div style="cursor:pointer; position:relative; margin-right:10px;" onClick="salirSistema()">
                            	<img src="images/salir.png" title="Salir" alt="Salir">
                            </div>
                            </td>
                    	</tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td height="4" align="left" valign="bottom">
                
                </td>
            </tr>
        </table>
	</body>
</html>
