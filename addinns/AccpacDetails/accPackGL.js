var xmlHttp;

var accNo=""
var accName=""
var accType=""
var accFactory=""
var pub_glPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_glUrl = pub_glPath+"/addinns/AccpacDetails/";
//var pub_taxurl	= "/gapro/addinns/AccpacDetails/";
function NewXMLHttpGLAcc(index) 
{
	if (window.ActiveXObject) 
    {
        GLAccXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        GLAccXmlHttp = new XMLHttpRequest();
    }
}

function GetXMLHttpGLAcc(index) 
{
	if (window.ActiveXObject) 
    {
        getGLAccXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        getGLAccXmlHttp = new XMLHttpRequest();
    }
}

function checkXMLHttpGLAllowcation(index) 
{
	if (window.ActiveXObject) 
    {
        checkGLAllowXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        checkGLAllowXmlHttp = new XMLHttpRequest();
    }
}

function SaveXMLHttpGLAllowcation(index) 
{
	if (window.ActiveXObject) 
    {
        SaveGLAlwXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        SaveGLAlwXmlHttp = new XMLHttpRequest();
    }
}


function getClear()
{
	$("#frmGlAccCreation")[0].reset();
	loadCombo('select intGLAccID,strDescription from glaccounts order by strDescription ','cboAcc');
	document.getElementById("txtAccID").focus();
	return true
}

function getCheckedValue(st)
{
	if(document.getElementById("txtAccID").value=="")
	{
		alert("Please enter \"Account Code\".");
		document.getElementById("txtAccID").focus();
		return false;
	} 
	
	if(document.getElementById("txtDescription").value=="")
	{
		alert("Please enter \"Account Description\"");
		document.getElementById("txtDescription").focus();
		return false;
	} 
	
	if(document.getElementById("cboAcType").value==0)
	{
		alert("Please select \"Account Type\"");
		document.getElementById("cboAcType").focus();
		return false;
	} 
	var x_id = document.getElementById("cboAcc").value;
	var x_name = document.getElementById("txtAccID").value;

	var x_find = checkInField('glaccounts','strAccID',x_name,'intGLAccID',x_id);
		if(x_find)
		{
			alert('"'+x_name+ "\" is already exist.");	
			document.getElementById("txtAccID").select();
			return;
		}	
		
	var intStatus =0;
	if($("#chkActive").attr('checked'))
			intStatus=1;
	accNo=URLEncode(document.getElementById("txtAccID").value);
	accName=URLEncode(document.getElementById("txtDescription").value);
	accType=document.getElementById("cboAcType").value;
	var accCat=document.getElementById('cboGLType').value.trim();
	var GLcategory = document.getElementById('cboCategory').value.trim();
	
	NewGLAccSave(accNo,accName,accType,st,intStatus,x_id,accCat,GLcategory);	
	return true;
}

function NewGLAccSave(accNo,accName,accType,st,intStatus,AccID,accCat,GLcategory)
{
	NewXMLHttpGLAcc();
    GLAccXmlHttp.onreadystatechange = HandleSaveGLAcc;
	GLAccXmlHttp.open("GET",pub_glUrl+'accPackGLDB.php?DBOprType=SaveNewGLAcc&AccNo=' + accNo + '&AccName='+ accName +'&AccType='+ accType +"&st"+st+"&intStatus="+intStatus+"&AccID="+AccID+"&cat="+accCat+"&GLcategory="+GLcategory, true);    
	GLAccXmlHttp.send(null);  
}

function HandleSaveGLAcc()
{
    if(GLAccXmlHttp.readyState == 4) 
    {
        if(GLAccXmlHttp.status == 200) 
        {  
			var XMLResult = GLAccXmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("GL Account saved successfully.");
				getClear();
			}
			else
			{
				alert("GL Account already exist.");
			}
		}
	}
}

function LoadGLAccs()
{
	clearSelectControl("cboDescription");
	GetXMLHttpGLAcc();
	
	getGLAccXmlHttp.onreadystatechange = HandleGLAccs;

	var xaccNo="0"
	var xaccDcs="0"
	var xaccFactory="0"
	
	//if(document.getElementById("cboID").value!=0)
	//{
	//	xaccNo=document.getElementById("cboID").value
	//}
	//else 
	
	if(document.getElementById("cboDescription").value!=0)
	{
		xaccDcs=document.getElementById("cboDescription").value
	}
	/*else if(document.getElementById("cboFacCode").value!=0)
	{
		xaccFactory=document.getElementById("cboFacCode").value
	}*/
	
    getGLAccXmlHttp.open("GET",pub_glUrl+'accPackGLDB.php?DBOprType=GetGLAccs&accNo=' + xaccNo + '&accDcs=' + xaccDcs, true);
	getGLAccXmlHttp.send(null); 
}

function HandleGLAccs()
{	
	if(getGLAccXmlHttp.readyState == 4) 
    {
	   if(getGLAccXmlHttp.status == 200) 
        {  
			var XMLGLAccName = getGLAccXmlHttp.responseXML.getElementsByTagName("accName");
			for ( var loop = 0; loop < XMLGLAccName.length; loop ++)
			 {
				var GLAccName = XMLGLAccName[loop].childNodes[0].nodeValue;
				var optStore = document.createElement("option");
				optStore.text = GLAccName;
				optStore.value = GLAccName;
				document.getElementById("cboDescription").options.add(optStore);
			 }
		}
	}
}

