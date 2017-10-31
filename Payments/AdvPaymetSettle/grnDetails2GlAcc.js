var xmlHttp;
var altxmlHttp;
var altxmlHttpArray = [];
var strPaymentType=""
var incr =0;
var invNoAvailability=false;

function ShowAllGLAccounts()
{
	var SupID = document.getElementById("cboSuppliers").value;

	//showBackGround('divBG',0);
	var url = "GLAccpop.php";
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(0,0,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
/*	var SupID = document.getElementById('cboSuppliers').value;
	var FacCd = document.getElementById('CompanyID').value;
	
	var txtTotGrn = document.getElementById('txtTotGrn').value;
	if(txtTotGrn > 0){
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleShowAllGLAccounts;
	altxmlHttpArray[incr].open("GET",'../supplierInvXML.php?RequestType=ShowAllGLAccounts&strPaymentType=N&SupplierId=' + SupID + '&FactoryCode=' + FacCd,true);
	altxmlHttpArray[incr].send(null);
	incr++;
	}else{
	 alert("Please select grn for GL Allocation");	
	}*/
}


function HandleShowAllGLAccounts()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
					//alert(altxmlHttpArray[this.index].responseText);
			
			var XMLGLAccId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccId");
			var XMLGLAccDesc = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccDesc");
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			
			drawPopupArea(670,450,'frmAllGLAccounts');
			
			var tableText = "<table width=\"650\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblsearch\" bgcolor=\"#FFF\" > " +
							"<tr>"+
							"<td>"+
							"	<table width=\"650\">"+
							"		<tr>"+
			              	"			<td height=\"25\" bgcolor=\"#FFF\" class=\"TitleN2white\">GL Accounts</td>"+
							"		</tr>"+
							"	</table>"+
							"<td>"+
            				"</tr>"+							
							"<tr  class=\"containers\">"+
							"<td>"+
							"	<table>"+
							"		<tr>"+
							"<td width=\"39\" height=\"25\">&nbsp;</td>"+
                    		"<td width=\"50\" class=\"normalfnt\">Factory</td>"+
                    		"<td width=\"250\">"+
                      		"<select name=\"cboFactory\"  class=\"normalfnt\" id=\"cboFactory\" style=\"width:250px\">"+
                      		"</select>"+
                    		"</td>"+
                    		"<td>&nbsp;</td>"+
                   	 		"<td width=\"100\" class=\"normalfnt\">Acc.Like</td>"+
                    		"<td width=\"200\"><input type=\"text\"  class=\"txtbox\"  name=\"txtNameLike\" id=\"txtNameLike\" size=\"25\" /></td>"+
							"<td width=\"8%\"><img src=\"../../images/search.png\" onclick=\"getGLAccounts()\" alt=\"search\" width=\"86\" height=\"24\" /></td>"+
							"</td>"+
							"	</table>"+
							"		</tr>"+
							
							"</tr>"+
							
							
							"</table> " +
							
							"<div id=\"divbuttons\" style=\"overflow:scroll; height:350px; width:665px;\">"+
							"<table width=\"650\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblallglaccounts\"> " +
               				"<tr><td width=\"39\" height=\"22\"  class=\"grid_header\">*</td> " +
                   			"<td width=\"350\"  class=\"grid_header\">GL Acc Id</td>" +
                   			"<td width=\"450\"  class=\"grid_header\">Description</td>" +
                   			"</tr>";

				for(var loop = 0; loop < XMLGLAccId.length; loop++)
				{
					var selection = "";
					
					if (XMLSelected[loop].childNodes[0].nodeValue == "True")
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"\" />";
					var cls;(loop%2==1)?cls='grid_row':cls='grid_row2';
					tableText += "<tr>"+
								"<td class='"+cls+"'><div align=\"center\">"+ selection +"</div></td>" +
								"<td class='"+cls+"' id=\"" + XMLGLAccId[loop].childNodes[0].nodeValue + "\">" + XMLGLAccId[loop].childNodes[0].nodeValue + "</td>" +
                    			"<td class='"+cls+"' id=\"" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "\">" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "</td>" +
								"</tr>";
				}
				tableText += "</table></div>";

				tableText += "<tr>"+
								"<td width=\"3%\" bgcolor=\"#D6E7F5\">&nbsp;</td>"+
								"<td colspan=\"2\" bgcolor=\"#D6E7F5\" class=\"normalfnt\">"+
								"<table width=\"100%\" border=\"0\">"+
									"<tr>"+
								  		"<td width=\"13%\">&nbsp;</td>"+
										"<td width=\"31\" colspan=\"2\"><img src=\"../../images/addsmall.png\" onClick=\"AddNewGLAccountRow(this);\" alt=\"Add\" /></td>"+
								  		"<td width=\"11%\"><img src=\"../../images/close.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"97\" height=\"24\" id=\"Close\" /></td>"+
									"</tr>"+
							   "</table></td>"+
						  	"</tr>";
				
				var frame = document.createElement("div");
    			frame.id = "glselectwindow";
				document.getElementById('frmAllGLAccounts').innerHTML=tableText;
				
				LoadFactoryList();
		}
	}
}

