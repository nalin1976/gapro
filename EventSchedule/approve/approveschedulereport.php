<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Approve Schedule Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script src="../../javascript/script.js" type="text/javascript"></script>
<?php 

include "../../Connector.php";

				
				$styleID=$_GET["styleID"];
				$companyID = $_GET["companyID"];				
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
    <td colspan="4"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%"><img src="../../images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
				<td width="6%" class="normalfnt">&nbsp;</td>
					<td width="74%" class="tophead"><p class="topheadBLACK"><?php echo $comName;?></p>
					<p class="normalfnt"><?php echo $strAddress1new.$strAddress2new.$strStreetnew.$strCitynew.$strStatenew.$comCountry."."."Tel:".$strPhone.",".$comZipCode." Fax: ".$comFax." E-Mail: ".$comEMail." Web: ".$comWeb;?></p>
				<p class="normalfnt"></p>     			</td>
              </tr>
          </table>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><p class="head2BLCK"><br/>Critical Events As At : <?php echo date('jS \of F Y'); ?> </p>
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
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
			<td colspan="5" class="normalfntLeftTABNoBorder"><b>Event</b></td>
        <td class="normalfntCenterTABNoBorder"><b>Expected Date</b></td>
        <td class="normalfntRiteTABNoBorder"><b>Delay (Days)</b></td>
        </tr>
        <?php
        $sql = "SELECT eventscheduleheader.intScheduleId,eventscheduleheader.intStyleId,  DATE_FORMAT(eventscheduleheader.dtDeliveryDate, '%Y %b %d')  AS deliveryDate, eventscheduleheader.strBuyerPONO, specification.intSRNO, useraccounts.Name AS merchandiser  
