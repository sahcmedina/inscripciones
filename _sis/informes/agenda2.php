<?php
error_reporting(E_ALL ^ E_NOTICE);
include("mc_table.php");
define('FPDF_FONTPATH', 'font/');
class PDF extends PDF_Mc_Table{	
	function Footer(){
	    //Posición: a 1,5 cm del final
	    $this->SetY(-10);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //Número de página
	    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	    //Posición: a 1,5 cm del final
	    $this->SetY(-10);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //Número de página
	    $this->Cell(0,10,utf8_decode('ArgOliva'),0,0,'C');
		}	

	function ColorRow($data, $fillColor = array(255,255,255), $isBold = false)
	{
		// Establecer tamaño fijo de 9 puntos con o sin negrita
		if ($isBold) {
			$this->SetFont('Arial', 'B', 10);
		} else {
			$this->SetFont('Arial', '', 10);
		}
		
		// Establecer color de relleno
		$this->SetFillColor($fillColor[0], $fillColor[1], $fillColor[2]);
		
		// Calcular altura de fila
		$nb = 0;
		for($i=0; $i<count($data); $i++) {
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		}
		$h = 5*$nb;
		
		// Verificar si se necesita un salto de página
		$this->CheckPageBreak($h);
		
		// Dibujar celdas
		for($i=0; $i<count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			
			// Guardar posición actual
			$x = $this->GetX();
			$y = $this->GetY();
			
			// Dibujar borde y relleno
			$this->Rect($x, $y, $w, $h, 'DF'); // 'DF' = Dibujar y Rellenar
			
			// Imprimir texto
			$this->MultiCell($w, 5, $data[$i], 0, $a);
			
			// Mover a la derecha de la celda
			$this->SetXY($x+$w, $y);
		}
		
		// Ir a la siguiente línea
		$this->Ln($h);
		
		// NO restauramos el tamaño de fuente porque queremos mantenerlo en 9
		// Dejamos establecido el tamaño 9 porque todas las ColorRow lo usarán
	}
}

// Blanco: SetFillColor(255, 255, 255)
// Negro: SetFillColor(0, 0, 0)
// Rojo: SetFillColor(255, 0, 0)
// Verde: SetFillColor(0, 255, 0)
// Azul: SetFillColor(0, 0, 255)
// Amarillo: SetFillColor(255, 255, 0)
// Magenta: SetFillColor(255, 0, 255)
// Cian: SetFillColor(0, 255, 255)

$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();

session_start();

$hay_tabla_1 = $_SESSION['hay_tabla_1'];
$hay_tabla_2 = $_SESSION['hay_tabla_2'];
$knt_emp_c   = $_SESSION['knt_emp_c'];
$arr_info    = $_SESSION['arr_info2']; // unica diferencia con el script "agenda1"
$f_dia       = $_SESSION['f_dia_2_']; 
$knt_emp_c_  = $knt_emp_c + 1;


// CABECERA	
$pdf->Image('logo_apaisado.png', 19 , 3,  250, 30, 'png', '');  // x(<->) y(arriba abajo) z(ancho) w(alto)
$pdf->Ln(30);
$pdf->SetFont('Helvetica','B', 11);// B negrita / I cursiva / U subrayado
$pdf->Cell(0,10,utf8_decode('Agenda de Negocios '.$f_dia),10,0,'C');
$pdf->Cell(190);
$pdf->Ln(10);


