<?php
$backwardseperator = "../";
include "../authentication.inc";
session_start();
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Marker Details</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="Button.js"></script>
<script src="../javascript/script.js"></script>
<script src="tuka.js"></script>
</head>

<body>
<?php
include"../Connector.php";
?>

<?php  

  if($_FILES["datUpload"]["error"] == 1){
   echo "The uploaded file exceeds the upload_max_filesize directive in php.ini .";
  }
  else if($_FILES["datUpload"]["error"] == 2){
   echo "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
  }
  else if($_FILES["datUpload"]["error"] == 3){
   echo "The uploaded file was only partially uploaded.";
  }
  else if($_FILES["datUpload"]["error"] == 4){
   echo "No file was uploaded";
  }
  else if($_FILES["datUpload"]["error"] == 6){
   echo "Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3";
  }
  else if($_FILES["datUpload"]["error"] == 7){
   echo "Failed to write file to disk. Introduced in PHP 5.1.0";
  }
  else if($_FILES["datUpload"]["error"] == 8){
   echo "A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded         extensions with phpinfo() may help. Introduced in PHP 5.2.0. ";
  }
  
  else if($_FILES["datUpload"]["error"] == 0){

 $filepath	     = $_POST['filepath2'];
 $txtComments	 = $_POST['txtComments'];
 $txtPttn	     = $_POST['txtPttn'];
 $txtStyle	     = $_POST['txtStyle'];
 $txtShrinkage	 = $_POST['txtShrinkage'];
 $txtPercentage	 = $_POST['txtPercentage'];

/*  $uploaddir  = "tukaExcel/";	   
  echo $uploadfile = $uploaddir . basename($_FILES['filepath']['name']);
  $uploadfile = $uploaddir . "ituploadhmm.txt";
	
	 if(move_uploaded_file($_FILES['filepath']['tmp_name'], $uploadfile)) 
 {
  echo "AAA";
 }	else{
  print_r($_FILES);
 }*/
 
 		$target  = "../tukaExcel/".$filepath."/xls/";
		$name    = explode('.',$_FILES['filepath2']['name']);

		if(move_uploaded_file($_FILES['filepath2']['tmp_name'], $target.$name[0].".".$name[1])){
         
		  require_once 'Excel/reader.php';
		  $data = new Spreadsheet_Excel_Reader();
		  $data->setOutputEncoding('CP1251');
		  $data->read("../tukaExcel/xls/$name[0].$name[1]");
		  

		   $markerName     = trim($data->sheets[0]['cells'][5][3]); 
		   $markerWidth    = trim($data->sheets[0]['cells'][6][3]); 
		   $markerLength   = trim($data->sheets[0]['cells'][7][3]); 
		   $plies          = trim($data->sheets[0]['cells'][8][3]); 
		   $layout         = trim($data->sheets[0]['cells'][9][3]); 
		   $material       = trim($data->sheets[0]['cells'][10][3]); 
		   $totPieces      = trim($data->sheets[0]['cells'][11][3]); 
		   $placed         = trim($data->sheets[0]['cells'][12][3]); 
		   $efficiency     = trim($data->sheets[0]['cells'][13][3]); 
		   $sumArea        = trim($data->sheets[0]['cells'][14][3]); 
		   $cutLength      = trim($data->sheets[0]['cells'][15][3]); 
		   $compBundles    = trim($data->sheets[0]['cells'][16][3]); 
		   $yeildPerBundle = trim($data->sheets[0]['cells'][17][3]); 
		   
		   $compCode=$_SESSION["FactoryID"];
		   
		   $strSQL="update syscontrol set  dblTukaSerial= dblTukaSerial+1 WHERE syscontrol.intCompanyID='$compCode'";
		   $result=$db->RunQuery($strSQL);
		   $strSQL="SELECT dblTukaSerial FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
		   $result=$db->RunQuery($strSQL);
		   
			while($row = mysql_fetch_array($result))
			{
			 $dblTukaSerial  =  $row["dblTukaSerial"] ;
			 break;
			}
		   
		   $sql1 = "insert into markerheader 
		           (intSerialNo,
		            strMarkerName,
		            strMarkerWidth,
					strMarkerLength,
					intPiles,
					strLayout,
					strMaterial,
					intTotPieces,
					intPlaced,
					strEffi,
					strSumArea,
					strCutLength,
					dtmDate,
					strComments,
					strPttn,
					strStyle,
					strShrinkage,
					strPercentage,
					dblYeildPerBundle)
					values
					('$dblTukaSerial',
					'$markerName',
					'$markerWidth',
					'$markerLength',
					'$plies',
					'$layout',
					'$material',
					'$totPieces',
					'$placed',
					'$efficiency',
					'$sumArea',
					'$cutLength',
					 now(),
					'$txtComments',
					'$txtPttn',
					'$txtStyle',
					'$txtShrinkage',
					'$txtPercentage',
					'$yeildPerBundle'
					)";
           $result1 = $db->RunQuery($sql1);
 

		   $te_date      = ""; 
		   $te_styleName = "";
		   $te_material  = "";
		   
		   for ($i = 21; $i < $data->sheets[0]['numRows']-1; $i++) {		

			 $date           =  $data->sheets[0]['cells'][$i][3];
			 $styleName      =  $data->sheets[0]['cells'][$i][4];
			 $material       =  $data->sheets[0]['cells'][$i][5];
			 $size           =  $data->sheets[0]['cells'][$i][6];
			 $order          =  $data->sheets[0]['cells'][$i][7];
			 $compBundles    =  $data->sheets[0]['cells'][$i][8];
			 $inCompBundles  =  $data->sheets[0]['cells'][$i][9];
			 $piecesBundles  =  $data->sheets[0]['cells'][$i][10];
			 $placed         =  $data->sheets[0]['cells'][$i][11];
			 
				if($date == '')
				{
	             $te_date = $te_date;
				}
				else
				{
				$te_date = $date;  
				}
				$te_date = $te_date; 
				
				if($styleName == '')
				{
	             $te_styleName = $te_styleName;
				}
				else
				{
				$te_styleName = $styleName;  
				}
				$te_styleName = $te_styleName; 
				
				if($material == '')
				{
	             $te_material = $te_material;
				}
				else
				{
				$te_material = $material;  
				}
				$te_material = $te_material;
				
				$sql2 = "insert into markerdetails 
				        (intSerialNo,
						 dtmDate,
						 strStyle,
						 strMaterial,
						 strSize,
						 strOrder,
						 dblCompBundles,
						 dblInCompBundles,
						 dblPieces,
						 dblPlaced)
						 values
						 ('$dblTukaSerial',
						  '$te_date',
						  '$te_styleName',
						  '$te_material',
						  '$size',
						  '$order',
						  '$compBundles',
						  '$inCompBundles',
						  '$piecesBundles',
						  '$placed'
						  )";
                $result2 = $db->RunQuery($sql2);
				
		   }		
		}else{
		 //print_r($_FILES);
		}
}
?>
<form enctype="multipart/form-data" id="frmTuka" name="frmTuka" method="post" action="tuka.php" >
<table width="100%" border="0" align="center">
  <tr>
    <td><?php include "../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="820" border="0" align="center">
      <tr>
        <td width="54%"><table width="100%" border="0" align="center" class="tableBorder">
          <tr>
            <td width="100%" height="24" bgcolor="" class="mainHeading">Marker Details</td>
          </tr>
          <tr>
            <td><div class="bcgl1"><table width="100%" border="0">

                <tr>
				  <td width="17%"></td>
                  <td width="19%" class="normalfnt">File</td>
                  <td width="46%"><input type="file" name="filepath2" style="width:300px;" id="filepath2" class="textbox"  /></td>
				  <td width="18%"><input type="image" src="../images/upload.jpg" name='save'/></td>
                </tr>
	            <tr>
				  <td></td>
                  <td width="19%" class="normalfnt">Comments</td>
                  <td><input type="text" name="txtComments" style="width:220px;" id="txtComments" class="textbox"  maxlength="30"/></td>
				  <td></td>
                </tr>
			    <tr>
				  <td></td>
                  <td width="19%" class="normalfnt">Pattern Name</td>
                  <td><input type="text" name="txtPttn" style="width:220px;" id="txtPttn" class="textbox"  maxlength="30"/></td>
				  <td></td>
                </tr>
				<tr>
				  <td></td>
                  <td width="19%" class="normalfnt">Style Name</td>
                  <td><input type="text" name="txtStyle" style="width:220px;" id="txtStyle" class="textbox"  maxlength="30"/></td>
				  <td></td>
                </tr>
				<tr>
				  <td></td>
                  <td width="19%" class="normalfnt">Shrinkage</td>
                  <td><input type="text" name="txtShrinkage" style="width:220px;" id="txtShrinkage" class="textbox"  maxlength="5"/></td>
				  <td></td>
                </tr>
				<tr>
				  <td></td>
                  <td width="19%" class="normalfnt">5 %</td>
                  <td><input type="text" name="txtPercentage" style="width:220px;" id="txtPercentage" class="textbox"  maxlength="5"/></td>
				  <td></td>
                </tr>
            </table></div></td>
          </tr>

          <tr>
            <td bgcolor=""><table width="100%" border="0" class="tableFooter" align="center">
             <tr>
				<td align="center">
				<?php
					if($result1 == 1 && $result2 == 1){
					  echo "<font color='blue' size='3' align='center'>Successfully Copied the Excel File</font><br>";
					}
				?>
				</td>
  			</tr>
            </table></td>
          </tr>
		  
		  <tr>
            <td bgcolor=""><table width="100%" border="0" class="tableFooter" align="center">
             <tr>
			    <td width="17%"></td>
			    <td width="19%" class="normalfnt">Marker</td>
				<td width="40%" align="left">
                 <select id="strMarkerName" name="strMarkerName">
				  <option></option>
					<?php
					   $sql = "SELECT distinct strMarkerName
								FROM
								markerheader order by strMarkerName";
					   $result=$db->RunQuery($sql);
						while($row = mysql_fetch_array($result))
						{
						 $strMarkerName = $row["strMarkerName"];
						 echo "<option value='$strMarkerName'>$strMarkerName</option>";
						}
					?>

				 </select>
				</td>
				<td width="24%" align="center"><img src="../images/report.png" width="100px" height="25px" onclick="loadReport();"/></td>
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
</body>
</html>


