<?php
class InformesModel extends ModelBase
{
		
	public function listar_informe($tipoInforme,$mandante,$tipodoc, $iddocs='')
	{
		
		include("config.php");

		$sqlpersonal = new SqlPersonalizado($config->get('dbhost'), $config->get('dbuser'), $config->get('dbpass') );
	
		$sqlpersonal->set_select( " m.rut_mandante rut_mandante, m.dv_mandante dv_mandante, 
				   de.rut_deudor rut_deudor, de.dv_deudor dv_deudor,
				   d.numero_siniestro numero_siniestro,
				   d.fecha_siniestro fecha_siniestro,
				   ed.estado estado,
				   d.monto monto,
				   td.tipo_documento tipo_documento,
				   b.banco banco,
				   d.numero_documento numero_documento,
				   cp.causal causal,
				   f.id_ficha numero_ficha,
				   de.primer_nombre primer_nombre,
				   de.primer_apellido primer_apellido,
				   j.descripcion juzgado_numero ,
				   jc.descripcion juzgado_comuna,
				   f.rol rol ");
		$sqlpersonal->set_from( " documentos d,
					mandantes m,
					deudores de,
					estadodocumentos ed,
					tipodocumento td,
					bancos b,
					causalprotesta cp,
  				    ficha f,
  				    juzgado j,
  				    juzgadocomuna jc ");
				
			$where = " d.id_mandatario = m.id_mandante
					and	  d.id_deudor = de.id_deudor
					and   d.id_estado_doc = ed.id_estado_doc
					and   d.id_tipo_doc = td.id_tipo_documento
					and   d.id_banco = b.id_banco
					and	  d.id_causa_protesto = cp.id_causal
					and   d.id_deudor = f.id_deudor
					and	  f.id_juzgado = j.id_juzgado
					and   f.id_juzgado_comuna = jc.id_juzgado_comuna 
					and   d.id_documento = f.id_documento 
					and   f.id_juzgado = j.id_juzgado
					and   f.id_juzgado_comuna = jc.id_juzgado_comuna
					and   d.id_estado_doc ".$tipoInforme .
				  " and   m.id_mandante = ". $mandante;
			
			if(($fecha_desde != "") && ($fecha_hasta != "")){
				
				$where = $where. " and d.fecha_creacion between ".$fecha_desde." and ". $fecha_hasta;
			}
			
			if($tipodoc != ""){
				
				$where = $where. " and d.id_tipo_doc = ".$tipodoc;
			}
			
			if($iddocs != "")
			{
				$where = $where. " and d.id_documento in (".$iddocs.")";
			}
			
			$sqlpersonal->set_where($where);
				
			
    		$sqlpersonal->load();

    	return $sqlpersonal;	
		
	}
	
}
?>