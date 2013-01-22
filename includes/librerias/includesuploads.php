<?php

		$max_size = 20000000;
	
		$nombre_archivo_foto = strtolower(str_replace(" ", "_",basename($_FILES['archivo']['name'])));
		//$nombre_archivo_foto = $_FILES['archivoFoto']['name'];
		$tipo_archivo_foto = $_FILES['archivoFoto']['type'];
		$tamano_archivo_foto = $_FILES['archivoFoto']['size']; 
		$error_foto = $_FILES['archivoFoto']['error'];
		$activo = "S";
				
		// VALIDACIONES DE TIPO DE ARCHIVO
		if (($nombre_archivo_foto != NULL && $nombre_archivo_foto != "") && !(strpos($tipo_archivo_foto, "gif") || strpos($tipo_archivo_foto, "jpeg") || strpos($tipo_archivo_foto, "jpg") || strpos($tipo_archivo_foto, "png"))) {
			if($ir == "")
				$ir = "../message.php?titulo=Error en subida de archivo&mensaje=La extensión de la foto no es correcta.&destino=panel.php?mod=adm_respuestas";
		}
		
		// VALIDACION TAMAÑO DE ARCHIVO
		if (($nombre_archivo_foto != NULL && $nombre_archivo_foto != "") && $_FILES['archivoFoto']['size'] > $max_size) {
			if($ir == "")
				$ir = "../message.php?titulo=Error en subida de archivo&mensaje=El tamaño de la foto supera el máximo permitido.&destino=panel.php?mod=adm_respuestas";
		}
		
				
		// UPLOAD DE ARCHIVOS
		if(($nombre_archivo_foto != NULL && $nombre_archivo_foto != "") && $error_foto == UPLOAD_ERR_OK) {
			$uploadOkFoto = move_uploaded_file($_FILES['archivoFoto']['tmp_name'], $dir_uploaded_files.$nombre_carpeta.$nombre_archivo_foto);

			if(!$uploadOkFoto) {
				if($ir == "")
					$ir = "../message.php?titulo=Error en subida de archivo&mensaje=El archivo no pudo subir correctamente.&destino=panel.php?mod=adm_respuestas";
			}
		}
		
		
?>