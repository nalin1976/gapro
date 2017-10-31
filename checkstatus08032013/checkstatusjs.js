var xmlHttp;
var thirdxmlHttp;

function closeWindow(){
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}
}
function loadStyle()
{
	var scNO = document.getElementById('cboscno').value;
	if(scNO != '')
	{
		var url="checkstatusmiddle.php";
					url=url+"?RequestType=getSCWiceStyleNo";
					url += '&scNO='+URLEncode(scNO);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("styleNOS")[0].childNodes[0].nodeValue;
		document.getElementById('cbostyleno').innerHTML =  OrderNo;
	}
	else
	{
		location = "checkstatus.php?";
		}
}
function GetXmlHttpObject()
 {
	var xmlHttp=null;
	try
	 {
		 // Firefox, Opera 8.0+, Safari
		 xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
	 // Internet Explorer
	 try
	  {
	  	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	  }
	 catch (e)
	  {
	  	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	 }
	return xmlHttp;
 }


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
 
function createThirdXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        thirdxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        thirdxmlHttp = new XMLHttpRequest();
    }
}


function SubmitForm()
{
	document.frmcheckstatus.submit();
}

function rowclickColorChange(obj)
{
	var rowIndex = obj.rowIndex;
	var tbl = document.getElementById('tblMain');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrowLiteBlue";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}
function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}

function getgrn(objbtn)//styleId,EventScheduleMethod
{
	
	var row = objbtn.parentNode.parentNode;
	var style = row.cells[1].lastChild.nodeValue;
	var color = row.cells[5].lastChild.nodeValue;
	var size = row.cells[6].lastChild.nodeValue;
	//alert(rowval);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleGetGrn;
	xmlHttp.open("GET", 'checkstatusmiddle.php?StyleID=' + style + '&Color=' + color + '&Size=' + size, true);
	xmlHttp.send(null);
	
}

function HandleGetGrn()
{
	if(xmlHttp.readyState == 4) 
    {
		if(xmlHttp.status == 200) 
        { 	
			var XMLPoNo = xmlHttp.responseXML.getElementsByTagName("PoNo");
			var PoNo = XMLPoNo[0].childNodes[0].nodeValue;	
			var XMLGrnNo = xmlHttp.responseXML.getElementsByTagName("GrnNo");
			var GrnNo = XMLGrnNo[0].childNodes[0].nodeValue;
			var XMLPoQty = xmlHttp.responseXML.getElementsByTagName("PoQty");
			var PoQty = XMLPoQty[0].childNodes[0].nodeValue;
			var XMLConfirm = xmlHttp.responseXML.getElementsByTagName("Confirm");
			var Confirm = XMLConfirm[0].childNodes[0].nodeValue;
			var XMLGrnQty = xmlHttp.responseXML.getElementsByTagName("GrnQty");
			var GrnQty = XMLGrnQty[0].childNodes[0].nodeValue;
/*			for(var x = 0 ; x < XMLPoNo.length ; x++)
			{
			
			
			var Balance = PoQty - GrnQty;
			//alert (Balance);
			}*/
			ShowWindow(XMLPoNo,XMLGrnNo,XMLPoQty,XMLConfirm,XMLGrnQty);
		}
	}	
}



