<?php
session_start();
include "../../Connector.php";
$backwardseperator = "../../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="550"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	
                        	<tr class="mainHeading" >
                            	<td width="100%" height="25">Chemicals</td>
                                <td width="18" ><img src="../../images/cross.png" alt="cross" onclick="CloseWindowInBC();"/></td>
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
                                    <!--<div style="height:250px;">-->
                                	<table style="width:510px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblChm">
									<thead>
                                    	<tr bgcolor="#498CC2" class="grid_header">
                                        	<th width="23" height="25" class="grid_header" style="text-align:center;width:20px;">No</th>
											<th width="251" class="grid_header" style="width:250px;">Chemical Description</th>
											<th width="74" class="grid_header" style="width:50px;">Unit</th>
											<th width="73" class="grid_header" style="width:50px;">Qty</th>
											<th width="74" class="grid_header" style="width:50px;">Unit Price</th>
											<th width="5" class="grid_header" style="width:1px;"><input name="chkChemSelectAll" type="checkbox" id="chkChemSelectAll" onclick="SelectAll(this,'tblChm');" /></th>
                                 		</tr>
									</thead>
									<tbody>
                                        <?php 
										$prcId=$_GET['prcId'];

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
														order by genmatitemlist.strItemDescription ASC";
														
										//echo $SQL_Chemicals;
										/*SELECT
														wc.intChemicalId,
														wc.dblUnitPrice,
														GMIL.strItemDescription,
														GMIL.strUnit
														FROM
														was_chemical AS wc
														Inner Join genmatitemlist GMIL ON wc.intChemicalId = GMIL.intItemSerial
														WHERE
														wc.intProcessId = '$prcId'
														order by GMIL.strItemDescription*/
														
										$resChm=$db->RunQuery($SQL_Chemicals);
										$i=1;
										while($row=mysql_fetch_array($resChm))
										{
										$color=""; 
											($i%2==1)?$color='grid_raw':$color='grid_raw2';?>
                                        
<tr class="bcgcolor-tblrowWhite" id="<?php echo $i;?>" style="height:20px;cursor:pointer;">
<td class="<?php echo $color;?>" style="text-align:left;"><?php echo $row['intChemicalId'];?></td>
<td style="width:100px;text-align:left;" class="<?php echo $color;?>"><?php //$des=split('-',$row['strItemDescription']); echo $des[count($des)-1];//echo $row['strItemDescription'];?>
<?php $des=split('-',$row['strItemDescription']); 
													//echo $des[count($des)-1];
													$chmA="";
													for($a=3;$a<count($des);$a++){
															$chmA.=$des[$a]."-";
													}
													echo substr($chmA,0,strlen($chmA)-1);
													//echo $row['strItemDescription'];?>
</td>
<td style="width:50px;text-align:left" class="<?php echo $color;?>" ><?php echo $row['strUnit'];?></td>
<td style="width:50px;"  class="<?php echo $color;?>"><input type="text" id="<?php echo "txtQty$i";?>"  value="<?php echo $row['dblQty'];?>" style="width:60px;text-align:right;" onkeypress="return CheckforValidDecimal(this.value,3,event)"/></td>
<td style="width:50px;"  class="<?php echo $color;?>"><input type="text" style="width:60px;text-align:right;" value="<?php echo $row['dblUnitPrice'];?>" onkeypress="return CheckforValidDecimal(this.value,2,event)" readonly="readonly" /></td>
<td style="width:10px;;text-align:center;"  class="<?php echo $color;?>"><input name="checkbox2" type="checkbox" id="<?php echo "chkChm$i";?>" /></td>
</tr>
                                        <?php $i++;}?>
										</tbody>
                                    </table>  
                                    <!--</div>-->                                </td>
                            </tr>
                            <tr>
							<td colspan="2" align="center">
							<img src="../../images/save.png" onclick="selectChemicals();" />
							<input type="hidden" id="hdnVal" />
							<img src="../../images/close.png" onclick="CloseWindowInBC();" /></td>
							</tr>
                         </table>
                    </td>
                </tr>
            </table>
         </td>
     </tr>
</table>
</body>
</html>