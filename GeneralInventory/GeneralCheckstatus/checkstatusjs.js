var xmlHttp;
var thirdxmlHttp;

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
     popupbox.style.left = 0 + 'px';
     popupbox.style.top = 0 + 'px';  
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


function ShowinterjobWindow()
{
	 drawPopupArea(950,600,'frminterjob');
	
	var HTMLText ="<table width=\"950\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
"  <tr>"+
"    <td>&nbsp;</td>"+
"  </tr>"+
"  <tr>"+
"    <td><table width=\"100%\" border=\"0\">"+
"      <tr>"+
"        <td width=\"4%\" height=\"233\">&nbsp;</td>"+
"        <td width=\"91%\"><form>"+
"          <table width=\"100%\" border=\"0\">"+
"            <tr>"+
"              <td height=\"16\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Bin GRN Details</td>"+
"            </tr>"+
"            <tr>"+
"              <td height=\"17\"><table width=\"100%\" border=\"0\">"+
"                <tr>"+
"                  <td><div id=\"divcons2\" style=\"overflow:scroll; height:100px; width:846px;\">"+
"                    <table width=\"825\" cellpadding=\"0\" cellspacing=\"0\">"+
"                      <tr>"+
"                        <td width=\"128\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Main Stores</td>"+
"                        <td width=\"109\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Sub Stores</td>"+
"                        <td width=\"127\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Location</td>"+
"                        <td width=\"112\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin</td>"+
"                        <td width=\"68\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>"+
"                        <td width=\"115\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>"+
"                        <td width=\"148\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Grn</td>"+
"                        </tr>"+
"                      <tr>"+
"                        <td class=\"normalfnt\">10339</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        </tr>"+
"                      <tr>"+
"                        <td class=\"normalfnt\">35454</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        </tr>"+
"                      <tr>"+
"                        <td class=\"normalfnt\">43545</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        </tr>"+
"                    </table>"+
"                  </div></td>"+
"                </tr>"+
"                <tr>"+
"                  <td height=\"16\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Inter Job Transfers</td>"+
"                </tr>"+
"                <tr>"+
"                  <td><div id=\"divcons3\" style=\"overflow:scroll; height:130px; width:846px;\">"+
"                    <table width=\"825\" cellpadding=\"0\" cellspacing=\"0\">"+
"                      <tr>"+
"                        <td width=\"100\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">ID</td>"+
"                        <td width=\"106\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style From</td>"+
"                        <td width=\"97\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style To</td>"+
"                        <td width=\"195\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
"                        <td width=\"98\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>"+
"                        <td width=\"82\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">User</td>"+
"                        <td width=\"90\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
"                      </tr>"+
"                      <tr>"+
"                        <td class=\"normalfnt\">10339</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                      </tr>"+
"                      <tr>"+
"                        <td class=\"normalfnt\">35454</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                      </tr>"+
"                      <tr>"+
"                        <td class=\"normalfnt\">43545</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                      </tr>"+
"                    </table>"+
"                  </div></td>"+
"                </tr>"+
"                <tr>"+
"                  <td height=\"16\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Location Transfers</td>"+
"                </tr>"+
"                <tr>"+
"                  <td><div id=\"divcons4\" style=\"overflow:scroll; height:130px; width:846px;\">"+
"                    <table width=\"825\" cellpadding=\"0\" cellspacing=\"0\">"+
"                      <tr>"+
"                        <td width=\"78\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">ID</td>"+
"                        <td width=\"108\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Gate Pass no</td>"+
"                        <td width=\"171\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Discription</td>"+
"                        <td width=\"44\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>"+
"                        <td width=\"84\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GP Qty</td>"+
"                        <td width=\"80\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Trans Qty</td>"+
"                        <td width=\"128\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Reason</td>"+
"                        <td width=\"86\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">User</td>"+
"                        </tr>"+
"                      <tr>"+
"                        <td class=\"normalfnt\">10339</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        </tr>"+
"                      <tr>"+
"                        <td class=\"normalfnt\">35454</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        </tr>"+
"                      <tr>"+
"                        <td class=\"normalfnt\">43545</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfnt\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntRite\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        <td class=\"normalfntMid\">Test</td>"+
"                        </tr>"+
"                    </table>"+
"                  </div></td>"+
"                </tr>"+
"              </table></td>"+
"            </tr>"+
"            <tr>"+
"              <td height=\"32\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
"                <tr bgcolor=\"#D6E7F5\">"+
"                  <td width=\"28%\">&nbsp;</td>"+
"                  <td width=\"18%\"><img src=\"../images/ok.png\" alt=\"ok\" width=\"86\" height=\"24\" /></td>"+
"                  <td width=\"6%\">&nbsp;</td>"+
"                  <td width=\"20%\"><img src=\"../images/close.png\" width=\"97\" height=\"24\" onclick=\"closeWindow();\" class=\"mouseover\" /></td>"+
"                  <td width=\"28%\">&nbsp;</td>"+
"                </tr>"+
"              </table></td>"+
"            </tr>"+
"          </table>"+
"        </form></td>"+
"        <td width=\"5%\">&nbsp;</td>"+
"      </tr>"+
"    </table></td>"+
"  </tr>"+
"  <tr>"+
"    <td>&nbsp;</td>"+
"  </tr>"+
"</table>";
	
	
	
	 var popupbox = document.createElement("div");
	 document.getElementById('frminterjob').innerHTML=HTMLText;
     popupbox.id = "popupbox";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 10;
     popupbox.style.left = 500 + 'px';
     popupbox.style.top = 165+ 'px';
     document.getElementById('frminterjob').innerHTML=HTMLText; 
	 //popupbox.innerHTML = htmlText;     
    document.body.appendChild(popupbox);
}

function LoadSCNo()
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
		}
	}
}

function LoadBuyerPO()
{
	var styleId = document.getElementById("cbostyleno").value;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleLoadBuyerPO;
    xmlHttp.open("GET", 'checkstatusmiddle.php?RequestType=LoadBuyerPO&StyleId=' + styleId, true);
    xmlHttp.send(null);  
}

function HandleLoadBuyerPO()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLBuyerPO= xmlHttp.responseXML.getElementsByTagName("BuyerPO");
/*			
			clearDropDown("cbobuyerpo");
			
			var optTmp = document.createElement("option");
			optTmp.text = "#Main Ratio#";
			optTmp.value = "#Main Ratio#";
			document.getElementById("cbobuyerpo").options.add(optTmp);
			
			var optTmp2 = document.createElement("option");
			optTmp2.text = "";
			optTmp2.value = "";
			document.getElementById("cbobuyerpo").options.add(optTmp2);
*/			
			for ( var loop = 0; loop < XMLBuyerPO.length; loop ++)
			{
				var opt = document.createElement("option");
				opt.text = XMLBuyerPO[loop].childNodes[0].nodeValue;
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