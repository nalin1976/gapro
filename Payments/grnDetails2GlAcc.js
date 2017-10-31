var xmlHttp;
var altxmlHttp;
var altxmlHttpArray = [];
var strPaymentType=""
var incr =0;
var invNoAvailability=false;

function ShowAllGLAccounts()
{
	var SupID = document.getElementById('cboSuppliers').value;
	var FacCd = document.getElementById('CompanyID').value;
	
	var txtTotGrn = document.getElementById('txtTotGrn').value;
	if(txtTotGrn > 0){
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleShowAllGLAccounts;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=ShowAllGLAccounts&strPaymentType=N&SupplierId=' + SupID + '&FactoryCode=' + FacCd,true);
	altxmlHttpArray[incr].send(null);
	incr++;
	}else{
	 alert("Please select grn for GL Allocation");	
	}
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
							"<td width=\"8%\"><img src=\"../images/search.png\" onclick=\"getGLAccounts()\" alt=\"search\" width=\"86\" height=\"24\" /></td>"+
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
										"<td width=\"31\" colspan=\"2\"><img src=\"../images/addsmall.png\" onClick=\"AddNewGLAccountRow(this);\" alt=\"Add\" /></td>"+
								  		"<td width=\"11%\"><img src=\"../images/close.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"97\" height=\"24\" id=\"Close\" /></td>"+
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
    altxmlHttpArray[incr].open("GET", 'advancepaymentDB.php?DBOprType=getFactoryList', true);
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
	
	//CreateXMLHttpForGLAccs();
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index=incr;
	altxmlHttpArray[incr].onreadystatechange = HandleGLAccs;
    altxmlHttpArray[incr].open("GET", 'advancepaymentDB.php?DBOprType=getGLAccountList&facID=' + facCode + '&NameLike=' + nameLike , true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleGLAccs()
{	
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
	   if(altxmlHttpArray[this.index].status == 200) 
        {  
			var XMLaccNo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accNo");
			var XMLaccName = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accDes");
		  
			var strGLAccs="<table width=\"650\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblallglaccounts\"> " +
               				"<tr><td width=\"39\" height=\"22\" bgcolor=\"\" class=\"grid_header\">*</td> " +
                   			"<td width=\"350\" bgcolor=\"\" class=\"grid_header\">GL Acc Id</td>" +
                   			"<td width=\"450\" bgcolor=\"\" class=\"grid_header\">Description</td>" +
                   			"</tr>"

			for ( var loop = 0; loop < XMLaccNo.length; loop ++)
			 {
				var accNo = XMLaccNo[loop].childNodes[0].nodeValue;
				var accDes = XMLaccName[loop].childNodes[0].nodeValue;
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strGLAccs += "<tr>"+
							"<td class=\""+cls+"\"><div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"\" /></div></td>" +
							"<td class=\""+cls+"\" id=\"" + accNo + "\">" + accNo + "</td>" +
                    		"<td class=\""+cls+"\" id=\"" + accDes + "\">" + accDes + "</td>" +
							"</tr>";
			}
			strGLAccs+=	"</table>"
			
			//document.getElementById("divGLAccs").innerHTML=strGLAccs;
			document.getElementById("divbuttons").innerHTML=strGLAccs;			
		}
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
			htm +="<td class=\""+cls+"\" style=\"text-align:left;\">"+rwGLAcc+"</td>";
			htm +="<td class=\""+cls+"\" style=\"text-align:left;\">"+rwGLDesc+"</td>";
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