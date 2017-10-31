<?php
session_start();
$backwardseperator = "../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Completed Events Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 

include "../Connector.php";

				
				$styleID=$_GET["styleID"];
				$companyID = $_GET["companyID"];
				//$styleID="LN3684-CC922078";
				$styleList = "";

				if ($styleID == "")
				{
					$sql = "SELECT DISTINCT eventscheduleheader.intStyleId FROM eventscheduleheader INNER JOIN orders ON eventscheduleheader.intStyleId = orders.intStyleId WHERE 
orders.intCompanyID = '$companyID';";

					$result = $db->RunQuery($sql);
					while($row = mysql_fetch_array($result ))
					{
						$styleList .= "'" . $row["intStyleId"]  . "',";
					}
					$styleList .= "' '";
				}
				else
				{
					$styleList = "'$styleID'";
				}
				
				$SQL="SELECT orders.intStyleId, companies.strName, companies.strAddress1,companies.strTQBNO,
companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.strCountry, companies.strZipCode,companies.strRegNo, 
companies.strPhone, companies.strEMail, companies.strFax, companies.strWeb FROM companies 
INNER JOIN orders ON companies.intCompanyID = orders.intCompanyID 
WHERE orders.intStyleId IN ($styleList);";

	 
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result ))
				{
				
					$comName=$row["strName"];
					$comAddress1=$row["strAddress1"];
					$comAddress2=$row["strAddress2"];
					$comStreet=$row["strStreet"];
					$comCity=$row["strCity"];
					$comCountry=$row["strCountry"];
					$comZipCode=$row["strZipCode"];
					$strPhone=$row["strPhone"];
					$comEMail=$row["strEMail"];
					$comFax=$row["strFax"];
					$comWeb=$row["strWeb"];
					$TQBNo=$row["strTQBNO"];
					$VatRegNo=$row["strRegNo"];
					
				$strAddress1new = trim($comAddress1) == "" ? $comAddress1 : $comAddress1 ;
				$strAddress2new = trim($comAddress2) == "" ? $comAddress2 : "," . $comAddress2;
				$strStreetnew = trim($comStreet) == "" ? $comStreet : "," . $comStreet ;
				$strCitynew = trim($comCity) == "" ? $comCity : "," . $comCity;
				$strStatenew = trim($comState) == "" ? $comState : "," . $comState . "," ;
				}
				?>

<table width="800" border="0" align="center" cellpadding="0">
<tr>
    <td width="960" colspan="4"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%"><img src="../images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
				<td width="6%" class="normalfnt">&nbsp;</td>
					<td width="74%" class="tophead"><p class="topheadBLACK"><?php echo $comName;?></p>
					<p class="normalfnt"><?php echo $strAddress1new.$strAddress2new.$strStreetnew.$strCitynew.$strStatenew.$comCountry."."."Tel:".$strPhone.",".$comZipCode." Fax: ".$comFax." E-Mail: ".$comEMail." Web: ".$comWeb;?></p>
				<p class="normalfnt"></p>     			</td>
                </tr>
          </table>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><p class="head2BLCK"><br/>Time And Action Plan - Completed Events </p>
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

			<td height="25" colspan="3" class="normalfntLeftTABNoBorder"><b>&nbsp;Event</b></td>
        <td colspan="2" class="normalfntCenterTABNoBorder"><b>Expected Date</b></td>
        <td colspan="2" class="normalfntCenterTABNoBorder"><b>Completed Date</b></td>
			<td colspan="2" class="normalfntCenterTABNoBorder"><b>Completed By</b></td>
        <td colspan="2" class="normalfntCenterTABNoBorder"><b>Remarks</b></td>
        </tr>
        <tr>
			<td colspan="11"><hr></td>        
        </tr>
        <?php
        $sql = "SELECT eventscheduleheader.intScheduleId,eventscheduleheader.intStyleId,  DATE_FORMAT(eventscheduleheader.dtDeliveryDate, '%Y %b %d')  AS deliveryDate, eventscheduleheader.strBuyerPONO, specification.intSRNO, useraccounts.Name AS merchandiser  
FROM eventscheduleheader 
INNER JOIN orders ON eventscheduleheader.intStyleId = orders.intStyleId 
LEFT JOIN specification ON eventscheduleheader.intStyleId = specification.intStyleId  AND specification.intStyleId = orders.intStyleId 
INNER JOIN useraccounts ON orders.intCoordinator = useraccounts.intUserID 
WHERE  eventscheduleheader.intStyleId IN ($styleList) AND NOT ISNULL((SELECT eventscheduledetail.intScheduleId FROM eventscheduledetail WHERE eventscheduledetail.intScheduleId = eventscheduleheader.intScheduleId AND NOT ISNULL(eventscheduledetail.dtCompleteDate) LIMIT 1) );";
        $result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result ))
			{
        ?>
			<tr>
        <td height="25" colspan="2" class="normalfntLeftTABNoBorder"><b>Style ID : </b><?php echo $row["intStyleId"]; ?></td>
			<td colspan="3"  class="normalfntLeftTABNoBorder"><b>Delivery Date : </b><?php echo $row["deliveryDate"]; ?></td>        
        <td colspan="2"  class="normalfntLeftTABNoBorder"><b>SC No : </b><?php echo $row["intSRNO"]; ?></td>
        <td colspan="2"  class="normalfntLeftTABNoBorder"><b>Buyer PO : </b><?php echo $row["strBuyerPONO"]; ?></td>
        <td colspan="3" class="normalfntLeftTABNoBorder"><b>Merchandiser : </b><?php echo $row["merchandiser"]; ?></td>
        </tr>
         <tr>
			<td colspan="11"><hr></td>        
        </tr>
        <?php
        $scheduleID = $row["intScheduleId"];
        $isFirstRow = true;
        $sql = "SELECT eventscheduledetail.intEventId,  DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d') as EstimateDate,eventscheduledetail.dtChangeDate, DATE_FORMAT(eventscheduledetail.dtCompleteDate, '%Y %b %d') as completedDate, events.strDescription, eventscheduledetail.strRemarks, useraccounts.name as completedBy  
FROM eventscheduledetail INNER JOIN events ON  eventscheduledetail.intEventId = events.intEventID 
inner join useraccounts on eventscheduledetail.intCompletedBy = useraccounts.intUserID
WHERE eventscheduledetail.intScheduleId = '$scheduleID' AND  NOT ISNULL(eventscheduledetail.dtCompleteDate)";
        $resultevent = $db->RunQuery($sql);
        
			while($rowevent = mysql_fetch_array($resultevent))
			{
        ?>
     <tr>

			<td height="25" colspan="3" class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strDescription"]; ?></td>
        <td colspan="2" class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
        <td colspan="2" class="normalfntCenterTABNoBorder"><?php echo $rowevent["completedDate"]; ?></td>
			<td colspan="2" class="normalfntCenterTABNoBorder"><?php echo $rowevent["completedBy"]; ?></td>
        <td colspan="2" class="normalfntCenterTABNoBorder"><?php echo $rowevent["strRemarks"]; ?></td>
        </tr>
        <?php
        	
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
</body>
</html>
