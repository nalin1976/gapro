// JavaScript Document
// Author - Prasad Rajapaksha
var pub_host = document.location.host;
var pub_popup_indexNo = 0;
var pub_zIndex = 0;

var isNS = (navigator.appName == "Netscape") ? 1 : 0;
if(navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
//var AllowableCharators=new Array("38","37","39","40","8","9","46");
var AllowableCharators=new Array("46","8","9","37","39");


function emailValidate(email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if(reg.test(email) == false) {
      return false;
   }
   return true;
}


 function isNumberKey(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;

	if (evt.ctrlKey && charCode==118 ){
		return true;
	}
	
		if (evt.ctrlKey && charCode==99 ){
		return true;
		
	}
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }

	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
  }

function isNumeric(sText)
{
	sText = trim(sText);
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }

 function DisableContextMenu()
 {
   return false;
 }
 
 function EnableRightClickEvent()
 {
	 document.oncontextmenu = null;
	  return false;
 }
 
 function DisableRightClickEvent()
 {
	  document.oncontextmenu = DisableContextMenu;
	  return false;
 }

function CheckforValidDecimal(value,decimalPoints,evt)
{
	
	decimalPoints = parseInt(decimalPoints)+1;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	var positionCount = parseInt(value.indexOf('.'));
	if((positionCount>0) && (charCode=='46'))
		return false;
	
	if (evt.shiftKey && charCode==37 ){
		return false;
	}
	if (evt.shiftKey && charCode==39 ){
		return false;
	}
	
		var allowableCharacters = new Array(46,8,9,37,39);
			
	//var allowableCharacters = new Array(46,9,45,36,35);
	
	for (var loop = 0 ; loop < allowableCharacters.length ; loop ++ )
	{
		if (charCode == allowableCharacters[loop] )
		{
			return true;
		}
	}
	
	
	for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }
	
	if (charCode==46 && value.indexOf(".") >-1)
		return false;
	else if (charCode==46)
		return true;
	
	if (value.indexOf(".") > -1 && value.substring(value.indexOf("."),value.length).length > decimalPoints)
		return false;
	
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;


	 return true;
}

function isValidZipCode(value,evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;

	if (evt.shiftKey && charCode==37 ){
		return false;
	}
	if (evt.shiftKey && charCode==39 ){
		return false;
	}
	
	var allowableCharacters = new Array(8,9,37,48,49,50,51,52,53,54,55,56,57);
	
	for (x in allowableCharacters)
	  {
		  if (allowableCharacters[x] == charCode)
		  return true;		
	  }


	 return false;
}

function IsNumberWithoutDecimals(value,evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;

	if (evt.shiftKey && charCode==37 ){
		return false;
	}
	if (evt.shiftKey && charCode==39 ){
		return false;
	}
	
	var allowableCharacters = new Array(8,9,37,48,49,50,51,52,53,54,55,56,57);
	
	for (x in allowableCharacters)
	  {
		  if (allowableCharacters[x] == charCode)
		  return true;		
	  }


	 return false;
}

function checkForTextNumber(value,evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;

		var allowableCharacters = new Array(8,9,37);

		if (evt.shiftKey && charCode==37 ){
			return false;
		}
		if (evt.shiftKey && charCode==39 ){
			return false;
		}
		
	if (evt.ctrlKey && charCode==118 ){
		return false;
	}
	
	if (evt.ctrlKey && charCode==99 ){
		return false;
		
	}
	
		for(var x=5;x<=30;x++)
		{
			allowableCharacters[x] = (x+92);
		}
		for(var x=32;x<58;x++)
		{
			allowableCharacters[x] = (x+33);
		}
		for(var x=59;x<=68;x++)
		{
			allowableCharacters[x] = (x-11);
		}
	
	for (x in allowableCharacters)
	  {
		  if (allowableCharacters[x] == charCode)
		  return true;		
	  }
	//alert('pass');
	return false;
}

