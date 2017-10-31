<?php
$backwardseperator = "../../";
include "../../authentication.inc";
session_start();
$userId			= $_SESSION["UserID"];
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload  Excel Files</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
include"../../Connector.php";
?>

<?php  

  if($_FILES["filepath2"]["error"] == 1){
   echo "The uploaded file exceeds the upload_max_filesize directive in php.ini .";
  }
  else if($_FILES["filepath2"]["error"] == 2){
   echo "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
  }
  else if($_FILES["filepath2"]["error"] == 3){
   echo "The uploaded file was only partially uploaded.";
  }
  else if($_FILES["filepath2"]["error"] == 4){
   echo "No file was uploaded";
  }
  else if($_FILES["filepath2"]["error"] == 6){
   echo "Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3";
  }
  else if($_FILES["filepath2"]["error"] == 7){
   echo "Failed to write file to disk. Introduced in PHP 5.1.0";
  }
  else if($_FILES["filepath2"]["error"] == 8){
   echo "A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded         extensions with phpinfo() may help. Introduced in PHP 5.2.0. ";
  }
  
  else if($_FILES["datUpload"]["error"] == 0){

 $filepath	    = $_POST['filepath2'];
 
mkdir("../../upload files", 0700);
mkdir("../../upload files/lc", 0700);
$filenameB = basename($_FILES['filepath2']['name']);
$file = "../../upload files/lc/".$filenameB;
$result2='';

if($_FILES["filepath2"]["name"] != '')
	{
 		 if (move_uploaded_file($_FILES["filepath2"]["tmp_name"],"../../upload files/lc/". $filenameB)){
        // require_once 'Excel/reader.php';
		 include $backwardseperator.'tukaExceReader/Excel/reader.php';
		 
		  $data = new Spreadsheet_Excel_Reader();
		  $data->setOutputEncoding('CP1251');
		  $data->read($file);
		  
//echo date('Y-m-d H:i:s', 1222431569); 
		  $supplier = $data->sheets[0]['cells'][2][2]; 
		  $supplier = str_replace("'","''",$supplier);
		  if($supplier == '')
		  {
		  		$result2 = "Supplier Details not available in the Excel file";
		  }
		  else
		  {
		  	//echo $data->sheets[0]['numRows']+1;
		   	  $result = '';	
			  for ($i = 5; $i < $data->sheets[0]['numRows']+1; $i++) {		
	
				 $fac =  $data->sheets[0]['cells'][$i][1];
				 $orderNo    =  $data->sheets[0]['cells'][$i][2];
				 $piNo = $data->sheets[0]['cells'][$i][3];
				// echo $orderNo.'//'.$piNo.'</br>';
				 if($orderNo == '' && $piNo == '')
				 	$result = 'false';
					 
				}	
				
				if($result == '')
				{
					 for ($i = 5; $i < $data->sheets[0]['numRows']+1; $i++) {		
	
					 $fac =  $data->sheets[0]['cells'][$i][1];
					 $orderNo    =  $data->sheets[0]['cells'][$i][2];
					 $piNo = $data->sheets[0]['cells'][$i][3];					 		
					 $oritRef = $data->sheets[0]['cells'][$i][4];
					 $supPIno =  $data->sheets[0]['cells'][$i][5];
					 $DDNno = $data->sheets[0]['cells'][$i][6];
					 $shipMode = $data->sheets[0]['cells'][$i][7];
					 $itemCode = $data->sheets[0]['cells'][$i][8];
					 $color = $data->sheets[0]['cells'][$i][9];
					 $size = $data->sheets[0]['cells'][$i][10];
					 $qty = $data->sheets[0]['cells'][$i][11];
					 $amount = $data->sheets[0]['cells'][$i][12];
					 $GW = $data->sheets[0]['cells'][$i][13];
					 $CM = $data->sheets[0]['cells'][$i][14];
					 $payment = $data->sheets[0]['cells'][$i][15];
					 $handleBy = $data->sheets[0]['cells'][$i][16]; 
					 $readyDate = $data->sheets[0]['cells'][$i][17];
					 $confirmDate = $data->sheets[0]['cells'][$i][18];
					 $handDate = $data->sheets[0]['cells'][$i][19];
					 $remarks =$data->sheets[0]['cells'][$i][20];
				
				/*$hours = floor($readyDate * 24);
            	$mins = floor($readyDate * 24 * 60) - $hours * 60;
            	$secs = floor($readyDate * SPREADSHEET_EXCEL_READER_MSINADAY) - $hours * 60 * 60 - $mins * 60;
            	$string = date ('Y-m-d', mktime($hours, $mins, $secs));
				echo $string;	*/
			$strreadyDate = '';
			$strconfirmDate = '';
			$strhandDate = '';
			
			if($readyDate != '')
				$strreadyDate = getFormatedDate($readyDate);
			if($confirmDate !='')
				$strconfirmDate = getFormatedDate($confirmDate);
			if($handDate != '')
				$strhandDate = 	getFormatedDate($handDate);
			
			
					//echo $readyDate;
					 $qty = ($qty == ''?'Null':$qty);
					 $amount = ($amount == ''?'Null':$amount);
					 $CM = ($CM == ''?'Null':$CM);

					$sql = " insert into lc_supplierdetails (strfactory, strOrderNo, strPINo,strOritRefNo, strSupplierPINo, strDNNo, strShipMode, strItemCode, strColor,strSize,dblQty,dblAmount,strGW,dblCM,strPayment, strHandleBy,dtmReadyDate,dtmPIConfirmDate,dtmHandoverDate,strRemarks,supplier,intUserId, dtmUploadDate)
		 values ('$fac','$orderNo','$piNo','$oritRef','$supPIno','$DDNno', '$shipMode','$itemCode','$color','$size','$qty', $amount,'$GW','$CM','$payment','$handleBy','$strreadyDate','$strconfirmDate','$strhandDate','$remarks','$supplier','$userId',now()) ";
					 $result2 = $db->RunQuery($sql);
					 
					}
				}
				else
				{
					$result2 = " Orderno or PI No not available";
				}	
			}
			//remove file from the server
			$fh = fopen($file, 'a');
			fclose($fh);	
			unlink($file);
		}
			
		
	}
}
?>
<form enctype="multipart/form-data" id="frmTuka" name="frmTuka" method="post" action="lc_upload.php" >
<table width="100%" border="0" align="center">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="820" border="0" align="center">
      <tr>
        <td width="54%"><table width="100%" border="0" align="center" class="tableBorder">
          <tr>
            <td width="100%" height="24" bgcolor="" class="mainHeading">Upload  Excel Files</td>
          </tr>
          <tr>
            <td><div class="bcgl1"><table width="100%" border="0">

                <tr>
                  <td width="21%" class="normalfntMid">LC Request Data</td>
                  <td width="71%"><input type="file" name="filepath2" style="width:300px;" id="filepath2" class="textbox" size="50"  /></td>
                  <td width="8%"><input type="image" src="../../images/upload.jpg" name='save'/></td>
                </tr>
            </table>
            </div></td>
          </tr>

          <tr>
            <td bgcolor=""><table width="100%" border="0" class="tableFooter" align="center">
             <tr>
				<td align="center">
				<?php
					if($result2 == 1){
					  echo "<font color='blue' size='3' align='center'>File uploaded successfully</font><br>";
					}
					else if($result2 =='')
						echo '&nbsp;';
					else 
						echo "<font color='blue' size='3' align='center'>".$result2."</font><br>";	
				?>
				</td>
  			</tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<?php 
function getFormatedDate($strDate)
{
	$utcDays = $strDate - ($data->nineteenFour ? SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS1904 : SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS);
	$utcValue = round(($utcDays) * SPREADSHEET_EXCEL_READER_MSINADAY);
	$strreadyDate = date ('Y-m-d', $utcValue);
	
	return $strreadyDate;
}
?>
</body>
</html>



