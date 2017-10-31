<?php
$backwardseperator = "../../../";
session_start();

$mId = $_GET['mId'];
$styleId = $_GET['styid'];
$OPid = $_GET['opid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js"></script>
<script src="thread_consumption.js" type="text/javascript"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
</head>

<body>

<?php
include "../../Connector.php";

?>
<table width="600"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="600" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	<tr><td align="right" colspan="3"><img src="../../images/closelabel.gif" onclick="CloseWindow();" style="width:40px;" /></td></tr>
                        	<tr class="cursercross" onmousedown="grab(document.getElementById('frmCombinations'),event);">
                            	<td height="30"  class="mainHeading2" colspan="3">Combination</td>
                            </tr>
                            <tr>
                           	  <td colspan="3"><div style="overflow:scroll;height:320px;">
                                <table>
                                  <tr>
                                    <td width="55%" align="center"><fieldset class="fieldsetStyle" style="width:800px;height:100px;-moz-border-radius: 5px;">
                                      <table align="center" width="100%">
                                        <tr>
                                          
                                           <td class="normalfnt" width="87">PO No</td>
                                          <td class="normalfnt" width="137"><input style="width:130px;" name="txtCombPo" id="txtCombPo" class="txtbox" type="text" readonly="" />                                          </td>   
                                          <td class="normalfnt" width="87">Style No</td>
                                          <td class="normalfnt" width="137"><input style="width:130px;" name="txtCombStyle" id="txtCombStyle" class="txtbox" type="text" readonly="" />
                                              <input style="width:50px;" name="txtCombStyleID" id="txtCombStyleID" class="txtbox" type="hidden" />
                                              <input type="hidden" name="txtPrevRow" id="txtPrevRow" />
                                              <input type="hidden" name="txtTotLen" id="txtTotLen"/>                                          </td>
                                        </tr>
                                        <tr>
                                        <td width="136" height="26" class="normalfnt">Machine</td>
                                    <td class="normalfnt" width="177"><select style="width: 132px;" class="txtbox" name="cboMachine" id="cboMachine" disabled="disabled">
                                              <option value="">Select one</option>
                                              <?php
								
								$SQL="	SELECT * 
								FROM ws_machinetypes m where m.intStatus=1";
								
								$result =$db->RunQuery($SQL);
								while ($row=mysql_fetch_array($result))
								{
								echo "<option value=\"".$row["intMachineTypeId"]."\">".$row["strMachineCode"]."</option>";
								}
								
								?>
                                            </select>
                                              <input type="hidden" name="txtCombStLength" id="txtCombStLength" style="width:10px" /></td>
                                          <td class="normalfnt" width="87">Operation</td>
                                          <td class="normalfnt" width="137"><input style="width:130px;" id="txtComOpert" name="txtComOpert" class="txtbox" type="text" readonly="" /><input style="width:50px;" id="txtComOpertID" name="txtComOpertID" class="txtbox" type="hidden" /></td>
                                        </tr>
                                       
                                        <tr>
                                          <td class="normalfnt" width="87">Machine ID</td>
                                          <td class="normalfnt" width="137"><input style="width:130px;" class="txtbox" id="txtCombMac" name="txtCombMac" type="text" readonly="" />
                                              <input style="width:50px;" class="txtbox" id="txtCombMacID" name="txtCombMacID" type="hidden" /></td>
                                              
                                              <td class="normalfnt" width="87">Length</td>
                                          <td class="normalfnt" width="137"><input style="width:130px;" class="txtbox" name="txtCombLen" id="txtCombLen" type="text" readonly="" />
                                              <input style="width:130px; visibility:hidden; height:1px" class="txtbox" name="txtCombSavedLen" id="txtCombSavedLen" type="text" readonly="" /><input type="hidden" id="txtSerial" name="hidden" readonly="" /></td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="normalfnt">Machine Factor Name</td>
                                          <td class="normalfnt"><select style="width: 132px;" class="txtbox" onchange="loadCombinationGrid();" name="cboMachine2" id="cboMachine2" >
                                            
                                           
								<?php
									$sqlCheckName = "SELECT
													 distinct ws_threaddetails_combination.intFactorNameID
													 FROM ws_threaddetails_combination
													 WHERE
													 ws_threaddetails_combination.strStyleId =  '$styleId' AND
													 ws_threaddetails_combination.strOperationId =  '$OPid'";
													 
									$result77 =$db->RunQuery($sqlCheckName);
									$row77=mysql_fetch_array($result77);
								
								  $SQL="SELECT
										distinct ws_machinefactors.intFactorNameID,
										ws_machinefactornames.strMachineFactorName
										FROM
										ws_machinefactors
										Inner Join ws_machinefactornames ON 
										ws_machinefactors.intFactorNameID =  ws_machinefactornames.intID
										WHERE
										ws_machinefactors.intMachineTypeId =  '$mId'
										order by ws_machinefactornames.strMachineFactorName";
								
								$result =$db->RunQuery($SQL);
								while ($row=mysql_fetch_array($result))
								{
									if(($row77['intFactorNameID']!="") && ($row77['intFactorNameID']==$row["intFactorNameID"]))
									{
									echo "<option selected value=\"".$row["intFactorNameID"]."\">".$row["strMachineFactorName"]."</option>";
									}
									else
									{
										echo "<option value=\"".$row["intFactorNameID"]."\">".$row["strMachineFactorName"]."</option>";
									}
								}
								
								?>
                                          </select></td>
                                        </tr>
                                        <tr>
                                          <td class="normalfntRite"  colspan="4"></td>
                                        </tr>
                                        <tr>
                                          <td class="normalfnt"  colspan="4"></td>
                                        </tr>
                                        <tr>
                                          <td class="normalfnt"  colspan="4"></td>
                                        </tr>
                                      </table>
                                    </fieldset></td>
                                    <td width="45%"></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><div id="divconsCombi" class="main_border_line" style="overflow:scroll; height:150px; width:825px;">
                                       <table width="100%" cellpadding="0"  cellspacing="1" class="thetable" id="tblCombination">
                                          <caption style="background-color:#FBF8B3">
                                          </caption>
                                          <tr>
                                            <td style="background-color:#FBF8B3" >Serial</td>
                                            <td style="background-color:#FBF8B3">Color</td>
                                            <td style="background-color:#FBF8B3">Stitch Type</td>
                                            <td style="background-color:#FBF8B3">Thread Type</td>
                                            <td style="background-color:#FBF8B3">Machine Id</td>
                                            <td style="background-color:#FBF8B3">Operation</td>
                                            <td style="background-color:#FBF8B3">Length</td>
                                            <!--<th style="display:none">status</th>-->
                                          </tr>
                                          <tr>
                                            <td colspan="9" height="40" class="normalfnt"></td>
                                          </tr>
                                          <tr>
                                            <td colspan="9" class="normalfntMid"><div id="imag"><img src="../../images/loadingimg.gif" /></div></td>
                                          </tr>
                                        </table>
                                    </div></td>
                                  </tr>
                                </table>
                       	      </div></td>
                            </tr>
                            <tr><td> <img src="../../images/save.png" onclick="saveCombinations();" class=""/> </td></tr>
                         </table>
                    </td>
                </tr>
            </table>
         </td>
     </tr>
</table>
</body>
</html>