function ShowWindow(PoNo,GrnNo,PoQty,Confirm,GrnQty)
{
	drawPopupArea(950,100,'frmGRN');
	
	var HTMLText = "<table width=\"950\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
"  <tr>"+
"    <td>&nbsp;</td>"+
"  </tr>"+
"  <tr>"+
"    <td><table width=\"100%\" border=\"0\">"+
"      <tr>"+
"        <td width=\"1%\" height=\"260\">&nbsp;</td>"+
"        <td width=\"88%\"><form>"+
"          <table width=\"100%\" border=\"0\">"+
"            <tr>"+
"              <td height=\"16\" colspan=\"2\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Check Status</td>"+
"            </tr>"+
"            <tr>"+
"              <td width=\"50%\" height=\"161\"><table width=\"100%\" height=\"159\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
"                <tr class=\"bcgl1\">"+
"                  <td width=\"100%\" height=\"138\"><table width=\"100%\" border=\"0\" class=\"bcgl1\">"+
"                      <tr>"+
"                        <td colspan=\"3\"><div id=\"divcons2\" style=\"overflow:scroll; height:130px; width:400px;\">"+
"                            <table width=\"709\" cellpadding=\"0\" cellspacing=\"0\">"+
"                              <tr>"+
"                                <td width=\"75\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>"+
"                                <td width=\"98\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Sup Batch No</td>"+
"                                <td width=\"74\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Recieve Qty</td>"+
"                                <td width=\"64\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">App</td>"+
"                                </tr>"+
			//for (var loop = 0 ; loop < $PoNo.length ; loop++)
			//{
                            "<tr>"+
"                                <td class=\"normalfnt\">10</td>"+
"                                <td class=\"normalfnt\">10</td>"+
"                                <td class=\"normalfntRite\">43545</td>"+
"                                <td class=\"normalfntMid\">Test</td>"+
"                                </tr>"+
			//}
                            "</table>"+
"                        </div></td>"+
"                      </tr>"+
"                  </table></td>"+
"                </tr>"+
"                <tr class=\"bcgl1\">"+
"                  <td height=\"19\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
"                      <tr bgcolor=\"#D6E7F5\">"+
"                        <td width=\"15%\" height=\"23\" class=\"normalfnt\">Total Qty</td>"+
"                        <td width=\"25%\" class=\"normalfnt\"><input name=\"txtchkstatus\" type=\"text\" class=\"txtbox\" id=\"txtchkstatus\" size=\"15\" /></td>"+
"                        <td width=\"33%\" class=\"normalfnt\">Approved Total Qty</td>"+
"                        <td width=\"26%\" class=\"normalfnt\"><input name=\"txtchkstatus2\" type=\"text\" class=\"txtbox\" id=\"txtchkstatus2\" size=\"15\" /></td>"+
"                        <td width=\"1%\">&nbsp;</td>"+
"                      </tr>"+
"                  </table></td>"+
"                </tr>"+
"              </table></td>"+
"              <td width=\"50%\"><table width=\"100%\" height=\"159\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
"                <tr class=\"bcgl1\">"+
"                  <td width=\"100%\" height=\"138\"><table width=\"100%\" border=\"0\" class=\"bcgl1\">"+
"                      <tr>"+
"                        <td colspan=\"3\"><div id=\"divcons\" style=\"overflow:scroll; height:130px; width:400px;\">"+
"                            <table width=\"450\" cellpadding=\"0\" cellspacing=\"0\">"+
"                              <tr>"+
"                                <td width=\"77\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">PO No</td>"+
"                                <td width=\"88\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GRN No</td>"+
"                                <td width=\"68\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Confirm</td>"+
"                                <td width=\"97\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>"+
"                                <td width=\"68\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Balance</td>"+
"                              </tr>";
                         for(var i = 0; i < PoNo.length ; i++)
						 {
							// var PoQtybal = parseFloat(PoQty[i].childNodes[0].nodeValue) - parseFloat(GrnQty[i].childNodes[0].nodeValue);
                             HTMLText += "<tr>"+
"                                <td class=\"normalfnt\">"+ PoNo[i].childNodes[0].nodeValue +"</td>"+
"                                <td class=\"normalfnt\">"+ GrnNo[i].childNodes[0].nodeValue +"</td>"+
"                                <td class=\"normalfntMid\">"+ Confirm[i].childNodes[0].nodeValue +"</td>"+
"                                <td class=\"normalfntMid\">"+ PoQty[i].childNodes[0].nodeValue +"</td>"+
"                                <td class=\"normalfntRite\">"+ ( PoQty[i].childNodes[0].nodeValue - GrnQty[i].childNodes[0].nodeValue) +"</td>"+
"                              </tr>";
						 }
                           HTMLText += "</table>"+
"                        </div></td>"+
"                      </tr>"+
"                  </table></td>"+
"                </tr>"+
"                <tr class=\"bcgl1\">"+
"                  <td height=\"19\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
"                      <tr bgcolor=\"#D6E7F5\">"+
"                        <td width=\"14%\">&nbsp;</td>"+
"                        <td width=\"39%\">&nbsp;</td>"+
"                        <td width=\"22%\"><img src=\"../images/ok.png\" alt=\"ok\" width=\"86\" height=\"24\" /></td>"+
"                        <td width=\"24%\"><img src=\"../images/close.png\" width=\"97\" height=\"24\" onclick=\"closeWindow();\" class=\"mouseover\"/></td>"+
"                        <td width=\"1%\">&nbsp;</td>"+
"                      </tr>"+
"                  </table></td>"+
"                </tr>"+
"              </table></td>"+
"            </tr>"+
"          </table>"+
"        </form></td>"+
"        <td width=\"11%\">&nbsp;</td>"+
"      </tr>"+
"    </table></td>"+
"  </tr>"+
"  <tr>"+
"    <td>&nbsp;</td>"+
"  </tr>"+
"</table>";
	
	
	var popupbox = document.createElement("div");
	 document.getElementById('frmGRN').innerHTML=HTMLText;
     popupbox.id = "popupbox";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 10;
     popupbox.style.left = 500 + 'px';
     popupbox.style.top = 165+ 'px';
     document.getElementById('frmGRN').innerHTML=HTMLText; 
	 //popupbox.innerHTML = htmlText;     
    document.body.appendChild(popupbox);
}


