<?php 
session_start();
$styleNo = $_GET['var'];
$userId		 = $_SESSION["UserID"];
include '../Connector.php';
//echo $userId;
//echo $styleNo;
?>

<?php
$file_type= $_POST["formstyle"];
//echo "ddd";

	$filepath = $_FILES["buyerPOfile"]["name"];
	//echo $filepath;
	mkdir("upload files", 0777);
	$filenameB = basename($filepath);
	$file = "upload files/".$filepath;
	//echo $file;
	move_uploaded_file($_FILES["buyerPOfile"]["tmp_name"],"upload files/". $filepath);
	$fh = fopen($file, 'x');
	
	if($filepath!='')
	{
		//echo $filepath;
		
		include 'reader.php';
			
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read($file);
			$rows = $data->sheets[0]['numRows']+1;
			//echo $rows;
			for ($i = 2; $i <= $rows; $i++)
			{	
				//echo $styleNo;
				$buyerPoNo 		 		=  $data->sheets[0]['cells'][$i][1];
				//echo  $buyerPoNo ;
				$quantity 		 		=  $data->sheets[0]['cells'][$i][2];
				//echo $quantity;
				$country 		 		=  $data->sheets[0]['cells'][$i][3];
				//echo $country ;
				$leadTime 		 		=  $data->sheets[0]['cells'][$i][4];
				//echo $leadTime; 
				$deliveryDate 		 	=  $data->sheets[0]['cells'][$i][5];
				//echo $deliveryDate;
				$deliveryDate =substr($deliveryDate,0,10);
				$deliveryDateArray=explode('/',$deliveryDate);
				$formatdeliveryDate=$deliveryDateArray[2]."-".$deliveryDateArray[1]."-".$deliveryDateArray[0];
				//echo $formatdeliveryDate;	
				
				$estimatedDate 		 	=  $data->sheets[0]['cells'][$i][6];
				$estimatedDate =substr($estimatedDate,0,10);
				$estimatedDateArray=explode('/',$estimatedDate);
				$formatestimatedDate=$estimatedDateArray[2]."-".$estimatedDateArray[1]."-".$estimatedDateArray[0];
				//echo date($formatestimatedDate); 
				
				$handoverDate 		 	=  $data->sheets[0]['cells'][$i][7];
				$handoverDate =substr($handoverDate,0,10);
				$handoverDateArray=explode('/',$handoverDate);
				$formathandoverDate=$handoverDateArray[2]."-".$handoverDateArray[1]."-".$handoverDateArray[0];
				//echo date($formathandoverDate); 
					
				$shippingMode 		 	=  $data->sheets[0]['cells'][$i][8];
				//echo $shippingMode;
				$remarks 		 		=  $data->sheets[0]['cells'][$i][9];
				//echo $remarks;
				
				 $sql1 ="INSERT INTO history_bpodelschedule 
														(intStyleId, 
														dtDateofDelivery, 
														strBuyerPONO, 
														intQty, 
														strRemarks, 
														intWithExcessQty)
													VALUES
														('$styleNo', 
														'$formatdeliveryDate', 
														'$buyerPoNo', 
														'$quantity', 
														'$remarks', 
														'$quantity')";
								
				$result1 = $db->RunQuery($sql1);
				if($result1 == 1)
				{
							 $sql2 = "INSERT INTO history_style_buyerponos 
								(intStyleId, 
								strBuyerPONO,
								strBuyerPoName, 
								strCountryCode,
								strRemarks)
							VALUES
									('$styleNo',
									'$buyerPoNo', 
									'$buyerPoNo', 
									'$country',
									'$remarks'
									);";
									
							$result2 = $db->RunQuery($sql2);
							if($result2 == 1)
							{
							 		 $sql3 = "Insert into history_deliveryschedule 	
														(intStyleId,dtDateofDelivery,dblQty,dbExQty,strShippingMode,isDeliveryBase,
														 intSerialNO,strRemarks,intUserId,dtmDate,dtmHandOverDate,intBPO,intRefNo,
														 estimatedDate,intCountry)
													values
														('$styleNo','$formatdeliveryDate','$quantity','0','$shippingMode','N','0',
														'$remarks','$userId','$formatdeliveryDate','$formathandoverDate',
														'$buyerPoNo','0','$formatestimatedDate','$country')";
									$result3 = $db->RunQuery($sql3);
							}//end of $result2 if
							
				}//end of $result1 if
				
				$SQL1 = "SELECT intStyleId,strBuyerPONO FROM bpodelschedule 
																	  WHERE intStyleId ='$styleNo' AND strBuyerPONO = '$buyerPoNo'";
				$RESULT1 = $db->RunQuery($SQL1);
				if(mysql_num_rows($RESULT1))
				{
					//echo mysql_num_rows($RESULT1);
					$sql_delete_bpodelschedule = "DELETE FROM bpodelschedule 
																		  WHERE intStyleId ='$styleNo' AND 
																		  strBuyerPONO = '$buyerPoNo'";
					$result_delete_bpodelschedule = $db->RunQuery($sql_delete_bpodelschedule);													  					//echo "Deleted Successfully";	
				}							
				else 									
				{						
					//echo 0;					
					$sql_insert_bpodelschedule = "INSERT INTO bpodelschedule (intStyleId, 
																				dtDateofDelivery, 
																				strBuyerPONO, 
																				intQty, 
																				strRemarks, 
																				intWithExcessQty)
																			VALUES
																				('$styleNo', 
																				'$formatdeliveryDate', 
																				'$buyerPoNo', 
																				'$quantity', 
																				'$remarks', 
																				'$quantity')";
					$result_insert_bpodelschedule = $db->RunQuery($sql_insert_bpodelschedule);						
					//echo "Inserted Successfully";							
				}//end of $RESULT1 if
				
				$SQL2 = "SELECT intStyleId,strBuyerPONO FROM style_buyerponos 
																	  WHERE intStyleId ='$styleNo' AND strBuyerPONO = '$buyerPoNo'";
				$RESULT2 = $db->RunQuery($SQL2);
				if(mysql_num_rows($RESULT2))
				{
					 $sql_delete_style_buyerponos = "DELETE FROM style_buyerponos 
																		  WHERE intStyleId ='$styleNo' AND 
																		  strBuyerPONO = '$buyerPoNo'";
					$result_delete_style_buyerponos = $db->RunQuery($sql_delete_style_buyerponos);		
				}
				else
				{
					  $sql_insert_style_buyerponos = "INSERT INTO style_buyerponos (intStyleId, 
																						strBuyerPONO,
																						strBuyerPoName, 
																						strCountryCode,
																						strRemarks)
																				VALUES
																						('$styleNo',
																						'$buyerPoNo', 
																						'$buyerPoNo', 
																						'$country',
																						'$remarks');";
																					
					$result_insert_style_buyerponos = $db->RunQuery($sql_insert_style_buyerponos);		
				}//end of $RESULT2 if
				
				$SQL3 = "SELECT intStyleId,intBPO FROM deliveryschedule 
																	  WHERE intStyleId ='$styleNo' AND intBPO = '$buyerPoNo'";
				$RESULT3 = $db->RunQuery($SQL3);
				if(mysql_num_rows($RESULT3))
				{
					
					 $sql_delete_deliveryschedule = "DELETE FROM deliveryschedule 
																		  WHERE intStyleId ='$styleNo' AND 
																		  intBPO = '$buyerPoNo'";
					$result_delete_deliveryschedule = $db->RunQuery($sql_delete_deliveryschedule);		
				}
				else
				{
				
					  $sql_insert_deliveryschedule = "INSERT INTO deliveryschedule (intStyleId,dtDateofDelivery,dblQty,dbExQty,
					  																strShippingMode,isDeliveryBase,intSerialNO,
					  																strRemarks,intUserId,dtmDate,dtmHandOverDate,
					 																intBPO, intRefNo,estimatedDate,intCountry)
					 											VALUES('$styleNo','$formatdeliveryDate','$quantity','0',
																		'$shippingMode','N',0,'$remarks',
																		'$userId','$formatdeliveryDate','$formathandoverDate',
																		'$buyerPoNo','0','$formatestimatedDate','$country');";
																														
					$result_insert_deliveryschedule = $db->RunQuery($sql_insert_deliveryschedule);		
				}//end of $RESULT2 if
				
			}//end of for loop
			
		echo "<strong>Successfully uploded.</strong>";
		//fopen($file);
		
		fclose($fh);	
		//unlink($file);	
	}//end of filepath if 
?>