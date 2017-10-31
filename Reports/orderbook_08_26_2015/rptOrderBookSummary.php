<?php
session_start();
include "../../Connector.php";
$backwardseperator 	= '../../';
$report_companyId 	= $_SESSION["FactoryID"];
$xml 				= simplexml_load_file('../../config.xml');
$reportname 		= $xml->PreOrder->ReportName;
$profitMargin 		= $xml->companySettings->MinimumProfitMargin;

$txtDfrom  	= $_GET["txtDfrom"];
$txtDto    	= $_GET["txtDto"];
$checkDate	= $_GET["checkDate"];
$buyer		= $_GET["Buyer"];
$chkDelDate	= $_GET["chkDelDate"];
$delDfrom	= $_GET["delDfrom"];
$delDto		= $_GET["delDto"];
$orderType	= $_GET["orderType"];
$division	= $_GET["Division"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Order Book Summary Report - Order Type Wise</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.hrefClass{
font-size:10px;
color:#3CF;
}
</style>

<style type="text/css">
body {
	background: #f0f0f0;
	margin: 0;
	padding: 0;
	font: 10px normal Verdana, Arial, Helvetica, sans-serif;
	color: #444;
}
h1 {font-size: 3em; margin: 20px 0;}
.container {width: 500px; margin: 10px auto;}
ul.tabs {
	margin: 0;
	padding: 0;
	float: left;
	list-style: none;
	height: 21px;
	border-bottom: 1px solid #999;
	border-left: 1px solid #999;
	width: 100%;
}
ul.tabs li {
	float: left;
	margin: 0;
	padding: 0;
	height: 20px;
	line-height: 20px;
	border: 1px solid #999;
	border-left: none;
	margin-bottom: -1px;
	background: #e0e0e0;
	overflow: hidden;
	position: relative;
}
ul.tabs li a {
	text-decoration: none;
	color: #000;
	display: block;
	font-size: 1.2em;
	padding: 0 20px;
	border: 1px solid #fff;
	outline: none;
}
ul.tabs li a:hover {
	background: #333;
	color:#FFF;
}	
html ul.tabs li.active, html ul.tabs li.active a:hover  {
	background: #fff;	
	border-bottom: 1px solid #fff;
	color:#000;
}
.tab_container {
	border: 1px solid #999;
	border-top: none;
	clear: both;
	float: left; 
	width: 100%;
	background: #fff;
	-moz-border-radius-bottomright: 5px;
	-khtml-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-moz-border-radius-bottomleft: 5px;
	-khtml-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
}
.tab_content {
	padding: 20px;
	font-size: 1.2em;
}
.tab_content h2 {
	font-weight: normal;
	padding-bottom: 10px;
	border-bottom: 1px dashed #ddd;
	font-size: 1.8em;
}
.tab_content h3 a{
	color: #254588;
}
.tab_content img {
	float: left;
	margin: 0 20px 20px 0;
	border: 1px solid #ddd;
	padding: 5px;
}
</style>
<style type="text/css">

table.fixHeader {
	border: solid #FFFFFF;
	border-width: 2px 2px 2px 2px;
	width: 1050px;
}

tbody.ctbody {
	height: 650px;
	overflow-y: auto;
	overflow-x: hidden;
}
/*.fixHeader thead tr { display: block; }
.fixHeader tbody { display: block;  overflow: auto; }*/
</style>

<style type="text/css">
.OBOrderType-Bulk{
	background-color: #FFF;
}

.OBOrderType-SampleInvoice{
	background-color: #FAC5DB;
}

.OBOrderType-SampleNonInvoice{
	background-color: #39F;
}

.OBOrderType-Seconds{
	background-color: #FC9;
}

.OBOrderType-Assorted{
	background-color: #E6E6E6;
}
.OBOrderType-Confirmed{
	background-color: #00CC66;
}

</style>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
});
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td>
	<table width ="100%" border="0" align="center" bgcolor="#FFFFFF" cellpadding="1" cellspacing="0">
		<tr>
     		 <td height="25"class="head2">Order Book Summary Report - Order Type Wise</td>
		</tr>
		<tr>
			<td height="15">
			<div  id="container" >
				<ul class="tabs">
                	<li class="active"><a href="#tabs-0" >All</a></li>
					<li class=""><a href="#tabs-1" >Bulk</a></li>
					<li class=""><a href="#tabs-2" >Sample Invoice</a></li>
                    <li class=""><a href="#tabs-3" >Sample Non Invoice</a></li>
                    <li class=""><a href="#tabs-4" >Seconds</a></li>
				</ul>
				<div class="tab_container">
                    <div  id="tabs-0" style="display: block;" class="tab_content">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <td width="5%"><table width="96" border="0" cellpadding="0" cellspacing="2" >
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#00CC66" >Confirmed</td>
                      </tr>
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#FFFF99">Pending</td>
                      </tr>
                    </table></td>
                    <td width="95%"><table width="856" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="1" height="20">&nbsp;</td>
                        <td width="30" class="txtbox OBOrderType-Bulk">&nbsp;</td>
                        <td width="183" class="normalfnt">&nbsp;Bulk </td>
                        <td width="30" class="txtbox OBOrderType-SampleInvoice">&nbsp;</td>
                        <td width="183" class="normalfnt">&nbsp;Sample Invoice </td>
                        <td width="30" class="txtbox OBOrderType-SampleNonInvoice">&nbsp;</td>
                        <td width="183" class="normalfnt">&nbsp;Sample Non Invoice </td>
                        <td width="30" class="txtbox OBOrderType-Seconds">&nbsp;</td>
                        <td width="183" class="normalfnt">&nbsp;Seconds&nbsp;</td>
                        <td width="30" >&nbsp;</td>
                        <td width="183" class="normalfnt">&nbsp;</td>
                      </tr>
                    </table></td>
                    </tr>
                    <tr>
                    <td colspan="2"><table width="100%" border="0" cellpadding="2" cellspacing="1" id="tblGRNDetails" bgcolor="#000000" class="fixHeader">
                    <thead>
                    <tr bgcolor="#CCCCCC" class="normalfntMid">
                        <th nowrap="nowrap" >Orit Order No</th>
                        <th height="25" nowrap="nowrap" >Order No</th>
                        <th nowrap="nowrap">Style No</th>
                        <th nowrap="nowrap">Division</th>
                        <th nowrap="nowrap">Order Qty</th>
                        <th nowrap="nowrap">Excess&nbsp;<br/>%</th>
                        <th nowrap="nowrap">Excess&nbsp;<br/>Qty</th>
                        <th nowrap="nowrap">FOB&nbsp;<br/>(PCS)</th>
                        <th nowrap="nowrap">Profit&nbsp;<br/>(PCS)</th>
                        <th nowrap="nowrap">Profit Margin&nbsp;<br/>(PCS) %</th>
                        <th nowrap="nowrap">C&amp;M&nbsp;<br/>(PCS)</th>
                        <th nowrap="nowrap">C&amp;M Earned&nbsp;<br/>(Order Qty)</th>
                        <th nowrap="nowrap">Total Order<br /> Qty</th>
                        <th nowrap="nowrap">Fabric Mat Cost&nbsp;<br/>(PCS)</th>
                        <th nowrap="nowrap">Total Fabric Value&nbsp;<br/>(USD)</th>
                        <th nowrap="nowrap">Other Mat Cost&nbsp;<br/>(PCS)</th>
                        <th nowrap="nowrap">Total Other <br />Cost Value&nbsp;(USD)</th>
                        <th nowrap="nowrap">Wash Cost&nbsp;<br/>(PCS)</th>
                        <th nowrap="nowrap">Total Wash <br />Cost Value&nbsp;(USD)</th>
                        <th nowrap="nowrap">Total Cost &nbsp;<br/>(PCS)</th>
                        <th nowrap="nowrap">Total Cost Value&nbsp;<br/>(USD)</th>
                        <th nowrap="nowrap" title="Preorder FOB * Order Qty(Without Excess)">Sales Value&nbsp;<br/>(USD)</th>
                        <th nowrap="nowrap">HTML Order<br/>Summery</th>
                        <th nowrap="nowrap">Excel Order <br/>Summery </th>
                        <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="ctbody">
                    <?php
                    $sql="select concat(date_format(O.dtmOrderDate,'%Y%m'),'',O.intCompanyOrderNo)as oritOrderNo,D.strDivision,O.reaFOB,O.dblFacProfit,O.intStyleId,O.strOrderNo,O.strStyle,O.intQty,O.reaExPercentage,O.reaSMVRate,O.reaSMV,O.intStatus,O.intOrderType from orders O inner join buyerdivisions D on D.intDivisionId=O.intDivisionId ";
                    
                    if($checkDate=="true")
                    {
						if($txtDfrom!="")
						{
							$DateFromArray	= explode('/',$txtDfrom);
							$formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
							$sql.=" AND date(O.dtmOrderDate)>='$formatedFromDate' ";
						}
						if($txtDto!="")
							{
						$DateToArray	= explode('/',$txtDto);
							$formatedToDate	= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
							$sql.=" AND date(O.dtmOrderDate)<='$formatedToDate' ";
						}
                    }
                    
                    if($chkDelDate=="true")
                    {
                    $sql .= " and O.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
						if($delDfrom!="")
						{
							$delDfromArray	= explode('/',$delDfrom);
							$formatedDelDfromArray	= $delDfromArray[2].'-'.$delDfromArray[1].'-'.$delDfromArray[0];
							$sql .= "and date(DS.dtDateofDelivery)>='$formatedDelDfromArray' ";
						}
						if($delDto!="")
						{
							$delDToArray	= explode('/',$delDto);
							$formatedDelDToArray	= $delDToArray[2].'-'.$delDToArray[1].'-'.$delDToArray[0];
							$sql .= "and date(DS.dtDateofDelivery)<='$formatedDelDToArray' ";
						}
							$sql .= ")";
                    }
                    
                    if($buyer!="")
                   	 	$sql .= "and O.intBuyerID='$buyer' ";
                    
                    if($orderType!="")
                    	$sql .= "and O.intOrderType='$orderType' ";
						
					if($division!="")
						$sql .= "and O.intDivisionId='$division' ";
                    
                    $sql.=" order by O.strOrderNo;";                    
                    $result=$db->RunQuery($sql);
                    while($row=mysql_fetch_array($result))
                    {
                    	$orderType	= $row["intOrderType"];
                    
                    if($row["intStatus"]=='11')
                    	$orderStatueBGColor = '#00CC66';
                    else
                    	$orderStatueBGColor = '#FFFF99';
                    
                    $values 			= GetValues($row["intStyleId"]);
                    $bgColor			= "bcgcolor-tblrowWhite";
                    $totprofitMargin 	= ($row["dblFacProfit"]/$row["reaFOB"])*100;
                    $cmEarned 			= round($row["reaSMVRate"]*$row["reaSMV"],4);
                    $salesValue			= round($row["reaFOB"]* round($row["intQty"]),2);
                    
                    switch($orderType)
                    {
						case 1:
							$bgColor = 'OBOrderType-Bulk';
							break;
						case 2:
							$bgColor = 'OBOrderType-SampleInvoice';
							break;
						case 3:
							$bgColor = 'OBOrderType-SampleNonInvoice';
							break;
						case 4:
							$bgColor = 'OBOrderType-Seconds';
							break;
						case 5:
							$bgColor = 'OBOrderType-Assorted';
							break;
                    }
                   ?>                    
                        <tr class="<?php echo $bgColor;?>" onmouseover="this.style.background ='#FFFFFF';" onmouseout="this.style.background='';">
                        <td nowrap="nowrap" class="normalfnt" style="background:<?php echo $orderStatueBGColor;?>"><?php echo $row["oritOrderNo"]?></td>
                        <td height="15" nowrap="nowrap" class="normalfnt"><a href="../../<?php echo $reportname?>?styleID=<?php echo $row["intStyleId"]?>" target="_blank" id="poreport" rel="1"><?php echo $row["strOrderNo"]?></a></td>
                        <td nowrap="nowrap" class="normalfnt"><?php echo $row["strStyle"]?></td>
                        <td nowrap="nowrap" class="normalfnt"><?php echo $row["strDivision"]?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($row["intQty"],0)?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo $row["reaExPercentage"]?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format((($row["intQty"]*$row["reaExPercentage"])/100),0)?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo $row["reaFOB"]?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo $row["dblFacProfit"]?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($totprofitMargin,2)?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($cmEarned,4)?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($cmEarned * $row["intQty"],2)?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0)?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($values[0],4);?></td>
                        <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($values[1],2);?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($values[2],4);?></td>
                        <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($values[3],2);?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($values[6],4);?></td>
                        <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($values[7],2);?></td>
                        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($values[4],4);?></td>
                        <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($values[5],2);?></td>	
                        <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA"><?php echo number_format($salesValue,2);?></td>
                        <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/costestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="costestimatesheet.php">Click Here</a></td>
                        <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/xclcostestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="xclcostestimatesheet.php">Click Here</a></td>
                        <td nowrap="nowrap" class="normalfntRite" >&nbsp;&nbsp;</td>
                    </tr>
                    
                    <?php 
                    $totOrderQty 		+= round($row["intQty"],0);
                    $totExOrderQty 		+= round(($row["intQty"]*$row["reaExPercentage"])/100,0);
                    $totWithExOrderQty	+= round($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0);
                    $totFabricMatCost	+= round($values[0],4);
                    $totFabricMatValue	+= round($values[1],2);
                    $totOtherMatCost	+= round($values[2],4);
                    $totOtherMatValue	+= round($values[3],2);
                    $totMatCost			+= round($values[4],4);
                    $totMatValue		+= round($values[5],2);
                    $totWashCost		+= round($values[6],4);
                    $totWashValue		+= round($values[7],2);
                    $totCMEarnedPerPcs	+= round($cmEarned,4);
                    $totCMEarnedTotal	+= round($cmEarned * $row["intQty"],2);
                    $totSalesValue		+= $salesValue;
                    }
                    ?>   
                    <tr bgcolor="#EAEAEA">
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td height="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedPerPcs,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedTotal,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWithExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totFabricMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totFabricMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOtherMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totOtherMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totSalesValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                    <td colspan="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    </tr>
                    </tbody>
                    </table></td>
                    </tr>
                    </table>
                    </div>
                    
                    <div id="tabs-1" style="display: none;" class="tab_content">
                    <form id="tblTabs-1">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="91" border="0" cellpadding="0" cellspacing="2" >
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#00CC66" >Confirmed</td>
                      </tr>
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#FFFF99">Pending</td>
                      </tr>
                    </table></td>
                      </tr>
                      <tr>
                        <td><table width="100%" border="0" cellpadding="1" cellspacing="1" id="tblGRNDetails" bgcolor="#000000">
                    <thead>
                    <tr bgcolor="#CCCCCC" class="normalfntMid">
                    <th nowrap="nowrap">Orit Order No</th>
                    <th height="25" nowrap="nowrap" >&nbsp;Order No&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Style No&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Division&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Order Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Excess&nbsp;<br/>
                    %</th>
                    <th nowrap="nowrap">&nbsp;Excess&nbsp;<br/>
                    Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;FOB&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Profit&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Profit Margin&nbsp;<br/>
                    (PCS) %</th>
                    <th nowrap="nowrap">&nbsp;C&amp;M&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;C&amp;M Earned&nbsp;<br/>
                    (Order Qty)</th>
                    <th nowrap="nowrap">&nbsp;Total Order<br />
                    Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Fabric Mat Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Fabric Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap">&nbsp;Other Mat Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Other <br />
                    Cost Value&nbsp;(USD)</th>
                    <th nowrap="nowrap">&nbsp;Wash Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Wash <br />
                    Cost Value&nbsp;(USD)</th>
                    <th nowrap="nowrap">&nbsp;Total Cost &nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Cost Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap" title="Preorder FOB * Order Qty(Without Excess)">&nbsp;Sales Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap">HTML Order&nbsp;<br/>
                    Summary</th>
                    <th nowrap="nowrap">Excel Order <br/>
                    Summary </th>
                    <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="ctbody">
                    <?php
                    $totOrderQty 		= 0;
                    $totExOrderQty 		= 0;
                    $totWithExOrderQty	= 0;
                    $totFabricMatCost	= 0;
                    $totFabricMatValue	= 0;
                    $totOtherMatCost	= 0;
                    $totOtherMatValue	= 0;
                    $totMatCost			= 0;
                    $totMatValue		= 0;
                    $totWashCost		= 0;
                    $totWashValue		= 0;
                    $totCMEarnedPerPcs	= 0;
                    $totCMEarnedTotal	= 0;
                    $totSalesValue		= 0;
                    
                    $sql="select concat(date_format(O.dtmOrderDate,'%Y%m'),'',O.intCompanyOrderNo)as oritOrderNo,D.strDivision,O.reaFOB,O.dblFacProfit,O.intStyleId,O.strOrderNo,O.strStyle,O.intQty,O.reaExPercentage,O.reaSMVRate,O.reaSMV,O.intStatus,O.intOrderType from orders O inner join buyerdivisions D on D.intDivisionId=O.intDivisionId ";
                    
                    if($checkDate=="true")
                    {
                    if($txtDfrom!="")
                    {
                    $DateFromArray	= explode('/',$txtDfrom);
                    $formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
                    $sql.=" AND date(O.dtmOrderDate)>='$formatedFromDate' ";
                    }
                    if($txtDto!="")
                    {
                    $DateToArray	= explode('/',$txtDto);
                    $formatedToDate	= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
                    $sql.=" AND date(O.dtmOrderDate)<='$formatedToDate' ";
                    }
                    }
                    
                    if($chkDelDate=="true")
                    {
                    $sql .= " and O.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
                    if($delDfrom!="")
                    {
                    $delDfromArray	= explode('/',$delDfrom);
                    $formatedDelDfromArray	= $delDfromArray[2].'-'.$delDfromArray[1].'-'.$delDfromArray[0];
                    $sql .= "and date(DS.dtDateofDelivery)>='$formatedDelDfromArray' ";
                    }
                    if($delDto!="")
                    {
                    $delDToArray	= explode('/',$delDto);
                    $formatedDelDToArray	= $delDToArray[2].'-'.$delDToArray[1].'-'.$delDToArray[0];
                    $sql .= "and date(DS.dtDateofDelivery)<='$formatedDelDToArray' ";
                    }
                    $sql .= ")";
                    }
                    
                    if($buyer!="")
                    	$sql .= "and O.intBuyerID='$buyer' ";
                    
					if($division!="")
						$sql .= "and O.intDivisionId='$division' ";
						
                    $sql .= "and O.intOrderType='1' ";
                    
                    $sql.=" order by O.strOrderNo;";
                    $result=$db->RunQuery($sql);
                    while($row=mysql_fetch_array($result))
                    {
                    $orderType	= $row["intOrderType"];
                    
                    if($row["intStatus"]=='11')
                    $orderStatueBGColor = '#00CC66';
                    else
                    $orderStatueBGColor = '#FFFF99';
                    
                    $values 			= GetValues($row["intStyleId"]);
                    $bgColor			= "bcgcolor-tblrowWhite";
                    $totprofitMargin 	= ($row["dblFacProfit"]/$row["reaFOB"])*100;
                    $cmEarned 			= round($row["reaSMVRate"]*$row["reaSMV"],4);
                    $salesValue			= round($row["reaFOB"]* round($row["intQty"]),2);
                    
                    ?>
                    <tr class="<?php echo $bgColor;?>" onmouseover="this.style.background ='#FFFFFF';" onmouseout="this.style.background='';">
                    <td nowrap="nowrap" class="normalfnt" style="background:<?php echo $orderStatueBGColor;?>">&nbsp;<?php echo $row["oritOrderNo"]?>&nbsp;</td>
                    <td height="15" nowrap="nowrap" class="normalfnt"><a href="../../<?php echo $reportname?>?styleID=<?php echo $row["intStyleId"]?>" target="_blank" id="poreport" rel="1">&nbsp;<?php echo $row["strOrderNo"]?>&nbsp;</a></td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strStyle"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strDivision"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($row["intQty"],0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["reaExPercentage"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format((($row["intQty"]*$row["reaExPercentage"])/100),0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["reaFOB"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblFacProfit"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($totprofitMargin,2)?></td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($cmEarned,4)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($cmEarned * $row["intQty"],2)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[0],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[1],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[2],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[3],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[6],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[7],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[4],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[5],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($salesValue,2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/costestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="costestimatesheet.php" style="color:#00F"><u>Click Here</u></a></td>
                    <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/xclcostestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="xclcostestimatesheet.php" style="color:#00F"><u>Click Here</u></a></td>
                    <td nowrap="nowrap" class="normalfntRite" >&nbsp;&nbsp;</td>
                    </tr>
                    
                    <?php 
                    $totOrderQty 		+= round($row["intQty"],0);
                    $totExOrderQty 		+= round(($row["intQty"]*$row["reaExPercentage"])/100,0);
                    $totWithExOrderQty	+= round($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0);
                    $totFabricMatCost	+= round($values[0],4);
                    $totFabricMatValue	+= round($values[1],2);
                    $totOtherMatCost	+= round($values[2],4);
                    $totOtherMatValue	+= round($values[3],2);
                    $totMatCost			+= round($values[4],4);
                    $totMatValue		+= round($values[5],2);
                    $totWashCost		+= round($values[6],4);
                    $totWashValue		+= round($values[7],2);
                    $totCMEarnedPerPcs	+= round($cmEarned,4);
                    $totCMEarnedTotal	+= round($cmEarned * $row["intQty"],2);
                    $totSalesValue		+= $salesValue;
                    }
                    ?>
                    <tr bgcolor="#EAEAEA">
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td height="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedPerPcs,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedTotal,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWithExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totFabricMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totFabricMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOtherMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totOtherMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totSalesValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                    <td colspan="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    </tr>
                    </tbody>
                    </table></td>
                      </tr>
                    </table>

                    </form>	
                    </div>
                    
                    <div id="tabs-2" style="display: none;" class="tab_content">
                    <form id="tblTabs-2">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="91" border="0" cellpadding="0" cellspacing="2" >
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#00CC66" >Confirmed</td>
                      </tr>
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#FFFF99">Pending</td>
                      </tr>
                    </table></td>
                      </tr>
                      <tr>
                        <td><table width="100%" border="0" cellpadding="1" cellspacing="1" id="tblGRNDetails" bgcolor="#000000">
                    <thead>
                    <tr bgcolor="#CCCCCC" class="normalfntMid">
                    <th nowrap="nowrap">Orit Order No</th>
                    <th height="25" nowrap="nowrap" >&nbsp;Order No&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Style No&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Division&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Order Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Excess&nbsp;<br/>
                    %</th>
                    <th nowrap="nowrap">&nbsp;Excess&nbsp;<br/>
                    Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;FOB&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Profit&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Profit Margin&nbsp;<br/>
                    (PCS) %</th>
                    <th nowrap="nowrap">&nbsp;C&amp;M&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;C&amp;M Earned&nbsp;<br/>
                    (Order Qty)</th>
                    <th nowrap="nowrap">&nbsp;Total Order<br />
                    Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Fabric Mat Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Fabric Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap">&nbsp;Other Mat Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Other <br />
                    Cost Value&nbsp;(USD)</th>
                    <th nowrap="nowrap">&nbsp;Wash Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Wash <br />
                    Cost Value&nbsp;(USD)</th>
                    <th nowrap="nowrap">&nbsp;Total Cost &nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Cost Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap" title="Preorder FOB * Order Qty(Without Excess)">&nbsp;Sales Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap">HTML Order&nbsp;<br/>
                    Summary</th>
                    <th nowrap="nowrap">Excel Order <br/>
                    Summary </th>
                    <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="ctbody">
                    <?php
                    $totOrderQty 		= 0;
                    $totExOrderQty 		= 0;
                    $totWithExOrderQty	= 0;
                    $totFabricMatCost	= 0;
                    $totFabricMatValue	= 0;
                    $totOtherMatCost	= 0;
                    $totOtherMatValue	= 0;
                    $totMatCost			= 0;
                    $totMatValue		= 0;
                    $totWashCost		= 0;
                    $totWashValue		= 0;
                    $totCMEarnedPerPcs	= 0;
                    $totCMEarnedTotal	= 0;
                    $totSalesValue		= 0;
                    
                    $sql="select concat(date_format(O.dtmOrderDate,'%Y%m'),'',O.intCompanyOrderNo)as oritOrderNo,D.strDivision,O.reaFOB,O.dblFacProfit,O.intStyleId,O.strOrderNo,O.strStyle,O.intQty,O.reaExPercentage,O.reaSMVRate,O.reaSMV,O.intStatus,O.intOrderType from orders O inner join buyerdivisions D on D.intDivisionId=O.intDivisionId ";
                    
                    if($checkDate=="true")
                    {
                    if($txtDfrom!="")
                    {
                    $DateFromArray	= explode('/',$txtDfrom);
                    $formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
                    $sql.=" AND date(O.dtmOrderDate)>='$formatedFromDate' ";
                    }
                    if($txtDto!="")
                    {
                    $DateToArray	= explode('/',$txtDto);
                    $formatedToDate	= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
                    $sql.=" AND date(O.dtmOrderDate)<='$formatedToDate' ";
                    }
                    }
                    
                    if($chkDelDate=="true")
                    {
                    $sql .= " and O.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
                    if($delDfrom!="")
                    {
                    $delDfromArray	= explode('/',$delDfrom);
                    $formatedDelDfromArray	= $delDfromArray[2].'-'.$delDfromArray[1].'-'.$delDfromArray[0];
                    $sql .= "and date(DS.dtDateofDelivery)>='$formatedDelDfromArray' ";
                    }
                    if($delDto!="")
                    {
                    $delDToArray	= explode('/',$delDto);
                    $formatedDelDToArray	= $delDToArray[2].'-'.$delDToArray[1].'-'.$delDToArray[0];
                    $sql .= "and date(DS.dtDateofDelivery)<='$formatedDelDToArray' ";
                    }
                    $sql .= ")";
                    }
                    
                    if($buyer!="")
                    	$sql .= "and O.intBuyerID='$buyer' ";
                    
					if($division!="")
						$sql .= "and O.intDivisionId='$division' ";
						
                    $sql .= "and O.intOrderType='2' ";
                    
                    $sql.=" order by O.strOrderNo;";
                    $result=$db->RunQuery($sql);
                    while($row=mysql_fetch_array($result))
                    {
                    $orderType	= $row["intOrderType"];
                    
                    if($row["intStatus"]=='11')
                    $orderStatueBGColor = '#00CC66';
                    else
                    $orderStatueBGColor = '#FFFF99';
                    
                    $values 			= GetValues($row["intStyleId"]);
                    $bgColor			= "bcgcolor-tblrowWhite";
                    $totprofitMargin 	= ($row["dblFacProfit"]/$row["reaFOB"])*100;
                    $cmEarned 			= round($row["reaSMVRate"]*$row["reaSMV"],4);
                    $salesValue			= round($row["reaFOB"]* round($row["intQty"]),2);
                    
                    ?>
                    <tr class="<?php echo $bgColor;?>" onmouseover="this.style.background ='#FFFFFF';" onmouseout="this.style.background='';">
                    <td nowrap="nowrap" class="normalfnt" style="background:<?php echo $orderStatueBGColor;?>">&nbsp;<?php echo $row["oritOrderNo"]?>&nbsp;</td>
                    <td height="15" nowrap="nowrap" class="normalfnt"><a href="../../<?php echo $reportname?>?styleID=<?php echo $row["intStyleId"]?>" target="_blank" id="poreport" rel="1">&nbsp;<?php echo $row["strOrderNo"]?>&nbsp;</a></td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strStyle"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strDivision"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($row["intQty"],0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["reaExPercentage"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format((($row["intQty"]*$row["reaExPercentage"])/100),0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["reaFOB"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblFacProfit"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($totprofitMargin,2)?></td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($cmEarned,4)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($cmEarned * $row["intQty"],2)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[0],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[1],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[2],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[3],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[6],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[7],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[4],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[5],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($salesValue,2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/costestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="costestimatesheet.php" style="color:#00F"><u>Click Here</u></a></td>
                    <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/xclcostestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="xclcostestimatesheet.php" style="color:#00F"><u>Click Here</u></a></td>
                    <td nowrap="nowrap" class="normalfntRite" >&nbsp;&nbsp;</td>
                    </tr>
                    
                    <?php 
                    $totOrderQty 		+= round($row["intQty"],0);
                    $totExOrderQty 		+= round(($row["intQty"]*$row["reaExPercentage"])/100,0);
                    $totWithExOrderQty	+= round($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0);
                    $totFabricMatCost	+= round($values[0],4);
                    $totFabricMatValue	+= round($values[1],2);
                    $totOtherMatCost	+= round($values[2],4);
                    $totOtherMatValue	+= round($values[3],2);
                    $totMatCost			+= round($values[4],4);
                    $totMatValue		+= round($values[5],2);
                    $totWashCost		+= round($values[6],4);
                    $totWashValue		+= round($values[7],2);
                    $totCMEarnedPerPcs	+= round($cmEarned,4);
                    $totCMEarnedTotal	+= round($cmEarned * $row["intQty"],2);
                    $totSalesValue		+= $salesValue;
                    }
                    ?>
                    <tr bgcolor="#EAEAEA">
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td height="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedPerPcs,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedTotal,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWithExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totFabricMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totFabricMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOtherMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totOtherMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totSalesValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                    <td colspan="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    </tr>
                    </tbody>
                    </table></td>
                      </tr>
                    </table>
                    </form>			
                    </div>
                    
                    <div id="tabs-3" style="display: none;" class="tab_content">
                    <form id="tblTabs-3">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="91" border="0" cellpadding="0" cellspacing="2" >
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#00CC66" >Confirmed</td>
                      </tr>
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#FFFF99">Pending</td>
                      </tr>
                    </table></td>
                      </tr>
                      <tr>
                        <td><table width="100%" border="0" cellpadding="1" cellspacing="1" id="tblGRNDetails" bgcolor="#000000">
                    <thead>
                    <tr bgcolor="#CCCCCC" class="normalfntMid">
                    <th nowrap="nowrap">Orit Order No</th>
                    <th height="25" nowrap="nowrap" >&nbsp;Order No&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Style No&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Division&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Order Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Excess&nbsp;<br/>
                    %</th>
                    <th nowrap="nowrap">&nbsp;Excess&nbsp;<br/>
                    Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;FOB&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Profit&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Profit Margin&nbsp;<br/>
                    (PCS) %</th>
                    <th nowrap="nowrap">&nbsp;C&amp;M&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;C&amp;M Earned&nbsp;<br/>
                    (Order Qty)</th>
                    <th nowrap="nowrap">&nbsp;Total Order<br />
                    Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Fabric Mat Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Fabric Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap">&nbsp;Other Mat Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Other <br />
                    Cost Value&nbsp;(USD)</th>
                    <th nowrap="nowrap">&nbsp;Wash Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Wash <br />
                    Cost Value&nbsp;(USD)</th>
                    <th nowrap="nowrap">&nbsp;Total Cost &nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Cost Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap" title="Preorder FOB * Order Qty(Without Excess)">&nbsp;Sales Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap">HTML Order&nbsp;<br/>
                    Summary</th>
                    <th nowrap="nowrap">Excel Order <br/>
                    Summary </th>
                    <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="ctbody">
                    <?php
                    $totOrderQty 		= 0;
                    $totExOrderQty 		= 0;
                    $totWithExOrderQty	= 0;
                    $totFabricMatCost	= 0;
                    $totFabricMatValue	= 0;
                    $totOtherMatCost	= 0;
                    $totOtherMatValue	= 0;
                    $totMatCost			= 0;
                    $totMatValue		= 0;
                    $totWashCost		= 0;
                    $totWashValue		= 0;
                    $totCMEarnedPerPcs	= 0;
                    $totCMEarnedTotal	= 0;
                    $totSalesValue		= 0;
                    
                    $sql="select concat(date_format(O.dtmOrderDate,'%Y%m'),'',O.intCompanyOrderNo)as oritOrderNo,D.strDivision,O.reaFOB,O.dblFacProfit,O.intStyleId,O.strOrderNo,O.strStyle,O.intQty,O.reaExPercentage,O.reaSMVRate,O.reaSMV,O.intStatus,O.intOrderType from orders O inner join buyerdivisions D on D.intDivisionId=O.intDivisionId ";
                    
                    if($checkDate=="true")
                    {
                    if($txtDfrom!="")
                    {
                    $DateFromArray	= explode('/',$txtDfrom);
                    $formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
                    $sql.=" AND date(O.dtmOrderDate)>='$formatedFromDate' ";
                    }
                    if($txtDto!="")
                    {
                    $DateToArray	= explode('/',$txtDto);
                    $formatedToDate	= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
                    $sql.=" AND date(O.dtmOrderDate)<='$formatedToDate' ";
                    }
                    }
                    
                    if($chkDelDate=="true")
                    {
                    $sql .= " and O.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
                    if($delDfrom!="")
                    {
                    $delDfromArray	= explode('/',$delDfrom);
                    $formatedDelDfromArray	= $delDfromArray[2].'-'.$delDfromArray[1].'-'.$delDfromArray[0];
                    $sql .= "and date(DS.dtDateofDelivery)>='$formatedDelDfromArray' ";
                    }
                    if($delDto!="")
                    {
                    $delDToArray	= explode('/',$delDto);
                    $formatedDelDToArray	= $delDToArray[2].'-'.$delDToArray[1].'-'.$delDToArray[0];
                    $sql .= "and date(DS.dtDateofDelivery)<='$formatedDelDToArray' ";
                    }
                    $sql .= ")";
                    }
                    
                    if($buyer!="")
                    $sql .= "and O.intBuyerID='$buyer' ";
                    
                    if($division!="")
						$sql .= "and O.intDivisionId='$division' ";
						
                    $sql .= "and O.intOrderType='3' ";
                    
                    $sql.=" order by O.strOrderNo;";
                    $result=$db->RunQuery($sql);
                    while($row=mysql_fetch_array($result))
                    {
                    $orderType	= $row["intOrderType"];
                    
                    if($row["intStatus"]=='11')
                    $orderStatueBGColor = '#00CC66';
                    else
                    $orderStatueBGColor = '#FFFF99';
                    
                    $values 			= GetValues($row["intStyleId"]);
                    $bgColor			= "bcgcolor-tblrowWhite";
                    $totprofitMargin 	= ($row["dblFacProfit"]/$row["reaFOB"])*100;
                    $cmEarned 			= round($row["reaSMVRate"]*$row["reaSMV"],4);
                    $salesValue			= round($row["reaFOB"]* round($row["intQty"]),2);
                    
                    ?>
                    <tr class="<?php echo $bgColor;?>" onmouseover="this.style.background ='#FFFFFF';" onmouseout="this.style.background='';">
                    <td nowrap="nowrap" class="normalfnt" style="background:<?php echo $orderStatueBGColor;?>">&nbsp;<?php echo $row["oritOrderNo"]?>&nbsp;</td>
                    <td height="15" nowrap="nowrap" class="normalfnt"><a href="../../<?php echo $reportname?>?styleID=<?php echo $row["intStyleId"]?>" target="_blank" id="poreport" rel="1">&nbsp;<?php echo $row["strOrderNo"]?>&nbsp;</a></td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strStyle"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strDivision"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($row["intQty"],0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["reaExPercentage"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format((($row["intQty"]*$row["reaExPercentage"])/100),0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["reaFOB"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblFacProfit"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($totprofitMargin,2)?></td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($cmEarned,4)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($cmEarned * $row["intQty"],2)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[0],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[1],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[2],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[3],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[6],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[7],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[4],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[5],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($salesValue,2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/costestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="costestimatesheet.php" style="color:#00F"><u>Click Here</u></a></td>
                    <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/xclcostestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="xclcostestimatesheet.php" style="color:#00F"><u>Click Here</u></a></td>
                    <td nowrap="nowrap" class="normalfntRite" >&nbsp;&nbsp;</td>
                    </tr>
                    
                    <?php 
                    $totOrderQty 		+= round($row["intQty"],0);
                    $totExOrderQty 		+= round(($row["intQty"]*$row["reaExPercentage"])/100,0);
                    $totWithExOrderQty	+= round($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0);
                    $totFabricMatCost	+= round($values[0],4);
                    $totFabricMatValue	+= round($values[1],2);
                    $totOtherMatCost	+= round($values[2],4);
                    $totOtherMatValue	+= round($values[3],2);
                    $totMatCost			+= round($values[4],4);
                    $totMatValue		+= round($values[5],2);
                    $totWashCost		+= round($values[6],4);
                    $totWashValue		+= round($values[7],2);
                    $totCMEarnedPerPcs	+= round($cmEarned,4);
                    $totCMEarnedTotal	+= round($cmEarned * $row["intQty"],2);
                    $totSalesValue		+= $salesValue;
                    }
                    ?>
                    <tr bgcolor="#EAEAEA">
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td height="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedPerPcs,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedTotal,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWithExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totFabricMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totFabricMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOtherMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totOtherMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totSalesValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                    <td colspan="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    </tr>
                    </tbody>
                    </table></td>
                      </tr>
                    </table>
                    </form>			
                    </div>
                    
                    <div id="tabs-4" style="display: none;" class="tab_content">
                    <form id="tblTabs-4">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="91" border="0" cellpadding="0" cellspacing="2" >
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#00CC66" >Confirmed</td>
                      </tr>
                      <tr>
                        <td class="border-All-fntsize10" style="text-align:center" bgcolor="#FFFF99">Pending</td>
                      </tr>
                    </table></td>
                      </tr>
                      <tr>
                        <td><table width="100%" border="0" cellpadding="1" cellspacing="1" id="tblGRNDetails" bgcolor="#000000">
                    <thead>
                    <tr bgcolor="#CCCCCC" class="normalfntMid">
                    <th nowrap="nowrap">Orit Order No</th>
                    <th height="25" nowrap="nowrap" >&nbsp;Order No&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Style No&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Division&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Order Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Excess&nbsp;<br/>
                    %</th>
                    <th nowrap="nowrap">&nbsp;Excess&nbsp;<br/>
                    Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;FOB&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Profit&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Profit Margin&nbsp;<br/>
                    (PCS) %</th>
                    <th nowrap="nowrap">&nbsp;C&amp;M&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;C&amp;M Earned&nbsp;<br/>
                    (Order Qty)</th>
                    <th nowrap="nowrap">&nbsp;Total Order<br />
                    Qty&nbsp;</th>
                    <th nowrap="nowrap">&nbsp;Fabric Mat Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Fabric Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap">&nbsp;Other Mat Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Other <br />
                    Cost Value&nbsp;(USD)</th>
                    <th nowrap="nowrap">&nbsp;Wash Cost&nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Wash <br />
                    Cost Value&nbsp;(USD)</th>
                    <th nowrap="nowrap">&nbsp;Total Cost &nbsp;<br/>
                    (PCS)</th>
                    <th nowrap="nowrap">&nbsp;Total Cost Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap" title="Preorder FOB * Order Qty(Without Excess)">&nbsp;Sales Value&nbsp;<br/>
                    (USD)</th>
                    <th nowrap="nowrap">HTML Order&nbsp;<br/>
                    Summary</th>
                    <th nowrap="nowrap">Excel Order <br/>
                    Summary </th>
                    <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="ctbody">
                    <?php
                    $totOrderQty 		= 0;
                    $totExOrderQty 		= 0;
                    $totWithExOrderQty	= 0;
                    $totFabricMatCost	= 0;
                    $totFabricMatValue	= 0;
                    $totOtherMatCost	= 0;
                    $totOtherMatValue	= 0;
                    $totMatCost			= 0;
                    $totMatValue		= 0;
                    $totWashCost		= 0;
                    $totWashValue		= 0;
                    $totCMEarnedPerPcs	= 0;
                    $totCMEarnedTotal	= 0;
                    $totSalesValue		= 0;
                    
                    $sql="select concat(date_format(O.dtmOrderDate,'%Y%m'),'',O.intCompanyOrderNo)as oritOrderNo,D.strDivision,O.reaFOB,O.dblFacProfit,O.intStyleId,O.strOrderNo,O.strStyle,O.intQty,O.reaExPercentage,O.reaSMVRate,O.reaSMV,O.intStatus,O.intOrderType from orders O inner join buyerdivisions D on D.intDivisionId=O.intDivisionId ";
                    
                    if($checkDate=="true")
                    {
                    if($txtDfrom!="")
                    {
                    $DateFromArray	= explode('/',$txtDfrom);
                    $formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
                    $sql.=" AND date(O.dtmOrderDate)>='$formatedFromDate' ";
                    }
                    if($txtDto!="")
                    {
                    $DateToArray	= explode('/',$txtDto);
                    $formatedToDate	= $DateToArray[2].'-'.$DateToArray[1].'-'.$DateToArray[0];
                    $sql.=" AND date(O.dtmOrderDate)<='$formatedToDate' ";
                    }
                    }
                    
                    if($chkDelDate=="true")
                    {
                    $sql .= " and O.intStyleId in ( select distinct O.intStyleId from orders O INNER JOIN deliveryschedule DS ON O.intStyleId = DS.intStyleId ";
                    if($delDfrom!="")
                    {
                    $delDfromArray	= explode('/',$delDfrom);
                    $formatedDelDfromArray	= $delDfromArray[2].'-'.$delDfromArray[1].'-'.$delDfromArray[0];
                    $sql .= "and date(DS.dtDateofDelivery)>='$formatedDelDfromArray' ";
                    }
                    if($delDto!="")
                    {
                    $delDToArray	= explode('/',$delDto);
                    $formatedDelDToArray	= $delDToArray[2].'-'.$delDToArray[1].'-'.$delDToArray[0];
                    $sql .= "and date(DS.dtDateofDelivery)<='$formatedDelDToArray' ";
                    }
                    $sql .= ")";
                    }
                    
                    if($buyer!="")
                   	 	$sql .= "and O.intBuyerID='$buyer' ";
                    
                    if($division!="")
						$sql .= "and O.intDivisionId='$division' ";
						
                    $sql .= "and O.intOrderType='4' ";
                    
                    $sql.=" order by O.strOrderNo;";
                    $result=$db->RunQuery($sql);
                    while($row=mysql_fetch_array($result))
                    {
                    $orderType	= $row["intOrderType"];
                    
                    if($row["intStatus"]=='11')
                    $orderStatueBGColor = '#00CC66';
                    else
                    $orderStatueBGColor = '#FFFF99';
                    
                    $values 			= GetValues($row["intStyleId"]);
                    $bgColor			= "bcgcolor-tblrowWhite";
                    $totprofitMargin 	= ($row["dblFacProfit"]/$row["reaFOB"])*100;
                    $cmEarned 			= round($row["reaSMVRate"]*$row["reaSMV"],4);
                    $salesValue			= round($row["reaFOB"]* round($row["intQty"]),2);
                    
                    ?>
                    <tr class="<?php echo $bgColor;?>" onmouseover="this.style.background ='#FFFFFF';" onmouseout="this.style.background='';">
                    <td nowrap="nowrap" class="normalfnt" style="background:<?php echo $orderStatueBGColor;?>">&nbsp;<?php echo $row["oritOrderNo"]?>&nbsp;</td>
                    <td height="15" nowrap="nowrap" class="normalfnt"><a href="../../<?php echo $reportname?>?styleID=<?php echo $row["intStyleId"]?>" target="_blank" id="poreport" rel="1">&nbsp;<?php echo $row["strOrderNo"]?>&nbsp;</a></td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strStyle"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strDivision"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($row["intQty"],0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["reaExPercentage"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format((($row["intQty"]*$row["reaExPercentage"])/100),0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["reaFOB"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo $row["dblFacProfit"]?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($totprofitMargin,2)?></td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($cmEarned,4)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($cmEarned * $row["intQty"],2)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0)?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[0],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[1],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[2],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[3],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[6],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[7],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($values[4],4);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($values[5],2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<?php echo number_format($salesValue,2);?>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/costestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="costestimatesheet.php" style="color:#00F"><u>Click Here</u></a></td>
                    <td nowrap="nowrap" class="normalfnt" ><a href="../../costestimatesheet/xclcostestimatesheet.php?StyleID=<?php echo $row["intStyleId"]; ?>" target="xclcostestimatesheet.php" style="color:#00F"><u>Click Here</u></a></td>
                    <td nowrap="nowrap" class="normalfntRite" >&nbsp;&nbsp;</td>
                    </tr>
                    
                    <?php 
                    $totOrderQty 		+= round($row["intQty"],0);
                    $totExOrderQty 		+= round(($row["intQty"]*$row["reaExPercentage"])/100,0);
                    $totWithExOrderQty	+= round($row["intQty"]+(($row["intQty"]*$row["reaExPercentage"])/100),0);
                    $totFabricMatCost	+= round($values[0],4);
                    $totFabricMatValue	+= round($values[1],2);
                    $totOtherMatCost	+= round($values[2],4);
                    $totOtherMatValue	+= round($values[3],2);
                    $totMatCost			+= round($values[4],4);
                    $totMatValue		+= round($values[5],2);
                    $totWashCost		+= round($values[6],4);
                    $totWashValue		+= round($values[7],2);
                    $totCMEarnedPerPcs	+= round($cmEarned,4);
                    $totCMEarnedTotal	+= round($cmEarned * $row["intQty"],2);
                    $totSalesValue		+= $salesValue;
                    }
                    ?>
                    <tr bgcolor="#EAEAEA">
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td height="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedPerPcs,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totCMEarnedTotal,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWithExOrderQty,0);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totFabricMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totFabricMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totOtherMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totOtherMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totWashValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo number_format($totMatCost,4);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totMatValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;<b><?php echo number_format($totSalesValue,2);?></b>&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    <td nowrap="nowrap" class="normalfntRite" bgcolor="#EAEAEA">&nbsp;</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                    <td colspan="25" nowrap="nowrap" class="normalfnt">&nbsp;</td>
                    </tr>
                    </tbody>
                    </table></td>
                      </tr>
                    </table>
                    </form>			
                    </div>
               </div>
			</div>	
			</td>
		</tr>
	</table>
	</td>
  </tr>
</table>
</body>
</html>
<?php
function  GetValues($styleId)
{
global $db;
$array = array();
	$sql="select COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=1),0)as totalFabCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=1),0)as totalValue,
	COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(2,3,4,5)),0)as totalOtherCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(2,3,4,5)),0)as totalOtherValue,
	COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId'),0)as grandTotalFabCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId'),0)as grandTotalValue,
	COALESCE((select sum(OD.dbltotalcostpc) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(6)),0)as totalWashCostPc,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID in(6)),0)as totalWashValue;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["totalFabCostPc"];
		$array[1] = $row["totalValue"];
		$array[2] = $row["totalOtherCostPc"];
		$array[3] = $row["totalOtherValue"];
		$array[4] = $row["grandTotalFabCostPc"];
		$array[5] = $row["grandTotalValue"];
		$array[6] = $row["totalWashCostPc"];
		$array[7] = $row["totalWashValue"];
	}
	return $array;
}

function GetBuyerName($buyer)
{
global $db;
	$sql="select strName from buyers where intBuyerID='$buyer'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strName"];
	}
}
?>