function drawPopupArea(width,height,popupname)
{
	 var popupbox = document.createElement("div");
     popupbox.id = "popupbox";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 2;
     popupbox.style.left = 500 + 'px';
     popupbox.style.top = 50 + 'px';  
	 var htmltext = "<div style=\"width:" + screen.width +"px; height:155px;text-align:center;\">" +
					"<table width=\"" + screen.width +"\">"+
					  "<tr><td height=\""+ ((screen.height - height)/4) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					 " <tr>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" height=\"24\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" +  width + "\" valign=\"top\"><div id=\"" + popupname +"\" style=\"width:" + width + "px; height:" + height + "px;background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf;\">"+
					"<table width=\"" +width + "\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					  "<tr>"+
						"<td width=\"" + width + "\" height=\"" +  height + "\" align=\"center\" valign=\"middle\">Loading.....</td>"+
						"</tr>"+
					"</table>"+
					"</div><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
					 "</tr>"+
					  "<tr>"+
						"<td height=\""+ (((screen.height - height)/4)+100) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					"</table>"+				
					"</div>";
    popupbox.innerHTML = htmltext;     
    document.body.appendChild(popupbox);
}


function closeWindow()
{  

	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box); 
		
	}
	catch(err)
	{        
	}	
}
/*function LoadSCNo()
{
	var styleID = document.getElementById('cbostyleno').value;
	if(styleID=="Select One")return;
    createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleScNo;
    thirdxmlHttp.open("GET", 'checkstatusmiddle.php?RequestType=SRNo&StyleID=' + styleID , true);
    thirdxmlHttp.send(null);  
}

function HandleScNo()
{
    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  		 
			var srNo= thirdxmlHttp.responseXML.getElementsByTagName("SR");
			
			var optCombo1 = document.getElementById("cboscno").options;
			for (var i = 0; i < optCombo1.length; i++)
			{			
				if(optCombo1[i].text == srNo[0].childNodes[0].nodeValue)
				{
					document.getElementById("cboscno").options.selectedIndex = optCombo1[i].index;
				}
			}
			
		}
	}
}

function LoadStyleNo()
{
	var scNo = document.getElementById("cboscno").value;
    createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandleStyleNo;
    thirdxmlHttp.open("GET", 'checkstatusmiddle.php?RequestType=StyleNo&ScNo=' + scNo, true);
    thirdxmlHttp.send(null);  
}

function HandleStyleNo()
{

    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
			var styleNo= thirdxmlHttp.responseXML.getElementsByTagName("Style");
			 
			var optCombo2 = document.getElementById("cbostyleno").options;
			for (var i = 0; i < optCombo2.length; i++)
			{			
				if(optCombo2[i].text == styleNo[0].childNodes[0].nodeValue)
				{
					document.getElementById("cbostyleno").options.selectedIndex = optCombo2[i].index;
					
				}				
			}
			LoadBuyerPO();
		}
	}
}*/

