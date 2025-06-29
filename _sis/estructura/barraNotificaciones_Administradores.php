<?php
	session_start();					
?>


<!-- BEGIN LOADER -->
<div id="load_screen"> <div class="loader"> <div class="loader-content">
	<div class="spinner-grow align-self-center"></div>
</div></div></div>	

<!--  BEGIN NAVBAR  -->
<div class="header-container container-xxl">
	<header class="header navbar navbar-expand-sm expand-header">

		<!-- LOGO -->
		<!-- LOGO -->
		<!-- LOGO -->
		 
		<ul class="navbar-item theme-brand flex-row  text-center">
			<li class="nav-item theme-logo">
				<a href="./principal.php">
					<img src="./images/logos/icono.ico" alt="logo">
				</a>
			</li>
			<li class="nav-item theme-text">
				<a href="./principal.php" class="nav-link"> <?php echo 'Inscripciones' ?></a>
			</li>
		</ul>
	
		<!-- BUSQUEDA -->
		<!-- BUSQUEDA -->
		<!-- BUSQUEDA -->
		
		<!-- Muestra borde de componentes del Form -->
		<style>
			input:focus, select:focus, textarea:focus {
				border: 2px solid #007bff !important;                   /* Borde azul más grueso */
				box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;  /* Sombra suave */
				transition: all 0.3s ease;                                /* Animación suave */
			}
		</style>

		<div class="search-animated toggle-search">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			<form class="form-inline search-full form-inline search" role="search">
				<div class="search-wrapper">
					<input id="autoComplete" type="text" class="form-control search-form-control ml-lg-auto" placeholder="Buscar...">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x search-close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
				</div>
				<div id="resultados" class="mt-1"></div>
			</form>
			<span class="badge badge-secondary">Ctrl + M</span>
		</div>

		<!-- DERECHA: idioma / tema / notificaciones / perfil -->
		<ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">

			<!-- IDIOMA -->
			<!-- <li class="nav-item dropdown language-dropdown">
				<a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="../src/assets/img/1x1/us.svg" class="flag-width" alt="flag">
				</a>
				<div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
					<a class="dropdown-item d-flex" href="javascript:void(0);"><img src="../src/assets/img/1x1/us.svg" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;English</span></a>
					<a class="dropdown-item d-flex" href="javascript:void(0);"><img src="../src/assets/img/1x1/tr.svg" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;Turkish</span></a>
					<a class="dropdown-item d-flex" href="javascript:void(0);"><img src="../src/assets/img/1x1/br.svg" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;Portuguese</span></a>
					<a class="dropdown-item d-flex" href="javascript:void(0);"><img src="../src/assets/img/1x1/in.svg" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;Hindi</span></a>
					<a class="dropdown-item d-flex" href="javascript:void(0);"><img src="../src/assets/img/1x1/de.svg" class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;German</span></a>
				</div>
			</li> -->

			<!-- TEMA -->
			<!-- TEMA -->
			<!-- TEMA -->

			<li class="nav-item theme-toggle-item">
				<a href="javascript:void(0);" class="nav-link theme-toggle">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon dark-mode"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun light-mode"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
				</a>
			</li>

			<!-- NOTIFICACIONES -->
			<!-- NOTIFICACIONES -->
			<!-- NOTIFICACIONES -->

			<li class="nav-item dropdown notification-dropdown">
				<a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
						<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
						<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
					</svg>
					<!-- <span class="badge badge-success"></span> -->
				</a>

				<div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
					<div class="drodpown-title message">
						<h6 class="d-flex justify-content-between">
							<span class="align-self-center">Mensajes</span> 
							<!-- <span class="badge badge-primary">9 Unread</span> -->
						</h6>
					</div>

					<div class="notification-scroll">

						<!-- <div class="dropdown-item">
							<div class="media server-log">
								<img src="./src/assets/img/profile-16.jpeg" class="img-fluid me-2" alt="avatar">
								<div class="media-body">
									<div class="data-info">
										<h6 class="">Kara Young</h6>
										<p class="">1 hr ago</p>
									</div>
									
									<div class="icon-status">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
									</div>
								</div>
							</div>
						</div> -->
						
						<div class="drodpown-title notification mt-2">
							<h6 class="d-flex justify-content-between">
								<span class="align-self-center">Notificaciones</span> 
								<!-- <span class="badge badge-secondary">16 New</span> -->
							</h6>
						</div>

						<!-- <div class="dropdown-item">
							<div class="media server-log">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>
								<div class="media-body">
									<div class="data-info">
										<h6 class="">Server Rebooted</h6>
										<p class="">45 min ago</p>
									</div>

									<div class="icon-status">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
									</div>
								</div>
							</div>
						</div>

						<div class="dropdown-item">
							<div class="media file-upload">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
								<div class="media-body">
									<div class="data-info">
										<h6 class="">Kelly Portfolio.pdf</h6>
										<p class="">670 kb</p>
									</div>

									<div class="icon-status">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
									</div>
								</div>
							</div>
						</div>

						<div class="dropdown-item">
							<div class="media ">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
								<div class="media-body">
									<div class="data-info">
										<h6 class="">Licence Expiring Soon</h6>
										<p class="">8 hrs ago</p>
									</div>

									<div class="icon-status">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
									</div>
								</div>
							</div>
						</div> -->
						
					</div>
				</div>
				
			</li>

			<!-- PERFIL -->
			<!-- PERFIL -->
			<!-- PERFIL -->

			<?php 
				
				$arr                = array();
				$arr         = $U->gets_datos_persona($login);
				
				// $UsuarioLogueado    = $datos[0]['nombre'].' '.$datos[0]['apellido'];
				$UsuarioLogueado    = $arr[0]['nombre'].' '.$arr[0]['apellido'];
				// $URL_img            = './foto_perfil/'.$datos[0]['id'].'.png';
				$URL_img            = './foto_perfil/'.$arr[0]['id'].'.png';
				if (!file_exists($URL_img)){ 
					$UsuarioLogueado_img= '<img src="./foto_perfil/999.png" alt="avatar" class="rounded-circle">';
				}else{
					$UsuarioLogueado_img= '<img src="./foto_perfil/'.$arr[0]['id'].'.png" alt="avatar" class="rounded-circle">';
				}
				//$arr         = $U->gets_datos_persona($login);
				$fk_perfil   = $arr[0]['fk_perfil'];
			?>

				<li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">

                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                                <?php echo $UsuarioLogueado_img ?>
                                <!-- <img alt="avatar" src="../src/assets/img/profile-30.png" class="rounded-circle"> -->
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    &#x1F44B;
                                </div>
                                <div class="media-body">
                                    <h5><?php echo utf8_encode($UsuarioLogueado); ?></h5>
                                    <!-- <p>Funcion</p> -->
                                </div>
                            </div>
                        </div>						
                        <div class="dropdown-item"><a href="./_usuario_perfil.php">			<span>Perfil		</span></a>      </div>
                        <div class="dropdown-item"><a href="./_usuario_cambiar_clave.php">	<span>Cambiar clave	</span></a>      </div>
                        <div class="dropdown-item"><a href="funciones/desconectar.php">		<span>Salir			</span></a>      </div>
                    </div>
                    
                </li>
		</ul>

	</header>
</div>

