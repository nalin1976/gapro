<?php
$backwardseperator = "../";
session_start();
include "../Connector.php";	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src=".js"></script>
</head>

<body>

<?php
$StyleNo=$_GET["style"];

?>
<table width="600"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td width="100%">
            <table  width="600" border="0">
                <tr>        	<td>
                    	<table width="60%" border="0" class="tableBorder">
                        	<tr><td align="right" colspan="3"><img src="../images/closelabel.gif" onclick="CloseWindow();" style="width:40px; height: 20px;" /></td></tr>
                        	
                            <tr>
                            	<td colspan="3">
                                    <div style="overflow:scroll;height:420px; width:900px;">
      <table align="center" width="1200" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblMain" class="table table-bordered">
      <thead>
        <tr>
          <td bgcolor="#498CC2" class="normaltxtmidb2" height="5">&nbsp;</td>  
          <td bgcolor="#498CC2" class="normaltxtmidb2" height="25">Main Category</td>
          <td bgcolor="#498CC2" class="normaltxtmidb2">Material Desc</td>
          <td bgcolor="#498CC2" class="normaltxtmidb2" height="25">Color</td>
          <td bgcolor="#498CC2" class="normaltxtmidb2" height="25">Size</td>
          <td bgcolor="#498CC2" class="normaltxtmidb2" height="25">Unit</td>
          <td bgcolor="#498CC2" class="normaltxtmidb2">Qty </td>
          <td bgcolor="#498CC2" class="normaltxtmidb2">Store Location </td>
        </tr>
      </thead>
      <tbody>
        <?php 

            $sql = "SELECT
matmaincategory.strDescription,
matitemlist.strItemDescription,
stocktransactions.strColor,
stocktransactions.strSize,
stocktransactions.strUnit,
Sum(stocktransactions.dblQty) AS Stock_Qty,
mainstores.strName
FROM
matitemlist
INNER JOIN stocktransactions ON matitemlist.intItemSerial = stocktransactions.intMatDetailId
INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
INNER JOIN mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
WHERE
stocktransactions.intStyleId = '$StyleNo'
GROUP BY
stocktransactions.intMatDetailId,
stocktransactions.strColor,
stocktransactions.strSize
HAVING 
round(Sum(stocktransactions.dblQty),2) > 0 ";
            
         $result = $db->RunQuery($sql);   
        //echo $sql;
	while($row =@mysql_fetch_array($result))
	{
	$loop++;
	$disposedQty=0;
	
		?>
        <tr>
          <td bgcolor="#FFFFFF" class="normalfnt"> <?php echo $loop; ?> </td>   
          <td bgcolor="#FFFFFF" class="normalfnt"> <?php echo $row["strDescription"]; ?> </td>  
          <td bgcolor="#FFFFFF" class="normalfnt"> <?php echo $row["strItemDescription"]; ?> </td>
          <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strColor"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strSize"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strUnit"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt"><?php echo round($row["Stock_Qty"],2); ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strName"]; ?></td>
          
        </tr>
        <?php 
	}
		?>
        </tbody>
      </table></div>
        </td></tr>
      </table></div> </td>
      </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>    </tr>
</table>
</body>
</html>