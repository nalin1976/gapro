<?php
$backwardseperator = "../";
include "../authentication.inc";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Supplier Invoice</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="Button.js"></script>
<script src="../javascript/script.js"></script>
<script src="SupInvUploadData.js"></script>
</head>

<body>
<?php
include"../Connector.php";
?>
<form id="frmSupInvUploadData" name="frmSupInvUploadData" enctype="multipart/form-data" method="post" action="SupInvUploadDataGrid.php">
<table width="100%" border="0" align="center">
  <tr>
    <td><?php include "../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="820" border="0" align="center">
      <tr>
        <td width="54%"><table width="100%" border="0" align="center" class="tableBorder">
          <tr>
            <td width="100%" height="24" bgcolor="" class="mainHeading">Upload Supplier Invoice</td>
          </tr>
          <tr>
            <td><div class="bcgl1"><table width="100%" border="0">
                <tr>
                  <td width="8%" rowspan="2">&nbsp;</td>
                  <td width="23%" class="normalfnt">Supplier</td>
                  <td width="69%"><select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:225px">	 
					<?php
					$SQL="SELECT
							suppliers.strSupplierID,
							suppliers.strTitle
							FROM
							suppliers order by suppliers.strTitle";
					$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
					}
					?>
                    </select></td>
					<td><img src="../images/upload.jpg" onclick="addToGrid();"/></td>
                </tr>
                <tr>
                  <td width="23%" class="normalfnt">File</td>
                  <td><input type="file" name="filepath2" style="width:300px;" id="filepath2" class="textbox"  /></td>
				  <td></td>
                </tr>
            </table></div></td>
          </tr>
		  

         
          <tr>
            <td bgcolor=""><table width="100%" border="0" class="tableFooter" align="center">
                <tr>

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
<div style="left:555px; top:430px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadReport();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadReport();"/></div></td>
  </tr>
  </table>	  
  </div>
</form>
</body>
</html>