function LoadStyleNo(obj)
{
	document.getElementById('cboOrderNo').value = obj.value;
	LoadBuyerPO();
	loadStyle();
}


function LoadSCNo(obj)
{
	document.getElementById('cboscno').value = obj.value;
	LoadBuyerPO();
}

function LoadBuyerPO()
{
	var styleId = document.getElementById("cboOrderNo").value;
	RomoveData('cbobuyerpo');
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleLoadBuyerPO;
    xmlHttp.open("GET", 'checkstatusmiddle.php?RequestType=LoadBuyerPO&StyleId=' + URLEncode(styleId), true);
    xmlHttp.send(null);  
}

function HandleLoadBuyerPO()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLBuyerPO		= xmlHttp.responseXML.getElementsByTagName("BuyerPO");
			var XMLBuyerPoName 	= xmlHttp.responseXML.getElementsByTagName("BuyerPoName");
			for ( var loop = 0; loop < XMLBuyerPO.length; loop ++)
			{
				var opt = document.createElement("option");
				opt.text = XMLBuyerPoName[loop].childNodes[0].nodeValue;
				opt.value = XMLBuyerPO[loop].childNodes[0].nodeValue;
				document.getElementById("cbobuyerpo").options.add(opt);
			}
		}
	}
}

function clearDropDown(controName)
{   
 var theDropDown = document.getElementById(controName)  
 var numberOfOptions = theDropDown.options.length  
 for (i=0; i<numberOfOptions; i++)
 {  
   theDropDown.remove(0)  
 }
}

function ShowinterjobWindow(obj)
{	
	var rw			= obj.parentNode.parentNode.parentNode;
	var styleID		= document.getElementById('cboOrderNo').value;
	var buyerPoNo	= rw.cells[0].id;			
	var matItemList	= rw.cells[3].childNodes[0].nodeValue;
	var color		= rw.cells[4].childNodes[0].nodeValue;
	var size		= rw.cells[5].childNodes[0].nodeValue;
	var mainStore	= document.getElementById('cbocompany').value;
showBackGround('divBG',0);
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=LoadStockDetailsRequest;
	xmlHttp.open("GET",'stockdetails.php?styleID=' +URLEncode(styleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&matItemList=' +matItemList+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&mainStore=' +mainStore ,true);
	xmlHttp.send(null);
}

	function LoadStockDetailsRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				drawPopupBox(860,550,'frmMaterialTransfer',1);
				//drawPopupArea(860,550,'frmMaterialTransfer');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;				
			}
		}
	}
	
function ShowDailyStockMovement(obj)
{
	var rw				= obj.parentNode.parentNode.parentNode;
	var styleID			= document.getElementById('cboOrderNo').value;
	var buyerPoNo		= rw.cells[0].id;			
	var matItemList		= rw.cells[3].childNodes[0].nodeValue;
	var color			= rw.cells[4].childNodes[0].nodeValue;
	var size			= rw.cells[5].childNodes[0].nodeValue;
	var mainStoreID		= document.getElementById('cbocompany').value;
	showBackGround('divBG',0);
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=ShowDailyStockMovementRequest;
	xmlHttp.open("GET",'dailystockmovement.php?styleID=' +URLEncode(styleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&matItemList=' +matItemList+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&mainStoreID=' +mainStoreID ,true);
	xmlHttp.send(null);
}

	function ShowDailyStockMovementRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				drawPopupBox(795,370,'frmDailyStockMovement',1);
				//drawPopupArea(795,370,'frmDailyStockMovement');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmDailyStockMovement').innerHTML=HTMLText;				
			}
		}
	}
		 