function saveGLAllowcation()
{
	var accID=0;
	var accGLID=0;
	var accFactory=document.getElementById("cboFactory").value.trim();
	//document.getElementById("txtAccID").value="";
	//document.getElementById("cboFactory").value=0;
	
	if(document.getElementById("cboFactory").value.trim()==0)
	{
		alert("Please select the Cost Center.");	
		document.getElementById("cboFactory").focus();
		return false;
	}
	if(document.getElementById("txtAccID").value.trim()=="")
	{
		alert("Please enter GL Accounts Allocation ID.");
		document.getElementById("txtAccID").focus();
		return false;
	}
	var tbl = document.getElementById('tblGLs');
	var count =0;
	var response=0;
	for(var no=1;no<tbl.rows.length;no++)
	{
		if(tbl.rows[no].cells[0].childNodes[0].childNodes[0].childNodes[0].checked)	
			count++;
	}
	
	if(count ==0)
	{
		alert("Please select \"Account ID\"");
		return false;
	}
	else
	{
		for(var no=1;no<tbl.rows.length;no++)
		{
			if(tbl.rows[no].cells[0].childNodes[0].childNodes[0].childNodes[0].checked)
			{
				
				var accID = tbl.rows[no].cells[1].id;
				var accGLID = tbl.rows[no].cells[2].id;
				
				var url = pub_glUrl+'accPackGLDB.php?DBOprType=saveGLAllowcation';
				//url += '&accID='+accID;
				url += '&accGLID='+accGLID;
				url += '&accFactory='+accFactory;
		
				htmlobj=$.ajax({url:url,async:false});
				var result = htmlobj.responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
				
				if(result == 'True')
					response++;
			}
		}
	}
	
	if(response == count)
	{
		alert("GL Accounts successfully allocated to \""+ $("#cboFactory option:selected").text()+"\"" );
		
	}
	getGLAccountsToAllowcation();
	return;
}

function HandleSaveGLAllowcation()
{
	if(SaveGLAlwXmlHttp.readyState == 4) 
    {
        if(SaveGLAlwXmlHttp.status == 200) 
        {  
/*			var XMLResult = SaveGLAlwXmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				document.getElementById("txtBinName").value = "";
				document.getElementById("txtBinRemark").value = "";
				clearBinsList()
				LoadBins(lid);
				alert("New Bin added successfully.");
			}
			else
			{
				alert("Process Failed.");
			}*/
		}
	}
}



function checkValidation()
{
	var x=0;
	
	if(document.getElementById("cboFactory").value==0)
	{
		alert("Please select the Cost Center")	;
		document.getElementById("cboFactory").focus();
		return false;
	}
	
	else if(document.getElementById("txtAccID").value=="")
	{
		alert("Please enter GL Accounts Allocation ID");
		document.getElementById("txtAccID").focus();
		return false;
	}
	
	else
	{		
		rows=document.getElementById('tblGLs').getElementsByTagName("TR");
		for (var j=1; j<rows.length; j++)
		{
			cells=rows[j].getElementsByTagName("TD");
			for (var i=0; i<cells.length; i++)
			{
				if(cells[0].firstChild.firstChild.firstChild.checked==true && cells[5].id==0 )
				{
					if(i==0)
					{
						cells[i].style.backgroundColor='#99FF99';					
						cells[i].value=document.getElementById("txtAccID").value;
					}
					else if(i==1)
					{
						cells[i].style.backgroundColor='#99FF99';
						//
						var glAccNo=cells[1].innerHTML;

						if(glAccNo.indexOf('-')== -1){
							cells[i].innerHTML=cells[i].innerHTML+"-"+document.getElementById("txtAccID").value;
						}
					}
					else if(i==4 || i==2 || i==3 || i==5)
					{
						cells[i].style.backgroundColor='#99FF99';
						cells[i].style.backgroundColor='#99FF99';
						cells[i].style.backgroundColor='#99FF99';
					}
				}
			}
		}
		
	}
}
//============================================================================================================

