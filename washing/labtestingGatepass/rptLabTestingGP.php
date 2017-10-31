<?php
	session_start();
	include "../../Connector.php";	
	$backwardseperator 	= "../../";	
	


$serial 	= $_GET["req"];
//$serialn = explode('/',$serial);


   $str_header="SELECT DISTINCT
				concat(was_labtestinggp.intLabGPYear,'/',was_labtestinggp.dblLabGPNo) AS GP,
				was_labtestinggp.strColor,
				was_labtestinggp.strVehicalNo,
				orders.strOrderNo,
				orders.strStyle,
				was_labtestinggp.dblQty,
				was_labtestinggp.strRemarks,
				useraccounts.`Name`,
				was_labtestinggp.intToFac,
				was_labtestinggp.intFromFac as intCompanyId,
				was_labtestinggp.dtmDate
				FROM
				was_labtestinggp
				INNER JOIN orders ON was_labtestinggp.intStyleNo = orders.intStyleId
				INNER JOIN useraccounts ON useraccounts.intUserID = was_labtestinggp.intUserId
				WHERE
				concat(was_labtestinggp.intLabGPYear,'/',was_labtestinggp.dblLabGPNo)= '$serial';";

$res=$db->RunQuery($str_header);
$row=mysql_fetch_array($res);
	$userId	= $row['intUser'];
	$report_companyId  = $row['intCompanyId'];
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
	$com=$f_name;
	$f_name .= ($rowf["strAddress2"]=='' ? '':'<br/>'.$rowf["strAddress2"]);
	$f_name .= ($rowf["strStreet"]=='' ? '':'<br/>'.$rowf["strStreet"]);
	$f_name .= ($rowf["strCity"]=='' ? '':'<br/>'.$rowf["strCity"]);
	$f_name .= ($rowf["strCountry"]=='' ? '':'<br/>'.$rowf["strCountry"]);
	$c = ($rowf["strCountry"]=='' ? '':'<br/>'.$rowf["strCountry"]);
	$f_name .= ($rowf["strPhone"]=='' ? '':'<br/>TEL : '.$rowf["strPhone"]);
	$f_name .= ($rowf["strFax"]=='' ? '':'<br/>FAX : '.$rowf["strFax"]);
	$from_city	= $rowf["strCity"];
}

$sqlt="SELECT CO.strName,CO.strAddress1,CO.strStreet,CO.strCity,C.strCountry,CO.strPhone,CO.strFax from was_outside_companies CO inner join country C on CO.intCountry=C.intConID where CO.intCompanyID='".$row['intToFac']."';";

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

?>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
    <td colspan="5" class="head2" ><!--ORIT APPARELS LANKA (PVT)LTD --><?php echo strtoupper($com).$c;?></td>
  </tr>
 <!-- <tr>
    <td colspan="5" class="tophead3"><div align="center" >GATE PASS </div></td>
  </tr>-->
   <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="142" height="40" class="border-All-fntsize12" nowrap="nowrap"><strong>&nbsp;WASHING STORES</strong></td>
    <td width="110" ><strong>&nbsp;</strong></td>
    <td width="218" class="border-All-fntsize12" nowrap="nowrap" style="text-align:center;"><strong>&nbsp;ADVICE OF DESPATCH-(Lab Testing)</strong></td>
    <td width="110" ><strong>&nbsp;</strong></td>
    <td width="220" class="border-All-fntsize12" nowrap="nowrap"><strong>&nbsp;GatePass No : <?php echo $serial ?></strong></td>
  </tr>
   <tr>
     <td height="10" colspan="5" >&nbsp;</td>
   </tr>
   <tr>
    <td height="10" colspan="5" class="border-top">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="5">
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
        <td><?php echo $row['strVehicalNo'];?> </td>
        <td><strong>GatePass Date</strong></td>
        <td>:</td>
        <td class="normalfnt"> <?php echo substr($row['dtmDate'],0,10);?> </td>
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
     	<td colspan="5">
         <table width="100%" border="1" cellspacing="0" cellpadding="0" rules="all">
           <tr>
             <td width="15%" class="border-top-bottom-left-fntsize12" height="25"><div align="center"><strong>PO No. </strong></div></td>
             <td width="15%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Style No</strong></div></td>
             <td width="11%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Color</strong></div></td>
             <td colspan="4" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Description of Articles </strong></div></td>
             <td width="14%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>No. of Packages</strong></div></td>            
             <td width="8%" class="border-All-fntsize12"><div align="center"><strong>Quantity</strong></div></td>
     		</tr>
            <tr>
             <td width="10%" class="normalfnt" height="25"><div align="left"><?php echo $row['strOrderNo'];?></div></td>
             <td width="10%" class="normalfnt"><div align="left"><?php echo $row['strStyle'];?></div></td>
             <td width="21%" class="normalfnt"><div align="left"><?php echo $row['strColor'];?></div></td>
             <td colspan="4" class="normalfnt"><div align="left"><?php echo $row['strRemarks'];?></div></td>
             <td width="14%" class="normalfnt"><div align="left"><?php echo GetDivision($row['intStyleId']);?></div></td>            
             <td width="8%" class="normalfnt"><div align="right"><?php echo $row['dblQty'];?></div></td>
           </tr>
		  </table>
          </td>
     </tr>
      <tr>  
          <td colspan="5">&nbsp;</td>
      </tr>
     <tr>  
          <td colspan="5">
            <table width="100%" border="0" cellpadding="0" cellspacing="1">
              <tr height="10"></tr>
              <tr>
                <td width="25%" class="normalfntMid"><?php echo $row['Name'];?></td>
                <td width="25%" class="normalfntMid">&nbsp;</td>
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
                <td width="25%" class="normalfntMid" height="25"><?php echo substr($row['dtmDate'],0,10);?></td>
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
                <td class="normalfntMid"><?php echo $row['strVehicalNo'];?></td>
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

/*function getUser($uId){
	global $db;
	$sql="SELECT useraccounts.Name FROM useraccounts WHERE useraccounts.intUserID='$uId'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["Name"];
}*/

?>