<?php
class InformesModel extends ModelBase
{
		
	public function listar_informe($tipoInforme,$mandante,$tipodoc, $iddocs='')
	{
		
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
		$sqlpersonal->set_select( "  m.rut_mandante rut_mandante, m.dv_mandante dv_mandante, 
									   ds.rut_deudor rut_deudor, ds.dv_deudor dv_deudor,
									   ds.primer_apellido primer_apellido, ds.segundo_apellido segundo_apellido,
									   ds.primer_nombre primer_nombre, ds.segundo_nombre segundo_nombre,
   									   ds.razonsocial razonsocial,
									   d.numero_siniestro numero_siniestro,
									   d.fecha_siniestro fecha_siniestro,
									   d.monto monto,
									   td.tipo_documento tipo_documento,
									   d.numero_documento numero_documento,
									   f.id_ficha numero_ficha,
									   f.juzgado_anexo juzgado,
									   f.rol rol,
									   d.id_documento id_documento,
   									   MAX(eg.fecha_prox_gestion) fecha_prox_gestion,
   									   MAX(eg.notas) notas ");
		$sqlpersonal->set_from( " documentos d , deudores ds LEFT JOIN ficha f ON ds.id_deudor = f.id_deudor, mandantes m, tipodocumento td ,estados_x_gestion eg ");
				
			$where = " d.id_deudor = ds.id_deudor
						AND d.id_documento = eg.id_documento
						AND d.id_mandatario = m.id_mandante
						AND d.id_tipo_doc = td.id_tipo_documento
						AND d.activo = 'S'
						AND ds.activo = 'S'
						AND m.activo = 'S'
						AND td.activo = 'S'
						AND d.id_estado_doc not in (2,4)
						AND d.id_estado_doc ".$tipoInforme .
				  " 	AND d.id_mandatario = ". $mandante;
			
			
			if($tipodoc != ""){
				
				$where = $where. " and d.id_tipo_doc = ".$tipodoc;
			}
			
			if($iddocs != "")
			{
				$where = $where. " and d.id_documento in (".$iddocs.")";
			}
			
			$where = $where. " GROUP BY
							   m.rut_mandante , m.dv_mandante , 
							   ds.rut_deudor , ds.dv_deudor ,
							   ds.primer_apellido , ds.segundo_apellido,
							   ds.primer_nombre , ds.segundo_nombre,
							   ds.razonsocial ,
							   d.numero_siniestro ,
							   d.fecha_siniestro ,
							   d.monto ,
							   td.tipo_documento ,
							   d.numero_documento ,
							   f.id_ficha ,
							   f.juzgado_anexo ,
							   f.rol ,
							   d.id_documento ";
			
			$sqlpersonal->set_where($where);
				
			
    		$sqlpersonal->load();

    	return $sqlpersonal;	
		
	}
	
	
}
?>