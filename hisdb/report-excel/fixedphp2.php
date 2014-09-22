<?php
	include_once('../connect_db.php');
	require_once '../Classes/PHPExcel.php';
	$columnhead=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

	$from2=explode('-',$_GET['from']);$from=$from2[2].'-'.$from2[1].'-'.$from2[0];
	$to2=explode('-',$_GET['to']);$to=$to2[2].'-'.$to2[1].'-'.$to2[0];
	$temp=null;$temp2=null;
	$len=3;
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1','Statistics')
		->setTitle("Statistics Female");
	$objPHPExcel->getActiveSheet()->setCellValue('A1','Name');
	$objPHPExcel->getActiveSheet()->setCellValue('B1','MRN');
	$objPHPExcel->getActiveSheet()->setCellValue('C1','NEWIC');
	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex(1)
		->setCellValue('A1','Statistics')
		->setTitle("Statistics Male");
	$objPHPExcel->getActiveSheet()->setCellValue('A1','Name');
	$objPHPExcel->getActiveSheet()->setCellValue('B1','MRN');
	$objPHPExcel->getActiveSheet()->setCellValue('C1','NEWIC');
	
	$sql="select mrn,name,newic,dob,AddDate,sex from patmast where AddDate between '{$from}' and '{$to}' order by sex,AddDate,MRN";
	$res=mysql_query($sql);
	
	$numrow1=2;$numrow=2;
	while($row=mysql_fetch_array($res,MYSQL_BOTH)){
		if($row['sex']=='F'){
			$objPHPExcel->setActiveSheetIndex(0);
			if($temp==null){
				$temp=$row['AddDate'];$numrow1++;
				$objPHPExcel->getActiveSheet()->setCellValue($columnhead[0].$numrow1,'Date: '.$temp);
				$objPHPExcel->getActiveSheet()->getStyle($columnhead[0].$numrow1)->getFont()->setBold(true);$numrow1++;
				for($x=0;$x<$len;$x++){//key data
					$objPHPExcel->getActiveSheet()->setCellValue($columnhead[$x].$numrow1,$row[$x]);
				}$numrow1++;
			}else if($temp!=$row['AddDate']){
				$temp=$row['AddDate'];$numrow1++;
				$objPHPExcel->getActiveSheet()->setCellValue($columnhead[0].$numrow1,'Date: '.$temp);
				$objPHPExcel->getActiveSheet()->getStyle($columnhead[0].$numrow1)->getFont()->setBold(true);$numrow1++;
				for($x=0;$x<$len;$x++){//key data
					$objPHPExcel->getActiveSheet()->setCellValue($columnhead[$x].$numrow1,$row[$x]);
				}$numrow1++;
			}else{
				for($x=0;$x<$len;$x++){//key data
					$objPHPExcel->getActiveSheet()->setCellValue($columnhead[$x].$numrow1,$row[$x]);
				}$numrow1++;
			}
		}else if($row['sex']=='M'){
			$objPHPExcel->setActiveSheetIndex(1);
			if($temp==null){
				$temp=$row['AddDate'];$numrow++;
				$objPHPExcel->getActiveSheet()->setCellValue($columnhead[0].$numrow,'Date: '.$temp);
				$objPHPExcel->getActiveSheet()->getStyle($columnhead[0].$numrow)->getFont()->setBold(true);$numrow++;
				for($x=0;$x<$len;$x++){//key data
					$objPHPExcel->getActiveSheet()->setCellValue($columnhead[$x].$numrow,$row[$x]);
				}$numrow++;
			}else if($temp!=$row['AddDate']){
				$temp=$row['AddDate'];$numrow++;
				$objPHPExcel->getActiveSheet()->setCellValue($columnhead[0].$numrow,'Date: '.$temp);
				$objPHPExcel->getActiveSheet()->getStyle($columnhead[0].$numrow)->getFont()->setBold(true);$numrow++;
				for($x=0;$x<$len;$x++){//key data
					$objPHPExcel->getActiveSheet()->setCellValue($columnhead[$x].$numrow,$row[$x]);
				}$numrow++;
			}else{
				for($x=0;$x<$len;$x++){//key data
					$objPHPExcel->getActiveSheet()->setCellValue($columnhead[$x].$numrow,$row[$x]);
				}$numrow++;
			}
		}
	}
	
	
		
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="01simple.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

	
?>