function drawPopupArea(width,height,popupname)
{
	
	 var popupbox = document.createElement("div");
     popupbox.id = "popupbox";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 2;
     popupbox.style.left = 0 + 'px';
     popupbox.style.top = 0 + 'px'; 
	 // popupbox.style.background = "#ECECFF"; 
 
	 var htmltext = "<div style=\"width:" + screen.width +"px; height:" + screen.height + "px;text-align:center;\">" +
					"<table width=\"" + screen.width +"\">"+
					  "<tr><td height=\""+ ((screen.height - height)/4) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					 " <tr>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" height=\"24\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" +  width + "\" valign=\"top\"><div id=\"" + popupname +"\" style=\"width:" + width + "px; height:" + height + "px;background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf;position:absolute;\">"+
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
	update();
}

function drawPopupArea2(width,height,popupname)
{
	
	 var popupbox = document.createElement("div");
     popupbox.id = "popupbox";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 2;
     popupbox.style.left = 0 + 'px';
     popupbox.style.top = 0 + 'px'; 
	 // popupbox.style.background = "#ECECFF"; 
 
	 var htmltext = "<div style=\"width:" + screen.width +"px; height:" + screen.height + "px;text-align:center;\">" +
					"<table width=\"" + screen.width +"\">"+
					  "<tr><td height=\""+ ((screen.height - height)/4) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					 " <tr>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" height=\"24\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" +  width + "\" valign=\"top\"><div id=\"" + popupname +"\" style=\"width:" + width + "px; height:" + height + "px;background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf;position:absolute;\">"+
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
	update();
}
function drawPopupAreaLayer(width,height,popupname,zindex)
{
	

	 var popupbox = document.createElement("div");
     popupbox.id = "popupLayer";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = zindex;
     popupbox.style.left = 0 + 'px';
     popupbox.style.top = 0 + 'px';  
	 var htmltext = "<div style=\"width:" + screen.width +"px; height:155px;text-align:center;\">" +
					"<table width=\"" + screen.width +"\">"+
					  "<tr><td height=\""+ ((screen.height - height)/4) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					 " <tr>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" height=\"24\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" +  width + "\" valign=\"top\"><div id=\"" + popupname +"\" style=\"width:" + width + "px; height:" + height + "px;background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#0376bf;position:absolute;\">"+
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
    update();
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

function closeLayer()
{
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function closeLayerByName(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}
function ltrim(str) { 
	for(var k = 0; k < str.length && isWhitespace(str.charAt(k)); k++);
	return str.substring(k, str.length);
}

function rtrim(str) {
	for(var j=str.length-1; j>=0 && isWhitespace(str.charAt(j)) ; j--) ;
	return str.substring(0,j+1);
}

function trim(str) {
	return ltrim(rtrim(str));
}

function isWhitespace(charToCheck) {
	var whitespaceChars = " \t\n\r\f";
	return (whitespaceChars.indexOf(charToCheck) != -1);
}

 function ControlableKeyAccess(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;


	 if (charCode == 9)
		return true;

	 return false;

  }
  
  function drawPopupBox(width,height,popupname,zindex)
{
	 var popupbox = document.createElement("div");
     popupbox.id = "popupLayer" + zindex;
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = zindex;
     popupbox.style.left = 30 + 'px';
     popupbox.style.top = 0 + 'px';  
	 var htmltext = "<div style=\"width:" + screen.width +"px; height:155px;text-align:center;\">" +
					"<table width=\"" + screen.width +"\">"+
					  "<tr><td height=\""+ ((screen.height - height)/4) +"\" colspan=\"3\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"</tr>"+
					 " <tr>"+
						"<td width=\"" + ((screen.width - width)/2) + "\" height=\"24\" valign=\"top\"><!--DWLayoutEmptyCell-->&nbsp;</td>"+
						"<td width=\"" +  width + "\" valign=\"top\"><div id=\"" + popupname +"\" style=\"width:" + width + "px; height:" + height + "px;background-color:#D6E7F5;text-align:center;border-style:solid; border-width:1px;border-color:#550000;\">"+
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

function closePopupBox(index)
{
	try
	{
		var box = document.getElementById('popupLayer' + index);
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

var mousex = 0;
var mousey = 0;
var grabx = 0;
var graby = 0;
var orix = 0;
var oriy = 0;
var elex = 0;
var eley = 0;
var algor = 0;

var dragobj = null;

function falsefunc() { return false; } // used to block cascading events

function getMouseXY(e) // works on IE6,FF,Moz,Opera7
{ 
  if (!e) e = window.event; // works on IE, but not NS (we rely on NS passing us the event)

  if (e)
  { 
    if (e.pageX || e.pageY)
    { // this doesn't work on IE6!! (works on FF,Moz,Opera7)
      mousex = e.pageX;
      mousey = e.pageY;
      algor = '[e.pageX]';
      if (e.clientX || e.clientY) algor += ' [e.clientX] '
    }
    else if (e.clientX || e.clientY)
    { // works on IE6,FF,Moz,Opera7
      mousex = e.clientX + document.body.scrollLeft;
      mousey = e.clientY + document.body.scrollTop;
      algor = '[e.clientX]';
      if (e.pageX || e.pageY) algor += ' [e.pageX] '
    }  
  }
}

function update(e)
{
  getMouseXY(e); // NS is passing (event), while IE is passing (null)

}


function grab(context,e)
{
	update(e);
  document.onmousedown = falsefunc; // in NS this prevents cascading of events, thus disabling text selection
  dragobj = context;
  dragobj.style.zIndex = context.zIndex; // move it to the top
  document.onmousemove = drag;
  document.onmouseup = drop;
  

  grabx = mousex;
  graby = mousey;

  elex = orix = dragobj.offsetLeft;
  eley = oriy = dragobj.offsetTop;
  //update();
}

function drag(e) // parameter passing is important for NS family 
{
  if (dragobj)
  {
    elex = orix + (mousex-grabx);
    eley = oriy + (mousey-graby);
    dragobj.style.position = "absolute";
    dragobj.style.left = (elex).toString(10) + 'px';
    dragobj.style.top  = (eley).toString(10) + 'px';
  }
  update(e);
  return false; // in IE this prevents cascading of events, thus text selection is disabled
}

function drop()
{
  if (dragobj)
  {
    dragobj.style.zIndex = 0;
    dragobj = null;
  }
  update();
  document.onmousemove = update;
  document.onmouseup = null;
  document.onmousedown = null;   // re-enables text selection on NS
}

function changeToTextBox(obj)
{
	var  currentTxt = obj.innerHTML;
	if ( obj.childNodes[0] instanceof HTMLInputElement)
	{
		return;
	}
	//var newdiv = document.createElement('div');
	//newdiv.innerHTML = "<input type=\"text\" value =\""+ currentTxt + "\">";
	obj.innerHTML = "<input type=\"text\" class=\"txtbox\" value =\""+ currentTxt + "\" onblur=\"changeToTableCell(this);\" size=\"9\" >";
	obj.childNodes[0].focus();
}



function changeToTableCell(obj)
{
	obj.parentNode.innerHTML = obj.value;
}


function quoteEncode(value)
{
	value = value.replace(/"/gi,'\\"');
	value = value.replace(/'/gi,"\\'");	
	return value;
}
function URLEncode(url)
{
	try
	{
		url = url.replace(/"/gi,'\\"');
		url = url.replace(/'/gi,"\\'");
		//alert(url);
		//strBuyerPo = strBuyerPo.replace(/#/gi,"***");
		
		url = "" + url + "";
		url = url.replace("&amp;", "&");
		// The Javascript escape and unescape functions do not correspond
		// with what browsers actually do...
		var SAFECHARS = "0123456789" +					// Numeric
						"ABCDEFGHIJKLMNOPQRSTUVWXYZ" +	// Alphabetic
						"abcdefghijklmnopqrstuvwxyz" +
						"-_.!~*'()";					// RFC2396 Mark characters
		var HEX = "0123456789ABCDEF";
	
		var plaintext = url;
		var encoded = "";
		for (var i = 0; i < plaintext.length; i++ ) {
			var ch = plaintext.charAt(i);
			if (ch == " ") {
				encoded += " ";				// x-www-urlencoded, rather than %20
			} else if (SAFECHARS.indexOf(ch) != -1) {
				encoded += ch;
			} else {
				var charCode = ch.charCodeAt(0);
				if (charCode > 255) {
					/*
					alert( "Unicode Character '" 
							+ ch 
							+ "' cannot be encoded using standard URL encoding.\n" +
							  "(URL encoding only supports 8-bit characters.)\n" +
							  "A space (+) will be substituted." );
					encoded += "+";
					*/
				} else {
					encoded += "%";
					encoded += HEX.charAt((charCode >> 4) & 0xF);
					encoded += HEX.charAt(charCode & 0xF);
				}
			}
		} // for
	
		//document.URLForm.F2.value = encoded;
	  //document.URLForm.F2.select();
		return encoded;
	}
	catch(e)
	{
		return url;
	}
}

function URLDecode(url)
{
   // Replace + with ' '
   // Replace %xx with equivalent character
   // Put [ERROR] in output if %xx is invalid.
   var HEXCHARS = "0123456789ABCDEFabcdef"; 
   var encoded = url;
   var plaintext = "";
   var i = 0;
   while (i < encoded.length) {
       var ch = encoded.charAt(i);
	   if (ch == "+") {
	       plaintext += " ";
		   i++;
	   } else if (ch == "%") {
			if (i < (encoded.length-2) 
					&& HEXCHARS.indexOf(encoded.charAt(i+1)) != -1 
					&& HEXCHARS.indexOf(encoded.charAt(i+2)) != -1 ) {
				plaintext += unescape( encoded.substr(i,3) );
				i += 3;
			} else {
				alert( 'Bad escape combination near ...' + encoded.substr(i) );
				plaintext += "%[ERROR]";
				i++;
			}
		} else {
		   plaintext += ch;
		   i++;
		}
	} // while

   return plaintext;
}
function showPleaseWait()
{
	var popupbox = document.createElement("div");
   popupbox.id = "divPleasewait";
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = 4;
   popupbox.style.left = 0 + 'px';
   popupbox.style.top = 0 + 'px'; 
   popupbox.style.background="#000000"; 
   popupbox.style.width = screen.width + 'px';
   popupbox.style.height = screen.height + 'px';
   popupbox.style.MozOpacity = 0.5;
   popupbox.style.color = "#FFFFFF";
	popupbox.innerHTML = "<p align=\"center\">Please wait.....</p>",
	document.body.appendChild(popupbox);
}

function hidePleaseWait()
{
	try
	{
		var box = document.getElementById('divPleasewait');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}
function showBackGroundBalck()
{
	var popupbox = document.createElement("div");
   popupbox.id = "divBackGroundBalck";
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = 4;
   popupbox.style.left = 0 + 'px';
   popupbox.style.top = 0 + 'px'; 
   popupbox.style.background="#000000"; 
   popupbox.style.width = screen.width + 'px';
   popupbox.style.height = screen.height + 'px';
   popupbox.style.MozOpacity = 0.5;
   popupbox.style.color = "#FFFFFF";
	document.body.appendChild(popupbox);
}

function hideBackGroundBalck()
{
	try
	{
		var box = document.getElementById('divBackGroundBalck');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function showBackGround(objId,objIndex)
{
	var popupbox = document.createElement("div");
   popupbox.id = objId;
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = objIndex;
   popupbox.style.left = 0 + 'px';
   popupbox.style.top = 0 + 'px'; 
   popupbox.style.background="#000000"; 
   popupbox.style.width = screen.width +'px';
   popupbox.style.height = screen.height +'px';
   popupbox.style.MozOpacity = 0.5;
   popupbox.style.color = "#FFFFFF";
	document.body.appendChild(popupbox);
}

function hideBackGround(objId)
{
	try
	{
		var box = document.getElementById(objId);
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

///////////////////////////////// /////////////////// /////////////////////////////
var xmlHttpForTitle;

setTitleToSession();

function setTitleToSession()
{
	var sc_title = document.title;
	var hostName = document.location.host;
	createXMLHttpRequestforTitle();
	//xmlHttpForTitle.onreadystatechange=requestforgettitle;
	xmlHttpForTitle.open("GET",'http://'+hostName+'/gapro/setTitleToSession.php?title=' + URLEncode(sc_title) ,true);
	xmlHttpForTitle.send(null);
}

//start - configuring HTTP request
function createXMLHttpRequestforTitle() 
{
	if (window.ActiveXObject) 
	{
		xmlHttpForTitle = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest)
	{
		xmlHttpForTitle = new XMLHttpRequest();
	}
}

function CreatePopUp(url,W,H,closePopUp)
{
	createXMLHttpRequestforTitle();	
	xmlHttpForTitle.onreadystatechange=CreatePopUpRequest;
	xmlHttpForTitle.W = W;
	xmlHttpForTitle.H = H;
	xmlHttpForTitle.closePopUp = closePopUp;
	xmlHttpForTitle.open("GET",url ,true);
	xmlHttpForTitle.send(null);
}
var test ="";

function CreatePopUpRequest()
{
	if (xmlHttpForTitle.readyState==4 && xmlHttpForTitle.status==200)
	{
			var W 			= xmlHttpForTitle.W;
			var H 			= xmlHttpForTitle.H;
			var closePopUp 	= xmlHttpForTitle.closePopUp;
			drawPopupArea(W,H,'frmPopUp'+(++pub_popup_indexNo));				
			var HTMLText=xmlHttpForTitle.responseText;		
			
			document.getElementById('frmPopUp'+pub_popup_indexNo).innerHTML = HTMLText;
			document.getElementById('tdHeader').innerHTML = "<img  align=\"right\" src=\"/gapro/images/closelabel.gif\" alt=\"Close\" name=\"Close\"  border=\"0\" id=\"Close\" onclick=\""+closePopUp+"();\"/>";				
			document.getElementById('tdDelete').innerHTML = "";
	}		
}
//////////////////////////////////////////////////////////////////
function CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose)
{
	createXMLHttpRequestforTitle();	
	xmlHttpForTitle.onreadystatechange=CreatePopUpRequest2;
	xmlHttpForTitle.W = W;
	xmlHttpForTitle.H = H;
	
	xmlHttpForTitle.tdHeader = tdHeader;
	xmlHttpForTitle.tdDelete = tdDelete;
	xmlHttpForTitle.tdPopUpClose = tdPopUpClose;
	
	xmlHttpForTitle.closePopUp = closePopUp;
	xmlHttpForTitle.open("GET",url ,true);
	xmlHttpForTitle.send(null);
}
var test ="";

function CreatePopUpRequest2()
{
	if (xmlHttpForTitle.readyState==4 && xmlHttpForTitle.status==200)
	{
			var W 			= xmlHttpForTitle.W;
			var H 			= xmlHttpForTitle.H;
			var closePopUp 	= xmlHttpForTitle.closePopUp;
			var zIn = ++pub_zIndex;
			drawPopupBox(W,H,'frmPopUp'+zIn,(zIn));				
			var HTMLText=xmlHttpForTitle.responseText;		
			
			HTMLText = HTMLText.replace(/main_bottom/gi,'main_bottompop');
			
			document.getElementById('frmPopUp'+zIn).innerHTML = HTMLText;
			document.getElementById(xmlHttpForTitle.tdHeader).innerHTML = "";
			//popup_close_button
			document.getElementById(xmlHttpForTitle.tdPopUpClose).innerHTML = "<img onclick=\""+closePopUp+"("+zIn+");\" align=\"right\" src=\"/gapro/images/cross.png\" />";
			
/*			document.getElementById(xmlHttpForTitle.tdHeader).innerHTML = "<img  align=\"right\" src=\"/gapro/images/closelabel.gif\" alt=\"Close\" name=\"Close\"  border=\"0\" id=\"Close\" onclick=\""+closePopUp+"("+zIn+");\"/>";*/				
			document.getElementById(xmlHttpForTitle.tdDelete).innerHTML = '';
	}		
}


///////////////////////////////////////////////////////////////
function inc(filename)
{				
	var body = document.getElementsByTagName('body').item(0);				
	script = document.createElement('script');				
	script.src = filename;
	script.type = 'text/javascript';				
	body.appendChild(script);
}	

function trim(str) {
	return ltrim(rtrim(str, ' '), ' ' );
}
 
function ltrim(str) {
	chars = ' '  || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str) {
	chars = ' ' || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function loadCombo(sql,control)
{

/*	createXMLHttpRequestforTitle();
	xmlHttpForTitle.onreadystatechange=requestforloadcombo;
	xmlHttpForTitle.open("GET",true);
	xmlHttpForTitle.control = control;
	xmlHttpForTitle.send(null);	
	*/
	//alert(sql);
	var url = '/gapro/commonPHP/comboLoad.php?sql='+sql;
	htmlobj=$.ajax({url:url,async:false});
	
	document.getElementById(control).innerHTML  = htmlobj.responseText;
}

function requestforloadcombo()
{
		
	if(xmlHttpForTitle.readyState == 4) 
	{
		if(xmlHttpForTitle.status == 200) 
		{
			document.getElementById(xmlHttpForTitle.control).innerHTML  = xmlHttpForTitle.responseText;
		}
	}
}

function checkInField(table,field,value,idField,id)
{
	var urlDetails = "/gapro/commonPHP/checkfield.php?table="+table+"&field="+field+"&value="+URLEncode(value)+"&idField="+idField+"&id="+id;
	htmlobj=$.ajax({url:urlDetails,async:false});
	var x= parseInt(htmlobj.responseText);	
	if(x==1)
		return true;
	else 
		return false;
}

function getZipCode(countryId)
{
	var urlDetails = "/gapro/commonPHP/commonFunction.php?id=getZipCode&countryId="+countryId;
	htmlobj=$.ajax({url:urlDetails,async:false});
	var x= htmlobj.responseText;	
	return x;
}

function setUsed(table,idField,id)
{
	var urlDetails = "/gapro/commonPHP/checkfield.php?table="+table+"&id="+id+"&idField="+idField;
	htmlobj=$.ajax({url:urlDetails,async:false});
	var x= parseInt(htmlobj.responseText);	

}

function valueEncode(value)
{
	value = value.replace(/"/gi,'\\"');
	value = value.replace(/'/gi,"\\'");
	return value;
}


function imposeMaxLength(Object,evt, MaxLen)
{
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (evt.ctrlKey && charCode==118 ){
		return false;
		
	}
	 	
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }
  return (Object.value.length < MaxLen);
}
function imposeMaxValue(obj,maxv)
{	
	//alert(obj.value);
	//obj.value = obj.value.substring(0,maxv);
}

function cdata(str)
{
	return str.replace("<","&lt;");
}

function loadOnButtonEnter()
{
	$(document).ready(function() {
		$('#butSave').keypress(function(e) {
			if(e.keyCode==13)
				$('#butSave').trigger('click');
		});
		$('#butDelete').keypress(function(e) {
			if(e.keyCode==13)
				$('#butDelete').trigger('click');
		});
		$('#butReport').keypress(function(e) {
			if(e.keyCode==13)
				$('#butReport').trigger('click');
		});
		$('#butNew').keypress(function(e) {
			if(e.keyCode==13)
				$('#butNew').trigger('click');
		});
		
		/////////////////////
		
		$('.cboCountry').change(function() {
			
				//alert(this.form.id);
		});
		
	});	
}

function set4deci(obj)
{
	var val = (obj.value=="" ? 0 :obj.value);
	var x = parseFloat(val).toFixed(4);
	obj.value =Number(x);
}

function getGRNwiseStocktransactionDetails(type,styleID,buyerPO,store,matID,color,size,grnNo,grnYear,grnType)
{
	 var url="/gapro/commonPHP/stocktransactionPopup.php?";
	 url += "&type="+type;
	 url += "&styleID="+styleID;
	 url += "&buyerPO="+buyerPO;
	 url += "&store="+store;
	 url += "&matID="+matID;
	 url += "&color="+color;
	 url += "&size="+size;
	 url += "&grnNo="+grnNo;
	 url += "&grnYear="+grnYear;
	 url += "&grnType="+grnType;
	 
	 htmlobj=$.ajax({url:url,async:false});
	 var HTMLText=htmlobj.responseText;
	 drawPopupBox(602,385,'frmStockTrans',20);
	 document.getElementById('frmStockTrans').innerHTML=HTMLText;
}

function getGLCode(accid,accno)
{
	return (accid+"/"+accno);
}
function string_constrain(e)
{
    var keyCode = e.keyCode || e.which;
     if(keyCode =='39')
	{
			return false;
	}

}

function RoundNumbers(number,decimals) {
	number = parseFloat(number).toFixed(parseInt(decimals));
	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
			numString += ".";// give it one at the end
		}
		var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
		var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
		var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
		if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
			if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff,cutoff+1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		} 
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0,cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
	for(var i=0;i<decimals-decs;i++) newString += "0";
	if (newString.charAt(newString.length-1) == ".")
		newString =newString.substring(0,newString.length-1);
	//var newNumber = Number(newString);// make it a number if you like
	newString = newString.replace("Infinity","0");
	return newString; // Output the result to the form field (change for your purposes)
}