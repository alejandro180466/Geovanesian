<?php
include('../../dominio/pdf/class.ezpdf.php');
$pdf = new Cezpdf();
$pdf->selectFont('../../dominio/pdf/fonts/Helvetica.afm'); //selecciono la fuente
$pdf->ezText('Mi primer pdf en PHP',20);  //texto y tamaño de letra
$pdf->ezStream();

?>