function getGLAccountsToAllowcation()
{
	var comID = document.getElementById("cboFactory").value;
	if(comID==0){
		clearGlAForm('frmGLAllocation','tblGLs');
		return false;
	}
	
	var url =pub_glUrl+'accPackGLDB.php?DBOprType=loadGLAlloData';	
		url += '&comID='+comID;
		
		htmlobj=$.ajax({url:url,async:false});
		
		var xmlfacAccNo = htmlobj.responseXML.getElementsByTagName("facAccNo");
			document.getElementById('txtAccID').value=xmlfacAccNo[0].childNodes[0].nodeValue;
			var xmlaccNo = htmlobj.responseXML.getElementsByTagName("accNo");
			var xmlaccGLNo = htmlobj.responseXML.getElementsByTagName("accGLID");
			var xmlaccName = htmlobj.responseXML.getElementsByTagName("accName");
			var xmlaccType = htmlobj.responseXML.getElementsByTagName("accType");
			var xmlaccFacCode = htmlobj.responseXML.getElementsByTagName("accFacCode");
			var xmlGLAccID = htmlobj.responseXML.getElementsByTagName("GLAccID");
			
			var strBinText = "<table width=\"600\" height=\"25\" bgcolor=\"#CCCCFF\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblGLs\">"+
			"<tr>"+
			"<td width=\"39\"  class=\"mainHeading4\"><input name=\"chkAll\" type=\"checkbox\" id=\"chkAll\" onclick=\"checkAll(this);\"  /></td>"+
			"<td width=\"115\"  class=\"mainHeading4\">Account ID</td>"+
			"<td width=\"243\" class=\"mainHeading4\">Description</td>"+
			"<td width=\"135\" class=\"mainHeading4\">Account Type</td>"+
			"<td width=\"60\"  class=\"mainHeading4\">Status</td>"+
			"</tr>";
			
			for ( var loop = 0; loop < xmlaccNo.length; loop ++)
			{
				var s=0;
				var accNo = xmlaccNo[loop].childNodes[0].nodeValue;
				
				var accGLNo = xmlaccGLNo[loop].childNodes[0].nodeValue;
				var GLAccNo = accNo;
				var GLAccountID = xmlGLAccID[loop].childNodes[0].nodeValue;
				if(accGLNo!="Allono")
				{
					accNo = accNo+xmlfacAccNo[0].childNodes[0].nodeValue;
					s=1;
				}
				else {
					s=0;
					accNo = accNo+xmlfacAccNo[0].childNodes[0].nodeValue;
					}
						
				var accName = xmlaccName[loop].childNodes[0].nodeValue;
				
				var accType = xmlaccType[loop].childNodes[0].nodeValue;
				if (accType==1) 
				{
					accType="PNL Account"
				}
				else if (accType==2)
				{
					accType="Balance Sheet"
				}
				else
				{
					accType=""
				}
				
				var accFacCode =document.getElementById("cboFactory").value;// xmlaccFacCode[loop].childNodes[0].nodeValue;
				var sts="";
				if(s==0){
					sts=" ";
				}
				else
				{
					sts="Allocated" ;
				}
				
				strBinText +="<tr bgcolor=\"#99FF99\" >"
				
				if(accGLNo!="Allono")
				{
					strBinText +="<td bgcolor=\"#FDE49B\" class=\"normalfnt\"><div align=\"center\">"+
								"<label>"
					strBinText +="<input name=\"chkSelect\" type=\"checkbox\" id=\"chkSelect\" value=\"checkbox\" disabled=\"disabled\";>"
					
					//strBinText +="<input name=\"chkSelect\" type=\"checkbox\" id=\"chkSelect\" value=\"checkbox\" checked=\"checked\"/>"
					strBinText +="</label>"+
								"</div></td>"+
								"<td bgcolor=\"#FDE49B\" class=\"normalfnt\">" + accNo + "</td>"+
								"<td bgcolor=\"#FDE49B\" class=\"normalfnt\">" + accName + "</td>"+
								"<td bgcolor=\"#FDE49B\" class=\"normalfnt\">" + accType + "</td>"+
								/*"<td bgcolor=\"#FDE49B\" class=\"normalfnt\">" + accFacCode + "</td>"+*/
								"<td bgcolor=\"#FDE49B\" class=\"normalfntMid\" id=\""+s+"\">" +sts+ "</td>"
					
				}
				else
				{
					
					strBinText +="<td  class=\"normalfnt\"><div align=\"center\">"+
								"<label>"
					strBinText +="<input name=\"chkSelect\" type=\"checkbox\" id=\"chkSelect\" value=\"checkbox\" checked=\"checked\" onclick=\"chngCheckBox(this);\"/>"
					strBinText +="</label>"+
								"</div></td>"+
								"<td class=\"normalfnt\" id=\""+GLAccNo+"\">" + accNo + "</td>"+
								"<td class=\"normalfnt\" id=\""+GLAccountID+"\">" + accName + "</td>"+
								"<td class=\"normalfnt\">" + accType + "</td>"+
								/*"<td class=\"normalfnt\">" + accFacCode + "</td>"+			*/		
								"<td class=\"normalfntMid\" id=\""+s+"\">" + sts + "</td>"					
					
					
					
				}
				
				strBinText +="</tr>"
			}
			
			strBinText +="</tr>"+
			/*"</tr>"+*/
			"</table>"

			document.getElementById("divcons").innerHTML=strBinText;
	
}



