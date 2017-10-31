<?php

session_start();
include '../Connector.php';

$arrWeeks = array();

//Get distinct year an month
$sqlGetWeeks = " SELECT DISTINCT consolidated_forcast.ForcastYear, consolidated_forcast.WeekOfYear 
                 FROM consolidated_forcast order by ForcastYear, WeekOfYear ";

$resWeeks = $db->RunQuery($sqlGetWeeks);

$i = 0;

?>

<html>
	<head>
		<title>Consolidate Report</title>
		<link href="../css/report.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<table width='100%' >
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
				<td width="100%">
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
						<thead>
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td><td colspan="10" class="reportHeader textHeader">&nbsp;Consolidated Report	</td></tr>
							<tr><td>&nbsp;</td></tr>
							<!-- Header section -->
							<tr><td width="10%">&nbsp;</td>
								<td width="10%" class="textInLeft textHeader fullBorder headerBackground">&nbsp;SC #</td>
								<td width="40%" class="textInLeft textHeader topBorder rightBorder bottomBorder headerBackground">&nbsp;Item</td>
								<td width="10%" class="textInLeft textHeader topBorder rightBorder bottomBorder headerBackground">&nbsp;Type</td>
								<td width="5%" class="textInLeft textHeader topBorder rightBorder bottomBorder headerBackground">&nbsp;</td>
								<?php
									while($rowWeeks = mysql_fetch_array($resWeeks)){

										echo "<td width='5%' class='textInRight topBorder rightBorder bottomBorder textHeader headerBackground'>".$rowWeeks[ForcastYear]."-".$rowWeeks[WeekOfYear]."&nbsp;</td>";

										$arrWeeks[] = $rowWeeks[ForcastYear].$rowWeeks[WeekOfYear];

									}

								?>
							</tr>
						</thead>
						<!-- End of header section -->
						<tbody>

							<?php

								
								$sqlStyleCodeList = " SELECT DISTINCT consolidated_forcast.StyleID, consolidated_forcast.ModelCode, 
								                                      specification.intSRNO, orders.strStyle, orders.strDescription 
												      FROM consolidated_forcast Inner Join specification ON consolidated_forcast.StyleID = specification.intStyleId Inner Join orders ON specification.intStyleId = orders.intStyleId order by consolidated_forcast.StyleID ";

								$resStyleCodeList = $db->RunQuery($sqlStyleCodeList);

								while($rowStyCodeleList = mysql_fetch_array($resStyleCodeList)){

									$WeekConsolidateQty = array();

									$styleCode 			= $rowStyCodeleList["StyleID"];
									$scNo 				= $rowStyCodeleList["intSRNO"];
									$itemDescription 	= $rowStyCodeleList["strDescription"];
									$styleID 			= $rowStyCodeleList["strStyle"];

									//Get total of consolidated qty
									$sqlConsolidateQty = " SELECT Sum(consolidated_forcast.ForcastQty) as TotConsolidateQty 
								                           FROM consolidated_forcast WHERE consolidated_forcast.StyleID =  '$styleCode'";

								    $resConsolidateQty = $db->RunQuery($sqlConsolidateQty);
								    
								    $arrConsolidateQty = mysql_fetch_row($resConsolidateQty);

								    $dblTotalConsolidateQty =   $arrConsolidateQty[0];                       	
								    // ==================================                       

									$strHTMLElement  	= "<tr><td>&nbsp;</td><td class='textInLeft leftBorder bottomBorder rightBorder consolidateBackground'>&nbsp;$scNo</td><td class='textInLeft bottomBorder rightBorder consolidateBackground'>&nbsp;$itemDescription</td><td class='textInLeft bottomBorder rightBorder consolidateBackground'>&nbsp;$styleID</td><td class='textInRight bottomBorder rightBorder consolidateBackground'>".number_format($dblTotalConsolidateQty)."&nbsp;</td>";


									$iWeekYearArraySize = count($arrWeeks);

									for($iArrCount = 0; $iArrCount<$iWeekYearArraySize; $iArrCount++){

										$iWeekYearInArray = $arrWeeks[$iArrCount];

										//Get all consolidated information for given style
										$sqlStyleList = " SELECT consolidated_forcast.ImanNo, consolidated_forcast.ForcastQty, specification.intSRNO, orders.strStyle, orders.strDescription 
														  FROM consolidated_forcast Inner Join specification ON consolidated_forcast.StyleID = specification.intStyleId Inner Join orders ON specification.intStyleId = orders.intStyleId
														  WHERE consolidated_forcast.StyleID =  '$styleCode' AND concat(consolidated_forcast.ForcastYear,consolidated_forcast.WeekOfYear) = $iWeekYearInArray ";

										$resStyleList = $db->RunQuery($sqlStyleList);
									
										if(mysql_num_rows($resStyleList) > 0){

											$arrResStyle = mysql_fetch_row($resStyleList);

											$dblForeCastQty = $arrResStyle[1];
											$strHTMLElement .= "<td class='textInRight bottomBorder rightBorder consolidateBackground'>".number_format($dblForeCastQty)."&nbsp;</td>";
											$WeekConsolidateQty[$iWeekYearInArray] = $dblForeCastQty;
										}else{	

											$strHTMLElement .= "<td class='textInRight bottomBorder rightBorder consolidateBackground'>0&nbsp;</td>";	
											$WeekConsolidateQty[$iWeekYearInArray] = 0;	  
										}
									}

									$strHTMLElement .= "</tr>";
									
									$arrayOfTotal = array();

									$sqlDeliveries = " SELECT deliveryschedule.intDeliveryId, deliveryschedule.intStyleId,
                                                                  deliveryschedule.dtDateofDelivery, deliveryschedule.dblQty,
                                                                  week(dtDateofDelivery) as DeliveryWeek, 
                                                                  year(dtDateofDelivery) as DeliveryYear
                                                           FROM deliveryschedule 
                                                           WHERE deliveryschedule.intStyleId =  '$styleCode'";

                                    $resDeliveries = $db->RunQuery($sqlDeliveries);      
                                    
                                    while($rowDeliveries = mysql_fetch_array($resDeliveries)){
                                    	
                                    	$strHTMLElement .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td class='leftBorder bottomBorder rightBorder'>&nbsp;</td>";

                                    	$iDeliveryYearWeek 	= $rowDeliveries["DeliveryYear"].$rowDeliveries["DeliveryWeek"];
                                    	$dblDeliveryQty 	= $rowDeliveries["dblQty"];


                                    	for($iArrCount = 0; $iArrCount<$iWeekYearArraySize; $iArrCount++){

											$iWeekYearInArray = $arrWeeks[$iArrCount];
											
											if($iDeliveryYearWeek == $iWeekYearInArray){

												$strHTMLElement .= "<td class='textInRight bottomBorder rightBorder'>".number_format($dblDeliveryQty)."&nbsp;</td>";
												$arrayOfTotal[$iDeliveryYearWeek] += $dblDeliveryQty;
											} else{
												$strHTMLElement .= "<td class='textInRight bottomBorder rightBorder'>0&nbsp;</td>";
												//$arrayOfTotal[$iArrCount] = 0;
												
											}											
										}

										$strHTMLElement .= "</tr>";

                                    }

                                    // Sort the array
                                    ksort($arrayOfTotal);
                                    //var_dump($arrayOfTotal);
                                    $strHTMLElement .= "<tr><td>&nbsp;</td><td class='fullBorder'>&nbsp;</td><td class='textInLeft topBorder rightBorder bottomBorder textHeader valHighlight'>&nbsp;TTL</td><td class='topBorder rightBorder bottomBorder valHighlight'>&nbsp;</td><td class='rightBorder bottomBorder valHighlight'>&nbsp;</td>";	

                                    for($iArrCount = 0; $iArrCount<$iWeekYearArraySize; $iArrCount++){

										$iWeekYearInArray = $arrWeeks[$iArrCount];

										if(array_key_exists($iWeekYearInArray, $arrayOfTotal)){
											$strHTMLElement .= "<td class='textInRight rightBorder bottomBorder valHighlight'>".number_format($arrayOfTotal[$iWeekYearInArray])."&nbsp;</td>";
										}else{
											$strHTMLElement .= "<td class='textInRight rightBorder bottomBorder valHighlight'>0&nbsp;</td>";	
										}

									}
									$strHTMLElement .= "</tr>";
									
									$strHTMLElement .= "<tr><td>&nbsp;</td><td class='leftBorder bottomBorder rightBorder'>&nbsp;</td><td class='textInLeft  rightBorder bottomBorder textHeader valBalRow'>&nbsp;BAL</td><td class='bottomBorder rightBorder valBalRow'>&nbsp;</td><td class='bottomBorder rightBorder valBalRow'>&nbsp;</td>";

									for($iArrCount = 0; $iArrCount<$iWeekYearArraySize; $iArrCount++){

										$iWeekYearInArray = $arrWeeks[$iArrCount];

										$dblTotAllocatedQty 	= 0;
										$dblTotConsolidateQty 	= 0;

										if(array_key_exists($iWeekYearInArray, $arrayOfTotal)){
											$dblTotAllocatedQty = (float)$arrayOfTotal[$iWeekYearInArray];
										}

										if(array_key_exists($iWeekYearInArray, $WeekConsolidateQty)){

											$dblTotConsolidateQty = (float)$WeekConsolidateQty[$iWeekYearInArray];
										}

										$dblBalQty = $dblTotConsolidateQty - $dblTotAllocatedQty;

										if($dblBalQty>=0)
											$strHTMLElement .= "<td class='textInRight bottomBorder rightBorder textHeader valBalRow'>".number_format($dblBalQty)."&nbsp;</td>";
										else	
										$strHTMLElement .= "<td class='textInRight bottomBorder rightBorder minusHighlight textHeader valBalRow'>".number_format($dblBalQty)."&nbsp;</td>";
									}

								
									echo $strHTMLElement;	

									
								
								}// End Of style code distinct section

							?>	

						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</body>



</html>