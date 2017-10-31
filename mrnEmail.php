<?php
session_start();
ob_start();
include "Connector.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MRN Report</title>

<style type="text/css">
.borderAshCent {
	font-family: Arial;
	border: 1px solid #999999;
	text-align: center;
}
.style13 {color: #FFFFFF; font-size: 10pt; font-family: Arial, Helvetica, sans-serif; font-weight: bold; text-align: center; }
.header {
	font-family: Arial;
	font-size: 18px;
	font-weight: bold;
	color: #000000;
	text-align: center;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 10pt;
}
.borderBLC {
	font-family:Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight:bold;
	border: 1px solid #999999;
	text-align: center;	
}
.bck {
	font-family: Arial;
	font-size: 12px;
	border: 1px solid #999999;
	text-align: center;
}
.borderAsh {
	border: 1pt solid #CCCCCC;
	font-family:Arial, Helvetica, sans-serif;
	font-size:9pt;
}
</style>
</head>
<body>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" >&nbsp;</td>
        <td width="37%" ><p><?php 
		$matreqno=$_GET["mrnNo"];
		$year=$_GET["year"];
		
		$SQL_matre="select matrequisition.intMatRequisitionNo,matrequisition.dtmDate,matrequisition.intRequestedBy,(select useraccounts.Name from useraccounts where useraccounts.intUserID = matrequisition.intRequestedBy) as requested from matrequisition where matrequisition.intMatRequisitionNo ='$matreqno' and matrequisition.intMRNYear='$year';";

		$result_matre = $db->RunQuery($SQL_matre);

		
		while($row = mysql_fetch_array($result_matre))
		{	
		$MatRequisitionNo=$row["intMatRequisitionNo"];
		$MatRequisitionDate=$row["dtmDate"];
		$MatRequisitionDateNew= substr($MatRequisitionDate,-19,10);
		$MatRequisitionDateNewDate= substr($MatRequisitionDateNew,-2);
		$MatRequisitionDateNewYear=substr($MatRequisitionDateNew,-10,4);
		$MatRequisitionDateNewmonth1=substr($MatRequisitionDateNew,-5);
		$MatRequisitionDateNewmonth=substr($MatRequisitionDateNewmonth1,-5,2);
		$MatReqRequestedBy=$row["requested"];
		}
		 ?></p></td>
        <td width="37%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" >
      <tr>
        <td width="83%" height="38" class="header">MATERIAL REQUISITION NOTE</td>
        <td width="17%" class="header">QAP-18-C</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="50%"><table width="100%" border="0">
              <tr> 
                <td width="41%" class="bck">Mat. Requisition No</td>
                <td width="59%" class="bck"><div align="left">:<?php echo $MatRequisitionNo;?></div>                </td>
              </tr>
            </table></td>
        <td width="50%"><table width="100%" border="0">
              <tr> 
                <td width="34%" class="bck">Requested Date</td>
                <td width="66%" class="bck"><div align="left">:<?php echo $MatRequisitionDateNewDate."/".$MatRequisitionDateNewmonth."/".$MatRequisitionDateNewYear;?>
                </div></td>
              </tr>
            </table></td>
      </tr>
    </table></td>
  </tr>
  <tr class="borderBLC">
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#666666" class="style13"> 
          <td width="14%" height="24">STYLE NO</td>
          <td width="42%">ITEM</td>
          <td width="16%">COLOR</td>
          <td width="14%">SIZE</td>
          <td width="14%">REQ QTY</td>
        </tr>
		
		<?php
		$sum = 0;
			$sql = "select  DISTINCT matmaincategory.intID, matmaincategory.strDescription from matrequisitiondetails,matitemlist,matmaincategory  where matrequisitiondetails.intMatRequisitionNo = $matreqno AND matrequisitiondetails.strMatDetailID = matitemlist.intItemSerial AND matitemlist.intMainCatID = matmaincategory.intID";
			$mainresult = $db->RunQuery($sql);
			while($row = mysql_fetch_array($mainresult))
			{	
		?>
		
        <tr bgcolor="#6699FF"> 
          <td colspan="5" class="style1"><?php echo  $row["strDescription"]; ?></td>
        </tr>
		<?php
		
		$CatID = $row["intID"];
		$sql = "select matitemlist.strItemDescription,  matrequisitiondetails.intStyleId, matrequisitiondetails.strColor,matrequisitiondetails.strSize,matrequisitiondetails.dblQty from matrequisitiondetails,matitemlist where matrequisitiondetails.intMatRequisitionNo = $matreqno   AND matrequisitiondetails.strMatDetailID = matitemlist.intItemSerial AND matitemlist.intMainCatID = $CatID";
		$subresult = $db->RunQuery($sql);
			while($row = mysql_fetch_array($subresult))
			{
			$qty= $row["dblQty"]; 
			$sum += $qty;
		?>
        <tr> 
          <td class="bck"><?php echo  $row["intStyleId"]; ?></td>
          <td class="bck"><?php echo  $row["strItemDescription"]; ?></td>
          <td class="bck"><?php echo  $row["strColor"]; ?></td>
          <td class="bck"><?php echo  $row["strSize"]; ?></td>
          <td class="bck"><div align="right"><?php echo  $row["dblQty"]; ?></div>          </td>
        </tr>
		<?php
			}
		}
		
		?>
		
		
        <tr bgcolor="#CCCCCC" class="borderBLC"> 
          <td class="style1" colspan="4">Total</td>
          <td class="style1"><div align="right"><?php echo $sum;?></div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td class="bck"><div align="center"><?php echo $MatReqRequestedBy;?></div>          </td>
        <td>&nbsp;</td>
        <td class="bck"></td>
        <td>&nbsp;</td>
        <td class="bck"></td>
      </tr>
      <tr>
        <td class="style1"><div align="center">Requested By</div></td>
        <td>&nbsp;</td>
        <td class="style1"><div align="center">Checked By</div></td>
        <td>&nbsp;</td>
        <td class="style1"><div align="center">Authorized By</div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php

	$SQL = "select UserName,Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
	$result = $db->RunQuery($SQL);
	$senderEmail = "";
	$senderName ="";
	while($row = mysql_fetch_array($result))
	{
		$senderEmail = $row["UserName"];
		$senderName = $row["Name"];
	}
	include "EmailSender.php";
	$eml =  new EmailSender();

	$reciever =$_GET["email"];
	$subject = "New MRN -".$matreqno;
	$body = ob_get_clean();
	
	//////////////////////////
	require_once('pdfWriter.php');
	$pdfName="MRN ".$matreqno;
$pdf=new pdfWriter();
$pdf->convertToPdf($body,$pdfName);
	
	$filename=$pdfName.".pdf";
	$path="pdfRpt\\";
	$message="Please find the attachment with this.";
	$eml->mail_attachment($filename, $path, $reciever, $senderEmail, $senderName, $senderEmail, $subject, $message);
	//$eml->SendMessage($senderEmail,$senderName,$reciever,$subject,$body);
	echo "3";
	try{
	unlink("pdfRpt\\".$filename);
	unlink("htmlRpt\\".$pdfName.".html");
	}catch(Exception $e){}
?>