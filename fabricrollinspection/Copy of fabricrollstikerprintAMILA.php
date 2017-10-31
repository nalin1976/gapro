<?PHP
	include "../Connector.php";
	$RollSerialNo		= $_GET["RollNo"];
	$RollSerialYear	= $_GET["RollYear"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<STYLE>
 A {text-decoration:none}
 A IMG {border-style:none; border-width:0;} 
.fontColor10 {FONT-SIZE:27PT; ; FONT-FAMILY:Arial; FONT-WEIGHT:BOLD; }
.fontColor11 {FONT-SIZE:7PT; ; FONT-FAMILY:Times New Roman; }
.fontColor12 {FONT-SIZE:10PT; ; FONT-FAMILY:Arial; FONT-WEIGHT:BOLD; }
.fontColor13 {FONT-SIZE:9PT; ; FONT-FAMILY:Arial; FONT-WEIGHT:BOLD; }
.fontColor14 {FONT-SIZE:8PT; ; FONT-FAMILY:Arial; }
.adornment10 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
</STYLE>
</head>

<body>
<table width="355" border="0" cellspacing="0" cellpadding="0">
  <?php for($j=0; $j<5; $j++) {?>
  <tr>
    <td>&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td width="84">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><span class="paragraph"><span class="fontColor11">Company -Len-</span><span class="fontColor11"><?php echo $compLength;?></span><span class="fontColor11"> </span><span class="fontColor11">YRD</span><span class="fontColor11"> / Wdt - </span><span class="fontColor11"><?php echo $compWidth;?></span><span class="fontColor11"> </span><span class="fontColor11">INCH</span><span class="fontColor11"> / Wgt - </span><span class="fontColor11"><?php echo $compWeight;?></span><span class="fontColor11"> </span><span class="fontColor11" >KGS</span></span></td>
  </tr>
  <tr>
    <td height="25" colspan="5" align="center"><span class="fontColor10" > 8243-A-007</span></td>
  </tr>
  <tr>
    <td colspan="5"><span class="fontColor14"><?PHP echo $supplierName;?></span><span class="paragraph"><span class="fontColor12">Batch # </span><span class="fontColor12"></span><?php echo $supplierBatchNo;?></span></span><span class="paragraph"><span class="fontColor12">Color </span><span class="fontColor12"></span><?php echo $supplierBatchNo;?></span></span></td>
  </tr>
  <tr>
    <td height="19" colspan="5" align="center"><sup><span class="fontColor11"> -Len-</span><span class="fontColor11"><?php echo number_format($suppLength,2);?></span><span class="fontColor11"> </span><span class="fontColor11">YRD</span><span class="fontColor11"> / Wdt-</span><span class="fontColor11"><?php echo number_format($suppWidth,2);?></span><span class="fontColor11">INCH</span><span class="fontColor11"> /Wgt-</span><span class="fontColor11"><?php echo number_format($suppweight,2);?></span><span class="fontColor11"> </span><span class="fontColor11">KGS</span></sup></td>
  </tr>
  
  <tr>
    <td height="19" width="50">&nbsp;</td>
    <td  width="50">&nbsp;</td>
    <td  width="50">&nbsp;</td>
    <td  width="50">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 <?php }?>  
</table>
</body>
</html>
