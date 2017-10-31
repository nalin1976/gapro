<?php
session_start();
include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Edit User Account</title>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="javascript/script.js"> </script>
<script type="text/javascript">
var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
		// alert(1);
	}	
}

function ReloadImage()
{
	var obj = document.getElementById('CAPTCHA');
    var src = obj.src;
    var pos = src.indexOf('?');
    if (pos >= 0) {
       src = src.substr(0, pos);
    }
    var date = new Date();
    obj.src = src + '?v=' + date.getTime();
}

function checkemail(str)
{
	var filter= /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(str))
		return true;
	else
		return false;
}

function validateForm(searchUserId,email,password1,password2,userName)
{
	if(searchUserId=="")
	{
		alert("Please select the 'User Name' which you want to edit.");
		document.getElementById('cboSearch').focus();
		return;
	}
	else if (!checkemail(email))
	{
		alert("Pease enter Valid email address");
		document.getElementById('txtemailaddress').focus();
		return false;
	}	
	/*else if (password1 == "")
	{
		alert("Pease enter the Password.");
		document.getElementById('txtpassword').select();
		return false;
	}*/
	else if(password1 !="" ||password2 !="" )
	{
		if (password1 != password2)
		{
			alert("The password and retype password does not match.");
			document.getElementById('txtpassword2').select();
			return false;
		}
	}
	else if (userName == "")
	{
		alert("Please enter 'User Name'.");
		document.getElementById('txtname').select();
		return false;
	}
	else
		return true;
	
return true;
}

function PrepairSubmition(obj)
{
	var searchUserId 	= document.getElementById('cboSearch').value;
	var email 			= document.getElementById('txtemailaddress').value.trim();
	var password1 		= document.getElementById('txtpassword').value.trim();
	var password2 		= document.getElementById('txtpassword2').value.trim();
	var userName 		= document.getElementById('txtname').value.trim();
	
	if(!validateForm(searchUserId,email,password1,password2,userName))
		return;
			
	var url  = "userHandling.php?";
		url += "RequestType=CheckEditUserAvailability";
		url += "&Email="+URLEncode(email);
		url += "&userId="+searchUserId;
	var htmlobj=$.ajax({url:url,async:false});
	var XMLResult = htmlobj.responseXML.getElementsByTagName("Result");
	
	if (XMLResult[0].childNodes[0].nodeValue == "True")
		alert("User already exists. Please try with another email address.");
	else
		EditUserAccount(searchUserId,email,password1,password2,userName);
}
function EditUserAccount(searchUserId,email,password1,password2,userName)
{
	var tblMain = document.getElementById('tblFactory');
	var exGenPercent = document.getElementById('txtExGrnPercent').value;
	var companies = '';
	for(var loop=1;loop<tblMain.rows.length;loop++)
	{
		if(tblMain.rows[loop].cells[1].childNodes[0].checked)
			companies += tblMain.rows[loop].cells[1].id +",";
	}
	if(companies=="")
	{
		alert("Please select the at least one company befor you save.");
		return;	
	}
	
	var url  = "userHandling.php?";
		url += "RequestType=EditUserDetails";
		url += "&Email="+URLEncode(email);
		url += "&passwoard="+password1;
		url += "&userName="+URLEncode(userName);
		url += "&userId="+searchUserId;
		url += "&companies="+companies;
		url += "&exGenPercent="+exGenPercent;
	var htmlobj=$.ajax({url:url,async:false});
	alert(htmlobj.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue);
}
function addCompaniesToText(obj)
{
	var tbl 	= document.getElementById('tblFactory');
	var rows 	= tbl.rows.length;
	var value='';
	for(var i=1;i<rows;i++)
	{
		var chk = tbl.rows[i].cells[1].childNodes[0];
		if(chk.checked)
		{
			value +=  tbl.rows[i].cells[1].id +',';
		}
	}
	document.getElementById('txtFactory').value = value;
}

function LoadUserDetails(obj)
{
	showBackGroundBalck();
	var url  = "userHandling.php?";
		url += "RequestType=LoadUserDetails";
		url += "&userId="+obj;
	var htmlobj=$.ajax({url:url,async:false});	
//	var XMLEmailAddress1 = htmlobj.responseXML.getElementsByTagName("EmailAddress1");				
//	document.getElementById('cboSearch').value =  XMLEmailAddress1[0].childNodes[0].nodeValue;
	var XMLEmailAddress = htmlobj.responseXML.getElementsByTagName("EmailAddress");
	if(XMLEmailAddress.length<=0){
		ClearForm(2);
		return;
	}
	
	document.getElementById('txtemailaddress').value =  XMLEmailAddress[0].childNodes[0].nodeValue;
	var XMLUserName = htmlobj.responseXML.getElementsByTagName("UserName");				
	document.getElementById('txtname').value =  XMLUserName[0].childNodes[0].nodeValue;
	var XMLExPercentage = htmlobj.responseXML.getElementsByTagName("ExPercentage");				
	document.getElementById('txtExGrnPercent').value =  XMLExPercentage[0].childNodes[0].nodeValue;
	
	LoadUserCompany(obj);
}

