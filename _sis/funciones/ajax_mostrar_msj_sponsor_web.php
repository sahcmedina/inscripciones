<?php

$mostrar = $_POST['m'];
switch ($mostrar){
	case 0: ?> <center><h5><span style="color: red;">¿ MOSTRAR ESTE SPONSOR EN LA WEB ?         </span></h5></center> <?php break;
	case 1: ?> <center><h5><span style="color: red;">¿ DEJAR DE MOSTRAR ESTE SPONSOR EN LA WEB ?</span></h5></center> <?php break;
}

?>