<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";
?>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #tblPrcBody { height:170px;  overflow:scroll;}
</style>

<table width="500" class="tableBorder" bgcolor="#FFFFFF">
          <!--  <tr>
            <td width="100%" height="16"  class="mainHeading">
			<table width="100%"border="0" >-->
                <tr><td align="right" colspan="3"><img src="../../images/closelabel.gif" onclick="CloseWindow();" style="width:40px;" /></td></tr>
                        	<tr  >
                            	<td height="35" class="mainHeading" colspan="3">Processes</td>
                            </tr>
             <!-- </table></td>-->
            </tr>
			
            <tr>
          <td height="0" class="normalfnt"><table width="100%" border="0" class="bcgl1">
		 <!-- <tr>
		    <td>&nbsp;</td>
		    </tr>-->
<!--		  <tr>
		  	<td  class="bcgcolor-tblrow normalfntMid" >Chemical Description </td>
		  </tr>-->
          			<tr>
                    	<table  width="100%" cellpadding="0" cellspacing="1" bgcolor="">
                            <tr>
                                   <td class="normalfnt">Search</td>
                                   <td align="left"><input type="text" id="txtPrcSearch" onkeyup="searchProcess(this,event);" style="width:250px"/></td>
                            </tr>
                        </table>
                  </tr>
                <tr>
                  <td width="100%">
                  <div style="overflow:scroll;height:225px;">
                      <table id="mytable" width="100%" cellpadding="0" cellspacing="1" bgcolor="">
                     <!-- <thead>-->
                    	
                        <tr bgcolor="#498CC2" class="normaltxtmidb2" height="25px;">
                        <td width="56" class="grid_header" style="width:10px;">Serial</td>
                        <td width="143" class="grid_header" style="width:300px;">Process Description</td>
                        <td width="60" class="grid_header" style="width:10px;">Liquor</td>
                        <td width="53" class="grid_header" style="width:10px;">Temp</td>
                        <td width="82" class="grid_header" style="width:10px;">Time</td>
                        <td width="79" class="grid_header" style="width:10px;">Time<br/>(Hand)</td>
                        </tr>
                        <!--</thead>
                        <tbody id="tblPrcBody">-->
<?php
$date="";
 $loop=0;
 $totalQty=0;
$sql="select intSerialNo,strProcessName,dblTemp,dblLiqour,dblTime,dblHTime from was_washformula where intStatus=1 order by strProcessName";
$result=$db->RunQuery($sql);
$rowCount = mysql_num_rows($result);
$i=1;
										while($row=mysql_fetch_array($result))
										{
										$color=""; 
											if(($i%2)==1){$color='grid_raw';}else{$color='grid_raw2';}?>
                                        
                                        <tr class="bcgcolor-tblrowWhite" id="<?php echo $i;?>" style="height:20px;cursor:pointer;" ondblclick="addProcesses(this.id);">
                                        	<td class="<?php echo $color;?>" style="text-align:right;"><?php echo $row['intSerialNo'];?></td>
                                            <td style="width:100px;text-align:left;" class="<?php echo $color;?>"><?php echo $row['strProcessName'];?></td>
                                            <td style="width:50px;text-align:right;" class="<?php echo $color;?>"><?php echo $row['dblTemp'];?></td>
                                            <td style="width:50px;text-align:right;" class="<?php echo $color;?>"><?php echo $row['dblLiqour'];?></td>
                                            <td style="width:50px;text-align:right;" class="<?php echo $color;?>"><?php echo $row['dblTime'];?></td>
                                            <td style="width:50px;text-align:right;" class="<?php echo $color;?>"><?php echo $row['dblHTime'];?></td>
                                 		</tr>
                                        <?php $i++;}?>
                                      <!--  </tbody>-->
                      </table>
                  </div></td>
            </tr>
              </table></td>
  </tr>
          </table>
