var xmlHttp;

var accNo=""
var accName=""
var accType=""
var accFactory=""

function XMLHttpForStylePO(index) 
{
	if (window.ActiveXObject) 
    {
       StylePOXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        StylePOXmlHttp = new XMLHttpRequest();
    }
}



function getStylePO()
{
	var strSupID=document.getElementById("cboSuppliers").value;
	XMLHttpForStylePO();
	
	StylePOXmlHttp.onreadystatechange = HandleStylePOList;

	
	
    StylePOXmlHttp.open("GET", 'advancePaymenSettelmenttDB.php?DBOprType=getStyle&SupID=' + strSupID, true);
	StylePOXmlHttp.send(null); 
}

function HandleStylePOList()
{	
	if(StylePOXmlHttp.readyState == 4) 
    {
	   if(StylePOXmlHttp.status == 200) 
        {  
			var XMLYear = StylePOXmlHttp.responseXML.getElementsByTagName("intYear");
			var XMLPONo = StylePOXmlHttp.responseXML.getElementsByTagName("poNo");
			var XMLPOValue = StylePOXmlHttp.responseXML.getElementsByTagName("poValue");
			var XMLPOBalance = StylePOXmlHttp.responseXML.getElementsByTagName("poBalance");
			var XMLStyle = StylePOXmlHttp.responseXML.getElementsByTagName("poStyle");
			
			
			strTable="<table width=\"860\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblPOList\" class=\"normalfnt\">"+"<thead>"+
					"<tr>"+
					"<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Set Off</td>"+
					"<td width=\"17%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style</td>"+
					"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>"+
					"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"right\">PO 0000Amount</div></td>"+
					"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"right\">Paid Amount</div></td>"+
					"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"right\">Balance</div></td>"+
					"<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GRN</td>"+
					"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">&nbsp;</td>"+
					"</tr>"+"<thead>"+
					
			if(XMLYear.length==0)
			{
				var supname=document.getElementById("cboSuppliers");
				var sss=supname.options[document.getElementById("cboSuppliers").selectedIndex].text;
				alert("There is no any PO from " + sss);	
				return;
			}
			
			for ( var loop = 0; loop < XMLYear.length; loop ++)
			 {
				var poYear = XMLYear[loop].childNodes[0].nodeValue;
				var poNo = XMLPONo[loop].childNodes[0].nodeValue;
				var poValue = XMLPOValue[loop].childNodes[0].nodeValue;
				var poBalance = XMLPOBalance[loop].childNodes[0].nodeValue;
				var poStyle = XMLStyle[loop].childNodes[0].nodeValue;
				
				if(poBalance=="")
				{	
					poBalance=poValue;
				}
				
				var poPaidAmt=poValue-poBalance;
				
				strTable+="<tr>"+
				"<td onmouseover=\"highlight(this.parentNode)\" height=\"20\" class=\"normalfntMid\"><input type=\"checkbox\" name=\"chkSurd\" id=\"chkSurd\" disabled=true/></td>"+
				"<td onmouseover=\"highlight(this.parentNode)\" class=\"normalfnt\">"+ poStyle +"</td>"+
				"<td onmouseover=\"highlight(this.parentNode)\" class=\"normalfnt\">"+ poNo +"</td>"+
				"<td onmouseover=\"highlight(this.parentNode)\" class=\"normalfntRite\">"+ poValue +"</td>"+
				"<td onmouseover=\"highlight(this.parentNode)\" class=\"normalfntRite\">"+ poPaidAmt +"</td>"+
				"<td onmouseover=\"highlight(this.parentNode)\" class=\"normalfntRite\">"+ poBalance +"</td>"+
				"<td onmouseover=\"highlight(this.parentNode)\"><div align=\"center\"><img src=\"../images/house.png\" onClick=\"getGRNList();\"  alt=\"GRN\"  class=\"mouseover\" /></div></td>"+
				
				/*"<td onmouseover=\"highlight(this.parentNode)\" class=\"normalfntMid\"><label>"+
				"<input name=\"cmbGRN\" type=\"submit\" id=\"cmbGRN\" style=\"height:20px\" value=\"...\" />"+
				"</label></td>"+
				"<td class=\"normalfntMid\">&nbsp;</td>"+
*/				"</tr>"
									
			 }
			 
			 
			 strTable+="</table>"
			 
			 document.getElementById("divcons2").innerHTML=strTable;
			 grid_fix_header_poList();
			 
		}
	}
}

function getGRNList()
{
	alert("GRN List");	
}
//===========================================================================================
function highlight(o)
{
	var p = o.parentNode;
	
	while( p.tagName != "TABLE")
	{
		p=p.parentNode;
	}
	for( var i=0; i < p.rows.length; ++i)
	{
		p.rows[i].className="";
	}
	while(o.tagName !="TR")
	o=o.parentNode
	o.className="backcolorYellow";
}

function NewGLAccSave(accNo,accName,accType,accFactory)
{
	NewXMLHttpGLAcc();
    GLAccXmlHttp.onreadystatechange = HandleSaveGLAcc;
	GLAccXmlHttp.open("GET", 'advancePaymenSettelmenttDB.php?DBOprType=SaveNewGLAcc&AccNo=' + accNo + '&AccName='+ accName +'&AccType='+ accType +'&FactoryCode='+ accFactory , true);
    
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
				//document.getElementById("txtname").value = "";
				//document.getElementById("txtremarks").value = "";
				//clearSelectControl("cboMainStores");
				LoadGLAccs();
				alert("New GL Account Saved Successfully.");
			}
			else
			{
				alert("Process Failed.");
			}
		}
	}
}

function grid_fix_header_poList()
{
	$("#tblPOList").fixedHeader({
	width: 100,height: 100
	});	
}