function HandleGLAccsAllocationTable()
{	
	if(checkGLAllowXmlHttp.readyState == 4) 
    {
	   if(checkGLAllowXmlHttp.status == 200) 
        {  
			
			var xmlfacAccNo = checkGLAllowXmlHttp.responseXML.getElementsByTagName("facAccNo");
			document.getElementById('txtAccID').value=xmlfacAccNo[0].childNodes[0].nodeValue;
			var xmlaccNo = checkGLAllowXmlHttp.responseXML.getElementsByTagName("accNo");
			var xmlaccGLNo = checkGLAllowXmlHttp.responseXML.getElementsByTagName("accGLID");
			var xmlaccName = checkGLAllowXmlHttp.responseXML.getElementsByTagName("accName");
			var xmlaccType = checkGLAllowXmlHttp.responseXML.getElementsByTagName("accType");
			var xmlaccFacCode = checkGLAllowXmlHttp.responseXML.getElementsByTagName("accFacCode");
			
			var strBinText = "<table width=\"600\" height=\"25\" bgcolor=\"#996f03\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblGLs\" class=\"normalfnt\">"+
			"<tr>"+
			"<td width=\"29\"  class=\"mainHeading4\">Select</td>"+
			"<td width=\"75\"  class=\"mainHeading4\">Account ID</td>"+
			"<td width=\"194\" height=\"33\"  class=\"mainHeading4\">Description</td>"+
			"<td width=\"91\" class=\"mainHeading4\">Account Type</td>"+
			"<td width=\"77\"  class=\"mainHeading4\">Fac Code</td>"+
			"<td width=\"10\"  class=\"mainHeading4\">Status</td>"+
			"</tr>"+
			"<tr>"
			
			for ( var loop = 0; loop < xmlaccNo.length; loop ++)
			{
				var s=0;
				var accNo = xmlaccNo[loop].childNodes[0].nodeValue;
				
				var accGLNo = xmlaccGLNo[loop].childNodes[0].nodeValue;
				
				if(accGLNo!="xno")
				{
					accNo=accGLNo
					s=1;
				}
				else {s=0;}
						
				var accName = xmlaccName[loop].childNodes[0].nodeValue;
				
				var accType = xmlaccType[loop].childNodes[0].nodeValue;
				if (accType==1) 
				{
					accType="PNL Account"
				}
				else if (accType==2)
				{
					accType="Balance Sheet"
				}
				else
				{
					accType=""
				}
				
				var accFacCode =document.getElementById("cboFactory").value;// xmlaccFacCode[loop].childNodes[0].nodeValue;
				var sts="";
				if(s==0){
					sts=" ";
				}
				else
				{
					sts="Allocated" ;
				}
				
				strBinText +="<tr class=\"bcgcolor-tblrowWhite\">"
				
				if(accGLNo!="xno")
				{
					strBinText +="<td bgcolor=\"#FDE49B\" class=\"normalfnt\"><div align=\"center\">"+
								"<label>"
					strBinText +="<input name=\"chkSelect\" type=\"checkbox\" id=\"chkSelect\" value=\"checkbox\" style=\"visibility:hidden;\";>"
					
					//strBinText +="<input name=\"chkSelect\" type=\"checkbox\" id=\"chkSelect\" value=\"checkbox\" checked=\"checked\"/>"
					strBinText +="</label>"+
								"</div></td>"+
								"<td bgcolor=\"#FDE49B\" class=\"normalfnt\">" + accNo + "</td>"+
								"<td bgcolor=\"#FDE49B\" class=\"normalfnt\">" + accName + "</td>"+
								"<td bgcolor=\"#FDE49B\" class=\"normalfnt\">" + accType + "</td>"+
								"<td bgcolor=\"#FDE49B\" class=\"normalfnt\">" + accFacCode + "</td>"+
								"<td bgcolor=\"#FDE49B\" class=\"normalfntMid\" id=\""+s+"\">" +sts+ "</td>"
					
				}
				else
				{
					
					strBinText +="<td  class=\"normalfnt\"><div align=\"center\">"+
								"<label>"
					strBinText +="<input name=\"chkSelect\" type=\"checkbox\" id=\"chkSelect\" value=\"checkbox\" checked=\"checked\" onclick=\"chngCheckBox(this);\"/>"
					strBinText +="</label>"+
								"</div></td>"+
								"<td class=\"normalfnt\">" + accNo + "</td>"+
								"<td class=\"normalfnt\">" + accName + "</td>"+
								"<td class=\"normalfnt\">" + accType + "</td>"+
								"<td class=\"normalfnt\">" + accFacCode + "</td>"+					
								"<td class=\"normalfntMid\" id=\""+s+"\">" + sts + "</td>"					
					
					
					
				}
				
				strBinText +="</tr>"
			}
			
			strBinText +="</tr>"+
			"</tr>"+
			"</table>"

			document.getElementById("divcons").innerHTML=strBinText;
			
			
			//for ( var loop = 0; loop < xmlaccNo.length; loop ++)
//			 {
//				var accNo = xmlaccNo[loop].childNodes[0].nodeValue;
//				var accName = xmlaccName[loop].childNodes[0].nodeValue;
//				var accType = xmlaccType[loop].childNodes[0].nodeValue;
//				var accFacCode = xmlaccFacCode[loop].childNodes[0].nodeValue;
//	
//				
////				var x=document.getElementById('tblGLs').insertRow(loop);
////				var y=x.insertCell(0);
////				var z=x.insertCell(1);
////				var a=x.insertCell(2);
////				var b=x.insertCell(3);
////				var c=x.insertCell(4);
////				var d=x.insertCell(5);
//				
//				//addRow(document.getElementById('tblGLs').rows[1].cells[0].firstChild)
//				
//				//
//				//var x=document.getElementById('tblGLs').rows[loop+1].cells[1].firstChild.value
//				//var x=loop+1
//				//addRow(document.getElementById('tblGLs').rows[loop+1].cells[1].firstChild,accNo,accName,accType,accFacCode,x)
//				
//				var theLink=document.getElementById('tblGLs').rows[loop+1].cells[1].firstChild;
//				
//				theRow = theLink.parentNode.parentNode;
//				theRow2 = theLink.parentNode;
//				
//				theBod=theRow.parentNode;
//				alert(theRow)
//				theTable=theRow.parentNode;
//				newRow = theRow.cloneNode(true);
//				theBod.appendChild(newRow);
//				
//				//newRow.cells[2].firstChild.innerHTML=accno;
//				//newRow.cells[3].firstChild.innerHTML=accname;
//				//newRow.cells[4].firstChild.innerHTML=acctype;
//				//newRow.cells[5].firstChild.innerHTML=accfcode;
//				document.getElementById('tblGLs').rows[loop+1].cells[2].innerHTML=accNo;
//				//document.getElementById('tblCats').rows[loop+1].cells[0].firstChild.
//				
//			 }
		}
	}
}


