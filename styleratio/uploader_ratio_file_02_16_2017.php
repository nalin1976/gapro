<?php 

session_start();
$styleNo 	=  $_GET['var'];
$Qty 		= $_GET['Qty'];
include '../Connector.php';
//echo $Qty;
//echo $styleNo; 

$userId 	= $_SESSION["UserID"];


?>

<?php 

$file_type= $_POST["formstyle"];
//echo "ddd";

	$filepath = $_FILES["ratiofile"]["name"];
	//echo $filepath;
	mkdir("upload files", 0777);
	$filenameB = basename($filepath);
	$file = "uploadfiles/".$filepath;
	//echo $file;
	move_uploaded_file($_FILES["ratiofile"]["tmp_name"],"uploadfiles/". $filepath);
	
	
	
	if($filepath!='')
	{
		//echo $filepath;
		
		$strMessage = '';
		
		include 'reader.php';
			
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($file);
		$rows = $data->sheets[0]['numRows'];
		
		// Delete all existing records in the style ration temp table for selected style
		//===============================================================================
		$strDeletc = "DELETE FROM style_ratio_temp WHERE intStyleId = $styleNo ";
		$res = $db->RunQuery($strDeletc);
								
				
		for ($i = 2; $i <= $rows; $i++)
		{
			$scno 		 			=  $data->sheets[0]['cells'][$i][1];
			$buyerPoNo 		 		=  $data->sheets[0]['cells'][$i][2];
			$color 			 		=  $data->sheets[0]['cells'][$i][3];
			$size	 		 		=  $data->sheets[0]['cells'][$i][4];
			$quantity 		 		=  $data->sheets[0]['cells'][$i][5];
			
			
			// Add style ratio details to the style ratio temp table extract from excel file
			//===============================================================================
			$strSqlAdd = " INSERT INTO style_ratio_temp(intStyleId, strBuyerPONO, strColor, strSize, dblQty) VALUES('$styleNo', '$buyerPoNo', '$color', '$size', '$quantity') ";
			$resAdd    = $db->ExecuteQuery($strSqlAdd);
														
		}//end of file row loop
		
		// Get sum of the quantity by buyer PO wise for the given style
		//===============================================================
		
		$strGetQty = " SELECT style_ratio_temp.strBuyerPONO, Sum(style_ratio_temp.dblQty) as TotBPOQty ".
		             " FROM  style_ratio_temp ".
					 " WHERE style_ratio_temp.intStyleId = '$styleNo'".
					 " GROUP BY style_ratio_temp.strBuyerPONO ";
					 
				 
		$resGetBPOQty = $db->RunQuery($strGetQty);
		
		
		while($rowBPOQty = mysql_fetch_array($resGetBPOQty)){
			
			$tmpBPONo 	= $rowBPOQty["strBuyerPONO"];
			$tmpBPOQty 	= (int)$rowBPOQty["TotBPOQty"];
			
			//Get quantity from the delivery schedule
			//==========================================			
			$strDelivery = " SELECT dblQty FROM deliveryschedule WHERE intStyleId = '$styleNo' AND intBPO = '$tmpBPONo' ";
			$resBPO		= $db->RunQuery($strDelivery);
			
                        $dblBPODeliveryQty = 0;
                        
			while($rowDeliveryQty = mysql_fetch_array($resBPO)){				
				$dblBPODeliveryQty = $rowDeliveryQty['dblQty'];				
			}
			
			// Check buyer po delivery quantity and ratio quantity will get match
			if($tmpBPOQty != $dblBPODeliveryQty){
				
				$strMessage .= " Total quantity of style ratio and buyer po quantity does not match -->$tmpBPONo \n";
				 
			}else{
                            /*echo $tmpBPOQty."\n";
                            if($tmpBPOQty > $dblBPODeliveryQty){
                                
                                $strMessage .= " Buyer PO quantity cannot be exceed. \n";
                            }else{*/
				
				$serial = 0;
				
				//Transfer style ratio to the history table
				$sqlHisStyRatio = "INSERT INTO historystyleratio(intStyleId,strBuyerPONO, strColor,strSize,dblQty,dblExQty,strUserId) SELECT intStyleId,strBuyerPONO, strColor,strSize,dblQty,dblExQty,strUserId FROM styleratio where intStyleId='$styleNo' AND strBuyerPONO='$tmpBPONo';";
	  			$db->ExecuteQuery($sqlHisStyRatio);	
				
				
				//Transfer material ratio to the history table
				$sqlHisMatRatio = "insert into historymaterialratio (intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty,materialRatioID)  select  intStyleId, 	strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty,materialRatioID from materialratio where intStyleId = '$styleNo' AND strBuyerPONO='$tmpBPONo'";
	  			$db->ExecuteQuery($sqlHisMatRatio);	
				
				//Set delete status in the style ratio
				$sqlDelStyRatio = " UPDATE styleratio SET intStatus = '0' WHERE (intStyleId='$styleNo') AND (strBuyerPONO='$tmpBPONo')";
				$db->ExecuteQuery($sqlDelStyRatio);	
				
				//Set delete status in the material ratio 
				$sqlDelMatRatio = "update materialratio set intStatus = '0' where intStyleId = '$styleNo' AND strBuyerPONO = '$tmpBPONo'";
				$db->executeQuery($sqlDelMatRatio);
				
				// Get style ratio details from temp table
				//================================================
				$strTmpRatio = "SELECT * FROM style_ratio_temp WHERE strBuyerPONO = '$tmpBPONo' AND intStyleId = '$styleNo'  " ;
				$resTmpRatio = $db->RunQuery($strTmpRatio);
				
				if($resTmpRatio){
				
					while($rowTmpRatio = mysql_fetch_array($resTmpRatio)){
						
						$strColor 	= $rowTmpRatio["strColor"];
						$strSize  	= $rowTmpRatio["strSize"];
						$dblRatioQty	= $rowTmpRatio["dblQty"];
						
						
						//Get style ratio details from the main style ratio table
						$strStyleRatio = " SELECT * FROM styleratio WHERE styleratio.intStyleId = '$styleNo' AND styleratio.strSize = '$strSize' AND styleratio.strColor = '$strColor' AND styleratio.strBuyerPONO = '$tmpBPONo'";
						$resStyleRatio = $db->RunQuery($strStyleRatio);
											
						if(mysql_num_rows($resStyleRatio)){
							
							$sql= " UPDATE styleratio SET intStatus = '1', dblQty = '$dblRatioQty'  WHERE (intStyleId='$styleNo') AND (strBuyerPONO='$tmpBPONo') AND (strColor='$strColor') AND (strSize='$strSize')";						
								
						}else{
							
							$sql= " insert into styleratio (intStyleId,strBuyerPONO,strColor,strSize,dblQty,dblExQty,strUserId,intserial,intStatus) values ('$styleNo','$tmpBPONo','$strColor','$strSize',$dblRatioQty,$dblRatioQty,'$userId','$serial', '1')";						
						}
						
						$db->executeQuery($sql);
						$serial++;
						
						// Get total order qty of the order
						//======================================================================
						$sql = "SELECT intSRNO, dblQuantity FROM specification WHERE intStyleId = '$styleNo'";
						$resOrderQty = $db->RunQuery($sql);
						
						$arrOrderQty = mysql_fetch_row($resOrderQty);
						
						$intSCNo	= $arrOrderQty[0];
						$dbOrderQty = $arrOrderQty[1];				
						//======================================================================
						
						// Get raw material information
						//====================================================
						$sql = " SELECT strMatDetailID, sngConPc, sngWastage, strPurchaseMode FROM specificationdetails WHERE intStyleId = '$styleNo'";
						$resRawMat = $db->RunQuery($sql);
						
						while($row = mysql_fetch_array($resRawMat)){
							
							$intMatId 		 = $row['strMatDetailID'];
							$dblConPc 		 = $row['sngConPc'];
							$dblWastage		 = $row['sngWastage'];
							$strPurchaseMode = $row['strPurchaseMode'];
							
							$dblTotCon	= ($dblConPc + ($dblConPc * ($dblWastage/100)));
												
							
							if($strPurchaseMode == 'COLOR'){
								
								// Get total qty of the color wise in buyer PO
								$strGetQty = " SELECT style_ratio_temp.strColor, Sum(style_ratio_temp.dblQty) as TotBPOQty ".
											 " FROM  style_ratio_temp ".
											 " WHERE style_ratio_temp.intStyleId = '$styleNo' AND strBuyerPONO = '$tmpBPONo'".
											 " GROUP BY style_ratio_temp.strColor ";
								$resBPOQty = $db->ExecuteQuery($strGetQty);
								
								while($rowTmpColorQty = mysql_fetch_array($resBPOQty)){
									
									$dblRatioQty = $rowTmpColorQty["TotBPOQty"];
									
									$dblTotReq	= round(($dblRatioQty * $dblTotCon), 0, PHP_ROUND_HALF_UP);
								
									// Add requirement to the materail ratio by buyer PO wise with Color
									$strSql = " SELECT * FROM materialratio WHERE intStyleId = '$styleNo' AND strMatDetailID = '$intMatId' AND strColor = '$strColor' AND strSize = 'N/A' AND strBuyerPONO = '$tmpBPONo' ";
									$resMatRatio = $db->RunQuery($strSql); 
									
									if(mysql_num_rows($resMatRatio)){
										
										$strSql1 = " UPDATE materialratio SET dblQty = '$dblTotReq', dblBalQty = '$dblTotReq', intStatus = '1' WHERE intStyleId = '$styleNo' AND strMatDetailID = '$intMatId' AND strColor = '$strColor' AND strSize = 'N/A' AND strBuyerPONO = '$tmpBPONo' ";							
									}else{
										$strSql1 = " INSERT INTO materialratio(intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID, dblRecutQty, serialNo, intStatus) VALUES('$styleNo', '$intMatId', '$strColor', 'N/A', '$tmpBPONo', '$dblTotReq', '$dblTotReq', '0', '$strMatratioId', '0','0', '1')";
									}
									$resMatRatioUpdate = $db->RunQuery($strSql1);
									
								}
							}//End of material ratio update if purchase mode COLOR
							
							if($strPurchaseMode == 'SIZE'){
								
								$dblTotReq	= round(($dblRatioQty * $dblTotCon),0,PHP_ROUND_HALF_UP);
								
								// Add requirement to the materail ratio by buyer PO wise with Color
								$strSql = " SELECT * FROM materialratio WHERE intStyleId = '$styleNo' AND strMatDetailID = '$intMatId' AND strColor = 'N/A' AND strSize = '$strSize' AND strBuyerPONO = '$tmpBPONo' ";
								$resMatRatio = $db->RunQuery($strSql); 
								
								if(mysql_num_rows($resMatRatio)){
									
									$strSql1 = " UPDATE materialratio SET dblQty = '$dblTotReq', dblBalQty = '$dblTotReq', intStatus = '1' WHERE intStyleId = '$styleNo' AND strMatDetailID = '$intMatId' AND strColor = 'N/A' AND strSize = '$strSize' AND strBuyerPONO = '$tmpBPONo' ";							
								}else{
									$strSql1 = " INSERT INTO materialratio(intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID, dblRecutQty, serialNo, intStatus) VALUES('$styleNo', '$intMatId', 'N/A', '$strSize', '$tmpBPONo', '$dblTotReq', '$dblTotReq', '0', '$strMatratioId', '0','0', '1')";
								}
								$resMatRatioUpdate = $db->RunQuery($strSql1);
							}//End of material ratio update if purchase mode SIZE
							
							if($strPurchaseMode == 'BOTH'){
								
								$dblTotReq	= round(($dblRatioQty * $dblTotCon),0,PHP_ROUND_HALF_UP);
								
								// Add requirement to the materail ratio by buyer PO wise with Color
								$strSql = " SELECT * FROM materialratio WHERE intStyleId = '$styleNo' AND strMatDetailID = '$intMatId' AND strColor = '$strColor' AND strSize = '$strSize' AND strBuyerPONO = '$tmpBPONo' ";
								$resMatRatio = $db->RunQuery($strSql); 
								
								if(mysql_num_rows($resMatRatio)){
									
									$strSql1 = " UPDATE materialratio SET dblQty = '$dblTotReq', dblBalQty = '$dblTotReq', intStatus = '1' WHERE intStyleId = '$styleNo' AND strMatDetailID = '$intMatId' AND strColor = '$strColor' AND strSize = '$strSize' AND strBuyerPONO = '$tmpBPONo' ";							
								}else{
									$strSql1 = " INSERT INTO materialratio(intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID, dblRecutQty, serialNo, intStatus) VALUES('$styleNo', '$intMatId', '$strColor', '$strSize', '$tmpBPONo', '$dblTotReq', '$dblTotReq', '0', '$strMatratioId', '0','0', '1')";
								}
								$resMatRatioUpdate = $db->RunQuery($strSql1);
							}//End of material ratio update if purchase mode BOTH
							
							if($strPurchaseMode == 'NONE'){
								
								$dblTotReq	= round(($tmpBPOQty * $dblTotCon),0,PHP_ROUND_HALF_UP);
								$strMatratioId = $intSCNo."-".$intMatId."-A";
							
								// Add requirement to the materail ratio by buyer PO wise
								$strSql = " SELECT * FROM materialratio WHERE intStyleId = '$styleNo' AND strMatDetailID = '$intMatId' AND strColor = 'N/A' AND strSize = 'N/A' AND strBuyerPONO = '$tmpBPONo' ";
								$resMatRatio = $db->RunQuery($strSql);
								
								if(mysql_num_rows($resMatRatio)){
									
									$strSql1 = " UPDATE materialratio SET dblQty = '$dblTotReq', dblBalQty = '$dblTotReq', intStatus = '1' WHERE intStyleId = '$styleNo' AND strMatDetailID = '$intMatId' AND strColor = 'N/A' AND strSize = 'N/A' AND strBuyerPONO = '$tmpBPONo' ";							
								}else{
									$strSql1 = " INSERT INTO materialratio(intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID, dblRecutQty, serialNo, intStatus) VALUES('$styleNo', '$intMatId', 'N/A', 'N/A', '$tmpBPONo', '$dblTotReq', '$dblTotReq', '0', '$strMatratioId', '0','0', '1')";
								}
								$resMatRatioUpdate = $db->RunQuery($strSql1);
							
							}//End of material ratio update if purchase mode NONE
							
							
						}// End of material ratio update						
						
					}// End of style ratio update
				}else{
					echo "Error in style ratio";	
				}
			}// End of validating style ratio and delivery schedule quantity		
			
			
		} // End of temp style ratio
		
		$iMaxSerial 	= 0;
						
		//Get maximum serial number from the style ratio
		$sqlMaxSerial 	= " SELECT IFNULL(MAX(intserial),0) AS MAX_Serial FROM styleratio WHERE intStyleId = '$styleNo' ";
		$resMaxNo		= $db->RunQuery($sqlMaxSerial);
		
		$arrMaxSerial	= mysql_fetch_row($resMaxNo);
		$iMaxSerial		= (int)$arrMaxSerial[0];
		//==============================================
		
		// Increment by 1 in serial
		$iMaxSerial++;
		
		// Update maximum serial number to the style ratio for buyer po number #MAIN RATIO#
		$sqlUpdate 	= " UPDATE styleratio SET intserial = '$iMaxSerial' WHERE intStyleId = '$styleNo' AND strBuyerPONO = '#Main Ratio#' ";
		$db->ExecuteQuery($sqlUpdate);
		
		$strMessage .= " Uploaded successfully";
		//================================================================
		echo "<strong><font color='green'>$strMessage</font></strong>";		
			
			
			
			
	}//end of $filepath if

?>