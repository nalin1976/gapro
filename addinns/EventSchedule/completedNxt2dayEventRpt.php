<?php
session_start();
$backwardseperator = "../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Critical Event Schedule Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 

include "../Connector.php";				
				
				$companyID =$_SESSION["FactoryID"];				
				$styleList = "";
				$styleID=$_GET["styleID"];
				$companyID = $_GET["companyID"];
				$buyer = $_GET["buyer"];
				$merchandiser = $_GET["merchandiser"];
				$sc = $_GET["sc"];
				
				 
					$sql = "SELECT DISTINCT ESH.strStyleId FROM eventscheduleheader ESH INNER JOIN orders O ON ESH.strStyleId = O.strStyleId 
					inner join eventscheduledetail ESD ON ESH.intScheduleId=ESD.intScheduleId
					WHERE O.intCompanyID = '$companyID' and ESD.dtmEstimateDate < CURDATE() AND ISNULL(ESD.dtCompleteDate) and O.intStatus in (0,10,11) order by O.strStyleId;";

					$result = $db->RunQuery($sql);
					while($row = mysql_fetch_array($result ))
					{
						$styleList .= "'" . $row["strStyleId"]  . "',";
					}
					
					$styleList .= "' '";
					
					if($styleID != '')
						$styleList = "'$styleID'";
		
				$SQL="SELECT orders.strStyleID, companies.strName, companies.strAddress1,companies.strTQBNO,
companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.strCountry, companies.strZipCode,companies.strRegNo, 
companies.strPhone, companies.strEMail, companies.strFax, companies.strWeb FROM companies 
INNER JOIN orders ON companies.intCompanyID = orders.intCompanyID 
WHERE orders.strStyleID IN ($styleList)";

	 
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result ))
				{
				
					$comName		= $row["strName"];
					$comAddress1	= $row["strAddress1"];
					$comAddress2	= $row["strAddress2"];
					$comStreet		= $row["strStreet"];
					$comCity		= $row["strCity"];
					$comCountry		= $row["strCountry"];
					$comZipCode		= $row["strZipCode"];
					$strPhone		= $row["strPhone"];
					$comEMail		= $row["strEMail"];
					$comFax			= $row["strFax"];
					$comWeb			= $row["strWeb"];
					$TQBNo			= $row["strTQBNO"];
					$VatRegNo		= $row["strRegNo"];
					 
				$strAddress1new = trim($comAddress1) == "" ? $comAddress1 : $comAddress1 ;
				$strAddress2new = trim($comAddress2) == "" ? $comAddress2 : "," . $comAddress2;
				$strStreetnew = trim($comStreet) == "" ? $comStreet : "," . $comStreet ;
				$strCitynew = trim($comCity) == "" ? $comCity : "," . $comCity;
				$strStatenew = trim($comState) == "" ? $comState : "," . $comState . "," ;
				}
				?>

<table width="800" border="0" align="center" cellpadding="0">
<tr>
    <td width="800" colspan="4"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
				<td width="6%" class="normalfnt">&nbsp;</td>
					<td width="74%" class="tophead"><p class="topheadBLACK"><?php echo $comName;?></p>
					<p class="normalfnt"><?php echo $strAddress1new.$strAddress2new.$strStreetnew.$strCitynew.$strStatenew.$comCountry."."."Tel:".$strPhone.",".$comZipCode." Fax: ".$comFax." E-Mail: ".$comEMail." Web: ".$comWeb;?></p>
					<p class="normalfnt">&nbsp;</p>
				<p class="normalfnt"></p>     			</td>
                </tr>
          </table>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><p class="head2BLCK"><br/>Events To Be Completed As At : <?php echo date('jS \of F Y',strtotime("+2 days")); ?> </p>
      <p class="head2BLCK"></p>
      <table width="100%" border="0" cellpadding="0" bgcolor="#FFFFFF">
        
        <tr>
          <td width="50%"></td>
          <td width="50%" valign="top"></td>
        </tr>
    </table>      </td>
  </tr>
 
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" bgcolor="#FFFFFF">
		<tr>
        <td width="7%" height="25">&nbsp;</td>
        <td width="12%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
			<td colspan="3" class="normalfntLeftTABNoBorder"><b>Event</b></td>
        <td width="14%" class="normalfntCenterTABNoBorder"><b>Expected Date</b></td>
        <td width="15%" class="normalfntCenterTABNoBorder"><b>Change Date</b></td>
        <td width="13%" class="normalfntCenterTABNoBorder"><b>Delay (Days)</b></td>
        </tr>
        <?php
        $sql = "SELECT eventscheduleheader.intScheduleId,eventscheduleheader.strStyleId,  DATE_FORMAT(eventscheduleheader.dtDeliveryDate, '%Y %b %d')  AS deliveryDate,
