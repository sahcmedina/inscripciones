<?php
include('mod6_foros.php'); $For = new Foros();
	
$arr_foros = $For->gets_all_foros();

echo json_encode($arr_foros);

?> 