function createAltXMLHttpRequestArray(index) 
{
    if (window.ActiveXObject) 
    {
        altxmlHttpArray[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttpArray[index] = new XMLHttpRequest();
    }
}

function LoadFactoryList()
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index=incr;
	altxmlHttpArray[incr].onreadystatechange = HandleFactories;
    altxmlHttpArray[incr].open("GET", '../advancepaymentDB.php?DBOprType=getFactoryList', true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleFactories()
{	
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
	   if(altxmlHttpArray[this.index].status == 200) 
        {  
			var XMLFactoryID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("compID");
			var XMLFactoryName = altxmlHttpArray[this.index].responseXML.getElementsByTagName("compName");
			RemoveCurrentCombo("cboFactory");
			
			var optFirst = document.createElement("option");			
			optFirst.text = "";
			optFirst.value = 0;
			document.getElementById("cboFactory").options.add(optFirst);
				
			for ( var loop = 0; loop < XMLFactoryID.length; loop ++)
			 {
				var FactoryID = XMLFactoryID[loop].childNodes[0].nodeValue;
				var FactoryName = XMLFactoryName[loop].childNodes[0].nodeValue;
				var optFactory = document.createElement("option");
				
				optFactory.text =FactoryName.toUpperCase() ;
				optFactory.value = FactoryID;
				//alert(FactoryName + "   " + FactoryID);
				
				document.getElementById("cboFactory").options.add(optFactory);
			 }
			 document.getElementById("cboFactory").value=0;
		}
	}
}

function RemoveCurrentCombo(comboname)
{
	var index = document.getElementById(comboname).options.length;
	while(document.getElementById(comboname).options.length > 0) 
	{
		index --;
		document.getElementById(comboname).options[index] = null;
	}
}

function getGLAccounts()
{
	var facCode=document.getElementById("cboFactory").value;
	var nameLike=document.getElementById("txtNameLike").value;	
		nameLike =nameLike.trim();
	var url='../supplierInvXML.php?RequestType=getGLAccountList&facID=' + facCode + '&NameLike=' + nameLike;
	htmlobj=$.ajax({url:url,async:false});
	
	$('#tblallglaccounts tr:gt(0)').remove();
	
	var XMLaccNo = htmlobj.responseXML.getElementsByTagName("accNo");
	var XMLaccName = htmlobj.responseXML.getElementsByTagName("accDes");
	var XMLAccountNo = htmlobj.responseXML.getElementsByTagName("AccountNo");	
	var XMLGLAccID = htmlobj.responseXML.getElementsByTagName("GLAccID");
	
			var strGLAccs="";
				  
			for ( var loop = 0; loop < XMLaccNo.length; loop ++)
			 {
				var accNo 		= XMLaccNo[loop].childNodes[0].nodeValue;
				var accDes 		= XMLaccName[loop].childNodes[0].nodeValue;
				var AccountNo   = XMLAccountNo[loop].childNodes[0].nodeValue;
				var GLAccID   = XMLGLAccID[loop].childNodes[0].nodeValue;
				
				var tbl 		= document.getElementById('tblallglaccounts');
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				row.className = "bcgcolor-tblrowWhite";
				
				var cell = row.insertCell(0);
				cell.className ="normalfntMid";
				cell.innerHTML = "<input type=\"checkbox\" name=\"chkSelGLAcc\" id=\"chkSelGLAcc\"/>";
				
				var cell = row.insertCell(1);
				cell.className ="normalfnt";
				cell.id		   = GLAccID;
				cell.innerHTML = accNo+""+AccountNo;
				
				var cell = row.insertCell(2);
				cell.className ="normalfnt";
				cell.innerHTML = accDes;
			}		
			
}

function AddNewGLAccountRow(objevent)
{
	//alert(objevent);
	var tblall = document.getElementById('tblallglaccounts');
		
	for ( var loop = 1 ;loop < tblall.rows.length ; loop ++ )
	{	
		if (tblall.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			var rwGLAcc = tblall.rows[loop].cells[1].childNodes[0].nodeValue;
			var rwGLDesc = tblall.rows[loop].cells[2].childNodes[0].nodeValue;
			
			var tbl = document.getElementById('tblglaccounts');
			
			var lastRow = tbl.rows.length;	
			for(var i=1;i<lastRow;i++){
				if(tbl.rows[i].cells[1].childNodes[0].nodeValue==rwGLAcc){
					alert("GL Acc Id Allready exist.");
					tblall.rows[loop].cells[0].childNodes[0].childNodes[0].checked=false;
					return false;
				}
			}
			var row = tbl.insertRow(lastRow);
			
			/*var cellGLChk = row.insertCell(0);
			cellGLChk.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" onclick=\"checkUncheckTextBox(this);\" /></div>";
			
			var cellGLAcc = row.insertCell(1);
			cellGLAcc.innerHTML = rwGLAcc;
			
			var cellGLDesc = row.insertCell(2);
			cellGLDesc.innerHTML = rwGLDesc;
			
			var cellGLAmt = row.insertCell(3);
			cellGLAmt.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ 0 +"\">";			
			*/
			var cls;
			((lastRow % 2)==1)?cls='grid_raw':cls='grid_raw2';
			var htm="<td class=\""+cls+"\"><div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" onclick=\"checkUncheckTextBox(this);\" /></div></td>";
			htm +="<td class=\""+cls+"\">"+rwGLAcc+"</td>";
			htm +="<td class=\""+cls+"\">"+rwGLDesc+"</td>";
			htm +="<td class=\""+cls+"\"><input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ 0 +"\"></td>";
			 row.innerHTML=htm;
		}
	}
}


function validateGrnAmountVsGLAmount(GlAmt)
{
	var TotGLAmt = parseFloat(document.getElementById('txtTotGrn').value);
	GlAmt = 0;
	
	var tbl = document.getElementById('tblglaccounts');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			GlAmt = parseFloat(GlAmt);
			var rwGlAmt = parseFloat(tbl.rows[loop].cells[3].childNodes[0].value);
			GlAmt = GlAmt + rwGlAmt;
			//GlAmt = round(GlAmt,2);
	
			if(TotGLAmt < GlAmt)
			{
				alert("Total GL value can not bee exceed Invoice Value!");
				//Sexy.alert('<h1>Invoice GL Valuation</h1><p>Total GL value can not bee exceed Invoice Value!</p>');return false;
				tbl.rows[loop].cells[3].childNodes[0].value = 0;
			}
		}
	}
	if (TotGLAmt != GlAmt)
	{
		//alert("Total invoice value has been put into GL Accounts !");
		//Sexy.alert('<h1>Invoice GL Valuation</h1><p>Total invoice value has been put into GL Accounts !</p>');return false;
		//document.getElementById('txtcommission').focus();
	}
	else if(TotGLAmt > GlAmt)
	{
		alert("Total GL value not tally with Invoice Value!" + "\n" + "You have to put more: " + (TotGLAmt - GlAmt) + " in to Gl Accounts !");
		//var remainAmt = TotGLAmt - GlAmt ;
		//Sexy.alert('<h1>Invoice GL Valuation</h1><p>Total GL value not tally with Invoice Value!" + "\n" + "You have to put more: " + (TotGLAmt - GlAmt) + " in to Gl Accounts !</p>');return false;
		
		//tbl.rows[loop].cells[3].childNodes[0].focus();
	}		
}