function LoadUserCompany(obj)
{
	var url  = "userHandling.php?";
		url += "RequestType=LoadUserCompany";
		url += "&userId="+obj;
	var htmlobj=$.ajax({url:url,async:false});	
	var XMLCompanyName = htmlobj.responseXML.getElementsByTagName("CompanyName");
	var XMLCompanyId = htmlobj.responseXML.getElementsByTagName("CompanyId");
	var XMLStatus = htmlobj.responseXML.getElementsByTagName("Status");
	RemoveAllRows('tblFactory');
	
	for(var loop=0;loop<XMLStatus.length;loop++)
	{
		var companyName = XMLCompanyName[loop].childNodes[0].nodeValue;
		var companyId = XMLCompanyId[loop].childNodes[0].nodeValue;
		var status = XMLStatus[loop].childNodes[0].nodeValue;
		
		AddCompanyToGrid(companyName,companyId,status);
	}
	hideBackGroundBalck();
}

function AddCompanyToGrid(companyName,companyId,status)
{
	var tblMain 	= document.getElementById('tblFactory');
	var lastRow 	= tblMain.rows.length;	
	var row 		= tblMain.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";	
    var	disabled 	= "";
	var cell 		= row.insertCell(0);
	cell.className  = "normalfnt";
	cell.innerHTML  = companyName;
	
	var cell 		= row.insertCell(1);
	cell.className  = "normalfntMid";
	cell.id 		= companyId;
	if(!canEditUserCompany)
		disabled 	= "disabled=\"disabled\"";
		
	if(status==1)
		cell.innerHTML  = "<input "+disabled+" name=\"chkFactory\" type=\"checkbox\" class=\"txtbox\" id=\"chkFactory\" value=\"checkbox\" checked=\"checked\"/>";
	else 
		cell.innerHTML  = "<input "+disabled+" name=\"chkFactory\" type=\"checkbox\" class=\"txtbox\" id=\"chkFactory\" value=\"checkbox\" />";
}

function ResetPage()
{	
	document.frmcategories.reset();
	var userId = document.getElementById('cboSearch').value;
	LoadUserCompany(userId);
}

function CheckAll(obj)
{
 	if(obj.checked)
		check = true;
	else
		check = false;
	var tbl = document.getElementById('tblFactory');
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		if(!tbl.rows[loop].cells[1].childNodes[0].disabled)
			tbl.rows[loop].cells[1].childNodes[0].checked = check
	}
}
function GetZeroIsEmpty(obj)
{
	if(obj.value=="")
		obj.value = 0;
}
function MaxQty(obj)
{
	if(obj.value>100)
		obj.value = 100;
}
</script>

</head>
<?php
	include "Connector.php";
?>

<?php
	//$canEditAnyUserAccount	= false;
	//$canEditUserCompany 	= true;
	if(!$canEditAnyUserAccount)
		$userId=$_SESSION["changingUser"];
	else
		$userId=$_SESSION["UserID"];	
	?>

