<?php
	include_once('../connect_db.php');
	require_once '../Classes/PHPExcel.php';
	$columnhead =array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

	$sysno1 = $_GET['rowidarray'];
	$sysno=explode(',',$sysno1);
	
	$temp=null;$temp2=null;
	$len=10;
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1','Subscribers Detail in Excel')
		->setTitle("Statistics Female");
	$objPHPExcel->getActiveSheet()->setCellValue('A2','MRN');
	$objPHPExcel->getActiveSheet()->setCellValue('B2','MEMBERNO');
	$objPHPExcel->getActiveSheet()->setCellValue('C2','CATEGORY');
	$objPHPExcel->getActiveSheet()->setCellValue('D2','AGREEMENT NO');
	$objPHPExcel->getActiveSheet()->setCellValue('E2','NAME');
	$objPHPExcel->getActiveSheet()->setCellValue('F2','IC NO');
	$objPHPExcel->getActiveSheet()->setCellValue('G2','DOB');
	$objPHPExcel->getActiveSheet()->setCellValue('H2','HANDPHONE');
	$objPHPExcel->getActiveSheet()->setCellValue('I2','ADD DATE');
	$objPHPExcel->getActiveSheet()->setCellValue('J2','SEX');
	

	
	$sql="select mrn,memberno,category,agreementno,name,newic,dob,telhp,AddDate,sex from membership where sysno in($sysno1)";
	$res=mysql_query($sql);
	
	$numrow1=4;$numrow=4;
	while($row=mysql_fetch_array($res,MYSQL_BOTH)){
		for($x=0;$x<$len;$x++){//key data
			$objPHPExcel->getActiveSheet()->setCellValue($columnhead[$x].$numrow1,$row[$x]);
		}$numrow1++;
	}
	
	
		
	
	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="01simple.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

	
?>