<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample Requisitions Pop Up</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/tablegrid.js"></script>

<script src="../../javascript/script.js"></script>
<script src="SampleRequisition.js"></script> <!-- added on 02/03/2011 by Chandima Batuwita-->


</head>
<body>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Sizes<span class="vol"></span><span id="sample_popup_close"></span></div>
	    </div>
		      <div class="main_body">
        <img src="../../images/add-new.png" alt="add new" align="right" id="cmdAddNew" width="109" height="16" onclick="showColorSizeSelector2('m')" />
        <table width="106%" border="0" class="bcgl1">
            
            <tr>
            <td>		
			<div style="overflow:scroll; height:200px; width:500px; ">
             <table width="15%" border="0" cellspacing="1" id="tbl_srp" bgcolor="#CCCCFF" >
                <thead>
                  <tr  style="text-align:center">
                    <td width="40%" class="normaltxtmidb2" bgcolor="#FFCC66"><b>Size/Colour</b><input type="text"readonly="readonly" style=" width:100px; text-align:center; visibility:hidden; width:100px; height:1px;"/></td>
                  </tr>
                </thead>
                
              </table>
		  </div>
          </td>
          </tr>
          </table>
    <br />
			<table align="center" width="367" border="0">
      			<tr>
					<td width="15%">&nbsp;</td>
					<td width="26%"><img src="../../images/new.png" width="90" onclick="addRow1();"/></td>
					<td width="23%"><img src="../../images/save.png" width="80"  onclick="addToGrid(<?php echo "$rowIndex" ?>);"/></td>
					<td width="26%"><img src="../../images/close.png" onclick="closePopupBox(1);" alt="close" width="90"  /></td>	
					<td width="10%">&nbsp;</td>
      			</tr>
		  </table>
		</div>
	</div>
    
</div>
</body>
</html>
