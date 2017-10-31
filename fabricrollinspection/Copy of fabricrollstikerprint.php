<?PHP
	include "../Connector.php";
	$RollSerialNo		= $_GET["RollNo"];
	$RollSerialYear	= $_GET["RollYear"];
?>
<HTML>
<?php 
$sql="select intSRNO,intSupplierBatchNo,strColor,
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
	$color				= $row["strColor"];
	$supplierName		= $row["supplierName"];
}
?>
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

<TITLE>Crystal Report Viewer</TITLE>
<BODY LEFTMARGIN="0" TOPMARGIN="0" BOTTOMMARGIN="0" RIGHTMARGIN="0">
<?php 
$sql="select intRollNo from fabricrolldetails 
	where intFRollSerialNO='$RollSerialNo'
	and intFRollSerialYear='$RollSerialYear'";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
		$rollNo	= $row["intRollNo"];
?>

<DIV  style="z-index:25; position:absolute; left:72PX; top:24PX; width:320PX; height:46PX; " class="adornment10"  ALIGN="CENTER">
<table width="315PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="CENTER"><span class="fontColor10"><?php echo $srNo;?></span><span class="fontColor10">-</span><span class="fontColor10">E</span><span class="fontColor10">-</span><span class="fontColor10">01</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:64PX; top:8PX; width:336PX; height:28PX; " class="adornment10"  ALIGN="CENTER">
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
<table width="331PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph" ALIGN="CENTER"><span class="fontColor11">Company -Len-</span><span class="fontColor11"><?php echo $compLength;?></span><span class="fontColor11"> </span><span class="fontColor11">YRD</span><span class="fontColor11"> / Wdt - </span><span class="fontColor11"><?php echo $compWidth;?></span><span class="fontColor11"> </span><span class="fontColor11">INCH</span><span class="fontColor11"> / Wgt - </span><span class="fontColor11"><?php echo $compWeight;?></span><span class="fontColor11"> </span><span class="fontColor11">KGS</span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:72PX; top:64PX; width:152PX; height:18PX; " class="adornment10" >
<table width="147PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor12">Batch # </span><span class="fontColor12"></span><?php echo $supplierBatchNo;?></span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:232PX; top:64PX; width:168PX; height:16PX; " class="adornment10" >
<table width="163PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor13">Color-</span><span class="fontColor13"><?php echo $color;?></span></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:72PX; top:80PX; width:48PX; height:15PX; " class="adornment10" >
<table width="43PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="fontColor14" ><?PHP echo $supplierName;?></td></tr></table>
</DIV>

<DIV  style="z-index:25; position:absolute; left:120PX; top:90px; width:288PX; height:26PX; " class="adornment10" >
<?php 
$sqlsupp="select sum(dblSuppLength)as suppLength,sum(dblSuppWidth)as suppWidth,sum(dblSuppWeight)as suppweight from fabricrolldetails where 
intFRollSerialNO='$RollSerialNo'
and intFRollSerialYear='$RollSerialYear'";
$result_supp=$db->RunQuery($sqlsupp);
while($row_supp=mysql_fetch_array($result_supp))
{
	$suppLength	=$row_supp["suppLength"];
	$suppWidth	=$row_supp["suppWidth"];
	$suppweight	=$row_supp["suppweight"];
}
?>
<table width="283PX" border=0 cellpadding="0" cellspacing="0"><tr><td NOWRAP class="paragraph"><span class="fontColor11"> -Len-</span><span class="fontColor11"><?php echo number_format($suppLength,2);?></span><span class="fontColor11"> </span><span class="fontColor11">YRD</span><span class="fontColor11"> / Wdt-</span><span class="fontColor11"><?php echo number_format($suppWidth,2);?></span><span class="fontColor11">INCH</span><span class="fontColor11"> /Wgt-</span><span class="fontColor11"><?php echo number_format($suppweight,2);?></span><span class="fontColor11">   </span><span class="fontColor11">KGS</span></td></tr></table>
</DIV>
</div>
<?php
}
?>
<BR>
</BODY>
</HTML>
