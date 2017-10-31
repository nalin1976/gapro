<?php
session_start();
include "../../Connector.php";
$xml 				= simplexml_load_file('../../config.xml');
$showAuthorizedBy 	= $xml->GeneralInventory->GeneralPO->ShowAuthorizedBy;
$backwardseperator 	= "../../";
$report_companyId  	= $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General MRN Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: small;
	font-weight: bold;
}
-->
</style>
</head>
<script type="text/javascript" >
var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function sendEmail(email)
{

	document.getElementById('progress').style.visibility = "visible";
	var year = <?php echo  $_GET["year"];?>;
	var mrnNo = <?php echo  $_GET["mrnNo"];?>;
	
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleEmail;
		xmlHttp.open("GET", 'mrnEmail.php?mrnNo=' + mrnNo + '&year=' + year + '&email=' + email, true);
		xmlHttp.send(null);
	
}

function HandleEmail()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		document.getElementById('progress').style.visibility = "hidden";
			if(xmlHttp.responseText.indexOf("123")>-1)
			{
					alert("The MRN has been emailed to the stores.");
			}
			else
			{
			alert("Error occur while sending email, please contact your system administrator.");
			}
		}
	}
}


</script>
<body>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>	  
        <!--<td width="20%"><img src="images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="37%" class="tophead"><p class="topheadBLACK">--><?php 
		$matreqno=$_GET["mrnNo"];
		$year=$_GET["year"];
		
		#=============================================================================
		# Comment On - 11/12/2013
		# Description - To add request department to the query
		#=============================================================================
		
		   /*$SQL_matre="select genmatrequisition.intMatRequisitionNo,genmatrequisition.dtmDate,genmatrequisition.intRequestedBy,(select useraccounts.Name from useraccounts where useraccounts.intUserID = genmatrequisition.intRequestedBy) as requested,genmatrequisition.intStatus from genmatrequisition where genmatrequisition.intMatRequisitionNo ='$matreqno' and genmatrequisition.intMRNYear=$year;";*/		   
		#======================== END ================================================
		
		#=============================================================================
		# Comment On - 01/06/2014
		# Description - To show confirmed by User to the report
		#=============================================================================
		   		
		/*$SQL_matre= " select genmatrequisition.intMatRequisitionNo,genmatrequisition.dtmDate,genmatrequisition.intRequestedBy,(select useraccounts.Name from useraccounts where useraccounts.intUserID = genmatrequisition.intRequestedBy) as requested, (select department.strDepartment from department where department.intDepID =  genmatrequisition.strDepartmentCode) as ReqDep, genmatrequisition.intStatus from genmatrequisition where genmatrequisition.intMatRequisitionNo ='$matreqno' and genmatrequisition.intMRNYear=$year;";*/
		#======================== END ================================================
		
		
		
		$SQL_matre = "select genmatrequisition.intMatRequisitionNo,genmatrequisition.dtmDate,genmatrequisition.intRequestedBy,(select useraccounts.Name from useraccounts where useraccounts.intUserID = genmatrequisition.intRequestedBy) as requested, (select department.strDepartment from department where department.intDepID =  genmatrequisition.strDepartmentCode) as ReqDep, genmatrequisition.intStatus, genmatrequisition.intConfirmedBy, (select useraccounts.Name from useraccounts where useraccounts.intUserID = genmatrequisition.intConfirmedBy) as ConfirmedBy from genmatrequisition where genmatrequisition.intMatRequisitionNo ='$matreqno' and genmatrequisition.intMRNYear=$year;";

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
		$MatConfirmedBy = $row["ConfirmedBy"];
		$Status = $row["intStatus"];
		$RequestDepartment = $row['ReqDep'];
		}
		
		/*$sql="SELECT intCompanyID FROM genmatrequisition where intMRNYear='$year' and intMatRequisitionNo='$matreqno';";
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{	
			$companyID=$row["intCompanyID"];
			
		}
		$key="mrnEmail".$companyID;
		$sql="SELECT strValue FROM settings where strKey='$key';";
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{	
			$email=$row["strValue"];
			
		}*/
		
		 ?><!--</td>-->
		 
        <td width="100%" height="18"><?php include '../../reportHeader.php'?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td width="83%" height="38" class="head2BLCK">MATERIAL REQUISITION NOTE</td>
        <td width="17%">QAP-18-C</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="1%" class="normalfnt2bldBLACK">&nbsp;</td>
        <td width="17%" class="normalfnt2bldBLACK">MRN No</td>
        <td width="49%" class="normalfnt">:<?php echo $year.'/'.$MatRequisitionNo;?></td>
        <td width="10%" class="normalfnt"><span class="normalfnt2bldBLACK">MRN Date</span></td>
        <td width="23%" class="normalfnt">: <?php echo $MatRequisitionDateNewDate."/".$MatRequisitionDateNewmonth."/".$MatRequisitionDateNewYear;?></td>
      </tr>      
      <tr>
        <td width="1%" class="normalfnt2bldBLACK">&nbsp;</td>
        <td width="17%" class="normalfnt2bldBLACK">Request Department</td>
        <td width="49%" class="normalfnt">:<?php echo $RequestDepartment; ?></td>
        <td width="10%" class="normalfnt">&nbsp;</td>
        <td width="23%" class="normalfnt">&nbsp;</td>
      </tr>
      <tr><td>&nbsp;</td></tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="0" class="tablez">
        <tr> 
          <td width="95" class="normalfntBtab">&nbsp;Item Code</td>	
          <td width="439" class="normalfntBtab" height="25">Item Description</td>
          <td width="191" class="normalfntBtab">Note</td>
          <td width="59" class="normalfntBtab">Req Qty</td>
        </tr>
		<?php
		$sum = 0;
			$sql = "select  DISTINCT genmatmaincategory.intID, genmatmaincategory.strDescription from genmatrequisitiondetails,genmatitemlist,genmatmaincategory  where genmatrequisitiondetails.intMatRequisitionNo = $matreqno AND genmatrequisitiondetails.strMatDetailID = genmatitemlist.intItemSerial AND genmatitemlist.intMainCatID = genmatmaincategory.intID";
			$mainresult = $db->RunQuery($sql);
			while($row = mysql_fetch_array($mainresult))
			{	
		?>
		
        <tr> 
          <td colspan="5" class="normalfntTAB"><b><?php echo  $row["strDescription"];?></b></td>
        </tr>
		<?php
		
		$CatID = $row["intID"];
		$sql = "select 
				GMIL.strItemDescription,
				GMRD.dblQty,
				GMRD.strNotes,
				GMIL.strItemCode
				from genmatrequisitiondetails GMRD,
				genmatitemlist GMIL 
				where GMRD.intMatRequisitionNo = $matreqno AND GMRD.intYear='$year'
				AND GMRD.strMatDetailID = GMIL.intItemSerial AND GMIL.intMainCatID = $CatID";
		$subresult = $db->RunQuery($sql);
			while($row = mysql_fetch_array($subresult))
			{
			$qty= $row["dblQty"]; 
			$sum += $qty;
		?>
        <tr> 
          <td class="normalfntTAB">&nbsp;&nbsp;<?php echo  $row["strItemCode"]; ?></td>
          <td class="normalfntTAB">&nbsp;&nbsp;<?php echo  $row["strItemDescription"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strNotes"]; ?></td>
          <td class="normalfntRiteTAB"><?php echo  number_format($row["dblQty"],3); ?></td>
        </tr>
		<?php
			}
		}
		
		?>

        <tr> 
          <td class="normalfntTAB">&nbsp;</td>
          <td class="normalfntTAB"><b>Total</b></td>
          <td class="normalfntTAB">&nbsp;</td>
		  <td class="normalfntRiteTAB"><b><?php echo number_format($sum,3);?></b></td>
        </tr>
      </table>
      
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td class="bcgl1txt1"><?php echo $MatReqRequestedBy;?></td>
        <td>&nbsp;</td>
        <td class="bcgl1txt1"></td>
        <td>&nbsp;</td>
        <td class="bcgl1txt1"><?php echo $MatConfirmedBy; ?></td>
      </tr>
      <tr>
        <td class="normalfnth2Bm">Requested By</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">Checked By</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">Authorized By</td>
      </tr>
    </table></td>
  </tr>
</table>
<!--<div style="left:314px; top:156px; z-index:30; position:absolute; width: 229px; visibility:hidden; height: 54px; background-color: #FFFF00; layer-background-color: #FFFF00; border: 1px none #000000;" id="progress">
  <table width="213" height="55" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><input type="image" name="imageField" src="images/loading.gif" /></td>
          </tr>
  </table>-->
		
		
</div>
</body>
</html>
<?php 
if($Status==10)
{
	echo "<div style=\"position:absolute;top:120px;left:400px;\"><img src=\"../../images/cancelled.png\" style=\"-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);\" /></div>";
}
else if($Status==0)
{
	echo "<div style=\"position:absolute;top:60px;left:300px;\"><img src=\"../../images/pending.png\"/></div>";
}
?>
