<?php
session_start();
$backwardseperator = "../";
include "${backwardseperator}authentication.inc";
include "../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>All Event Schedule Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php 
	$styleID=$_GET["styleID"];
	$companyID = $_SESSION["FactoryID"];
	$styleList = "";
	$buyer = $_GET["buyer"];
	$merchandiser = $_GET["merchandiser"];
	$sc = $_GET["sc"];
	if ($styleID == "")
	{
		$sql = "SELECT DISTINCT ESH.strStyleId FROM eventscheduleheader ESH INNER JOIN orders O ON ESH.strStyleId = O.strStyleId 
		inner join eventscheduledetail ESD ON ESH.intScheduleId=ESD.intScheduleId
		WHERE O.intCompanyID = '$companyID' and  ISNULL(ESD.dtCompleteDate)
		and ESD.dtmEstimateDate < CURDATE()  order by O.strStyleId;";
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result ))
		{
			$styleList .= "'" . $row["strStyleId"]  . "',";
		}
			$styleList .= "' '";
	}
	else
	{
		$styleList = "'$styleID'";
	}
	
	$SQL="SELECT orders.strStyleID, companies.strName, companies.strAddress1,companies.strTQBNO,
	companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, companies.strCountry, companies.strZipCode,companies.strRegNo, 
	companies.strPhone, companies.strEMail, companies.strFax, companies.strWeb FROM companies 
	INNER JOIN orders ON companies.intCompanyID = orders.intCompanyID 
	WHERE orders.strStyleID IN ($styleList);";
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
<table width="1000" border="0" align="center" cellpadding="0">
<tr>
    <td width="960" colspan="4"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
				<td width="6%" class="normalfnt">&nbsp;</td>
					<td width="74%" class="tophead"><p class="topheadBLACK"><?php echo $comName;?></p>
					<p class="normalfnt"><?php echo $strAddress1new.$strAddress2new.$strStreetnew.$strCitynew.$strStatenew.$comCountry."<br/>"."<b>Tel:</b>".$strPhone."&nbsp;".$comZipCode."<b>Fax:</b>".$comFax."<br/><b>E-Mail:</b>".$comEMail."&nbsp;<b>Web:</b>".$comWeb;?></p>
				<p class="normalfnt"></p>     			</td>
                </tr>
          </table>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><p class="head2BLCK">All Events As At : <?php echo date('jS \of F Y'); ?> </p>
      <table width="100%" border="0" cellpadding="0" bgcolor="#FFFFFF">
        
        <tr>
          <td width="50%"></td>
          <td width="50%" valign="top"></td>
        </tr>
    </table>      </td>
  </tr>
 
  <tr>
    <td colspan="4"><table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" rules="all" >
	<thead>
		<tr>
			<th class="normalfntCenterTABNoBorder" height="25">&nbsp;Events</th>
			<th width="10%" colspan="-4" nowrap="nowrap" class="normalfntCenterTABNoBorder">Expected Date</th>
			<th width="10%" nowrap="nowrap"class="normalfntCenterTABNoBorder">Change Date</th>
			<th width="22%" class="normalfntCenterTABNoBorder">Change Reason</th>
			<th width="19%" class="normalfntCenterTABNoBorder">Remarks</th>
			<th width="6%" class="normalfntCenterTABNoBorder">Delay (Days)</th>
        </tr>
	</thead>
        <?php
        $sql = "SELECT eventscheduleheader.intScheduleId,eventscheduleheader.strStyleId,  DATE_FORMAT(eventscheduleheader.dtDeliveryDate, '%Y %b %d')  AS deliveryDate, eventscheduleheader.strBuyerPONO, specification.intSRNO, useraccounts.Name AS merchandiser  
FROM eventscheduleheader 
INNER JOIN orders ON eventscheduleheader.strStyleId = orders.strStyleID 
LEFT JOIN specification ON eventscheduleheader.strStyleId = specification.strStyleID  AND specification.strStyleID = orders.strStyleID 
INNER JOIN useraccounts ON orders.intCoordinator = useraccounts.intUserID 
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
        ?>
        <tr>
			<td colspan="8"></td>        
        </tr>
		<tr>
		  <td height="25" colspan="8" class="normalfntLeftTABNoBorder"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="7%"><b>Style No : </b></td>
              <td width="14%"><?php echo $row["strStyleId"]; ?></td>
              <td width="5%"><b>SC No : </b></td>
              <td width="6%"><?php echo $row["intSRNO"]; ?></td>
              <td width="9%"><b>Buyer PONo : </b></td>
              <td width="11%"><?php echo $row["strBuyerPONO"]; ?></td>
              <td width="10%"><b>Merchandiser : </b></td>
              <td width="18%"><?php echo $row["merchandiser"]; ?></td>
              <td width="12%"><b>Date of delivery :</b></td>
              <td width="8%"><?php echo $row["deliveryDate"]; ?></td>
            </tr>
          </table></td>
	    </tr>
		
		<tr bgcolor="#CCCCCC">
			<td class="normalfntTAB" colspan="7">&nbsp;</td>
		</tr>