//============================================================================================================
/*function getGLAccountsToAllowcation()
{
	var facCode=document.getElementById("cboFactory").value
	GetXMLHttpGLAcc();
	getGLAccXmlHttp.onreadystatechange = HandleGLAccsAllocationTable;
	getGLAccXmlHttp.open("GET",'accPackGLDB.php?DBOprType=GetGLAllowcationWithNon&glaccFactory=' + facCode , true);
	getGLAccXmlHttp.send(null); 
	
}
function HandleGLAccsAllocationTable()
{	
	checkXMLHttpGLAllowcation();
	
	if(getGLAccXmlHttp.readyState == 4) 
    {
	   if(getGLAccXmlHttp.status == 200) 
        {  
			var xmlaccNo = getGLAccXmlHttp.responseXML.getElementsByTagName("accNo");
			var xmlaccName = getGLAccXmlHttp.responseXML.getElementsByTagName("accName");
			var xmlaccType = getGLAccXmlHttp.responseXML.getElementsByTagName("accType");
			var xmlaccFacCode = getGLAccXmlHttp.responseXML.getElementsByTagName("accFacCode");
			
			var strBinText = "<table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLs\" class=\"normalfnt\">"+
			"<tr>"+
			"<td width=\"29\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Select</td>"+
			"<td width=\"75\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Account ID</td>"+
			"<td width=\"194\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Description</td>"+
			"<td width=\"91\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Account Type</td>"+
			"<td width=\"77\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2L\">Fac Code</td>"+
			"</tr>"+
			"<tr>"
			
			for ( var loop = 0; loop < xmlaccNo.length; loop ++)
			{
				var accNo = xmlaccNo[loop].childNodes[0].nodeValue;
				var accName = xmlaccName[loop].childNodes[0].nodeValue;
				
				var accType = xmlaccType[loop].childNodes[0].nodeValue;
				if (accType==1) 
				{
					accType="PNL Account"
				}
				else if (accType==2)
				{
					accType="Balance Sheet"
				}
				else
				{
					accType=""
				}
				var accFacCode =document.getElementById("cboFactory").value;// xmlaccFacCode[loop].childNodes[0].nodeValue;
				
				strBinText +="<tr>"+
				"<td class=\"normalfnt\"><div align=\"center\">"+
				"<label>"+
				"<input name=\"chkSelect\" type=\"checkbox\" id=\"chkSelect\" value=\"checkbox\" checked=\"checked\"/>"+
				"</label>"+
				"</div></td>"+

				"<td class=\"normalfnt\">" + accNo + "</td>"+
				"<td class=\"normalfnt\">" + accName + "</td>"+
				"<td class=\"normalfnt\">" + accType + "</td>"+
				"<td class=\"normalfnt\">" + accFacCode + "</td></tr>"
			}
			
			strBinText +="</tr>"+
			"</tr>"+
			"</table>"

			document.getElementById("divcons").innerHTML=strBinText;
			
			
			//for ( var loop = 0; loop < xmlaccNo.length; loop ++)
//			 {
//				var accNo = xmlaccNo[loop].childNodes[0].nodeValue;
//				var accName = xmlaccName[loop].childNodes[0].nodeValue;
//				var accType = xmlaccType[loop].childNodes[0].nodeValue;
//				var accFacCode = xmlaccFacCode[loop].childNodes[0].nodeValue;
//	
//				
////				var x=document.getElementById('tblGLs').insertRow(loop);
////				var y=x.insertCell(0);
////				var z=x.insertCell(1);
////				var a=x.insertCell(2);
////				var b=x.insertCell(3);
////				var c=x.insertCell(4);
////				var d=x.insertCell(5);
//				
//				//addRow(document.getElementById('tblGLs').rows[1].cells[0].firstChild)
//				
//				//
//				//var x=document.getElementById('tblGLs').rows[loop+1].cells[1].firstChild.value
//				//var x=loop+1
//				//addRow(document.getElementById('tblGLs').rows[loop+1].cells[1].firstChild,accNo,accName,accType,accFacCode,x)
//				
//				var theLink=document.getElementById('tblGLs').rows[loop+1].cells[1].firstChild;
//				
//				theRow = theLink.parentNode.parentNode;
//				theRow2 = theLink.parentNode;
//				
//				theBod=theRow.parentNode;
//				alert(theRow)
//				theTable=theRow.parentNode;
//				newRow = theRow.cloneNode(true);
//				theBod.appendChild(newRow);
//				
//				//newRow.cells[2].firstChild.innerHTML=accno;
//				//newRow.cells[3].firstChild.innerHTML=accname;
//				//newRow.cells[4].firstChild.innerHTML=acctype;
//				//newRow.cells[5].firstChild.innerHTML=accfcode;
//				document.getElementById('tblGLs').rows[loop+1].cells[2].innerHTML=accNo;
//				//document.getElementById('tblCats').rows[loop+1].cells[0].firstChild.
//				
//			 }
		}
	}
}
*/

