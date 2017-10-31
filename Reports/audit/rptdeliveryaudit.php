<?php
	session_start();

	$option		= $_GET["opt"];
	$styleCode	= $_GET["stylecode"];
	$fromDate   = $_GET["frmdate"];
	$toDate		= $_GET["todate"];


	$backwardseperator = "../../";

	include "../../Connector.php"; 
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delivery Schedule Audit Report</title>

<link href="../../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<script src="../../js/jquery.min.js" type="text/javascript"></script>
<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


<style type="text/css">
.setpadding{padding-top: 20px; }
.changedItem{background-color: #ffcc33; }
.columnHeader{font-family: "Tahoma"; font-size: 12px; font-weight: bold;}
.lineDetails{font-family: "Tahoma"; font-size: 12px;}
.colHE-box{font-family: "Tahoma"; font-size: 11px; font-weight: bold; border:#000000 1px solid;}
.colHE-TRB{font-family: "Tahoma"; font-size: 11px; font-weight: bold; border-top:#000000 1px solid; 
			border-right: #000000 1px solid; border-bottom: #000000 1px solid; }
.colHE-pad{padding: 5px 5px 5px 5px;}
.colHE-hight{height:43px;}
.colHE-LR{border-left: #000000 1px solid; border-right: #000000 1px solid;}
.colLI-box{font-family: "Tahoma"; font-size: 11px; border:#000000 1px solid; margin: 0px;}
.colLI-TRB{font-family: "Tahoma"; font-size: 11px; border-top:#000000 1px solid; 
			border-right: #000000 1px solid; border-bottom: #000000 1px solid;}
.qtyText{text-align: right;}
.colLI-hight{height:27px;}
.jumbotron{padding: 0.5em 0.6em;
    h2 {
        font-size: 2em;
    }
}
.bg-removeItems{background-color:#ff6666;}
.bg-newItems{background-color: #00cc00;}
.bg-modified{background-color: #9a9ae5;}
th{padding: 2px 2px 2px 2px; border:#000000 1px solid; font-family: "Tahoma"; font-size: 11px; font-weight: bold;}
.col-1{padding: 2px 2px 2px 2px; border:#000000 1px solid; font-family: "Tahoma"; font-size: 11px;}
.col-2{padding: 2px 2px 2px 2px; border-top:#000000 1px solid; border-right:#000000 1px solid; border-bottom:#000000 1px solid;font-family: "Tahoma"; font-size: 11px;}
.changeHighlight{background-color:#F4FA58; }
a{color: #000000;}


</style>
</head>
<body>
<div class="container">
	<div class="row">
		
		
<?php

	switch($option){

		case "1": # Get delivery information to audit by selected Style / SC#

			#  ====================================================================
			// Get Style information 
			#  ====================================================================
			$arrStyleInfor = mysql_fetch_row(GetStyleInfor($styleCode));

			$scNo 		= $arrStyleInfor[0];
			$styleId 	= $arrStyleInfor[1];
			$styleDesc	= $arrStyleInfor[2];
			$buyer      = $arrStyleInfor[3];
?>					
			
			<div class="col-lg-1">&nbsp;</div>
			<div class="col-lg-8">
				<div class="jumbotron">
					<h3>Delivery Schedule Audit Report</h3>
				</div>	
			</div>
			<div class="col-lg-12">&nbsp;</div>		
			<div class="col-lg-1">&nbsp;</div>
			<div class="col-lg-1 col-md-1 columnHeader">&nbsp;Style ID</div>
			<div class="col-lg-2 lineDetails"><?php echo $styleId; ?></div>
			<div class="col-lg-1 columnHeader">&nbsp;Description</div>
			<div class="col-lg-6 lineDetails"><?php echo $styleDesc; ?></div>
			<div class="col-lg-12">&nbsp;</div>
			<div class="col-lg-1">&nbsp;</div>
			<div class="col-lg-1 columnHeader">&nbsp;SC NO</div>
			<div class="col-lg-2 lineDetails"><?php echo $scNo; ?></div>
			<div class="col-lg-1 columnHeader">&nbsp;Buyer </div>
			<div class="col-lg-6 lineDetails"><?php echo $buyer; ?></div>
			<div class="col-lg-12 setpadding">&nbsp;</div>	
			<div class="col-lg-1">&nbsp;</div>
			<div class="col-lg-1 colHE-box colHE-pad colHE-hight" >Buyer PO No</div>
			<div class="col-lg-1 colHE-TRB colHE-pad colHE-hight qtyText">Quantity</div>
			<div class="col-lg-1 colHE-TRB colHE-pad colHE-hight">Delivery Date</div>
			<div class="col-lg-1 colHE-TRB colHE-pad colHE-hight">Hand Over Date</div>
			<div class="col-lg-1 colHE-TRB colHE-pad colHE-hight">Estimated Date</div>
			<div class="col-lg-2 colHE-TRB colHE-pad colHE-hight">Changed User</div>
			<div class="col-lg-1 colHE-TRB colHE-pad colHE-hight">Changed Date</div>
			<div class="col-lg-3" style="height:40px;">&nbsp;</div>
			<div class="col-lg-12">&nbsp;</div>

<?php
			
			# ======================================================================================
			// Get the delivery lines are in deliveryschedule but not in the delivery history
			# ======================================================================================
			$sqlQuery = " SELECT * FROM deliveryschedule 
                          WHERE deliveryschedule.intStyleId = '$styleCode' AND deliveryschedule.intBPO NOT IN(select history_deliveryschedule.intBPO  from history_deliveryschedule WHERE history_deliveryschedule.intStyleId = deliveryschedule.intStyleId )";


            $rsNewItems = $db->RunQuery($sqlQuery);

            if(mysql_num_rows($rsNewItems)>0){echo "<div class='col-lg-1'>&nbsp;</div>
					<div class='col-lg-8 colHE-box colHE-pad bg-newItems'>New Added Details</div><div class='col-lg-3' style='height:40px;'>&nbsp;</div>";}
           
            while($rowNewItems = mysql_fetch_array($rsNewItems)){

            	$bpoNo 			= $rowNewItems["intBPO"];
            	$bpoQty			= number_format($rowNewItems["dblQty"]);
            	$DeliveryDate 	= date('Y-m-d',strtotime($rowNewItems["dtDateofDelivery"]));
            	$HandOverDate 	= $rowNewItems["dtmHandOverDate"];
            	$EstimatedDate	= $rowNewItems["estimatedDate"];
            	$userID			= $rowNewItems["intUserId"];
            	$dtDate      	= $rowNewItems["dtmDate"];

            	$userName      = GetUserName($userID);

            	echo "<div class='col-lg-1'>&nbsp;</div><div class='col-lg-1 colLI-box colHE-pad'>$bpoNo</div><div class='col-lg-1 colLI-TRB colHE-pad qtyText'>$bpoQty</div><div class='col-lg-1 colLI-TRB colHE-pad'>$DeliveryDate</div><div class='col-lg-1 colLI-TRB colHE-pad'>$HandOverDate</div><div class='col-lg-1 colLI-TRB colHE-pad'>$EstimatedDate</div><div class='col-lg-2 colLI-TRB colHE-pad '>$userName</div><div class='col-lg-1 colLI-TRB colHE-pad'>$dtDate</div><div class='col-lg-3 colHE-pad'>&nbsp;</div>";
            }  

            # ======================================================================================

            # =======================================================================================
			// Get the delivery lines are in history deliveryschedule but not in the deliveryschedule
			# =======================================================================================

			$sqlQuery = " SELECT * FROM history_deliveryschedule
                           WHERE history_deliveryschedule.intStyleId = '$styleCode' AND history_deliveryschedule.intBPO NOT IN(select deliveryschedule.intBPO  from deliveryschedule WHERE history_deliveryschedule.intStyleId = deliveryschedule.intStyleId)";

            $rsRemoveItems = $db->RunQuery($sqlQuery);   

            if(mysql_num_rows($rsRemoveItems)>0){echo "<div class='col-lg-12'>&nbsp;</div><div class='col-lg-1'>&nbsp;</div>
					<div class='col-lg-8 colHE-box colHE-pad bg-removeItems'>Removed Items</div><div class='col-lg-3' style='height:40px;'>&nbsp;</div>";}  

			while($rowRemovedItems = mysql_fetch_array($rsRemoveItems)){

            	$bpoNo 			= $rowRemovedItems["intBPO"];
            	$bpoQty			= $rowRemovedItems["dblQty"];
            	$DeliveryDate 	= date('Y-m-d',strtotime($rowRemovedItems["dtDateofDelivery"]));
            	$HandOverDate 	= $rowRemovedItems["dtmHandOverDate"];
            	$EstimatedDate	= $rowRemovedItems["estimatedDate"];
            	$userID			= $rowRemovedItems["AuditUser"];
            	$dtDate      	= date('Y-m-d',strtotime($rowRemovedItems["AuditDate"]));

            	$userName      = GetUserName($userID);

            	echo "<div class='col-lg-1'>&nbsp;</div><div class='col-lg-1 colLI-box colHE-pad'>$bpoNo</div><div class='col-lg-1 colLI-TRB colHE-pad qtyText'>$bpoQty</div><div class='col-lg-1 colLI-TRB colHE-pad'>$DeliveryDate</div><div class='col-lg-1 colLI-TRB colHE-pad'>$HandOverDate</div><div class='col-lg-1 colLI-TRB colHE-pad'>&nbsp;$EstimatedDate</div><div class='col-lg-2 colLI-TRB colHE-pad'>&nbsp;$userName</div><div class='col-lg-1 colLI-TRB colHE-pad'>$dtDate</div><div class='col-lg-3 colHE-pad'>&nbsp;</div>";
            }  		         
            # =======================================================================================

            # =======================================================================================
			// Get Modified delivery lines 
			# =======================================================================================

			echo "<div class='col-lg-12'>&nbsp;</div><div class='col-lg-1'>&nbsp;</div>
					<div class='col-lg-8 colHE-box colHE-pad bg-modified'>Modified Items</div><div class='col-lg-3' style='height:40px;'>&nbsp;</div>";

            $sqlPOList = " SELECT deliveryschedule.intBPO FROM deliveryschedule WHERE deliveryschedule.intStyleId =  '$styleCode' ";

            $rsBPOList = $db->RunQuery($sqlPOList);

            while($rowBPOList = mysql_fetch_array($rsBPOList)){

            	$strBPONo = $rowBPOList["intBPO"];


            	$rsBPOChanged = GetDeliveryChanges(1, $styleCode, $strBPONo, "", "");

				while($rowBPOChanged = mysql_fetch_array($rsBPOChanged)){

					$bpoNo 			= $strBPONo;
	            	$bpoQty			= number_format($rowBPOChanged["HisQty"]);
	            	$DeliveryDate 	= date('Y-m-d',strtotime($rowBPOChanged["HisDeliveryDate"]));
	            	$HandOverDate 	= date('Y-m-d',strtotime($rowBPOChanged["HisHODate"]));
	            	$EstimatedDate	= date('Y-m-d', strtotime($rowBPOChanged["HisEstimateDate"]));
	            	$userID			= $rowBPOChanged["AuditUser"];
	            	$dtDate      	= $rowBPOChanged["AuditDate"];
	            	$IsDeliDateChanged 	= $rowBPOChanged["DeliDateChange"];
	            	$IsQtyChanged		= $rowBPOChanged["QtyChange"];
	            	$IsHOChanged		= $rowBPOChanged["HandOverChanged"];
	            	$IsEstiChanged		= $rowBPOChanged["EstChanged"];

            		$userName      = GetUserName($userID);

            		$lineHTML		= "";

            		if(($IsQtyChanged == '1') || ($IsDeliDateChanged == '1') || ($IsHOChanged == '1') || ($IsEstiChanged == '1')){

            			$lineHTML 		= "<div class='col-lg-1'>&nbsp;</div><div class='col-lg-1 colLI-box colHE-pad'>$bpoNo</div>";

            			if($IsQtyChanged == '1')
            				$lineHTML .= "<div class='col-lg-1 changedItem colLI-TRB colHE-pad qtyText'>$bpoQty</div>";
            			else
            				$lineHTML .= "<div class='col-lg-1 colLI-TRB colHE-pad qtyText'>$bpoQty</div>";

            			if($IsDeliDateChanged == '1')
            				$lineHTML .="<div class='col-lg-1 changedItem colLI-TRB colHE-pad'>$DeliveryDate</div>"	;
	            		else
	            			$lineHTML .= "<div class='col-lg-1 colLI-TRB colHE-pad'>$DeliveryDate</div>";

	            		if($IsHOChanged == '1')
	            			$lineHTML .= "<div class='col-lg-1 changedItem colLI-TRB colHE-pad'>$HandOverDate</div>";
	            		else
	            			$lineHTML .= "<div class='col-lg-1 colLI-TRB colHE-pad'>$HandOverDate</div>";

	            		if($IsEstiChanged == '1')
	            			$lineHTML .= "<div class='col-lg-1 changedItem colLI-TRB colHE-pad'>$EstimatedDate</div>";
	            		else
	            			$lineHTML .= "<div class='col-lg-1 colLI-TRB colHE-pad'>$EstimatedDate</div>";

	            		$lineHTML .= "<div class='col-lg-2 colLI-TRB colHE-pad'>$userName</div><div class='col-lg-1 colLI-TRB colHE-pad'>$dtDate</div><div class='col-lg-3 colHE-pad'>&nbsp;</div>";

	            		echo $lineHTML;
            		}
					
				}
            }
            # =======================================================================================

		break;

		case 2:
?>
			<div class="col-lg-12">
				<div class="jumbotron">
					<h3>Delivery Schedule Audit Report</h3>
				</div>	
			</div>
			<div class="col-lg-1">&nbsp;</div>
				<div class="col-lg-11 columnHeader">&nbsp;Report From <?php echo $fromDate; ?> To <?php echo $toDate; ?></div>
			<div class="col-lg-12">
				<table width="100%">
					<thead>
						<tr>
							<th width="5%">SC No</th>
							<th width="10%">Style ID</th>	
							<th width="12%">Description</th>
							<th width="12%">Buyer</th>
							<th width="5%">Buyer PO No</th>
							<th width="5%">Quantity</th>
							<th width="5%">Delivery Date</th>
							<th width="5%">Had Over Date</th>
							<th width="5%">Estimated Date</th>
							<th width="5%">Changed By</th>
							<th width="5%">Chnaged Date</th>

						</tr>
					</thead>
					<tbody>
				<?php

						$rsDeliveryDetails = GetDeliveryChanges($option, "-1", "-1",$fromDate, $toDate);
						//echo mysql_num_rows($rsDeliveryDetails);
						while($rowDeliveryDetails = mysql_fetch_array($rsDeliveryDetails)){

							$bpoNo 				= $rowDeliveryDetails["intBPO"];
			            	$bpoQty				= number_format($rowDeliveryDetails["HisQty"]);
			            	$DeliveryDate 		= date('Y-m-d',strtotime($rowDeliveryDetails["HisDeliveryDate"]));
			            	$HandOverDate 		= date('Y-m-d',strtotime($rowDeliveryDetails["HisHODate"]));
			            	$EstimatedDate		= date('Y-m-d', strtotime($rowDeliveryDetails["HisEstimateDate"]));
			            	$userID				= $rowDeliveryDetails["AuditUser"];
			            	$dtDate      		= $rowDeliveryDetails["AuditDate"];
			            	$IsDeliDateChanged 	= $rowDeliveryDetails["DeliDateChange"];
			            	$IsQtyChanged		= $rowDeliveryDetails["QtyChange"];
			            	$IsHOChanged		= $rowDeliveryDetails["HandOverChanged"];
			            	$IsEstiChanged		= $rowDeliveryDetails["EstChanged"];
			            	$SCNO 				= $rowDeliveryDetails["intSRNO"];
			            	$styleID   			= $rowDeliveryDetails["strStyle"];
			            	$StyleDescrip		= $rowDeliveryDetails["strDescription"];
			            	$Buyer          	= $rowDeliveryDetails["strName"];
			            	$CurrentDeliveryDate = date('Y-m-d',strtotime($rowDeliveryDetails["CurrentDeliveryDate"]));
			            	$CurrentHODate       = date('Y-m-d',strtotime($rowDeliveryDetails["CurrentHODate"]));
			            	$CurrentEstimateDate = date('Y-m-d',strtotime($rowDeliveryDetails["CurrentHODate"]));
			            	$CurrentQty          = $rowDeliveryDetails["CurrentDeliveryQty"];

		            		$userName      = GetUserName($userID);	

		            		if(($IsQtyChanged == '1') || ($IsDeliDateChanged == '1') || ($IsHOChanged == '1') || ($IsEstiChanged == '1')){

		            		  	$lineHTML .= "<tr><td class='col-1'>$SCNO</td><td class='col-2'>$styleID</td><td class='col-2'>$StyleDescrip</td><td class='col-2'>$Buyer</td><td class='col-2'>$bpoNo</td>";

		            		  	if($IsQtyChanged == '1')
		            		  		$lineHTML .= "<td class='col-2 qtyText changeHighlight'><a class='tip' href='#' data-toggle='tooltip' title='$CurrentQty'>$bpoQty</a></td>";
		            		  	else
		            		  		$lineHTML .= "<td class='col-2 qtyText'>$bpoQty</td>";

		            		  	if($IsDeliDateChanged == '1')
		            		  		$lineHTML .= "<td class='col-2 changeHighlight'><a class='tip' href='#' data-toggle='tooltip' title='$CurrentDeliveryDate'>$DeliveryDate</a></td>";
		            		  	else	
		            		  		$lineHTML .= "<td class='col-2'>$DeliveryDate</td>";

		            		  	if($IsHOChanged == '1')
		            		  		$lineHTML .= "<td class='col-2 changeHighlight'><a class='tip' href='#' data-toggle='tooltip' title='$CurrentHODate'>$HandOverDate</a></td>";
		            		  	else	
		            		  		$lineHTML .= "<td class='col-2'>$HandOverDate</td>";	

		            		  	if($IsEstiChanged == '1')
		            		  		$lineHTML .= "<td class='col-2 changeHighlight'><a class='tip' href='#' data-toggle='tooltip' title='$CurrentEstimateDate'>$EstimatedDate</a></td>";
		            		  	else	
		            		  		$lineHTML .= "<td class='col-2'>$EstimatedDate</td>";		


		            		  	$lineHTML .= "<td class='col-2'>$userName</td><td class='col-2'>$dtDate</td></tr>";


		            		}		

						}

						echo $lineHTML;

				?>		

					</tbody>
				</table>
			</div>
			
			

<?php

		break;

	}

?>
				
	</div>
</div>	

<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});

</script>
</body>



</html>

<?php 

	function GetUserName($prmUserId){


		global $db;

		$sql = " SELECT useraccounts.UserName, useraccounts.Name
                 FROM useraccounts
                 WHERE useraccounts.intUserID =  '$prmUserId'";

        $rsUsers = $db->RunQuery($sql);
                 
        $arrResults = mysql_fetch_row($rsUsers);

        $UsersName	= $arrResults[1];

        return $UsersName;

	}

	function GetStyleInfor($styleCode){

		global $db;

		$sql = " SELECT specification.intSRNO, orders.strStyle, orders.strDescription, buyers.strName
                 FROM specification Inner Join orders ON specification.intStyleId = orders.intStyleId Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
                 WHERE specification.intStyleId = '$styleCode'";


         $rsStyleDetails = $db->RunQuery($sql);

         return $rsStyleDetails;
	}

	function GetDeliveryChanges($option, $StyleId, $BuyerPO, $FromDate, $ToDate){


		global $db;

		switch ($option) {
			case '1':

				$sql =  "   SELECT DISTINCT deliveryschedule.dtDateofDelivery AS CurrentDeliveryDate, 
            	         		deliveryschedule.dblQty AS CurrentDeliveryQty, deliveryschedule.dtmHandOverDate AS CurrentHODate,
						 		deliveryschedule.estimatedDate AS CurrentEstimateDate, history_deliveryschedule.dtDateofDelivery AS HisDeliveryDate, history_deliveryschedule.dblQty AS HisQty, history_deliveryschedule.dtmHandOverDate AS HisHODate, history_deliveryschedule.estimateddate AS HisEstimateDate, history_deliveryschedule.AuditUser,
								STR_TO_DATE(history_deliveryschedule.AuditDate, '%Y-%m-%d') AS AuditDate,
								IF(deliveryschedule.dtDateofDelivery != history_deliveryschedule.dtDateofDelivery,1 ,0) AS DeliDateChange,
								IF(deliveryschedule.dblQty != history_deliveryschedule.dblQty,1,0) AS QtyChange,
								IF(deliveryschedule.dtmHandOverDate != history_deliveryschedule.dtmHandOverDate,1,0) AS HandOverChanged,
								IF(deliveryschedule.estimatedDate != history_deliveryschedule.estimateddate,1,0) AS EstChanged
							FROM deliveryschedule Inner Join history_deliveryschedule ON deliveryschedule.intStyleId = history_deliveryschedule.intStyleId AND deliveryschedule.intBPO = history_deliveryschedule.intBPO
							WHERE deliveryschedule.intStyleId =  '$StyleId' AND deliveryschedule.intBPO = '$BuyerPO'";
				
				break;
			
			case '2':
				$sql = " SELECT DISTINCT deliveryschedule.dtDateofDelivery AS CurrentDeliveryDate,
								deliveryschedule.dblQty AS CurrentDeliveryQty, deliveryschedule.dtmHandOverDate AS CurrentHODate,
								deliveryschedule.estimatedDate AS CurrentEstimateDate, history_deliveryschedule.dtDateofDelivery AS HisDeliveryDate, history_deliveryschedule.dblQty AS HisQty, history_deliveryschedule.dtmHandOverDate AS HisHODate, history_deliveryschedule.estimateddate AS HisEstimateDate,
								history_deliveryschedule.AuditUser, 
								STR_TO_DATE(history_deliveryschedule.AuditDate,'%Y-%m-%d') AS AuditDate,
								IF(deliveryschedule.dtDateofDelivery != history_deliveryschedule.dtDateofDelivery,1 ,0) AS DeliDateChange,
								IF(deliveryschedule.dblQty != history_deliveryschedule.dblQty,1,0) AS QtyChange,
								IF(deliveryschedule.dtmHandOverDate != history_deliveryschedule.dtmHandOverDate,1,0) AS HandOverChanged,
								IF(deliveryschedule.estimatedDate != history_deliveryschedule.estimateddate,1,0) AS EstChanged,
								specification.intSRNO, orders.strStyle, orders.strDescription, buyers.strName, 
								history_deliveryschedule.intBPO
						FROM deliveryschedule Inner Join history_deliveryschedule ON deliveryschedule.intStyleId = history_deliveryschedule.intStyleId AND deliveryschedule.intBPO = history_deliveryschedule.intBPO
							Inner Join specification ON deliveryschedule.intStyleId = specification.intStyleId
							Inner Join orders ON specification.intStyleId = orders.intStyleId Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
						WHERE history_deliveryschedule.AuditDate BETWEEN '$FromDate' AND '$ToDate'
						ORDER BY specification.intSRNO, history_deliveryschedule.AuditDate ";
				break;
		}
		
		$result = $db->RunQuery($sql);

		return $result;
		
	}

	
?>