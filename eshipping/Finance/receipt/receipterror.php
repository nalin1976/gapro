<?php
session_start();
	include "../../Connector.php";		
	$backwardseperator = "../../../";
	include "../../authentication.inc";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Error Report</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" src="receipt.js"></script>
<script src="../../shipmentpackinglist/stylerato/stylerato_plugin/styleratioplplugin.js" type="text/javascript"></script>
<script src="../../javascript/tablednd.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="v">
  <tr>
    
  </tr>
  <tr>
    <td align="center"><table width="400" border="0" cellspacing="0" cellpadding="0" style="padding:15px;">
      <tr>
        <th width="399" height="20" bgcolor="#316895" class="TitleN2white">Error Report</th>
      </tr>
      <tr>
        <td>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="2" id="tblerror" class="normalfnt bcgl1">
          
          <tr>
            <td  colspan="2" ></td>
            </tr>
         <!-- <tr>
            <th  colspan="2" class="mainHeading2" style="background-color:#CCC; text-align:center">Size Ratio</th>
            </tr>
          <tr>-->
            <td  colspan="2" valign="top"><table width="399" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="sizeratio_grid">
              <thead>
                <tr bgcolor="#498CC2" class="normaltxtmidb2">
                  <th width="45%" style="text-align:center">Invoice No</th>
                  <th width="45%" style="text-align:center">Po No</th>
                  </tr>
                </thead>
                <tbody>
                
                
                <?php 
				
			
				
						
								 $sql_error="SELECT strInvoice_No, strBuyer_PoNo
											FROM import_receipt
											WHERE intStatus=0";
											
								$result_error=$db->RunQuery($sql_error);	
								
								while($row=mysql_fetch_array($result_error))
									{
										?>
										<tr>
										<td align="center"><?php echo $row['strInvoice_No'];   ?></td>
                                        <td align="center"><?php  echo $row['strBuyer_PoNo'];   ?></td>
                                        
                                       </tr> 
								
                                
                                <?php
								
									}	
								
													
					
			
				
				?>
               
             
                </tbody>
              </table>
              
              </td>
            </tr>
          
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
<script src="../../js/jquery.fixedheader.js" type="text/javascript"></script>
<script src="../../shipmentpackinglist/stylerato/stylerato_plugin/stylerato_plugin.js" type="text/javascript"></script>
</html>