<?PHP
	include "../Connector.php";
	$RollSerialNo		= $_GET["RollNo"];
	$RollSerialYear	= $_GET["RollYear"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GaPro - Sticker Print</title>
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
<?php 
$sql="select intSRNO,
intSupplierBatchNo,
intCompanyBatchNo,
strColor,
(select strTitle from suppliers S where S.strSupplierID=FH.strSupplierID)AS supplierName
 from fabricrollheader FH
inner join specification SP on SP.intStyleId=FH.intStyleId 
where intFRollSerialNO='$RollSerialNo'
and intFRollSerialYear='$RollSerialYear' ;";
$result=$db->RunQuery($sql);
while ($row=mysql_fetch_array($result))
{

	$srNo				= $row["intSRNO"];
	$supplierBatchNo	= $row["intSupplierBatchNo"];
	$companyBatchNo		= $row["intCompanyBatchNo"];
	$color				= $row["strColor"];
	$supplierName		= $row["supplierName"];
}
?>
<body>
<table width="355" border="0" cellspacing="0" cellpadding="0">
<tr><td>
<?php 
$sql="select intRollNo from fabricrolldetails 
	where intFRollSerialNO='$RollSerialNo'
	and intFRollSerialYear='$RollSerialYear'";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
		$rollNo	= $row["intRollNo"];
?>
<div style="border-width:1px;border:#ffffff;border-style:solid;overflow:hidden;">
 <table>
  <tr>
    <td width="50">&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td width="84">&nbsp;</td>
  </tr>
 <?php 
$sqlcomp="select dblCompLength as compLength,dblCompWidth as compWidth,dblCompWeight as compWeight from fabricrolldetails 
WHERE  intRollNo='$rollNo'
AND intFRollSerialNO='$RollSerialNo'
AND  intFRollSerialYear='$RollSerialYear'";
$result_comp=$db->RunQuery($sqlcomp);
while($row_comp=mysql_fetch_array($result_comp))
{
	$compLength	=$row_comp["compLength"];
	$compWidth	=$row_comp["compWidth"];
	$compWeight	=$row_comp["compWeight"];
}
?>
  <tr>
    <td colspan="5" align="center"><span class="paragraph"><span class="fontColor11">Company -Len-</span><span class="fontColor11"><?php echo $compLength;?></span><span class="fontColor11"> </span><span class="fontColor11">YRD</span><span class="fontColor11"> / Wdt - </span><span class="fontColor11"><?php echo $compWidth;?></span><span class="fontColor11"> </span><span class="fontColor11">INCH</span><span class="fontColor11"> / Wgt - </span><span class="fontColor11"><?php echo $compWeight;?></span><span class="fontColor11"> </span><span class="fontColor11" >KGS</span></span></td>
  </tr>
  <tr>
    <td height="25" colspan="5" align="center"><span class="fontColor10" ><?php echo $srNo.'-'. $companyBatchNo.'-'.$rollNo;?></span></td>
  </tr>
  <tr>
    <td colspan="5"><span class="fontColor14"><?PHP echo substr($supplierName,0,10);?></span><span class="paragraph"><span class="fontColor14">&nbsp;Batch # </span><span class="fontColor13"></span><?php echo $supplierBatchNo;?></span></span><span class="paragraph"><span class="fontColor14">Color:</span><span class="fontColor13"></span><?php echo $color;?></span></span></td>
  </tr>
<?php 
$sqlsupp="select dblSuppLength as suppLength,dblSuppWidth as suppWidth,dblSuppWeight as suppweight from fabricrolldetails 
where intRollNo='$rollNo'
and intFRollSerialNO='$RollSerialNo'
and intFRollSerialYear='$RollSerialYear'";
$result_supp=$db->RunQuery($sqlsupp);
while($row_supp=mysql_fetch_array($result_supp))
{
	$suppLength	=$row_supp["suppLength"];
	$suppWidth	=$row_supp["suppWidth"];
	$suppweight	=$row_supp["suppweight"];
}
?>
  <tr>
    <td height="19" colspan="5" align="center"><sup><span class="fontColor11"> -Len-</span><span class="fontColor11"><?php echo number_format($suppLength,2);?></span><span class="fontColor11"> </span><span class="fontColor11">YRD</span><span class="fontColor11"> / Wdt-</span><span class="fontColor11"><?php echo number_format($suppWidth,2);?></span><span class="fontColor11">INCH</span><span class="fontColor11"> /Wgt-</span><span class="fontColor11"><?php echo number_format($suppweight,2);?></span><span class="fontColor11"> </span><span class="fontColor11">KGS</span></sup></td>
  </tr>
  
  <tr>
    <td height="10"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  </table>
  </div>
 <?php }?>  
 </td></td>
</table>
</body>
</html>
