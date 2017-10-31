<?php
	session_start();
	$backwardseperator 	= "../../../";	
	include $backwardseperator."Connector.php" ;
	$xmldoc=simplexml_load_file($backwardseperator.'config.xml');
	$Company=$xmldoc->companySettings->Declarant;
	
	$titleid			= $_GET["titleid"];
	
	function xlsBOF() 
	{
    	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
   	    return;
	}
	function xlsEOF()
    {
   	    echo pack("ss", 0x0A, 0x00);
        return;
    }
	function xlsWriteNumber($Row, $Col, $Value)
    {
   	    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
        echo pack("d", $Value);
        return;
    }
	function xlsWriteLabel($Row, $Col, $Value) 
	{
   	    $L = strlen($Value);
        echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
        echo $Value;
        return;
	}
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");    
	header ("Pragma: no-cache");    
	header ('Content-type: application/x-msexcel');
	header ("Content-Disposition: attachment; filename=zolla_edl_excel.xls" ); 
	header ("Content-Description: PHP/INTERBASE Generated Data" ); 
	
	xlsBOF();
	
	
	xlsWriteLabel(++$i,0,"ORIT TRADING LANKA (PVT) LTD");
	
	
	xlsWriteLabel(++$i,0,"07-02,East Tower, World Trade Center, Eachelon Square, Colombo 1, Sri Lanka.");
			
	
	xlsWriteLabel(++$i,0,"07-02,East Tower, World Trade Center, Eachelon Square, Colombo 1, Sri Lanka.");
	
	xlsWriteLabel(++$i,0,"Tel: 0094-11-2346370-5 Fax: 0094-11-2346376");
	$i+=3;
	xlsWriteLabel($i,0,"EXPORT DECLARATION");
	$i+=2;
	xlsWriteLabel($i,0,"INVOICE NO");
	
	xlsWriteLabel(++$i,0,"DATE");
	
	xlsWriteLabel(++$i,0,"EXPORT PORT");
	
	xlsWriteLabel(++$i,0,"DATE OF PORT");
	
	xlsWriteLabel(++$i,0,"FACTORY NAME");
	
	xlsWriteLabel(++$i,0,"BILL OF LADING NO");
	
	xlsWriteLabel(++$i,0,"CONSIGNEE");
	
	xlsWriteLabel(++$i,0,"COUNTRY OF ORIGIN");
	
	xlsWriteLabel(++$i,0,"INCOTERMS");
	
	xlsWriteLabel(++$i,0,"PAYMENT FOR TRANSPORTATION");
	$i+=3;	
	# write grid headers to the excel sheet #############
	$headerArray1 = array('ORDER NUMBER','ARTICLE','SHIPPED QTY','UNIT PRICE FOB-USD','AMOUNT FOB-USD','PKGS',
							'G.WT','N.WT','H.S.CODE');
    $c=0;
	foreach($headerArray1 as $val)
	{
		xlsWriteLabel($i,$c,"$val");
		$c++;
	}
	### data rows for above grid goes here ############
	for($k=1;$k<6;$k++)
	{
		$DetailArray = array($k,'','0','','0','0','0','0','');	
    	$c=0;
		++$i;
		foreach($DetailArray as $val)
		{
			xlsWriteLabel($i,$c,$val);
			$c++;
		}
		
	}
	$footerArray = array('TOTAL','','0','','0','0','0','0','');	
    $c=0;
	++$i;
	foreach($footerArray as $val)
	{
		xlsWriteLabel($i,$c,"$val");
		$c++;
	}
	#column array after the grid ##############
	$coldataArray = array('ORDER NO','ACCOMPANYING FORMS','PRODUCER','DESCRIPTION','FINAL CONSUMER COUNTRY','FULL NAME & ADDRESS OF MAKER',
							'EXPORTER\'S INVOICE NO');	
							
	$i+=3;
	foreach($coldataArray as $val)
	{
		xlsWriteLabel($i,0,"$val");
		$i++;
	}
	
	$i++;
	xlsWriteLabel($i,0,"NAME");
	$i++;
	xlsWriteLabel($i,0,"POSITION");
	$i++;
	xlsWriteLabel($i,0,"SIGNATURE/STAMP");
	
	xlsEOF();

?>