/*function selectDeselectAll(obj){
	var tbl=document.getElementById("tblGLs").tBodies[0];
	var rows=tbl.rows.length;

	if(obj.checked){
		for(var i=1;i<rows;i++){
				
		}
		
	}
	else{
		
	}
		
}*/

function LoadGLAccstoViewTable()
{
	//clearSelectControl("cboDescription");
	var glaccNo="0"
	var glaccDcs="0"
	var glaccFactory="0"
	
	if(document.getElementById("cboID").value!=0)
	{
		glaccNo=document.getElementById("cboID").value
	}
	
	if(document.getElementById("cboDescription").value!=0)
	{
		glaccDcs=document.getElementById("cboDescription").value
	}
	if(document.getElementById("cboFactory").value!=0)
	{
		glaccFactory=document.getElementById("cboFactory").value
	}
	//alert(glaccNo)
	//alert(glaccDcs)
	//alert(glaccFactory)
	
	
	GetXMLHttpGLAcc();
	getGLAccXmlHttp.onreadystatechange = HandleGLAccsViewTable;
    getGLAccXmlHttp.open("GET",pub_glUrl+'accPackGLDB.php?DBOprType=GetGLAccs&glaccNo=' + glaccNo + '&glaccDcs=' + glaccDcs + '&glaccFactory=' + glaccFactory, true);
	getGLAccXmlHttp.send(null); 
}


function HandleGLAccsViewTable()
{	
	
	if(getGLAccXmlHttp.readyState == 4) 
    {
	   if(getGLAccXmlHttp.status == 200) 
        {  
			var xmlaccNo = getGLAccXmlHttp.responseXML.getElementsByTagName("accNo");
			var xmlaccName = getGLAccXmlHttp.responseXML.getElementsByTagName("accName");
			var xmlaccType = getGLAccXmlHttp.responseXML.getElementsByTagName("accType");
			var xmlaccFacCode = getGLAccXmlHttp.responseXML.getElementsByTagName("accFacCode");
			
			var strBinText = "<table bgcolor=\"\"  width=\"600\" height=\"\"  cellpadding=\"0\" cellspacing=\"1\" id=\"tblGLs\" class=\"normalfnt\">"+
			"<tr>"+
			"<td width=\"29\"  class=\"grid_header\">Del</td>"+
			"<td width=\"32\"  class=\"grid_header\">Edit</td>"+
			"<td width=\"75\"  class=\"grid_header\">Account ID</td>"+
			"<td width=\"194\" height=\"16\"  class=\"grid_header\">Description</td>"+
			"<td width=\"91\"  class=\"grid_header\">Account Type</td>"+
			"<td width=\"77\"  class=\"grid_header\" >Fac Code</td>"+
			"</tr>"+
			"<tr>"
			
			for ( var loop = 0; loop < xmlaccNo.length; loop ++)
			{
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				var accNo = xmlaccNo[loop].childNodes[0].nodeValue;
				var accName = xmlaccName[loop].childNodes[0].nodeValue;
				
				var accType = xmlaccType[loop].childNodes[0].nodeValue;
				if (accType==1) 
				{
					accType="PNL Account"
				}
				else if (accType==2)
				{
					accType="Balance Sheet"
				}
				else
				{
					accType=""
				}
				var accFacCode = xmlaccFacCode[loop].childNodes[0].nodeValue;
				
				strBinText +="<tr>"+
				"<td class=\""+cls+"\"><div align=\"center\"><img src=\"../../images/del.png\" onclick=\"glAccDelete(this.parentNode.parentNode.parentNode)\" alt=\"del\" width=\"15\" height=\"15\" /></div></td>"+
			"<td class=\""+cls+"\"><div align=\"center\"><img src=\"../../images/edit.png\" alt=\"edit\" width=\"15\" height=\"15\" onclick=\"editGL(this);\" /></div></td>"+
				"<td class=\""+cls+"\" style=\"text-align:left;\" id=\""+accNo+"\">" + accNo+"-"+accFacCode + "</td>"+
				"<td class=\""+cls+"\" style=\"text-align:left;\">" + accName + "</td>"+
				"<td class=\""+cls+"\" style=\"text-align:left;\">" + accType + "</td>"+
				"<td class=\""+cls+"\" style=\"text-align:left;\">" + accFacCode + "</td></tr>"
			}
			
			strBinText +="</tr>"+
			"</tr>"+
			"</table>"

			document.getElementById("divcons").innerHTML=strBinText;
			
			
			//for ( var loop = 0; loop < xmlaccNo.length; loop ++)
//			 {
//				var accNo = xmlaccNo[loop].childNodes[0].nodeValue;
//				var accName = xmlaccName[loop].childNodes[0].nodeValue;
//				var accType = xmlaccType[loop].childNodes[0].nodeValue;
//				var accFacCode = xmlaccFacCode[loop].childNodes[0].nodeValue;
//	
//				
////				var x=document.getElementById('tblGLs').insertRow(loop);
////				var y=x.insertCell(0);
////				var z=x.insertCell(1);
////				var a=x.insertCell(2);
////				var b=x.insertCell(3);
////				var c=x.insertCell(4);
////				var d=x.insertCell(5);
//				
//				//addRow(document.getElementById('tblGLs').rows[1].cells[0].firstChild)
//				
//				//
//				//var x=document.getElementById('tblGLs').rows[loop+1].cells[1].firstChild.value
//				//var x=loop+1
//				//addRow(document.getElementById('tblGLs').rows[loop+1].cells[1].firstChild,accNo,accName,accType,accFacCode,x)
//				
//				var theLink=document.getElementById('tblGLs').rows[loop+1].cells[1].firstChild;
//				
//				theRow = theLink.parentNode.parentNode;
//				theRow2 = theLink.parentNode;
//				
//				theBod=theRow.parentNode;
//				alert(theRow)
//				theTable=theRow.parentNode;
//				newRow = theRow.cloneNode(true);
//				theBod.appendChild(newRow);
//				
//				//newRow.cells[2].firstChild.innerHTML=accno;
//				//newRow.cells[3].firstChild.innerHTML=accname;
//				//newRow.cells[4].firstChild.innerHTML=acctype;
//				//newRow.cells[5].firstChild.innerHTML=accfcode;
//				document.getElementById('tblGLs').rows[loop+1].cells[2].innerHTML=accNo;
//				//document.getElementById('tblCats').rows[loop+1].cells[0].firstChild.
//				
//			 }
		}
	}
}