switch($knt_emp_c_){

	case 2:
		$pdf->SetWidths(array(40,100)); // suma= 265
		$pdf->SetAligns(array('C','C'));
		$pdf->SetFont('Helvetica','B', 10);// B negrita / I cursiva / U subrayado
		$fila= array($arr_info[0][0], utf8_decode($arr_info[0][1]) );
		$pdf->ColorRow($fila, array(200, 200, 200), true);
		$pdf->SetAligns(array('C','C'));
		$pdf->SetFont('Helvetica','', 10);// B negrita / I cursiva / U subrayado
		for ($i = 1; is_array($arr_info) && $i < count($arr_info); $i++) {
			$cur = $arr_info[$i];
			$cant= 0;
			$f1  = $cur[0]; if($f1!='') $cant++;			$f2 = $cur[1]; if($f2!='') $cant++;
 
			if($cant > 1){
				$fila= array(utf8_decode($cur[0]), utf8_decode($cur[1]) );
				if($i % 2 == 0) { 
					$pdf->ColorRow($fila, array(240, 240, 240), false);
				}else{ 
					$pdf->Row($fila);
				}	
			}			
		}
		$pdf->Ln(10);
		break;

	case 3:
		$pdf->SetWidths(array(40,100, 100)); // suma= 265
		$pdf->SetAligns(array('C','C','C'));
		$pdf->SetFont('Helvetica','B', 10);// B negrita / I cursiva / U subrayado
		$fila= array($arr_info[0][0], utf8_decode($arr_info[0][1]), utf8_decode($arr_info[0][2]) );
		$pdf->ColorRow($fila, array(200, 200, 200), true);
		$pdf->SetAligns(array('C','C','C'));
		$pdf->SetFont('Helvetica','', 10);// B negrita / I cursiva / U subrayado
		for ($i = 1; is_array($arr_info) && $i < count($arr_info); $i++) {
			$cur = $arr_info[$i];
			$cant= 0;
			$f1  = $cur[0]; if($f1!='') $cant++;			$f2 = $cur[1]; if($f2!='') $cant++;                  $f3 = $cur[2]; if($f3!='') $cant++;

			if($cant > 1){
				$fila= array(utf8_decode($cur[0]), utf8_decode($cur[1]), utf8_decode($cur[2]) );
				if($i % 2 == 0) { 
					$pdf->ColorRow($fila, array(240, 240, 240), false);
				}else{ 
					$pdf->Row($fila);
				}	
			}			
		}
		$pdf->Ln(10);
		break;

	case 4:
		$pdf->SetWidths(array(40,75,75,75)); // suma= 265
		$pdf->SetAligns(array('C','C','C','C'));
		$pdf->SetFont('Helvetica','B', 10);// B negrita / I cursiva / U subrayado
		$fila= array($arr_info[0][0], utf8_decode($arr_info[0][1]), utf8_decode($arr_info[0][2]), utf8_decode($arr_info[0][3]));
		$pdf->ColorRow($fila, array(200, 200, 200), true);
		$pdf->SetAligns(array('C','C','C','C'));
		$pdf->SetFont('Helvetica','', 10);// B negrita / I cursiva / U subrayado
		for ($i = 1; is_array($arr_info) && $i < count($arr_info); $i++) {
			$cur = $arr_info[$i];

			$cant= 0;
			$f1  = $cur[0]; if($f1!='') $cant++;			$f2 = $cur[1]; if($f2!='') $cant++;
			$f3  = $cur[2]; if($f3!='') $cant++;            $f4 = $cur[3]; if($f4!='') $cant++;
 
			if($cant > 1){
				$fila= array(utf8_decode($cur[0]), utf8_decode($cur[1]) ,utf8_decode($cur[2]) ,utf8_decode($cur[3]));
				if($i % 2 == 0) { 
					$pdf->ColorRow($fila, array(240, 240, 240), false);
				}else{ 
					$pdf->Row($fila);
				}	
			}					
			
		}
		$pdf->Ln(10);
		break;

	case 5:
		$pdf->SetWidths(array(40,56,56,56,56)); // suma= 265
		$pdf->SetAligns(array('C','C','C','C','C'));
		$pdf->SetFont('Helvetica','B', 10);// B negrita / I cursiva / U subrayado
		$fila= array($arr_info[0][0], utf8_decode($arr_info[0][1]), utf8_decode($arr_info[0][2]), utf8_decode($arr_info[0][3]), utf8_decode($arr_info[0][4]));
		$pdf->ColorRow($fila, array(200, 200, 200), true);
		$pdf->SetAligns(array('C','C','C','C','C'));
		$pdf->SetFont('Helvetica','', 10);// B negrita / I cursiva / U subrayado
		for ($i = 1; is_array($arr_info) && $i < count($arr_info); $i++) {
			$cur = $arr_info[$i];

			$cant= 0;
			$f1  = $cur[0]; if($f1!='') $cant++;			$f2 = $cur[1]; if($f2!='') $cant++;				$f3  = $cur[2]; if($f3!='') $cant++;            
			$f4 = $cur[3]; if($f4!='') $cant++;             $f5 = $cur[4]; if($f5!='') $cant++;
	
			if($cant > 1){
				$fila= array(utf8_decode($cur[0]), utf8_decode($cur[1]) ,utf8_decode($cur[2]) ,utf8_decode($cur[3])  ,utf8_decode($cur[4]));
				if($i % 2 == 0) { 
					$pdf->ColorRow($fila, array(240, 240, 240), false);
				}else{ 
					$pdf->Row($fila);
				}	
			}					
			
		}
		$pdf->Ln(10);
		break;

	case 6:
		$pdf->SetWidths(array(40,45,45,45,45,45)); // suma= 265
		$pdf->SetAligns(array('C','C','C','C','C','C'));
		$pdf->SetFont('Helvetica','B', 10);// B negrita / I cursiva / U subrayado
		$fila= array($arr_info[0][0], utf8_decode($arr_info[0][1]), utf8_decode($arr_info[0][2]), utf8_decode($arr_info[0][3]), utf8_decode($arr_info[0][4]), utf8_decode($arr_info[0][5]) );
		$pdf->ColorRow($fila, array(200, 200, 200), true);
		$pdf->SetAligns(array('C','C','C','C','C','C'));
		$pdf->SetFont('Helvetica','', 10);// B negrita / I cursiva / U subrayado
		for ($i = 1; is_array($arr_info) && $i < count($arr_info); $i++) {
			$cur = $arr_info[$i];

			$cant= 0;
			$f1  = $cur[0]; if($f1!='') $cant++;			$f2 = $cur[1]; if($f2!='') $cant++;				$f3 = $cur[2]; if($f3!='') $cant++;            
			$f4 = $cur[3]; if($f4!='') $cant++;             $f5 = $cur[4]; if($f5!='') $cant++;             $f6 = $cur[5]; if($f5!='') $cant++;
	
			if($cant > 1){
				$fila= array(utf8_decode($cur[0]), utf8_decode($cur[1]) ,utf8_decode($cur[2]) ,utf8_decode($cur[3]) ,utf8_decode($cur[4]), utf8_decode($cur[5]) );
				if($i % 2 == 0) { 
					$pdf->ColorRow($fila, array(240, 240, 240), false);
				}else{ 
					$pdf->Row($fila);
				}	
			}					
			
		}
		$pdf->Ln(10);
		break;
	
	case 7:
		$pdf->SetWidths(array(40,37,37,37,37,37,37)); // suma= 265
		$pdf->SetAligns(array('C','C','C','C','C','C','C'));
		$pdf->SetFont('Helvetica','B', 10);// B negrita / I cursiva / U subrayado
		$fila= array($arr_info[0][0], utf8_decode($arr_info[0][1]), utf8_decode($arr_info[0][2]), utf8_decode($arr_info[0][3]), utf8_decode($arr_info[0][4]), utf8_decode($arr_info[0][5]), utf8_decode($arr_info[0][6]) );
		$pdf->ColorRow($fila, array(200, 200, 200), true);
		$pdf->SetAligns(array('C','C','C','C','C','C','C'));
		$pdf->SetFont('Helvetica','', 10);// B negrita / I cursiva / U subrayado
		for ($i = 1; is_array($arr_info) && $i < count($arr_info); $i++) {
			$cur = $arr_info[$i];

			$cant= 0;
			$f1  = $cur[0]; if($f1!='') $cant++;			$f2 = $cur[1]; if($f2!='') $cant++;				$f3 = $cur[2]; if($f3!='') $cant++;            
			$f4  = $cur[3]; if($f4!='') $cant++;            $f5 = $cur[4]; if($f5!='') $cant++;             $f6 = $cur[5]; if($f5!='') $cant++;
			$f7  = $cur[6]; if($f7!='') $cant++;

			if($cant > 1){
				$fila= array(utf8_decode($cur[0]), utf8_decode($cur[1]) ,utf8_decode($cur[2]) ,utf8_decode($cur[3]) ,utf8_decode($cur[4]), utf8_decode($cur[5]), utf8_decode($cur[6]) );
				if($i % 2 == 0) { 
					$pdf->ColorRow($fila, array(240, 240, 240), false);
				}else{ 
					$pdf->Row($fila);
				}	
			}					
			
		}
		$pdf->Ln(10);
		break;
}


// CIERRE Y ENTREGA DEL PDF 
$pdf->Output("agenda.pdf","F");
echo "<script language='javascript'>window.open('agenda.pdf','_self','');</script>";


// borrar las variables de sesion
if (isset($_SESSION['hay_tabla_1']))      unset($_SESSION['hay_tabla_1']);
if (isset($_SESSION['hay_tabla_2']))      unset($_SESSION['hay_tabla_2']);
if (isset($_SESSION['knt_emp_c']))        unset($_SESSION['knt_emp_c']);
if (isset($_SESSION['arr_info']))         unset($_SESSION['arr_info']);
if (isset($_SESSION['f_dia_1_']))         unset($_SESSION['f_dia_1_']);
if (isset($_SESSION['f_dia_2_']))         unset($_SESSION['f_dia_2_']);

exit;	
?>