function Report()
{
	var orderId 			= document.getElementById("cboOrderNo").value;
	var buyerPoNo 			= document.getElementById("cbobuyerpo").value;	
	var companyID 			= document.getElementById("cbocompany").value;
	var mainMatCategoryId 	= document.getElementById("cboMainMatCategory").value;
	var styleName           = document.getElementById('cbostyleno').options[document.getElementById('cbostyleno').selectedIndex].text;
	if(orderId=="")
	{
		alert("Please select the 'Order No'");
		document.getElementById("cboOrderNo").focus();
		return;
	}
	
	newwindow=window.open('checkstatusreport.php?OrderId='+orderId+ '&buyerPoNo=' +URLEncode(buyerPoNo)+  '&companyID=' +companyID+ '&mainMatCategoryId=' +mainMatCategoryId+'&styleName='+styleName ,'checkStatusReport');
	if (window.focus) {newwindow.focus()}
}

function ShowExtra(obj)
{
	var rw			= obj.parentNode.parentNode.parentNode;
	var styleID		= document.getElementById('cboOrderNo').value;
	var buyerPoNo	= rw.cells[0].id;			
	var matItemList	= rw.cells[3].childNodes[0].nodeValue;
	var color		= rw.cells[4].childNodes[0].nodeValue;
	var size		= rw.cells[5].childNodes[0].nodeValue;
	var mainStoreID		= document.getElementById('cbocompany').value;
	
	showBackGround('divBG',0);
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=ShowExtraRequest;
	xmlHttp.open("GET",'extra.php?styleID=' +URLEncode(styleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&matItemList=' +matItemList+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&mainStoreID=' +mainStoreID ,true);
	xmlHttp.send(null);
}

	function ShowExtraRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				drawPopupBox(705,462,'frmMaterialTransfer',1);
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;				
			}
		}
	}	

function loadOrderNo()
{
	var stytleName = document.getElementById('cbostyleno').value;
	if(stytleName != '')
	{
		var url="checkstatusmiddle.php";
					url=url+"?RequestType=getStyleWiseOrderandSC";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("styleOrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
		
		var SCNo = htmlobj.responseXML.getElementsByTagName("styleSCNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboscno').innerHTML =  SCNo;
	}
	else
	{
		location = "checkstatus.php?";
		}
	
}
function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}
/*function loadDescription()
{
	var mainCat = document.getElementById("cboMainMatCategory").value;
	var styleNo = document.getElementById("cbostyleno").value;
	var  url             ='checkstatusmiddle.php?RequestType=loadItem&mainCat='+mainCat+'&styleNo='+styleNo;
	//alert(url);
	var xmlhttp_obj      =$.ajax({url:url,async:false})
	//alert(xmlhttp_obj.responseText);
		document.getElementById("cboDescription").innerHTML = xmlhttp_obj.responseText;
}*/
function loadDescription()
{
	var mainCat = document.getElementById("cboMainMatCategory").value;
	var styleNo = document.getElementById("cbostyleno").value;
	if(styleNo != '' && mainCat != '')
	{
		var url="checkstatusmiddle.php";
					url=url+"?RequestType=loadItem";
					url += '&mainCat='+URLEncode(mainCat);
					url += '&styleNo='+URLEncode(styleNo);
					
		var htmlobj=$.ajax({url:url,async:false});
		var description = htmlobj.responseXML.getElementsByTagName("DES")[0].childNodes[0].nodeValue;
		document.getElementById('cboDescription').innerHTML =  description;
		
	}
	else
	{
		location = "checkstatus.php?";
		}
	
}