function editGL(obj){
	var accId=obj.parentNode.parentNode.parentNode.cells[2].id;
	var facCode=obj.parentNode.parentNode.parentNode.cells[5].innerHTML;
	window.location.href=pub_glUrl+"addGL.php?accId="+accId+"&facCode="+facCode+"&status=1";
}

function loadEditGls(accId,facCode){
	if(accId.trim()!=""){
	var path=pub_glUrl+"accPackGLDB.php?DBOprType=loadEditDet&accId="+accId+"&facCode="+facCode;
	htmlobj=$.ajax({url:path,async:false});

	var XMLDescription	=htmlobj.responseXML.getElementsByTagName("strDescription");
	var XMLAccType		=htmlobj.responseXML.getElementsByTagName("strAccType");

	document.getElementById('txtAccID').value=accId;
	//document.getElementById('cboFacCode').value=facCode;
	document.getElementById('txtDescription').value= XMLDescription[0].childNodes[0].nodeValue;
	document.getElementById('cboAcType').value= XMLAccType[0].childNodes[0].nodeValue;
	//alert(XMLAccType[0].childNodes[0].nodeValue);
	}
}

function setValues(ID)
{
	if(ID==1)
	{
		document.getElementById("cboDescription").value=0	
		document.getElementById("cboFactory").value=0
	}
	else if(ID==2)
	{
		document.getElementById("cboID").value=0	
		document.getElementById("cboFactory").value=0		
	}
	else if(ID==3)
	{
		document.getElementById("cboID").value=0	
		document.getElementById("cboDescription").value=0	
	}
}

function glAccDelete(elem)
{
	var selectedGLAccNo =  elem.cells[2].id;
	var responce=confirm("Are you sure,you want to delete GL Account No." + selectedGLAccNo +"?");
	if (responce==true)
	{		
		var url = pub_glUrl+'accPackGLDB.php?DBOprType=deleteGLAccount&accNo='+selectedGLAccNo;
		htmlobj=$.ajax({url:url,async:false});  
		clearViewGlAcc(elem);						
	}
}

function clearViewGlAcc(elem)
{
	//document.getElementById('frmViewGlAcc').reset();
	/*var tbl=document.getElementById('tblGLs')
	var rCount = tbl.rows.length;
	for(var loop=1;loop<rCount;loop++)
	{
			tbl.deleteRow(loop);
			rCount--;
			loop--;
	}*/
	
	elem.parentNode.removeChild(elem);
	LoadGLAccstoViewTable();
	loadCombo('select strAccID,strAccID from glaccounts','cboID');	
}

function clearSelectControl(cboid)
{
   var select=document.getElementById(cboid);
   if(select!=null)
   {
	   var options=select.getElementsByTagName("option");
	   var aa=0;
	   for (aa=select.options.length-1;aa>=0;aa--)
	   {
			select.remove(aa);
	   }
   }
}
//---------------------------LASANTHA ---- 22-09-2010-------
function clearGlAForm(frm,tbl){
	document.getElementById(frm).reset();
	var tbl=document.getElementById(tbl)
	var rCount = tbl.rows.length;
	for(var loop=1;loop<rCount;loop++)
	{
			tbl.deleteRow(loop);
			rCount--;
			loop--;
	}
	document.getElementById('cboFactory').focus();
}

