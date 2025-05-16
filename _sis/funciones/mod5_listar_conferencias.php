<?php
include('mod5_conferencias.php'); $Con = new Conferencias();

$arr_conferencias = array();
$arr_conferencias = $Con->gets_all_conferencias();

echo json_encode($arr_conferencias);

?> 