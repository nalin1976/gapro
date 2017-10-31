<?php
$backwardseperator = "../../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src=".js"></script>
</head>

<body>

<?php
include "../../Connector.php";

?>
<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	<tr><td align="right" colspan="3"><img src="../../images/closelabel.gif" onclick="CloseWindow();" style="width:40px;" /></td></tr>
                        	<tr>
                            	<td height="35" class="mainHeading" colspan="3">Chemicals</td>
                            </tr>
                            <tr style="display:none;">
                        	  <td height="25" colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr >
                                  <td width="2%">&nbsp;</td>
                                  <td width="12%">&nbsp;<b>Search</b></td>
                                  <td width="61%"><input type="text" id="txtChemSearch" name="txtChemSearch" style="width:250px" onkeypress="SearchChemical(this,event,<?php echo $_GET['prcId'];?>);"/></td>
                                  <td width="25%">&nbsp;</td>
                                </tr>
                              </table></td>
                       	  </tr>
                            <tr>
                            	<td colspan="3">
                                    <div style="overflow:scroll;height:192px;">
                                	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblChm">
                                    	<!--<tr class="">
                                        	<td class="grid_header">No</td>
                                        	<td style="width:200px;" class="grid_header">Chemical Description</td>
											<td style="width:70px;" class="grid_header">Unit</td>
											<td style="width:70px;" class="grid_header">Qty</td>
											<td style="width:70px;" class="grid_header">Unit Price</td>
											<td style="width:50px;" class="grid_header"><input type="checkbox" onclick="SelectAll(this,'tblChm')"</td>
                                 		</tr>-->
                                        <tr bgcolor="#498CC2" class="grid_header">
                                            <th width="23" height="25" class="grid_header" style="text-align:center;width:20px;">No</th>
                                            <th width="200" class="grid_header" style="width:250px;">Chemical Description</th>
                                            <th width="74" class="grid_header" style="width:50px;">Unit</th>
                                            <th width="73" class="grid_header" style="width:50px;">Qty</th>
                                            <th width="74" class="grid_header" style="width:50px;">Unit Price</th>
                                            <th width="5" class="grid_header" style="width:1px;"><input name="chkChemSelectAll" type="checkbox" id="chkChemSelectAll" onclick="SelectAll(this,'tblChm');" /></th>
                                        </tr>
                                        <?php 
										$prcId=$_GET['prcId'];
									/*	$SQL_Chemicals="SELECT 
														wc.intChemicalId,
														wcl.strItemDescription,
														wcl.strUnit,
														wc.dblQty,
														wc.dblUnitPrice 
														FROM was_chemmatitemlist AS wcl
														Inner Join was_chemical AS wc ON wcl.intSerialNo = wc.intChemicalId
														WHERE  intStatus=1
														AND 
														wc.intProcessId= $prcId order by wc.intChemicalId;";*/
														
										$SQL_Chemicals="SELECT
														wc.intChemicalId,
														wc.dblUnitPrice,
														genmatitemlist.strItemDescription,
														genmatitemlist.strUnit
														FROM
														was_chemical AS wc
														Inner Join genmatitemlist ON wc.intChemicalId = genmatitemlist.intItemSerial
														WHERE
														wc.intProcessId = '$prcId'
														AND genmatitemlist.intStatus='1'
														order by genmatitemlist.strItemDescription ASC";
														//echo $SQL_Chemicals;
										$resChm=$db->RunQuery($SQL_Chemicals);
										$i=1;
										while($row=mysql_fetch_array($resChm))
										{
										$color=""; 
											if(($i%2)==0){$color='grid_raw';}else{$color='grid_raw2';}?>
                                        
                                        <tr class="bcgcolor-tblrowWhite" id="<?php echo $i;?>" style="height:20px;cursor:pointer;">
                                        	<td class="<?php echo $color;?>" style="text-align:left;"><?php echo $row['intChemicalId'];?></td>
                                            <td style="width:100px;text-align:left;" class="<?php echo $color;?>">
                                            	<?php $des=split('-',$row['strItemDescription']); 
													//echo $des[count($des)-1];
													$chmA="";
													for($a=3;$a<count($des);$a++){
															$chmA.=$des[$a]."-";
													}
													echo substr($chmA,0,strlen($chmA)-1);
													//echo $row['strItemDescription'];?>
                                            </td>
                                            <td style="width:50px;text-align:left;" class="<?php echo $color;?>">
                                            	<?php echo $row['strUnit'];?>
                                            </td>
                                            <td style="width:50px;text-align:right;"  class="<?php echo $color;?>">
                                                <input type="text" id="<?php echo "txtQty$i";?>"  value="<?php echo $row['dblQty'];?>" style="width:50px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,3,event)"/>
                                            </td>
                                            <td style="width:50px;text-align:right;"  class="<?php echo $color;?>">
												<input type="text" style="width:50px;text-align:right;" value="<?php echo $row['dblUnitPrice'];?>" onkeypress="return CheckforValidDecimal(this.value,2,event)" />
                                            </td>
                                            <td style="width:50px;"  class="<?php echo $color;?>"><input type="checkbox" id="<?php echo "chkChm$i";?>" /></td>
                                 		</tr>
                                        <?php $i++;}?>
                                      
                                    </table>  
                                    </div>
                                </td>
                            </tr>
                            <tr><td><img src="../../images/ok.png" onclick="selectChemicals();" /><input type="hidden" id="hdnVal" />
							<img src="../../images/close.png" onclick="CloseWindow();" /> </td></tr>
                         </table>
                    </td>
                </tr>
            </table>
         </td>
     </tr>
</table>
</body>
</html>