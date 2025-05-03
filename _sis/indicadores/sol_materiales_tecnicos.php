<?php
	session_start();	
    require_once('./funciones/mod2_sol_material.php');     $SolMat = new SolicitudMateriales();
	require_once ('./Mobile_Detect/Mobile_Detect.php');

	$arr_solicPorTec = array();

	// # pendientes de revision
	if($perfil_user == 6){
		// Tecnico
		$arr_solicPorTec = $SolMat->gets_solicPorTec_pend($id_user);
		$knt_solicPend   = count($arr_solicPorTec); 
		$url_pendientes  = '_ind_sol_materiales_pend.php';
	}else{
		// Admin
		$knt_solicPend   = $SolMat->get_cant_solicPendTodas(); 
		$url_pendientes  = '_ind_sol_materiales_pend_admin.php';
	}

    // Dispositivo conectado
    $dispositivo = new Mobile_Detect();
    if ($dispositivo->isMobile()){       $disp_conectado = 'Movil';    }
    else{							     $disp_conectado = 'PC';       }

	if($disp_conectado == 'Movil'){
		$center_1= '<center>';	$center_2= '</center>';		$salto= '<br/>';
	}else{
		$center_1= '';			$center_2= '';              $salto= '';
	}

?>

<!-- VIEW -->
<div id="badgeOutline" class="col-lg-12 mx-auto layout-spacing">
	<div class="statbox widget box box-shadow">

		<div class="widget-header"><?php echo $center_1 ?>
			<div class="row"><div class="col-xl-12 col-md-12 col-sm-12 col-12"><h7> Solicitud de Material</h7></div></div><?php echo $center_2 ?>			
		</div>

		<?php echo $salto ?>

		<div class="widget-content widget-content-area text-center">

			<?php if($perfil_user == 6){ ?>
				<a href="_ind_sol_materiales.php"><span class="badge outline-badge-success mb-2 me-4"> Solicitar </span></a>
			<?php } ?>

			<a href="<?php echo $url_pendientes ?>" class="position-relative d-inline-block">
				<span class="badge outline-badge-info mb-2 me-4">Pendientes</span>
				<?php if($knt_solicPend >0){ ?>
					<span class="badge bg-danger position-absolute rounded-circle d-flex justify-content-center align-items-center" 
						style="top: -5px; right: 10px; width: 20px; height: 20px; font-size: 0.75rem;"><?php echo $knt_solicPend ?>
					</span>
				<?php } ?>
			</a>

			<a href="#" class="position-relative d-inline-block">
				<span class="badge outline-badge-info mb-2 me-4">Historial</span>
			</a>

		</div>
	</div>
</div>

