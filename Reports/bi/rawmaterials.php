<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";

require_once("../../commonPHP/generalclass.php");

$classGeneral = new GeneralClass();

$resStoresList = $classGeneral->GetMainStores();
$resCustomerList = $classGeneral->GetCustomers();
$resMainCategoryList = $classGeneral->GetMainCategoryList();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Raw Material Flow</title>
<link href="../../css/erpstyle.css" type="text/css" rel="stylesheet" />
<script src="bi.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="900" border="0"  cellpadding="0" cellspacing="0" align="center" >
<tr><td>
	<div class="bifront">
    	<table width="100%" cellpadding="1" cellspacing="1" border="0">
        	<tr><td colspan="2">&nbsp;</td></tr>	
        	<tr>
            	<td width="50%" valign="top">
                	<fieldset>
            			<legend >Location</legend>
                        	<select id="cmbStores" class="cmb" >
                            	<option value="-1"></option>
                                <?php 
									while($row=mysql_fetch_array($resStoresList)){
										echo "<option value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";	
									}
								?>
                            </select>
                        
                    </fieldset>    
            	</td><td width="50%"><fieldset>
            			<legend >Material Category</legend>
               	  <table width="100%" cellpadding="3" cellspacing="1" border="1">
                            	<tr>
                                	<td>Main Category</td>
                                    <td><select id="cmbMainCategory" class="cmb">
                                    		<option value="-1"></option>
                                            <?php
												while($rowMainCat = mysql_fetch_array($resMainCategoryList)){
													echo "<option value=".$rowMainCat["intID"]. ">".$rowMainCat["strDescription"]."</option>";	
												}
												
											
											?>
                                    </select>                                
           			</tr>
                                <tr>
                                	<td height="6"></td>

                    </tr>
                              <tr><td>Sub Category</td>
                              	  <td><select id="cmbSubCategory" class="cmb">
                                    	<option value="-1"></option>
                                        <option value="-1">1</option>
                                  </select></td>
                              
                              </tr>
                  </table>
                    </fieldset></td></tr>
                    
                <tr><td>
                	<fieldset>
            			<legend >Customer</legend>
                        	<select id="cmbCustomer" class="cmb">
                            	<option value="-1"></option>
                             <?php 
								while($rowCustomers=mysql_fetch_array($resCustomerList)){
									echo "<option value=\"".$rowCustomers["intBuyerID"]."\">".$rowCustomers["strName"]."</option>";	
								}
							?>
                        	</select>
                    </fieldset>  
                
                	</td>
                	<td width="50%">
                    	<fieldset>
            			<legend >Report Range</legend>
                        	<select id="cmbReportRange">
                        		<option value="1">Month wise in all years</option>
                                <option value="2">All years without months</option>
                            </select>
                    </fieldset>  
                    </td>
                </tr>	 
                <!--<tr>
                	<td>&nbsp;</td>
                    <td width="50%">
                    	<fieldset>
            			<legend >Report Type</legend>
                        	<select id="cmbReportType"></select>
                        	<option value="1"></option>
                    	</fieldset>  
                    </td>
                </tr> -->
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr><td colspan="2" align="right">
                	<img src="../../images/view.jpg" onclick="ViewCharts()" />&nbsp;<img src="../../images/close.png" />&nbsp;
                </td></tr>  
    	</table>
    </div>
</td></tr>


</table>
</body>
</html>