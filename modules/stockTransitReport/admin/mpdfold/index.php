<?php

require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();


$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML('Introduction');

$mpdf->TOCpagebreak();
$mpdf->TOC_Entry("Chapter 1",0);
$mpdf->WriteHTML('Chapter 1 ...');

$mpdf->Output();
?>