<body onload="LoadUserDetails('<?php echo $userId ?> ');">
  <tr>
    <td><?php include 'Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">

  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="26%">&nbsp;</td>
        <td width="48%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" class="mainHeading">Edit User Account </td>
          </tr>
          <tr>
            <td height="165"><form name="frmcategories" id="frmcategories" method="post" action="edituser.php">
              <table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" height="26" class="head1">Basic Information</td>
                </tr>
                <tr class="bcgl1">
                  <td><table width="100%" border="0" class="tableBorder">
                    <tr>
                      <td width="5%"><input name="txtUpdate" type="hidden" class="txtbox" id="txtUpdate" value="Update" /></td>
                      <td width="31%" class="normalfnt">Search</td>
                      <td width="64%" class="normalfnt"><select id="cboSearch" name="cboSearch" style="width:260px;" 
					  <?php if(!$canEditAnyUserAccount){ ?> disabled="disabled"  <?php  } ?> class="txtbox" onchange="">
        <?php
             if(!$canEditAnyUserAccount){   
			//$SQL="SELECT intUserID, UserName,Name FROM useraccounts WHERE intCompanyID = '".$_SESSION["FactoryID"]."' AND intUserID='".$userId."'";
			$SQL="SELECT intUserID, UserName,Name,intExPercentage FROM useraccounts WHERE intUserID='".$userId."' and status = 1 order by UserName";
			$result = $db->RunQuery($SQL);
                while($row = mysql_fetch_array($result))
                {
					$email = $row["UserName"];
					$Name = $row["Name"];
					$exPercentage = $row["intExPercentage"];
                	echo "<option value=\"". $row["intUserID"] ."\">" . $row["UserName"] ."</option>" ;
                }
			}
			else{
			//$SQL="SELECT intUserID, UserName FROM useraccounts WHERE intCompanyID = '".$_SESSION["FactoryID"]."' ";
			$SQL="SELECT intUserID, UserName FROM useraccounts WHERE status = 1 order by UserName";
                	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			}
                $result = $db->RunQuery($SQL);
                while($row = mysql_fetch_array($result))
                {
                	echo "<option value=\"". $row["intUserID"] ."\">" . $row["UserName"] ."</option>" ;
                }
                
                ?>
      </select></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">E-Mail Address</td>
                      <td class="normalfnt"><input name="txtemailaddress" type="text" class="txtbox" id="txtemailaddress" size="40" value="<?php echo $email?>"/></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">New Password</td>
                      <td class="normalfnt"><input name="txtpassword" type="password" class="txtbox" id="txtpassword" size="40" /></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Re-Type Password</td>
                      <td class="normalfnt"><input name="txtpassword2" type="password" class="txtbox" id="txtpassword2" size="40" /></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">User Name</td>
                      <td class="normalfnt"><input name="txtname" type="text" class="txtbox" id="txtname" size="40" value="<?php echo $Name?>"/></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="normalfnt">Ex. Grn Percentage</td>
                      <td class="normalfnt"><input name="txtExGrnPercent" type="text" class="txtbox" id="txtExGrnPercent" size="2" maxlength="3" value="<?php echo $exPercentage?>" style="text-align:right" onkeypress="return IsNumberWithoutDecimals(this.value,event);" onblur="GetZeroIsEmpty(this);" onkeyup="MaxQty(this);" <?php if(!$canEditUserExcessPecentage) { ?> disabled="disabled" <?php }?>/>
                        &nbsp;%</td>
                    </tr>
					
					  <tr>
                      <td>
                        <input style="visibility:hidden"  name="txtFactory" type="text" id="txtFactory" size="2" />                     </td>
                      <td class="normalfnt">Factory / Office </td>
                      <td class="normalfnt">
					  <div id="divMain" style="overflow:auto;width:260px;height:100px;" >
				  <table id="tblFactory" width="100%" border="0" class="tableBorder" cellspacing="1" bgcolor="#FFD9D9">
					<tr class="mainHeading2">
					  <td width="91%" >Company Name </td>
					  <td width="9%"><input name="chkAll" type="checkbox" class="txtbox" id="chkAll" value="checkbox" onclick="CheckAll(this);" <?php if(!$canEditUserCompany){ ?> disabled="disabled" <?php } ?>/></td>
					</tr>
									
                 <?php
				$SQL = "SELECT intCompanyID,concat(strName,'-',strComCode)as strName FROM companies c where intStatus='1' order by strName;";
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{
				$flag=0;
					//if($canEditAnyUserAccount){
						 $SQL2 = "SELECT userId,companyId FROM usercompany c where  userId='".$userId."' ";
						$result2 = $db->RunQuery($SQL2);
						while($row2 = mysql_fetch_array($result2))
						{
						
						if($row["intCompanyID"]==$row2["companyId"])
						 $flag++;
						}
					//}				
				?>
					<tr class="bcgcolor-tblrowWhite">
					  <td ><?php echo $row["strName"]; ?></td>
					  <td id="<?php echo $row["intCompanyID"]; ?>" align="center"><input name="chkFactory" type="checkbox" class="txtbox" id="chkFactory" value="checkbox"  <?php if($flag>0){ ?> checked="checked"  <?php  } ?> <?php if(!$canEditUserCompany){ ?>
					  disabled="disabled" <?php } ?> onclick="addCompaniesToText(this);" /></td>
					</tr>
				<?php
				}
				?>
				  </table>      </div>							  </td>
					  </tr>
					 
                    <tr>
                      <td height="21">&nbsp;</td>
                      <td valign="top" class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td ><table width="100%" border="0" class="tableBorder">
                    <tr>
                      <td><div align="center">
					  <img src="images/new.png" alt="new" width="96" height="24" onclick="ResetPage();"/>
					  <img src="images/save.png" alt="next" onclick="PrepairSubmition();" />
                      <a href="main.php"><img src="images/close.png" alt="Close"  border="0" /></a>
					  </div></td>                      
                    </tr>
                  </table></td>
                </tr>
              </table>
                        </form>            </td>
          </tr>
        </table></td>
        <td width="26%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
     <td class="copyright" align="right">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
var canEditUserCompany = "<?php echo $canEditUserCompany ?>";
</script>
