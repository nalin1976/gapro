<?php

session_start();
include '../Connector.php';

$userId 	= $_SESSION["UserID"];


$file_type = $_POST["frmStyle"];
	

$filepath = $_FILES["file-0a"]["name"];


//mkdir("uploadf", 0777);
$filenameB = basename($filepath);

$file = "uploadf/".$filepath;
//echo $file;
move_uploaded_file($_FILES["file-0a"]["tmp_name"],"uploadf/". $filepath);

if($filepath!=''){

	include 'reader.php';

	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($file);

	$rows = $data->sheets[0]["numRows"];
	$cols = $data->sheets[0]["numCols"];

	// Read lines in Excel file 
	for ($i = 4; $i <= $rows; $i++)
	{

		$modelCode 	= $data->sheets[0]['cells'][$i][3];
		$modelDesc 	= $data->sheets[0]['cells'][$i][4];
		$ImanNo    	= $data->sheets[0]['cells'][$i][5];
		$scNo 		= $data->sheets[0]['cells'][$i][6];


		//Get style code from SC 
		//=========================

		$sql 			= " SELECT intStyleId FROM specification WHERE intSRNO = '$scNo'";

		$resStyleCode   = $db->RunQuery($sql);

		$arrStyleCode 	= mysql_fetch_row($resStyleCode);

		$iStyleCode		= $arrStyleCode[0];

		//=====================================================================

		for($c = 8; $c <= $cols; $c++){

			$ColHeaderValue = $data->sheets[0]['cells'][3][$c];

			if($ColHeaderValue != ""){
				
				$weekQty = $data->sheets[0]['cells'][$i][$c];

				if($weekQty != 0){

					$forecastYear = substr($ColHeaderValue,0,4);
					$forecastWeek = substr($ColHeaderValue,4,2);

					// Verify if line item exist in the consolidated_forcast table
					// ===========================================================
					$sqlVerify = " SELECT * FROM consolidated_forcast WHERE StyleID = '$iStyleCode' AND ModelCode = '$modelCode' AND ForcastYear = '$forecastYear' AND WeekOfYear = '$forecastWeek' ";

					$resVerify = $db->RunQuery($sqlVerify);

					if(mysql_num_rows($resVerify) > 0){

						$arrVerifyValues = mysql_fetch_row($resVerify);

						$hisModelDesc 	= $arrVerifyValues[4];
						$hisImanNo    	= $arrVerifyValues[5];
						$hisForeCastQty	= $arrVerifyValues[6];

						if($weekQty != $hisForeCastQty){

							//Save history consolidated_forcast table before update to new value
							//====================================================================
							$sqlAddHisConsolidate = " INSERT INTO history_consolidate_forcast(StyleID, ModelCode, ForcastYear, WeekOfYear, ModelDescription, ImanNo, ForcastQty, dtmDate) VALUES('$iStyleCode', '$modelCode', '$forecastYear', '$forecastWeek', '$hisModelDesc', '$hisImanNo', '$hisForeCastQty', now())";

							$db->ExecuteQuery($sqlAddHisConsolidate);
							//====================================================================

							// Update new quantity value to the consolidated_forcast table
							// ===========================================================
							$sqlUpdateConsolidate = " UPDATE consolidated_forcast SET ModelDescription = '$modelDesc', ImanNo = '$ImanNo', ForcastQty = '$weekQty' WHERE StyleID = '$iStyleCode' AND ModelCode = '$modelCode' AND ForcastYear = '$forecastYear' AND WeekOfYear = '$forecastWeek'  ";
							$db->ExecuteQuery($sqlUpdateConsolidate);


							// ===========================================================
						}


					}else{

						// Add quantities to the consolidated table
						// ==============================================
						$sqlAddConsolidate = " INSERT INTO consolidated_forcast(StyleID, ModelCode, ForcastYear, WeekOfYear, ModelDescription, ImanNo, ForcastQty) VALUES('$iStyleCode', '$modelCode', '$forecastYear', '$forecastWeek', '$modelDesc', '$ImanNo', '$weekQty')";

						$db->ExecuteQuery($sqlAddConsolidate);
						// ==============================================
					}
					// ===========================================================
						
				}

				
			}

			//echo $data->sheets[0]['cells'][3][$c]."<br />";
		}

	}

	header('Location: forcast.php');    

}else{
	echo "Fail";
}


?>