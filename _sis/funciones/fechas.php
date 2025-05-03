<?php
class Fechas{

	/**
	TABLAS AFECTADAS: 
	* 	(actualización) 
	*   (consulta)
	*/
	
	/**
	ESTADOS: 
	* 	
	*/
	
	function get_nombre_dia_corto($fecha){
	   	$fechats = strtotime($fecha); 

		//lo devuelve en numero 0 domingo, 1 lunes,....
		switch (date('w', $fechats)){
		    case 0: return "Dom"; 	break;
		    case 1: return "Lun"; 	break;
		    case 2: return "Mar"; 	break;
		    case 3: return "Mie"; 	break;
		    case 4: return "Jue"; 	break;
		    case 5: return "Vie"; 	break;
		    case 6: return "Sab"; 	break;
		}
	}
	function get_sumar_dias($fecha, $cant){
		// aaaa-mm-dd
		return date("Y-m-d",strtotime($fecha."+ $cant days")); 	
	}
	function get_restar_dias($fecha, $cant){
		// aaaa-mm-dd
		return date("Y-m-d",strtotime($fecha."- $cant days")); 	
	}
	function get_convert_fecha_a_diaSemana($fecha){
		$dia_s = date("l", strtotime($fecha));
		$return= '';
		switch($dia_s){
			case 'Monday' :   $return='Lun'; break;
			case 'Tuesday':   $return='Mar'; break;
			case 'Wednesday': $return='Mie'; break;
			case 'Thursday':  $return='Jue'; break;
			case 'Friday' :   $return='Vie'; break;
			case 'Saturday':  $return='Sab'; break;
			case 'Sunday' :   $return='Dom'; break;
		} 	
		return $return;
	}	
	function get_convert_nroMes_a_letra($mes){
		$return= '';
		switch($mes){
			case '1' : $return='Ene'; break;
			case '01': $return='Ene'; break;
			case '2' : $return='Feb'; break;
			case '02': $return='Feb'; break;
			case '3' : $return='Mar'; break;
			case '03': $return='Mar'; break;
			case '4' : $return='Abr'; break;
			case '04': $return='Abr'; break;
			case '5' : $return='May'; break;
			case '05': $return='May'; break;
			case '6' : $return='Jun'; break;
			case '06': $return='Jun'; break;
			case '7' : $return='Jul'; break;
			case '07': $return='Jul'; break;
			case '8' : $return='Ago'; break;
			case '08': $return='Ago'; break;
			case '9' : $return='Sep'; break;
			case '09': $return='Sep'; break;
			case '10': $return='Oct'; break;
			case '11': $return='Nov'; break;
			case '12': $return='Dic'; break;
		} 	
		return $return;
	}	
	function get_convert_nroMes_a_letra_largo($mes){
		$return= '';
		switch($mes){
			case '1' : $return='Enero'; break;
			case '01': $return='Enero'; break;
			case '2' : $return='Febrero'; break;
			case '02': $return='Febrero'; break;
			case '3' : $return='Marzo'; break;
			case '03': $return='Marzo'; break;
			case '4' : $return='Abril'; break;
			case '04': $return='Abril'; break;
			case '5' : $return='Mayo'; break;
			case '05': $return='Mayo'; break;
			case '6' : $return='Junio'; break;
			case '06': $return='Junio'; break;
			case '7' : $return='Julio'; break;
			case '07': $return='Julio'; break;
			case '8' : $return='Agosto'; break;
			case '08': $return='Agosto'; break;
			case '9' : $return='Septiembre'; break;
			case '09': $return='Septiembre'; break;
			case '10': $return='Octubre'; break;
			case '11': $return='Noviembre'; break;
			case '12': $return='Diciembre'; break;
		} 	
		return $return;
	}	
	function diferencia_fechas($f_inicio, $f_fin){		
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		
		$date1 = new DateTime($f_inicio);
		$date2 = new DateTime($f_fin);
		$diff  = $date1->diff($date2);
		return $diff->days;
	}
    function diferencia_hs($hs_inicio, $hs_fin){		
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		
		$apertura= new DateTime($hs_inicio);
		$cierre  = new DateTime($hs_fin);
		$tiempo  = $apertura->diff($cierre);
		return $tiempo->format('%H:%i:%s');
	}
	function restar_($hora1,$hora2){
 
	    $temp1 = explode(":",$hora1);
	    $temp_h1 = (int)$temp1[0];
	    $temp_m1 = (int)$temp1[1];
	    $temp_s1 = (int)$temp1[2];
	    $temp2 = explode(":",$hora2);
	    $temp_h2 = (int)$temp2[0];
	    $temp_m2 = (int)$temp2[1];
	    $temp_s2 = (int)$temp2[2];
	 
	    // si $hora2 es mayor que la $hora1, invierto 
	    if( $temp_h1 < $temp_h2 ){
	        $temp  = $hora1;
	        $hora1 = $hora2;
	        $hora2 = $temp;
	    }
	    /* si $hora2 es igual $hora1 y los minutos de 
	       $hora2 son mayor que los de $hora1, invierto*/
	    elseif( $temp_h1 == $temp_h2 && $temp_m1 < $temp_m2){
	        $temp  = $hora1;
	        $hora1 = $hora2;
	        $hora2 = $temp;
	    }
	    /* horas y minutos iguales, si los segundos de  
	       $hora2 son mayores que los de $hora1,invierto*/
	    elseif( $temp_h1 == $temp_h2 && $temp_m1 == $temp_m2 && $temp_s1 < $temp_s2){
	        $temp  = $hora1;
	        $hora1 = $hora2;
	        $hora2 = $temp;
	    }
	 
	    $hora1=explode(":",$hora1);
	    $hora2=explode(":",$hora2);
	    $temp_horas = 0;
	    $temp_minutos = 0;
	 
	    //resto segundos 
	    $segundos;
	    if( (int)$hora1[2] < (int)$hora2[2] ){
	        $temp_minutos = -1;
	        $segundos = ( (int)$hora1[2] + 60 ) - (int)$hora2[2];
	    }
	    else
	        $segundos = (int)$hora1[2] - (int)$hora2[2];
	 
	    //resto minutos 
	    $minutos;
	    if( (int)$hora1[1] < (int)$hora2[1] ){
	        $temp_horas = -1;
	        $minutos = ( (int)$hora1[1] + 60 ) - (int)$hora2[1] + $temp_minutos;
	    }
	    else
	        $minutos =  (int)$hora1[1] - (int)$hora2[1] + $temp_minutos;
	 
	    //resto horas     
	    $horas = (int)$hora1[0]  - (int)$hora2[0] + $temp_horas;
	 
	    if($horas<10)
	        $horas= '0'.$horas;
	 
	    if($minutos<10)
	        $minutos= '0'.$minutos;
	 
	    if($segundos<10)
	        $segundos= '0'.$segundos;
	 
	    $rst_hrs = $horas.':'.$minutos.':'.$segundos;
	 
	    return ($rst_hrs);
	}
    function suma_hs($hora1,$hora2){ 	
    
	    $hora1= explode(":",$hora1);
	    $hora2= explode(":",$hora2);
	    $temp = 0;
	 
	    //sumo segundos 
	    $segundos= (int)$hora1[2] + (int)$hora2[2];
	    while($segundos>=60){
	        $segundos=$segundos-60;
	        $temp++;
	    }
	 
	    //sumo minutos 
	    $minutos= (int)$hora1[1] + (int)$hora2[1] + $temp;
	    $temp=0;
	    while($minutos>=60){
	        $minutos=$minutos-60;
	        $temp++;
	    }
	 
	    //sumo horas 
	    $horas=(int)$hora1[0]+(int)$hora2[0]+$temp;	 
	    if($horas<10)        	$horas   = '0'.$horas;	 
	    if($minutos<10)       	$minutos = '0'.$minutos;	 
	    if($segundos<10)        $segundos= '0'.$segundos;
	   
	    $sum_hrs = $horas.':'.$minutos.':'.$segundos;	 
	    return $sum_hrs;	 
    }
}
?>