eventscheduleheader.strBuyerPONO, specification.intSRNO, useraccounts.Name AS merchandiser  
FROM eventscheduleheader 
INNER JOIN orders ON eventscheduleheader.strStyleId = orders.strStyleID 
LEFT JOIN specification ON eventscheduleheader.strStyleId = specification.strStyleID  AND specification.strStyleID = orders.strStyleID 
INNER JOIN useraccounts ON orders.intCoordinator = useraccounts.intUserID 
inner join buyers on buyers.intBuyerID = orders.intBuyerID
WHERE  eventscheduleheader.strStyleId IN ($styleList)";
		
		
		if($merchandiser != "")
			$sql .= " and orders.intCoordinator='$merchandiser'";
		
		 if ($buyer != "")
			$sql .= " and orders.intBuyerID='$buyer'";
			
		 if ($sc != "")
			$sql .= " and specification.intSRNO ='$sc'";
			
			
        $result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result ))
			{
				$checkRow = CheckRow($row["intScheduleId"]);
				 
				if($checkRow){
        ?>
        <tr>
			<td colspan="10"><hr></td>        
        </tr>
			<tr>
        <td height="25" colspan="2" class="normalfntLeftTABNoBorder"><b>Style ID : </b><?php echo $row["strStyleId"]; ?></td>
        <td  class="normalfntLeftTABNoBorder">&nbsp;</td>
        <td width="16%"  class="normalfntLeftTABNoBorder"><b>SC No</b> : <?php echo $row["intSRNO"]; ?></td>
        <td  colspan="3"  class="normalfntLeftTABNoBorder"><b>Buyer PO : </b><?php echo $row["strBuyerPONO"]; ?></td>
        <td colspan="3" class="normalfntLeftTABNoBorder"><b>Merchandiser : </b><?php echo $row["merchandiser"]; ?></td>
        </tr>
      <tr bgcolor="#CCCCCC">
         <td class="normalfntTAB" colspan="9">Date Of Delivery : <?php echo $row["deliveryDate"]; ?></td>
        </tr>
        <?php
        $scheduleID = $row["intScheduleId"];
        $isFirstRow = true;
        $sql = "SELECT eventscheduledetail.intEventId,
DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d') as EstimateDate,
DATE_FORMAT(eventscheduledetail.dtChangeDate, '%Y %b %d') as ChangeDate,
eventscheduledetail.strChangedReason,
DATEDIFF(CURDATE(),eventscheduledetail.dtmEstimateDate) AS diff,
DATEDIFF(CURDATE(),dtChangeDate) AS changediff, 
events.strDescription  
FROM eventscheduledetail INNER JOIN events ON  eventscheduledetail.intEventId = events.intEventID 
WHERE eventscheduledetail.intScheduleId = '$scheduleID' AND eventscheduledetail.dtmEstimateDate < CURDATE() AND ISNULL(eventscheduledetail.dtCompleteDate)";
        $resultevent = $db->RunQuery($sql);
      
			while($rowevent = mysql_fetch_array($resultevent))
			{
				if($rowevent["changediff"]==""){
					if (substr($rowevent["diff"],0,1)=='-')
						$prossDiffe =  substr($rowevent["diff"],1);
					else
						$prossDiffe = ($rowevent["diff"]*-1);
				}else{
					if (substr($rowevent["changediff"],0,1)=='-')
						$prossDiffe =  substr($rowevent["changediff"],1);
					else
						$prossDiffe = ($rowevent["changediff"]*-1);
				}
				
		if($isFirstRow)
		{
        ?>
       	 	<tr>
        		<td height="25" colspan="9" class="normalfntLeftTABNoBorder"><br>
        		 Events
        		<hr></td>
        	</tr>
        <?php
        $isFirstRow = false;
        }
		if($prossDiffe>0 && $prossDiffe<3){
        ?>
      <tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
			<td colspan="3" class="normalfntLeftTABNoBorder"><?php echo $rowevent["strDescription"]; ?></td>
        <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
        <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["ChangeDate"]; ?></td>
        <td class="normalfntCenterTABNoBorder"><?php echo $prossDiffe; ?></td>
        </tr>
        <?php  
			}      	
        	}  
			}     	
        }
        ?>
    </table></td>
  </tr>
  <tr>
    <td height="25" colspan="4" class="normalfnth2B">
        </span></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4">
	</td>
  </tr>  
  
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
<?php
function CheckRow($sheduleId)
{
global $db;
$CheckRow = false;
$sql_check = "SELECT eventscheduledetail.intEventId,
DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d') as EstimateDate,
DATE_FORMAT(eventscheduledetail.dtChangeDate, '%Y %b %d') as ChangeDate,
eventscheduledetail.strChangedReason,
DATEDIFF(CURDATE(),eventscheduledetail.dtmEstimateDate) AS diff,
DATEDIFF(CURDATE(),dtChangeDate) AS changediff, 
events.strDescription  
FROM eventscheduledetail INNER JOIN events ON  eventscheduledetail.intEventId = events.intEventID 
WHERE eventscheduledetail.intScheduleId = '$sheduleId' 
AND eventscheduledetail.dtmEstimateDate < CURDATE() AND ISNULL(eventscheduledetail.dtCompleteDate)";

$result_check=$db->RunQuery($sql_check);
while($row_check=mysql_fetch_array($result_check))
{
	//if($row_check["changediff"]=="")
	if(is_null($row_check["changediff"]))
	{
		if (substr($row_check["diff"],0,1)=='-')
			$diff =  substr($row_check["diff"],1);
		else
			$diff = ($row_check["diff"]*-1);
	}else{
		if (substr($row_check["changediff"],0,1)=='-')
			$diff =  substr($row_check["changediff"],1);
		else
			$diff = ($row_check["changediff"]*-1);
	}
	//echo $diff.'-'.$sheduleId."c";
	if($diff>0 && $diff<3)
	{
		$CheckRow = true;
		return $CheckRow;	
	}
		
}
return $CheckRow;
}
?>
</body>
</html>
