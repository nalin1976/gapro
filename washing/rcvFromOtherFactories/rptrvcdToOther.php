<?php
	session_start();
	include "../../Connector.php";	
	$inputSerialNumber=$_GET["req"];
	$inputSerialNumber=split('/',$inputSerialNumber);
	//$year=$_GET["intYear"];
	$backwardseperator 	= "../../";	
	$userId	= $_GET["UserId"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>Gatepass Transfer In Note Report</title>
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
</style>
</head>

<body>

<table width="850" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php 
				
				$str_header="SELECT 
					was_rcvdfromfactory.intCompanyId 
					FROM was_rcvdfromfactory 
					WHERE
					was_rcvdfromfactory.dblSerial = '$inputSerialNumber[1]' AND
					was_rcvdfromfactory.intYear='$inputSerialNumber[0]'
					GROUP BY was_rcvdfromfactory.dblSerial";
	  //echo $str_header;
	  
	  $results_header=$db->RunQuery($str_header);
	  $row=mysql_fetch_array($results_header);
				$report_companyId  = $row["intCompanyId"];
				
				include_once("../../reportHeader.php");?>
                
                </td>

              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">Gatepass Transfer In</td>
  </tr>
  
  <tr>
    <td colspan="5" style="text-align:center">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td height="15">&nbsp;</td>
        <td width="1%">&nbsp;</td>
        <td width="39%">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
<?php
	  $str_header="SELECT
					orders.strOrderNo,
					orders.strStyle,
					orders.intStyleId,
					was_rcvdfromfactory.dtmDate,
					was_rcvdfromfactory.strColor,
					was_rcvdfromfactory.dblQty,
					concat(was_rcvdfromfactory.intGPYear,'/',was_rcvdfromfactory.dblGPNo) AS GP,
					was_rcvdfromfactory.dblSerial,
					companies.strName,
					was_rcvdfromfactory.strRemarks,
					was_rcvdfromfactory.intFromFactory,
					was_rcvdfromfactory.intUser,
					was_washformula.strProcessName
					FROM
					orders
					INNER JOIN was_rcvdfromfactory ON was_rcvdfromfactory.intStyleId = orders.intStyleId
					INNER JOIN companies ON was_rcvdfromfactory.intFromFactory = companies.intCompanyID
					left JOIN was_washformula ON was_rcvdfromfactory.intReason = was_washformula.intSerialNo
					WHERE
					was_rcvdfromfactory.dblSerial = '$inputSerialNumber[1]' AND
					was_rcvdfromfactory.intYear='$inputSerialNumber[0]'
					GROUP BY was_rcvdfromfactory.dblSerial";
	  //echo $str_header;
	  
	  $results_header=$db->RunQuery($str_header);
	  $row=mysql_fetch_array($results_header);
?>
      <tr>
        <td width="12%" align="left">&nbsp;&nbsp;<strong>Factory </strong> </td>
        <td align="left">:</td>
        <td align="left"><?php echo $row["strName"]; ?></td>
        <td width="12%" align="left"><strong>Gate Pass No </strong></td>
        <td width="1%" align="left">:</td>
        <td width="35%" align="left"><?php echo $row["GP"]; ?></td>
        </tr>
      <tr >
        <td width="12%" height="20" align="left">&nbsp;&nbsp;<strong>Serial </strong></td>
        <td align="left">:</td>
        <td align="left"><?php echo $_GET["req"];?></td>
        <td width="12%" align="left"><strong>Date</strong></td>
        <td align="left">:</td>
        <td align="left"><?php echo $row["dtmDate"]; ?></td>
        </tr>
      <tr>
        <td><strong>&nbsp;&nbsp;Reason </strong></td>
        <td>:</td>
        <td colspan="4"><?php echo $row["strProcessName"];?></td>
        </tr>
    </table></td>
  </tr>
  
   <tr>
    <td>
    <table width="100%"  border="1"rules="all">
    	<tr>
        	<!--<td width="15%" class="border-top-bottom-left-fntsize12" height="25"><div align="center"><strong>Serial </strong></div></td>-->
        	<td width="20%" class="border-top-bottom-left-fntsize12" height="25"><div align="center"><strong>PO No. </strong></div></td>
             <td width="19%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Style No</strong></div></td>
             <td width="21%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Color</strong></div></td>
             <td width="30%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Division</strong></div></td>
             <td width="10%" class="border-All-fntsize12"><div align="center"><strong>Quantity</strong></div></td>
        </tr>
 		 <tr>
         	<!--<td width="15%" class="normalfnt" height="25">&nbsp;<?php echo $row["strOrderNo"]; ?></td>-->
        	<td width="20%" class="normalfnt" height="25">&nbsp;<?php echo $row["strOrderNo"]; ?></td>
            <td width="19%" class="normalfnt">&nbsp;<?php echo $row["strStyle"]; ?></td>
            <td width="21%" class="normalfnt">&nbsp;<?php echo $row["strColor"]; ?></td>
            <td width="30%" class="normalfnt">&nbsp;<?php echo  GetDivision($row["intStyleId"]); ?></td>
            <td width="10%" class="normalfntR"><?php echo $row["dblQty"]; ?>&nbsp;</td>

        </tr>
      
    </table>
    <table width="100%">
    	  <tr>
         	<!--<td width="15%" class="normalfnt" height="25">&nbsp;<?php echo $row["strOrderNo"]; ?></td>-->
        	<td width="3%" class="normalfnt" height="25"></td>
            <td width="4%" class="normalfnt"></td>
            <td width="13%" class="normalfnt"></td>
            <td width="36%" class="normalfnt"></td>
            <td colspan="4%" class="normalfnt"></td>
            <td width="8%" class="normalfntR"></td>

        </tr>
        <tr>
         	<!--<td width="15%" class="normalfnt" height="25">&nbsp;<?php echo $row["strOrderNo"]; ?></td>-->
        	<td width="3%" class="normalfnt" height="25"></td>
            <td width="4%" class="normalfnt"></td>
            <td width="13%" class="normalfntMid" style="border-bottom:dotted #000 1px;"><?php echo getUser($row['intUser']);?></td>
            <td width="36%" class="normalfnt"></td>
            <td colspan="4%" class="normalfnt"></td>
            <td width="8%" class="normalfntR"></td>

        </tr>
        <tr>
         	<!--<td width="15%" class="normalfnt" height="25">&nbsp;<?php echo $row["strOrderNo"]; ?></td>-->
        	<td width="3%" class="normalfnt" height="25"></td>
            <td width="4%" class="normalfnt"></td>
            <td width="13%" class="normalfntMid">Received by</td>
            <td width="36%" class="normalfnt"></td>
            <td colspan="4%" class="normalfnt"></td>
            <td width="8%" class="normalfntR"></td>

        </tr>
    </table>
    </td>
  </tr>
  </table>
  <?php
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

function getUser($id){
global $db;
$sql="select ur.Name from useraccounts ur where ur.intUserID='$id'";
$res=$db->RunQuery($sql);
$row=mysql_fetch_array($res);
return $row['Name'];
	
}?>
</body>
</html>
