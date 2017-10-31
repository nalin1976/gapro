<?php
	session_start();
	include "../../Connector.php";	
	$backwardseperator 	= "../../";	
	


$serial 	= $_GET["req"];
$serialn = explode('/',$serial);


	$str_header="SELECT wf.intYear,wf.dblGPNo,wf.dtmDate,wf.strColor,wf.intStyleId,wf.intSFactory,wf.intToFactory,wf.strVehicleNo,wf.intCompanyId,orders.strOrderNo,	orders.strStyle,wf.strRemarks,wf.dblQty,wf.intUser,was_washformula.strProcessName,wf.intStatus,wf.inrConfirmedBy
	FROM
	was_issuedtootherfactory AS wf
	INNER JOIN orders ON wf.intStyleId = orders.intStyleId
	LEFT JOIN was_washformula ON wf.intReason = was_washformula.intSerialNo
	WHERE
	wf.intYear AND wf.dblGPNo='".$serialn[1]."' and wf.intYear='".$serialn[0]."';";

$res=$db->RunQuery($str_header);
$row=mysql_fetch_array($res);

	$userId	= $row['intUser'];
	$report_companyId  = $row["intCompanyId"];
	$status= $row['intStatus'];
	$Confirm=$row['inrConfirmedBy'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>Gate Pass</title>
<style type="text/css">
.tophead1  {
color:#000000;
font-family:"Century Gothic";
font-size:24px;
line-height:24px;
font-weight:normal;
margin:0;
}
.tophead2  {
color:#000000;
font-family:"Century Gothic";
line-height:22px;
font-size:20px;
font-weight:normal;
margin:0;
}
.tophead3  {
color:#000000;
font-family:"Century Gothic";
line-height:18px;
font-size:16px;
font-weight:bold;
margin:0;
}
.reportBottom{
border-top:dotted;
border-width:1px;
font-family:Arial;
font-size:12px;
text-align:center;

}
</style>
</head>

<body>
<?php
$sqlf="select CO.strName,CO.strAddress1,CO.strAddress2,CO.strStreet,CO.strCity,C.strCountry,CO.strZipCode,CO.strPhone,CO.strFax from companies CO
inner join country C on CO.intCountry=C.intConID where CO.intCompanyID='".$row['intCompanyId']."';";
$resultf=$db->RunQuery($sqlf);
while($rowf=mysql_fetch_array($resultf))
{
	$f_name = $rowf["strName"];
	$f_name .= ($rowf["strAddress1"]=='' ? '':'<br/>'.$rowf["strAddress1"]);
	$f_name .= ($rowf["strAddress2"]=='' ? '':'<br/>'.$rowf["strAddress2"]);
	$f_name .= ($rowf["strStreet"]=='' ? '':'<br/>'.$rowf["strStreet"]);
	$f_name .= ($rowf["strCity"]=='' ? '':'<br/>'.$rowf["strCity"]);
	$f_name .= ($rowf["strCountry"]=='' ? '':'<br/>'.$rowf["strCountry"]);
	$f_name .= ($rowf["strPhone"]=='' ? '':'<br/>TEL : '.$rowf["strPhone"]);
	$f_name .= ($rowf["strFax"]=='' ? '':'<br/>FAX : '.$rowf["strFax"]);
	$from_city	= $rowf["strCity"];
}

$sqlt="select CO.strName,CO.strAddress1,CO.strAddress2,CO.strStreet,CO.strCity,C.strCountry,CO.strZipCode,CO.strPhone,CO.strFax from companies CO
inner join country C on CO.intCountry=C.intConID where CO.intCompanyID='".$row['intToFactory']."';";
$resultt=$db->RunQuery($sqlt);
while($rowt=mysql_fetch_array($resultt))
{
	$t_name  = $rowt["strName"];
	$t_name .= ($rowt["strAddress1"]=='' ? '':'<br/>'.$rowt["strAddress1"]);
	$t_name .= ($rowt["strAddress2"]=='' ? '':'<br/>'.$rowt["strAddress2"]);
	$t_name .= ($rowt["strStreet"]=='' ? '':'<br/>'.$rowt["strStreet"]);
	$t_name .= ($rowt["strCity"]=='' ? '':'<br/>'.$rowt["strCity"]);
	$t_name .= ($rowt["strCountry"]=='' ? '':'<br/>'.$rowt["strCountry"]);
	$t_name .= ($rowt["strPhone"]=='' ? '':'<br/>TEL : '.$rowt["strPhone"]);
	$t_name .= ($rowt["strFax"]=='' ? '':'<br/>FAX : '.$rowt["strFax"]);
	
	
}
if($status==10){
	echo "<div style=\"position:absolute;top:200px;left:320px;\">
            	<img src=\"../../images/cancelled.png\">
           		 </div>";
}
if($status==0){
echo "<div style=\"position:absolute;top:200px;left:320px;\">
            	<img src=\"../../images/pending.png\">
           		 </div>"; 	
}
?>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
    <td colspan="3" class="head2" >ORIT APPARELS LANKA (PVT)LTD.</td>
  </tr>
  <tr>
    <td colspan="3" class="tophead3"><div align="center" >GATE PASS -(Lot/Bulk Wise)</div></td>
  </tr>
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="200" height="40" class="border-All-fntsize12" nowrap="nowrap"><strong>&nbsp;Wash Ready - <?php echo getWashReadyComapny($row['intSFactory']);?></strong></td>
    <td width="401" ></td>
    <td width="200" class="border-All-fntsize12" nowrap="nowrap"><strong>&nbsp;GatePass No : <?php echo $serial ?></strong></td>
  </tr>
   <tr>
     <td height="10" colspan="3" >&nbsp;</td>
   </tr>
   <tr>
    <td height="10" colspan="3" class="border-top">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td width="12%" valign="top">&nbsp;&nbsp;<strong>Deliver From </strong> </td>
        <td width="1%" valign="top">:</td>
        <td width="37%" rowspan="3" valign="top"><?php echo $f_name;?></td>
        <td width="12%" valign="top"><strong>Deliver To</strong></td>
        <td width="1%" valign="top">:</td>
        <td width="37%" rowspan="3" valign="top"><?php echo $t_name;?></td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td><strong>&nbsp; Vehicle No</strong></td>
        <td>:</td>
        <td><?php echo $row['strVehicleNo'];?> </td>
        <td><strong>GatePass Date</strong></td>
        <td>:</td>
        <td class="normalfnt"> <?php echo $row['dtmDate'];?> </td>
      </tr>
      
      <tr>
        <td><strong>&nbsp; Reason</strong></td>
        <td>:</td>
        <td><?php echo $row['strProcessName'];?> </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
	  
	  <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
   <tr>
     	<td colspan="3">
         <table width="100%" border="1" cellspacing="0" cellpadding="0" rules="all">
           <tr>
             <td width="15%" class="border-top-bottom-left-fntsize12" height="25"><div align="center"><strong>PO No. </strong></div></td>
             <td width="15%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Style No</strong></div></td>
             <td width="11%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Color</strong></div></td>
             <td width="14%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Division</strong></div></td>
             <td colspan="4" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Description of Articles </strong></div></td>
             <td width="8%" class="border-All-fntsize12"><div align="center"><strong>Quantity</strong></div></td>
     		</tr>
            <tr>
             <td  class="normalfnt" height="25"><div align="center"><?php echo $row['strOrderNo'];?></div></td>
             <td  class="normalfnt"><div align="center"><?php echo $row['strStyle'];?></div></td>
             <td  class="normalfnt"><div align="center"><?php echo $row['strColor'];?></div></td>
             <td  class="normalfnt"><div align="center"><?php echo GetDivision($row['intStyleId']);?></div></td>
             <td  colspan="4" class="normalfnt"><div align="left"><?php echo $row['strRemarks'];?></div></td>
             <td  class="normalfnt"><div align="center"><?php echo $row['dblQty'];?></div></td>
           </tr>
		  </table>
          </td>
     </tr>
      <tr>  
          <td colspan="3">&nbsp;</td>
      </tr>
     <tr>  
          <td colspan="3">
            <table width="100%" border="0" cellpadding="0" cellspacing="1">
              <tr height="10"></tr>
              <tr>
                <td width="25%" class="normalfntMid"><?php echo getUser($userId);?></td>
                <td width="25%" class="normalfntMid"><?php echo getUser($Confirm);?></td>
                <td width="25%" class="normalfntMid">&nbsp;</td>
                <td width="25%" class="normalfntMid">&nbsp;</td>
              </tr>
              <tr>
                <td class="reportBottom">Prepared by</td>
                <td class="reportBottom">Authorized By</td>
                <td class="reportBottom">Delivered By</td>
                <td class="reportBottom">Signature</td>
              </tr>
              <tr>
                <td width="25%" class="normalfntMid" height="25"><?php echo $row['dtmDate'];?></td>
                <td width="25%" class="normalfntMid">&nbsp;</td>
                <td width="25%" class="normalfntMid">&nbsp;</td>
                <td width="25%" class="normalfntMid">&nbsp;</td>
              </tr>
              <tr>
                <td class="reportBottom">Date</td>
                <td class="reportBottom">Time Out</td>
                <td class="reportBottom">Time In</td>
                <td class="reportBottom">Signature Security</td>
              </tr>
              <tr>
                <td class="normalfntMid" height="25">&nbsp;</td>
                <td class="normalfntMid">&nbsp;</td>
                <td class="normalfntMid"><?php echo $row['strVehicleNo'];?></td>
                <td class="normalfntMid">&nbsp;</td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td class="reportBottom">No Of Packages </td>
                <td class="reportBottom">Vehical No </td>
                <td >&nbsp;</td>
              </tr>       
        </table>
           </td>
  </tr>
          </table>
    	</td>
    </tr>
</table>
</body>
</html>
<?php
function getWashReadyComapny($ComId)
{
global $db;
	$sql="select c.strCity from companies c where c.intCompanyID='$ComId'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strCity"];

}
function GetDivision($styleId)
{
global $db;
	$sql="select distinct BD.strDivision from orders O inner join buyerdivisions BD on BD.intDivisionId=O.intDivisionId where O.intStyleId='$styleId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strDivision"];
	}
}

function getUser($uId){
	global $db;
	$sql="SELECT useraccounts.Name FROM useraccounts WHERE useraccounts.intUserID='$uId'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["Name"];
}

?>