FROM eventscheduleheader 
INNER JOIN orders ON eventscheduleheader.intStyleId = orders.intStyleId 
LEFT JOIN specification ON eventscheduleheader.intStyleId = specification.intStyleId  AND specification.intStyleId = orders.intStyleId 
INNER JOIN useraccounts ON orders.intCoordinator = useraccounts.intUserID 
WHERE  eventscheduleheader.intStyleId IN ($styleList);";
		

        $result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result ))
			{
        ?>
        <tr>
			<td colspan="12"><hr></td>        
        </tr>
			<tr>
        <td height="25" colspan="3" class="normalfntLeftTABNoBorder"><b>Style ID : </b><?php echo $row["intStyleId"]; ?></td>
        <td  colspan="3"  class="normalfntLeftTABNoBorder"><b>SC No : </b><?php echo $row["intSRNO"]; ?></td>
        <td  colspan="3"  class="normalfntLeftTABNoBorder"><b>Buyer PO : </b><?php echo $row["strBuyerPONO"]; ?></td>
        <td colspan="3" class="normalfntLeftTABNoBorder"><b>Merchandiser : </b><?php echo $row["merchandiser"]; ?></td>
        </tr>
      <tr bgcolor="#CCCCCC">
         <td class="normalfntTAB" colspan="11">Date Of Delivery : <?php echo $row["deliveryDate"]; ?></td>
        </tr>
        <?php
        $scheduleID = $row["intScheduleId"];
        $isFirstRow = true;
        $sql = "SELECT eventscheduledetail.intEventId,  DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d') as EstimateDate,eventscheduledetail.dtChangeDate,eventscheduledetail.dtCompleteDate,eventscheduledetail.strChangedReason,DATEDIFF(CURDATE(),eventscheduledetail.dtmEstimateDate) AS diff, events.strDescription  
FROM eventscheduledetail INNER JOIN events ON  eventscheduledetail.intEventId = events.intEventID 
WHERE eventscheduledetail.intScheduleId = '$scheduleID' AND eventscheduledetail.dtmEstimateDate < CURDATE() AND ISNULL(eventscheduledetail.dtCompleteDate)";
        $resultevent = $db->RunQuery($sql);
      
			while($rowevent = mysql_fetch_array($resultevent))
			{
			if($isFirstRow)
			{
        ?>
         <tr>
        <td height="25" colspan="11" class="normalfntLeftTABNoBorder"><br>Delayed Events<hr></td>
			<td colspan="5"></td>
        <td></td>
        <td></td>
        </tr>
        <?php
        $isFirstRow = false;
        }
        ?>
      <tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
			<td colspan="5" class="normalfntLeftTABNoBorder"><?php echo $rowevent["strDescription"]; ?></td>
        <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
        <td class="normalfntCenterTABNoBorder">- <?php echo $rowevent["diff"]; ?></td>
        </tr>
        <?php        	
        	}
        	
        $isFirstRow = true;
        $sql = "SELECT eventscheduledetail.intEventId,  DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d') as EstimateDate,eventscheduledetail.dtChangeDate,eventscheduledetail.dtCompleteDate,eventscheduledetail.strChangedReason,DATEDIFF(CURDATE(),eventscheduledetail.dtmEstimateDate) AS diff, events.strDescription  
FROM eventscheduledetail INNER JOIN events ON  eventscheduledetail.intEventId = events.intEventID 
WHERE eventscheduledetail.intScheduleId = '$scheduleID' AND eventscheduledetail.dtmEstimateDate = CURDATE() AND ISNULL(eventscheduledetail.dtCompleteDate)";
        $resultevent = $db->RunQuery($sql);
        
			while($rowevent = mysql_fetch_array($resultevent))
			{
			if($isFirstRow)
			{
        ?>
         <tr>
        <td height="25" colspan="11" class="normalfntLeftTABNoBorder"><br>Today Events<hr></td>
			<td colspan="5"></td>
        <td></td>
        <td></td>
        </tr>
        <?php
        $isFirstRow = false;
        }
        ?>
      <tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
			<td colspan="5" class="normalfntLeftTABNoBorder"><?php echo $rowevent["strDescription"]; ?></td>
        <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
        <td class="normalfntCenterTABNoBorder">0</td>
        </tr>
        <?php
        	
        	}
        	 	 
        $isFirstRow = true;
       
         $sql = "SELECT eventscheduledetail.intEventId,  DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d') as EstimateDate,eventscheduledetail.dtChangeDate,eventscheduledetail.dtCompleteDate,eventscheduledetail.strChangedReason,DATEDIFF(CURDATE(),eventscheduledetail.dtmEstimateDate) AS diff, events.strDescription  
FROM eventscheduledetail INNER JOIN events ON  eventscheduledetail.intEventId = events.intEventID 
WHERE eventscheduledetail.intScheduleId = '$scheduleID' AND (eventscheduledetail.dtmEstimateDate > CURDATE() AND  eventscheduledetail.dtmEstimateDate <= DATE_ADD( CURDATE() , INTERVAL 2 DAY)) AND ISNULL(eventscheduledetail.dtCompleteDate)";
        $resultevent = $db->RunQuery($sql);
        echo $sql;
			while($rowevent = mysql_fetch_array($resultevent))
			{
			if($isFirstRow)
			{
        ?>
         <tr>
        <td height="25" colspan="11" class="normalfntLeftTABNoBorder"><br>
        To be complete in next 2 days
          <hr></td>
			<td colspan="5"></td>
        <td></td>
        <td></td>
        </tr>
        <?php
        $isFirstRow = false;
        }
        ?>
      <tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
			<td colspan="5" class="normalfntLeftTABNoBorder"><?php echo $rowevent["strDescription"]; ?></td>
        <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
        <td class="normalfntCenterTABNoBorder">+ <?php echo $rowevent["diff"] * -1; ?></td>
        </tr>
        	<?php        	
        	}
			        $isFirstRow = true;
       
         $sql = "SELECT eventscheduledetail.intEventId,  DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d') as EstimateDate,eventscheduledetail.dtChangeDate,eventscheduledetail.dtCompleteDate,eventscheduledetail.strChangedReason,DATEDIFF(CURDATE(),eventscheduledetail.dtmEstimateDate) AS diff, events.strDescription  
FROM eventscheduledetail INNER JOIN events ON  eventscheduledetail.intEventId = events.intEventID 
WHERE eventscheduledetail.intScheduleId = '$scheduleID' AND (eventscheduledetail.dtmEstimateDate >= DATE_ADD( CURDATE() , INTERVAL 2 DAY)) AND ISNULL(eventscheduledetail.dtCompleteDate)";
        $resultevent = $db->RunQuery($sql);
        
			while($rowevent = mysql_fetch_array($resultevent))
			{
			if($isFirstRow)
			{
			?>
			 <tr>
        <td height="25" colspan="11" class="normalfntLeftTABNoBorder"><br>
        Pending events
          <hr></td>
			<td colspan="5"></td>
        <td></td>
        <td></td>
        </tr>
        <?php
        $isFirstRow = false;
        }
        ?>
      <tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
			<td colspan="5" class="normalfntLeftTABNoBorder"><?php echo $rowevent["strDescription"]; ?></td>
        <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
        <td class="normalfntCenterTABNoBorder">+ <?php echo $rowevent["diff"] * -1; ?></td>
        </tr>
		<?php
        }
		
		//
		 $isFirstRow = true;
        $sql = "SELECT eventscheduledetail.intEventId,  DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d') as EstimateDate,eventscheduledetail.dtChangeDate,eventscheduledetail.dtCompleteDate,eventscheduledetail.strChangedReason,DATEDIFF(CURDATE(),eventscheduledetail.dtmEstimateDate) AS diff, events.strDescription  
FROM eventscheduledetail INNER JOIN events ON  eventscheduledetail.intEventId = events.intEventID 
WHERE eventscheduledetail.intScheduleId = '$scheduleID' AND (eventscheduledetail.dtCompleteDate is not null)";
        $resultevent = $db->RunQuery($sql);
        
			while($rowevent = mysql_fetch_array($resultevent))
			{
			if($isFirstRow)
			{
        ?>
         <tr>
        <td height="25" colspan="11" class="normalfntLeftTABNoBorder"><br>Complete Events<hr></td>
			<td colspan="5"></td>
        <td></td>
        <td></td>
        </tr>
        <?php
        $isFirstRow = false;
        }
        ?>
      <tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
			<td colspan="5" class="normalfntLeftTABNoBorder"><?php echo $rowevent["strDescription"]; ?></td>
        <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
        <td class="normalfntCenterTABNoBorder">0</td>
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
  <tr bgcolor="#d6e7f5" id="approve">
    <td width="40%"  >&nbsp;</td>
	 <td width="10%"  ><img src="../../images/approve.png" alt="approve" width="113" height="24" class="mouseover" onclick="ApproveSchedule();"/></td>
	  <td width="10%"  ><img src="../../images/close.png" alt="close" width="97" height="24" class="mouseover" onclick="Close()" /></td>
	   <td width="40%"  >&nbsp;</td>
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
<script type="text/javascript">
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
function Close()
{
	window.close();
}
function ApproveSchedule()
{
	var styleId = "<?php echo $_GET["styleID"];?>";
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = ApproveScheduleRequest;
	xmlHttp.index = styleId;
	xmlHttp.open("GET",'../ManageScheduleXML.php?RequestType=ApproveSchedule&StyleId=' + URLEncode(styleId) , true);
	xmlHttp.send(null);
}
	function ApproveScheduleRequest()
	{
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
		{
			alert ("Style name : "+ xmlHttp.index +" approved");
			document.getElementById('approve').style.visibility = "hidden";
			Close();
		}
	}
</script>