<!--BEGIN - Today Pending Events-->
<?php
$scheduleID = $row["intScheduleId"];
$isFirstRow = true;
$sql="(SELECT ED.intEventId, DATE_FORMAT(ED.dtmEstimateDate, '%Y %b %d') as EstimateDate,
DATE_FORMAT(ED.dtChangeDate, '%Y %b %d') as dtChangeDate, ED.dtCompleteDate,ED.strChangedReason, 
DATEDIFF(CURDATE(), ED.dtmEstimateDate) AS diff, 
DATEDIFF(CURDATE(), ED.dtChangeDate) AS changediff, E.strDescription ,ED.strRemarks
FROM eventscheduledetail ED
INNER JOIN events E ON ED.intEventId = E.intEventID 
WHERE ED.intScheduleId = '$scheduleID' AND ISNULL(ED.dtCompleteDate))";
$resultevent = $db->RunQuery($sql);

while($rowevent = mysql_fetch_array($resultevent))
{
	if($rowevent["changediff"]=="")
	{
		if (substr($rowevent["diff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["diff"],1);
		else
			$prossDiffe = ($rowevent["diff"]*-1);
	}
	else
	{
		if (substr($rowevent["changediff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["changediff"],1);
		else
			$prossDiffe = ($rowevent["changediff"]*-1);
	}
	
	if($prossDiffe == 0)
	{
		if($isFirstRow)
		{
?>
        <tr>
        	<td height="25" colspan="7" class="normalfntLeftTABNoBorder" ><b>Today pending event<b/>/s</td>
        </tr>
<?php
        $isFirstRow = false;
        }
?>
		<tr>
			<td class="normalfntLeftTABNoBorder" height="25">&nbsp;&nbsp;<?php echo $rowevent["strDescription"]; ?></td>
			<td colspan="-4" class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
			<td class="normalfntCenterTABNoBorder"><?php echo $rowevent["dtChangeDate"]; ?></td>
			<td class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strChangedReason"]; ?></td>
			<td class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strRemarks"]; ?></td>
			<td class="normalfntCenterTABNoBorder"> <?php echo $prossDiffe;?></td>
		</tr>
<?php
	}
}
?>
<!--END - Today Pending Events-->

<!--BEGIN - To be completed in next 2 days Events-->
<?php
$scheduleID = $row["intScheduleId"];
$isFirstRow = true;

$sql="(SELECT ED.intEventId, DATE_FORMAT(ED.dtmEstimateDate, '%Y %b %d') as EstimateDate,
DATE_FORMAT(ED.dtChangeDate, '%Y %b %d') as dtChangeDate, ED.dtCompleteDate,ED.strChangedReason, 
DATEDIFF(CURDATE(), ED.dtmEstimateDate) AS diff, 
DATEDIFF(CURDATE(), ED.dtChangeDate) AS changediff, E.strDescription ,ED.strRemarks
FROM eventscheduledetail ED
INNER JOIN events E ON ED.intEventId = E.intEventID 
WHERE ED.intScheduleId = '$scheduleID' AND ISNULL(ED.dtCompleteDate))";
$resultevent = $db->RunQuery($sql);      
while($rowevent = mysql_fetch_array($resultevent))
{
	if($rowevent["changediff"]=="")
	{
		if (substr($rowevent["diff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["diff"],1);
		else
			$prossDiffe = ($rowevent["diff"]*-1);
	}
	else
	{
		if (substr($rowevent["changediff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["changediff"],1);
		else
			$prossDiffe = ($rowevent["changediff"]*-1);
	}
	if($prossDiffe>0 && $prossDiffe<3)
	{
		if($isFirstRow)
		{
 ?>
         <tr>
        <td height="25" colspan="7" class="normalfntLeftTABNoBorder"><b>To be completed in next two days event/s<b/> </td>
        </tr>
<?php
		$isFirstRow = false;
		}
?>
      <tr>
			<td class="normalfntLeftTABNoBorder" height="25">&nbsp;&nbsp;<?php echo $rowevent["strDescription"]; ?></td>
        <td colspan="-4" class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
         <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["dtChangeDate"]; ?></td>
          <td class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strChangedReason"]; ?></td>
          <td class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strRemarks"]; ?></td>
          <td class="normalfntCenterTABNoBorder"> <?php echo $prossDiffe;?></td>
        </tr>
<?php
	}
}
?>
<!--END - To be completed in next 2 days Events-->

<!--BEGIN - Pending Events-->
<?php
$scheduleID = $row["intScheduleId"];
$isFirstRow = true;
$sql="(SELECT ED.intEventId, DATE_FORMAT(ED.dtmEstimateDate, '%Y %b %d') as EstimateDate,
DATE_FORMAT(ED.dtChangeDate, '%Y %b %d') as dtChangeDate, ED.dtCompleteDate,ED.strChangedReason, 
DATEDIFF(CURDATE(), ED.dtmEstimateDate) AS diff, 
DATEDIFF(CURDATE(), ED.dtChangeDate) AS changediff, E.strDescription ,ED.strRemarks
FROM eventscheduledetail ED
INNER JOIN events E ON ED.intEventId = E.intEventID 
WHERE ED.intScheduleId = '$scheduleID' AND ISNULL(ED.dtCompleteDate))";
$resultevent = $db->RunQuery($sql);

while($rowevent = mysql_fetch_array($resultevent))
{
	if($rowevent["changediff"]=="")
	{
		if (substr($rowevent["diff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["diff"],1);
		else
			$prossDiffe = ($rowevent["diff"]*-1);
	}
	else
	{
		if (substr($rowevent["changediff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["changediff"],1);
		else
			$prossDiffe = ($rowevent["changediff"]*-1);
	}
	
	if($prossDiffe>2)
	{
		if($isFirstRow)
		{
?>
        <tr>
        	<td height="25" colspan="7" class="normalfntLeftTABNoBorder"><b>Pending Event/s<b/></td>
        </tr>
<?php
        $isFirstRow = false;
        }
?>
		<tr>
			<td class="normalfntLeftTABNoBorder" height="25">&nbsp;&nbsp;<?php echo $rowevent["strDescription"]; ?></td>
			<td colspan="-4" class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
			<td class="normalfntCenterTABNoBorder"><?php echo $rowevent["dtChangeDate"]; ?></td>
			<td class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strChangedReason"]; ?></td>
			<td class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strRemarks"]; ?></td>
			<td class="normalfntCenterTABNoBorder"> <?php echo $prossDiffe;?></td>
		</tr>
<?php
	}
}
?>
<!--END - Pending Events-->

<!--BEGIN - Delayed Events-->
<?php
	$scheduleID = $row["intScheduleId"];
	$isFirstRow = true;
/*	$sql = "SELECT eventscheduledetail.intEventId, 
	DATE_FORMAT(eventscheduledetail.dtmEstimateDate, '%Y %b %d') as EstimateDate,DATE_FORMAT(eventscheduledetail.dtChangeDate, '%Y %b %d') as dtChangeDate,
	eventscheduledetail.dtCompleteDate,eventscheduledetail.strChangedReason,
	DATEDIFF(CURDATE(), eventscheduledetail.dtmEstimateDate) AS diff, 
	DATEDIFF(CURDATE(), eventscheduledetail.dtChangeDate) AS changediff, 
	events.strDescription  
	FROM eventscheduledetail INNER JOIN events ON  eventscheduledetail.intEventId = events.intEventID 
	WHERE eventscheduledetail.intScheduleId = '$scheduleID' AND eventscheduledetail.dtChangeDate < CURDATE() AND ISNULL(eventscheduledetail.dtCompleteDate)";*/
	
$sql="(SELECT ED.intEventId, DATE_FORMAT(ED.dtmEstimateDate, '%Y %b %d') as EstimateDate,
DATE_FORMAT(ED.dtChangeDate, '%Y %b %d') as dtChangeDate, ED.dtCompleteDate,ED.strChangedReason, 
DATEDIFF(CURDATE(), ED.dtmEstimateDate) AS diff, 
DATEDIFF(CURDATE(), ED.dtChangeDate) AS changediff, E.strDescription,
ED.strRemarks
FROM eventscheduledetail ED 
INNER JOIN events E ON ED.intEventId = E.intEventID 
WHERE ED.intScheduleId = '$scheduleID' AND ED.dtmEstimateDate < CURDATE() AND ISNULL(ED.dtCompleteDate) AND ISNULL(ED.dtChangeDate))
union
(SELECT ED.intEventId, DATE_FORMAT(ED.dtmEstimateDate, '%Y %b %d') as EstimateDate,
DATE_FORMAT(ED.dtChangeDate, '%Y %b %d') as dtChangeDate, ED.dtCompleteDate,ED.strChangedReason, 
DATEDIFF(CURDATE(), ED.dtmEstimateDate) AS diff, 
DATEDIFF(CURDATE(), ED.dtChangeDate) AS changediff, E.strDescription ,ED.strRemarks
FROM eventscheduledetail ED
INNER JOIN events E ON ED.intEventId = E.intEventID 
WHERE ED.intScheduleId = '$scheduleID' AND ED.dtChangeDate < CURDATE() AND ISNULL(ED.dtCompleteDate))";
$resultevent = $db->RunQuery($sql);      
while($rowevent = mysql_fetch_array($resultevent))
{
	if($rowevent["changediff"]=="")
	{
		if (substr($rowevent["diff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["diff"],1);
		else
			$prossDiffe = ($rowevent["diff"]*-1);
	}
	else
	{
		if (substr($rowevent["changediff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["changediff"],1);
		else
			$prossDiffe = ($rowevent["changediff"]*-1);
	}
	
	if($isFirstRow)
	{
        ?>
         <tr>
        <td height="25" colspan="7" class="normalfntLeftTABNoBorder"><b>Delayed Event/s<b/></td>
        </tr>
<?php
		$isFirstRow = false;
	}
?>
      <tr>
			<td class="normalfntLeftTABNoBorder" height="25">&nbsp;<?php echo $rowevent["strDescription"]; ?></td>
        <td colspan="-4" class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
         <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["dtChangeDate"]; ?></td>
          <td class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strChangedReason"]; ?></td>
          <td class="normalfntLeftTABNoBorder"><?php echo $rowevent["strRemarks"]; ?></td>
          <td class="normalfntCenterTABNoBorder"> <?php echo $prossDiffe;?></td>
        </tr>
<?php
}
?>
<!--END - Delayed Events-->

<!--BEGIN - Complete Events-->
<?php
$scheduleID = $row["intScheduleId"];
$isFirstRow = true;

$sql="(SELECT ED.intEventId, DATE_FORMAT(ED.dtmEstimateDate, '%Y %b %d') as EstimateDate,
DATE_FORMAT(ED.dtChangeDate, '%Y %b %d') as dtChangeDate, ED.dtCompleteDate,ED.strChangedReason, 
DATEDIFF(CURDATE(), ED.dtmEstimateDate) AS diff, 
DATEDIFF(CURDATE(), ED.dtChangeDate) AS changediff, E.strDescription ,ED.strRemarks
FROM eventscheduledetail ED
INNER JOIN events E ON ED.intEventId = E.intEventID 
WHERE ED.intScheduleId = '$scheduleID' AND NOT ISNULL(ED.dtCompleteDate))";
$resultevent = $db->RunQuery($sql);
      
while($rowevent = mysql_fetch_array($resultevent))
{
	if($rowevent["changediff"]=="")
	{
		if (substr($rowevent["diff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["diff"],1);
		else
			$prossDiffe = ($rowevent["diff"]*-1);
	}
	else
	{
		if (substr($rowevent["changediff"],0,1)=='-')
			$prossDiffe =  substr($rowevent["changediff"],1);
		else
			$prossDiffe = ($rowevent["changediff"]*-1);
	}
	
	if($isFirstRow)
	{
?>
         <tr>
        <td height="25" colspan="7" class="normalfntLeftTABNoBorder"><b>Completed Event/s<b/></td>
        </tr>
<?php
	$isFirstRow = false;
	}
?>
      <tr>
			<td class="normalfntLeftTABNoBorder" height="25">&nbsp;&nbsp;<?php echo $rowevent["strDescription"]; ?></td>
        <td colspan="-4" class="normalfntCenterTABNoBorder"><?php echo $rowevent["EstimateDate"]; ?></td>
         <td class="normalfntCenterTABNoBorder"><?php echo $rowevent["dtChangeDate"]; ?></td>
          <td class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strChangedReason"]; ?></td>
          <td class="normalfntLeftTABNoBorder">&nbsp;<?php echo $rowevent["strRemarks"]; ?></td>
          <td class="normalfntCenterTABNoBorder"> <?php echo $prossDiffe;?></td>
        </tr>
<?php
}
?>
<!--END - Complete Events-->
<?php
}
?>
    </table></td>
  </tr>
  

  <tr>
    <td colspan="4">	</td>
  </tr>  
  
  <tr>
    <td colspan="4"></td>
  </tr>
</table>
</body>
</html>