function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblglaccounts');
	var rw = objevent.parentNode.parentNode.parentNode;
	
	if (rw.cells[0].childNodes[0].childNodes[0].checked)
	{
		rw.cells[3].childNodes[0].value = "0";
	}
	else if(rw.cells[0].childNodes[0].childNodes[0].checked == false) 
	{
		rw.cells[3].childNodes[0].value = "";
	}
}



var checkGLfirstTime = 0;
function AddNewGLAccounttoMain(objevent)
{
	//alert(objevent);
	var tblall = document.getElementById('tblallglaccounts');
	
	for ( var loop = 1 ;loop < tblall.rows.length ; loop ++ )
	{	
		var boolcheck = false;	
		if (tblall.rows[loop].cells[0].lastChild.checked == true)
		{
			var glAccId = tblall.rows[loop].cells[1].id;
			var rwGLAcc = tblall.rows[loop].cells[1].childNodes[0].nodeValue;
			var rwGLDesc = tblall.rows[loop].cells[2].childNodes[0].nodeValue;
			
			var tbl = document.getElementById('tblglaccounts');
			
			var lastRow = tbl.rows.length;
			for(var i=1;i<lastRow;i++)
			{
				try
				{
					if(tbl.rows[i].cells[1].childNodes[0].nodeValue==rwGLAcc)
					{
						boolcheck=true;
						
					}
				}
				catch(e)
				{
					checkGLfirstTime = 1;
				}
					
			}
			if(!boolcheck)
					{
							
						var row = tbl.insertRow(lastRow);
						row.className = "bcgcolor-tblrowWhite";
						
						var cell = row.insertCell(0);
						cell.className ="normalfntMid";	
						cell.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"false\" onclick=\"checkUncheckTextBox(this);\" /></div>";
						
						var cell = row.insertCell(1);
						cell.className ="normalfnt";
						cell.id		   = glAccId;
						cell.ondblclick = changeToStyleTextBox;
						cell.innerHTML = rwGLAcc;
						
						var cell = row.insertCell(2);
						cell.className ="normalfnt";
						cell.innerHTML = rwGLDesc;
						
						var cell = row.insertCell(3);
						cell.className ="normalfntMid";
						cell.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox lastcellz\" style=\"width:100px\" align =\"center\" onkeypress=\"return isNumberKey(event,this.value);\" onkeyup=\"clckGLBox(this.value,this.parentNode.parentNode.rowIndex);setTotGlVale();setAmountToGlAcc(event,this);\" onblur=\"setFixedValue(this.value,this.parentNode.parentNode.rowIndex);\" onkeydown=\"addNewGLRow(event,this.parentNode.parentNode.rowIndex);\" value=\""+ 0 +"\">";
						
				
						/*var cls;
						((lastRow % 2)==1)?cls='normalfnt':cls='normalfnt';
					    htm="<td class=\""+cls+"\"><div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"false\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div></td>";
						htm +="<td class=\""+cls+"\" style=\"text-align:left;\" id=\""+glAccId+"\">"+rwGLAcc+"</td>";
						htm +="<td class=\""+cls+"\" style=\"text-align:left;\">"+rwGLDesc+"</td>";
						htm +="<td class=\""+cls+"\"><input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" onkeyup=\"clckGLBox(this);\" onkeydown=\"addNewGLRow(event,this.parentNode.parentNode.rowIndex);\" value=\""+ 0 +"\"></td>";
						 row.innerHTML=htm;*/
					}
					else
					{
						alert("GL Acc Id "+rwGLAcc+" Allready exist.");
					}
					
			
		}
	}
	// event_setter();
	if(checkGLfirstTime==1)
		tbl.deleteRow(1);
	checkGLfirstTime = 0;
		
}

function clckGLBox(value,row)
{
	var tbl = document.getElementById('tblglaccounts');
	if(value == 0 || value == "")
	{
		tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = false;
	}
	else
		tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = true;
}

//------------------------------------------------------------------------------------------------------------------------------------------
