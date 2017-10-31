<?php 

session_start();
$styleNo =  $_GET['var'];
$Qty = $_GET['Qty'];
include '../Connector.php';
//echo $Qty;
//echo $styleNo; 

$userId	 = $_SESSION["UserID"];
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
	
	if($filepath!='')
	{
            //echo $filepath;
            $errOther = 0;
            $isErrorOccured = 0;
            include 'reader.php';
			
            $data = new Spreadsheet_Excel_Reader();
            $data->setOutputEncoding('CP1251');
            $data->read($file);
            $rows = $data->sheets[0]['numRows'];
            //echo $rows."<br />";
			
            for ($i = 2; $i <= $rows; $i++)
            {	

                $quantity =  $data->sheets[0]['cells'][$i][2];
                //echo "Row Qty .".$quantity ."<br />";
                $totalQty += $quantity ;
                
                //Check previous buyer po number empty or blank
                //==============================================
                
                if($data->sheets[0]['cells'][$i][14] == ''){
                    $errOther = 1;
                    $isErrorOccured = 1;
                    //echo "D"."<br />";
                    echo "<strong><font color='red' style='font-family: Arial; font-size: 14px; font-weight:bold;'>Previous buyer po column cannot be empty, please enter previous buyer PO number.</font></strong><br />";
                    break;
                }
                //==============================================
                
                // Check if supplier po raised against the previous buyer PO
                // =========================================================
                $sql1 = "SELECT * FROM purchaseorderdetails WHERE intStyleId = '$styleNo' AND purchaseorderdetails.strBuyerPONO = '".$data->sheets[0]['cells'][$i][14]."'";
                $result = $db->RunQuery($sql1);
                if(mysql_num_rows($result)){
                    
                    //Get delivery qty from the delivery table
                    $sql2 = " SELECT deliveryschedule.dblQty
                              FROM deliveryschedule INNER JOIN style_buyerponos ON deliveryschedule.intStyleId = style_buyerponos.intStyleId AND deliveryschedule.intBPO = style_buyerponos.strBuyerPONO
                              WHERE deliveryschedule.intStyleId ='$styleNo' AND style_buyerponos.strBuyerPoName ='".$data->sheets[0]['cells'][$i][14]."'";
                    //echo $sql2;
                    $result1 = $db->RunQuery($sql2);
                    
                    $_arrDeliveryQty = mysql_fetch_row($result1);
                    $_dblDeliveryQty = $_arrDeliveryQty[0];
                    
                    if($_dblDeliveryQty != $quantity){
                        $errOther = 1;
                        $isErrorOccured = 1;
                        echo "<strong><font color='red' style='font-family: Arial; font-size: 12px; font-weight:bold;'>Sorry! you cannot split the delivery quantities for buyer PO ".$data->sheets[0]['cells'][$i][14]." because supplier PO raised for this buyer PO.</font></strong><br /><br />";
                        break;
                    }
                }
                // =========================================================

                //echo $data->sheets[0]['cells'][$i][1]."<br />";

            }//end of for loop
			
            //echo "Total Qty ". $Qty ." Buyer PO Qty ".$totalQty;
            if(($totalQty != $Qty) && ($errOther == 0))
            {
                    //echo $totalQty;
                    //echo $Qty;
                    $isErrorOccured = 1;
                    echo "<strong><font color='red' style='font-family: Arial; font-size: 14px; font-weight:bold;' >Total qty of Uploaded Document does not match with Order Qty.</font></strong><br /><br />";
            }
            else
            {
		if($isErrorOccured == 0){		
                    $SQL1 = "SELECT * FROM bpodelschedule WHERE intStyleId ='$styleNo'";

                    $RESULT1 = $db->RunQuery($SQL1);
                    if(mysql_num_rows($RESULT1))
                    {
                        $sql_delete_bpodelschedule = "DELETE FROM bpodelschedule WHERE intStyleId ='$styleNo'";
                        $result_delete_bpodelschedule = $db->RunQuery($sql_delete_bpodelschedule);	
                    }
					
					
                    $SQL2 = "SELECT * FROM style_buyerponos WHERE intStyleId ='$styleNo'";

                    $RESULT2 = $db->RunQuery($SQL2);
                    if(mysql_num_rows($RESULT2))
                    {
                            $sql_delete_style_buyerponos = "DELETE FROM style_buyerponos WHERE intStyleId ='$styleNo' ";
                            $result_delete_style_buyerponos = $db->RunQuery($sql_delete_style_buyerponos);	
                    }
					
					
                    //===========================================================================================================
                    // Description - Add existing delivery schedule details to the history delivery schedule table before delete
                    //               the current records
                    // Change On   - 08/11/2015
                    // Change By   - Nalin Jayakody
                    //===========================================================================================================

                    $sql_addhistory =  " INSERT INTO history_deliveryschedule (intStyleId, dtDateofDelivery, dblQty, dbExQty, strShippingMode, isDeliveryBase, intSerialNO,strRemarks,intUserId,dtmDate,dtmHandOverDate,intBPO,intRefNo, estimatedDate,intCountry, intDeliveryStatus,dtmCutOffDate,AuditDate,AuditUser)
    SELECT deliveryschedule.intStyleId, deliveryschedule.dtDateofDelivery, deliveryschedule.dblQty, deliveryschedule.dbExQty, deliveryschedule.strShippingMode, deliveryschedule.isDeliveryBase, deliveryschedule.intSerialNO, deliveryschedule.strRemarks, deliveryschedule.intUserId, deliveryschedule.dtmDate, deliveryschedule.dtmHandOverDate, deliveryschedule.intBPO, deliveryschedule.intRefNo, deliveryschedule.estimatedDate, deliveryschedule.intCountry, deliveryschedule.intDeliveryStatus, deliveryschedule.dtmCutOffDate, now(), '$userId'	
    FROM deliveryschedule WHERE deliveryschedule.intStyleId = '$styleNo'";

                    $resAddHistory	= $db->RunQuery($sql_addhistory);

                    //===========================================================================================================

                    $SQL3 = "SELECT * FROM deliveryschedule WHERE intStyleId ='$styleNo'";

                    $RESULT3 = $db->RunQuery($SQL3);
                    if(mysql_num_rows($RESULT3))
                    {

                        $sql_delete_deliveryschedule = "DELETE FROM deliveryschedule WHERE intStyleId ='$styleNo'";
                        //$result_delete_deliveryschedule = $db->RunQuery($sql_delete_deliveryschedule);		
                        //echo $sql_delete_deliveryschedule;
                        $result_delete_deliveryschedule = $db->ExecuteQuery($sql_delete_deliveryschedule);		
                    }
					
					
				
                    for ($i = 2; $i <= $rows; $i++)
                    {
                        $buyerPoNo 	=  $data->sheets[0]['cells'][$i][1];
                        $quantity 	=  $data->sheets[0]['cells'][$i][2];
                        $country 	=  $data->sheets[0]['cells'][$i][3];
                        $leadTime 	=  $data->sheets[0]['cells'][$i][4];

                        $deliveryDate =  $data->sheets[0]['cells'][$i][5];
                        // echo $buyerPoNo . " - " . $deliveryDate ."<br />";
                        $deliveryDate =substr($deliveryDate,0,10);
                        $deliveryDateArray=explode('/',$deliveryDate);
                        $formatdeliveryDate=$deliveryDateArray[2]."-".$deliveryDateArray[1]."-".$deliveryDateArray[0];

                        $s = $deliveryDate - 25569;
                        //echo strtotime("+$s days", mktime(0,0,0,1,1,1970))." S<br /> ";

                        $estimatedDate 		 	=  $data->sheets[0]['cells'][$i][6];
                        $estimatedDate =substr($estimatedDate,0,10);
                        $estimatedDateArray=explode('/',$estimatedDate);
                        $formatestimatedDate=$estimatedDateArray[2]."-".$estimatedDateArray[1]."-".$estimatedDateArray[0];

                        $handoverDate 		 	=  $data->sheets[0]['cells'][$i][7];
                        $handoverDate =substr($handoverDate,0,10);
                        $handoverDateArray=explode('/',$handoverDate);
                        $formathandoverDate=$handoverDateArray[2]."-".$handoverDateArray[1]."-".$handoverDateArray[0];

                        $shippingMode 		 	=  $data->sheets[0]['cells'][$i][8];
                        $remarks 		 		=  $data->sheets[0]['cells'][$i][9];

                        // ======================================================================
                        // Add On      - 08/10/2015
                        // Description - Add delivery status to the delivery schedule
                        // Change By   - Nalin Jayakody
                        // ======================================================================

                        $deliveryStatus			=  $data->sheets[0]['cells'][$i][11];
                        $cutOffDate			=  $data->sheets[0]['cells'][$i][12];

                        $locationId			=  $data->sheets[0]['cells'][$i][13];

                        // ======================================================================
                        // Add On      - 06/2/2016
                        // Description - Add previous buyer PO to the delivery schedule
                        // Change By   - Nalin Jayakody
                        // ======================================================================
                        $prevBPO 			= $data->sheets[0]['cells'][$i][14];	
                        // ======================================================================

                        // ======================================================================
                        // Add On      - 06/23/2016
                        // Description - add short ship status and reason to the delivery schedule by excel file
                        // Change By   - Nalin Jayakody
                        // ======================================================================
                        $shortShipStatus    = $data->sheets[0]['cells'][$i][15];   
                        $shortShipReasonId  = $data->sheets[0]['cells'][$i][16];   
                        // ======================================================================


                        $cutOffDate 		=  substr($cutOffDate,0,10);
                        $cutOffDateArray		=  explode('/',$cutOffDate);
                        $formatcutOffDate		=  $cutOffDateArray[2]."-".$cutOffDateArray[1]."-".$cutOffDateArray[0];
                        // ======================================================================
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

                                //========================================================
                                // Comment On - 08/11/2015
                                // Comment By - Nalin Jayakody
                                //========================================================
                                /*if($result2 == 1)
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
                                }//end of $result2 if*/
                                //========================================================

                        }//end of $result1 if

                        //echo $styleNo;

                        if($quantity != 0)
                        {	
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


                            $sql_insert_style_buyerponos = "INSERT INTO style_buyerponos (intStyleId, 
                                                            strBuyerPONO,
                                                            strBuyerPoName, 
                                                            strCountryCode,
                                                            strRemarks)
                                                            VALUES
                                                            ('$styleNo',
                                                            '$buyerPoNo', 
                                                            '$prevBPO', 
                                                            '$country',
                                                            '$remarks');";

                            $result_insert_style_buyerponos = $db->RunQuery($sql_insert_style_buyerponos);


                            $sql_insert_deliveryschedule = "INSERT INTO deliveryschedule (intStyleId,dtDateofDelivery,dblQty,dbExQty,
                                                                                        strShippingMode,isDeliveryBase,intSerialNO,
                                                                                        strRemarks,intUserId,dtmDate,dtmHandOverDate,
                                                                                        intBPO, intRefNo,estimatedDate,intCountry,intDeliveryStatus,
                                                                                        dtmCutOffDate, intManufacturingLocation, prvBPO, intShortShipped, shortShipId)
                                                            VALUES('$styleNo','$formatdeliveryDate','$quantity','0',
                                                                '$shippingMode','N','$leadTime','$remarks',
                                                                '$userId','$formatdeliveryDate','$formathandoverDate', '$buyerPoNo','0','$formatestimatedDate','$country','$deliveryStatus','$formatcutOffDate','$locationId','$prevBPO', '$shortShipStatus', '$shortShipReasonId' );";

                            $result_insert_deliveryschedule = $db->RunQuery($sql_insert_deliveryschedule);			
                        }//end of quantity !=0 if

                    }//end of $quantity for loop
                    
                        echo "<strong><font color='green' style='font-family: Arial; font-size: 13px; font-weight:bold;'>Successfully uploded.</font></strong>";
                }else{
                    echo "<strong><font color='tomato' style='font-family: Arial; font-size: 14px; font-weight:bold;'>File upload fail !</font></strong>";
                }    
				
            }//end of else of $total != $Qty
			
			
			
	}//end of $filepath if

?>
<style>
    .f{
        color:tomato
    }
</style>