function chngCheckBox(obj)
{
	var td=obj.parentNode.parentNode.parentNode;
	var tr = td.parentNode;
	var glAlloNo=td.parentNode.cells[1].innerHTML;
	var glNo = td.parentNode.cells[1].id;
	var glLength = glNo.length;
	var facAccno = document.getElementById('txtAccID').value;
	/*if(glNo.indexOf('-')==-1)
	{
		//checkValidation();
		return false;
	}
	else
	{
		var glN=glNo.split('-');
		td.parentNode.cells[1].innerHTML="";
		td.parentNode.cells[1].innerHTML=glN[0];
		td.parentNode.cells[0].style.backgroundColor='#FFF';
		td.parentNode.cells[1].style.backgroundColor='#FFF';
		td.parentNode.cells[2].style.backgroundColor='#FFF';
		td.parentNode.cells[3].style.backgroundColor='#FFF';
		td.parentNode.cells[4].style.backgroundColor='#FFF';
		td.parentNode.cells[5].style.backgroundColor='#FFF';
		
	}*/
	if(!obj.checked)
	{
		td.parentNode.cells[0].style.backgroundColor='#FFF';
		td.parentNode.cells[1].style.backgroundColor='#FFF';
		td.parentNode.cells[2].style.backgroundColor='#FFF';
		td.parentNode.cells[3].style.backgroundColor='#FFF';
		td.parentNode.cells[4].style.backgroundColor='#FFF';
		//tr.style.bgcolor='#FFF';
		if(glAlloNo.length>glLength)
			td.parentNode.cells[1].innerHTML = glNo;
	}
	else
	{
		td.parentNode.cells[0].style.backgroundColor='#99FF99';
		td.parentNode.cells[1].style.backgroundColor='#99FF99';
		td.parentNode.cells[2].style.backgroundColor='#99FF99';
		td.parentNode.cells[3].style.backgroundColor='#99FF99';
		td.parentNode.cells[4].style.backgroundColor='#99FF99';
		if(glAlloNo.length==glLength)
			td.parentNode.cells[1].innerHTML = glNo+facAccno;
	}
}
function glReport(factory)
{
	var fact=document.getElementById(factory).value.trim();
	//alert(fact);
	if(fact==0){
		alert("Please select the 'Cost Center'.");
		document.getElementById(factory).focus();
		return false;
		}
	window.open(pub_glUrl+"rptFactoryWiseGLReprot.php?fact="+ fact,'frmFactory'); 
}

function viewGLdetails()
{
	var accID = URLEncode(trim(document.getElementById('cboAcc').value));
	
	var url = pub_glUrl+'accPackGLDB.php?DBOprType=viewGLData';	
		url += '&accID='+accID;
		
		htmlobj=$.ajax({url:url,async:false});
		
	var GLcode = htmlobj.responseXML.getElementsByTagName("GLAccID")[0].childNodes[0].nodeValue;
	var GLdes = htmlobj.responseXML.getElementsByTagName("strDescription")[0].childNodes[0].nodeValue;
	var AccType = htmlobj.responseXML.getElementsByTagName("strAccType")[0].childNodes[0].nodeValue;
	var status = htmlobj.responseXML.getElementsByTagName("intStatus")[0].childNodes[0].nodeValue;
	var GLType	= htmlobj.responseXML.getElementsByTagName("intGlType")[0].childNodes[0].nodeValue; 
	var GLCategory	= htmlobj.responseXML.getElementsByTagName("intGlCategory")[0].childNodes[0].nodeValue; 
	
	document.getElementById('txtAccID').value = GLcode;
	document.getElementById('txtDescription').value = GLdes;
	document.getElementById('cboAcType').value = AccType;
	document.getElementById('cboGLType').value = GLType;
	document.getElementById('cboCategory').value = GLCategory;
	
	if(status == 1)
		$('#chkActive').attr('checked', true);
	else
		$('#chkActive').attr('checked', false);
}

function deleteGLAcc()
{
	var GlAccId = document.getElementById('cboAcc').value;
	
	if(GlAccId == 0 || GlAccId == "")
	{
		alert("Please select Account Code");
		document.getElementById('cboAcc').focus();
		
	}
	else
	{
		var sname = document.getElementById("cboAcc").options[document.getElementById('cboAcc').selectedIndex].text;
			//alert(sname);
			var r=confirm('Are you sure you want to delete "' + sname +'" ?');
			if (r==true)		
				DeleteData(GlAccId);
	}
}

function DeleteData(GlAccId)
{
	var url = pub_glUrl+'accPackGLDB.php?DBOprType=deleteGLdata';	
		url += '&GlAccId='+GlAccId;
		
		htmlobj=$.ajax({url:url,async:false});
		var XMLResult = htmlobj.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("Deleted successfully");
				getClear();
			}
			else
			{
				alert(XMLResult[0].childNodes[0].nodeValue);	
			}
				
}

function checkAll(obj)
{
	var tbl = document.getElementById("tblGLs");
	
	for(var loop=1;loop< tbl.rows.length;loop++)
	{
		if(obj.checked == true)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].childNodes[0].disabled)
				continue;
			else
			{
				tbl.rows[loop].cells[0].childNodes[0].childNodes[0].childNodes[0].checked = true;
				chngCheckBox(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].childNodes[0]);
			}
		}
		else
		{
			if(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].childNodes[0].disabled)
				continue;
			tbl.rows[loop].cells[0].childNodes[0].childNodes[0].childNodes[0].checked = false;
			chngCheckBox(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].childNodes[0]);
		}
	}
}

function Report()
{
	window.open(pub_glUrl+"rptglaccount.php",'rptGlReport');
}