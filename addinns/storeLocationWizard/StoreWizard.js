// JavaScript Document
var xmlHttp;
var mid;
var sid;
var lid;
var bid;
var strBin;
var xmlHttpreq = [];
var strBinName=""

function createNewXMLHttpTRowObj(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpreq[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpreq[index] = new XMLHttpRequest();
    }
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

function createAltXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        altxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttp = new XMLHttpRequest();
    }
}

function createXMLHttpRequestLOC() 
{
    if (window.ActiveXObject) 
    {
        locxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        locxmlHttp = new XMLHttpRequest();
    }
}

function createHtmlXmlBinObj() 
{
    if (window.ActiveXObject) 
    {
        binxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        binxmlHttp = new XMLHttpRequest();
    }
}



function createHtmlXmlAvlMatSubCatDelete() 
{
    if (window.ActiveXObject) 
    {
        catDelete = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        catDelete = new XMLHttpRequest();
    }
}


function createHtmlXmlBinAllocation() 
{
    if (window.ActiveXObject) 
    {
        binAllowcationXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        binAllowcationXmlHttp = new XMLHttpRequest();
    }
}

function createHtmlXmlMatSubCat() 
{
    if (window.ActiveXObject) 
    {
        matSubCatmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        matSubCatmlHttp = new XMLHttpRequest();
    }
}

function createHtmlXmlAvlMatSubCat() 
{
    if (window.ActiveXObject) 
    {
        avlMatSubCatmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        avlMatSubCatmlHttp = new XMLHttpRequest();
    }
}

function createHtmlXmlUnits() 
{
    if (window.ActiveXObject) 
    {
        unitXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        unitXmlHttp = new XMLHttpRequest();
    }
}


function ShowHTMLWindow()
{
	try
	{
		//var box = document.getElementById('popupbox');
		document.getElementById('popupsubstore').style.visibility = 'hidden';
		document.getElementById('popupbox').style.visibility = 'hidden';
		
		document.getElementById('popupbox').style.visibility = 'visible';
		

		return;
	}
	catch(err)
	{        
	}	
	
	var htmlMainStoreForm = "<table width=\"500\" border=\"0\">"+
					  "<tr>"+
						"<td width=\"486\" height=\"24\" bgcolor=\"#498CC2\" 				class=\"TitleN2white\">Stores Location Wizard</td>"+
					 "</tr>"+
					  "<tr>"+
						"<td height=\"203\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
						  "<tr>"+
							"<td height=\"20\" colspan=\"3\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Main Stores</td>"+
							"</tr>"+
						 " <tr>"+
							"<td width=\"48%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">Select</td>"+
							"<td width=\"4%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">&nbsp;</td>"+
							"<td width=\"48%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">New</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td height=\"141\" valign=\"top\"><select name=\"cboMainStores\" size=\"10\" class=\"txtbox\" id=\"cboMainStores\" style=\"width:225px\"   > "+
							"</select></td>"+
							"<td>&nbsp;</td>"+
							"<td valign=\"top\"><table width=\"100%\" border=\"0\" class=\"backcolorGreen\">"+
							  "<tr>"+
								"<td class=\"normalfnt\">Name</td>"+
							  "</tr>"+
							  "<tr>"+
								"<td><input name=\"txtname\" type=\"text\" class=\"txtbox\" id=\"txtname\" size=\"35\" /></td>"+
							  "</tr>"+
							  "<tr>"+
								"<td class=\"normalfnt\">Remarks</td>"+
							  "</tr>"+
							  "<tr>"+
								"<td><textarea name=\"txtremarks\" id=\"txtremarks\" cols=\"25\" rows=\"3\"></textarea></td>"+
							  "</tr>"+
							  "<tr>"+
								"<td bgcolor=\"#D6E7F5\"><div align=\"right\"><img src=\"../../images/addsmall.png\" onClick=\"SaveNewStore();\" alt=\"Add\" width=\"95\" height=\"24\" class=\"mouseover\" /></div></td>"+
							  "</tr>"+					
							"</table></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td height=\"15\" colspan=\"3\" class=\"normaltxtmidb2L\">&nbsp;</td>"+
							"</tr>"+
						"</table></td>"+
					  "</tr>"+
					  "<tr>"+
						"<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">"+
						  "<tr>"+
							
							"<td width=\"25%\">&nbsp;</td>"+
							"<td width=\"25%\"><a href=\"../../main.php\"><img src=\"../../images/close.png\" alt=\"Close\" width=\"95\" height=\"24\" border=\"0\" class=\"mouseover\" /></a></td>"+
							"<td width=\"25%\"><img src=\"../../images/next.png\" onClick=\"showSubStoresWindow();\" width=\"95\" height=\"24\" border=\"0\" class=\"mouseover\"/></td>"+
							"<td width=\"25%\">&nbsp;</td>"+
							
						 "</tr>"+
						"</table></td>"+
					  "</tr>"+
					"</table>";
			
			
	
			
			
	 var popupbox = document.createElement("div");
     popupbox.id = "popupbox";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 1;
     popupbox.style.left = 250 + 'px';
     popupbox.style.top = 100 + 'px';  
	 popupbox.innerHTML = htmlMainStoreForm;        
     document.body.appendChild(popupbox);
	 LoadMainStores();
	 
}


function showSubStoresWindow()
{
	if (document.getElementById("cboMainStores").value=="")
	{
		alert("Please select a Main Store")
		return false;
	}
	else
	{
		mid=document.getElementById("cboMainStores").value;	
	}
	
	try
	{
		document.getElementById('popupsubstore').style.visibility = 'visible';
		document.getElementById('popupbox').style.visibility = 'hidden';
		var x=document.getElementById('popuplocation');
		if(x!=null)
		{
			document.getElementById('popuplocation').style.visibility = 'hidden';
		}
		RemoveAvailableSubstoresList()
		LoadSubStores(mid);
		return;
	}
	catch(err)
	{        
	}	
	
	
	
	

	var selectedMainStore =  document.getElementById("cboMainStores").options[document.getElementById("cboMainStores").selectedIndex].text;
	
	LoadSubStores(document.getElementById("cboMainStores").value);

	var myHtmlSubStoreForm="<table width=\"500\" border=\"0\">"+
							  "<tr>"+
								"<td width=\"486\" height=\"24\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Stores Location Wizard</td>"+
							  "</tr>"+
							  "<tr>"+
								"<td height=\"203\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
								  "<tr>"+
									"<td height=\"20\" colspan=\"3\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Sub Stores For : " + selectedMainStore +"</td>"+
									"</tr>"+
								  "<tr>"+
									"<td width=\"48%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">Select</td>"+
									"<td width=\"4%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">&nbsp;</td>"+
									"<td width=\"48%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">New</td>"+
								  "</tr>"+
								  "<tr>"+
										"<td height=\"141\" valign=\"top\"><select name=\"cboSubStores\" size=\"10\" class=\"txtbox\" id=\"cboSubStores\" style=\"width:225px\">"+
						"</select></td>"+
						"<td>&nbsp;</td>"+
						"<td valign=\"top\"><table width=\"100%\" border=\"0\" class=\"backcolorGreen\">"+
						  "<tr>"+
							"<td class=\"normalfnt\">Name</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td><input name=\"txtSubName\" type=\"text\" class=\"txtbox\" id=\"txtSubName\" size=\"35\" /></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td class=\"normalfnt\">Remarks</td>"+
						  "</tr>"+
						  "<tr>"+
							"<td><textarea name=\"txtSubRemarks\" id=\"txtSubRemarks\" cols=\"25\" rows=\"3\"></textarea></td>"+
						  "</tr>"+
						  "<tr>"+
							"<td bgcolor=\"#D6E7F5\"><div align=\"right\"><img src=\"../../images/addsmall.png\" onClick=\"SaveNewSubStore(" + mid + ")\" alt=\"Add\" width=\"95\" height=\"24\" /></div></td>"+
						  "</tr>"+
						  "</table></td>"+
					  "</tr>"+
					  "<tr>"+
						"<td height=\"15\" colspan=\"3\" class=\"normaltxtmidb2L\">&nbsp;</td>"+
						"</tr>"+
					"</table></td>"+
				  "</tr>"+
				  "<tr>"+
					"<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">"+
					  "<tr>"+
						
						"<td width=\"25%\">&nbsp;</td>"+
						"<td width=\"25%\"><img src=\"../../images/back.png\" onClick=\"ShowHTMLWindow();\" alt=\"subClose\" width=\"95\" height=\"24\" border=\"0\/></td>"+
						"<td width=\"25%\"><img src=\"../../images/next.png\" onClick=\"showLocationWindow();\" alt=\"subNext\" width=\"95\" height=\"24\" border=\"0\/></td>"+
						"<td width=\"25%\">&nbsp;</td>"+
						
					  "</tr>"+
					"</table></td>"+
				  "</tr>"+
			"</table>"	;
			
	var popupbox = document.createElement("div");
     popupbox.id = "popupsubstore";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 1;
     popupbox.style.left = 250 + 'px';
     popupbox.style.top = 100 + 'px';  
	 popupbox.innerHTML = myHtmlSubStoreForm;     
     document.body.appendChild(popupbox);
}


function showLocationWindow()
{
	if (document.getElementById("cboSubStores").value=="")
	{
		alert("Please Select a Sub Store")
		return false;
	}
	else
	{
		sid=document.getElementById("cboSubStores").value;	
	}	
	
	try
	{
		document.getElementById('popuplocation').style.visibility = 'visible';
		document.getElementById('popupsubstore').style.visibility = 'hidden';
		var strObj=document.getElementById('popupBins');
		if(strObj!=null)
		{
			document.getElementById('popupBins').style.visibility = 'hidden';
		}
		RemoveAvailableSLocationList()
		LoadLocations(sid);
		return;
	}
	catch(err)
	{        
	}	


	
	var selectedSubStore =  document.getElementById("cboSubStores").options[document.getElementById("cboSubStores").selectedIndex].text;
	//alert(document.getElementById("cboSubStores").value);
	LoadLocations(document.getElementById("cboSubStores").value);
	
	var myHtmlLocationForm="<table width=\"500\" border=\"0\">"+
  "<tr>"+
    "<td width=\"486\" height=\"24\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Stores Location Wizard</td>"+
  "</tr>"+
  "<tr>"+
    "<td height=\"203\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
      "<tr>"+
      	"<td height=\"20\" colspan=\"3\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Store Locations For : " + selectedSubStore + "</td>"+
        "</tr>"+
      "<tr>"+
        "<td width=\"48%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">Select</td>"+
        "<td width=\"4%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">&nbsp;</td>"+
        "<td width=\"48%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">New</td>"+
      "</tr>"+
      "<tr>"+
        "<td height=\"141\" valign=\"top\"><select name=\"cboLocations\" size=\"10\" class=\"txtbox\" id=\"cboLocations\" style=\"width:225px\">"+
        "</select></td>"+
        "<td>&nbsp;</td>"+
        "<td valign=\"top\"><table width=\"100%\" border=\"0\" class=\"backcolorGreen\">"+
          "<tr>"+
            "<td class=\"normalfnt\">Name</td>"+
          "</tr>"+
          "<tr>"+
            "<td><input name=\"txtLocName\" type=\"text\" class=\"txtbox\" id=\"txtLocName\" size=\"35\" /></td>"+
          "</tr>"+
          "<tr>"+
            "<td class=\"normalfnt\">Remarks</td>"+
          "</tr>"+
          "<tr>"+
            "<td><textarea name=\"txtLocRemarks\" id=\"txtLocRemarks\" cols=\"25\" rows=\"3\"></textarea></td>"+
          "</tr>"+
          "<tr>"+
            "<td bgcolor=\"#D6E7F5\"><div align=\"right\"><img src=\"../../images/addsmall.png\" onClick=\"SaveNewLocation(mid,sid)\" alt=\"locationAdd\" width=\"95\" height=\"24\" /></div></td>"+
          "</tr>"+
          "</table></td>"+
      "</tr>"+
      "<tr>"+
        "<td height=\"15\" colspan=\"3\" class=\"normaltxtmidb2L\">&nbsp;</td>"+
        "</tr>"+
    "</table></td>"+
  "</tr>"+
  "<tr>"+
    "<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">"+
      "<tr>"+
        "<td width=\"25%\">&nbsp;</td>"+
        
		"<td width=\"25%\"><img src=\"../../images/back.png\" onClick=\"showSubStoresWindow();\" alt=\"locClose\" width=\"95\" height=\"24\" border=\"0\/></td>"+
		
        "<td width=\"25%\"><img src=\"../../images/next.png\" onClick=\"showBinWindow();\" alt=\"locNext\" width=\"95\" height=\"24\" border=\"0\/></td>"+
		
        "<td width=\"25%\">&nbsp;</td>"+
      "</tr>"+
    "</table></td>"+
  "</tr>"+
"</table>"
	
	var popupbox = document.createElement("div");
     popupbox.id = "popuplocation";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 1;
     popupbox.style.left = 250 + 'px';
     popupbox.style.top = 100 + 'px';  
	 popupbox.innerHTML = myHtmlLocationForm;     
     document.body.appendChild(popupbox);
	
}




function getRowNo(obj)
{
	var index;
	index = obj.parentNode.rowIndex;
	bid = obj.parentNode.cells[0].firstChild.nodeValue;
	strBin= obj.parentNode.cells[1].firstChild.nodeValue;

	try
	{
		
		
		var strbinAll=document.getElementById('popupBins');
		if(strbinAll!=null)
		{
			document.getElementById('popupBins').style.visibility =  'hidden';
		}
		var strbinAll=document.getElementById('popuplocation');
		if(strbinAll!=null)
		{
			document.getElementById('popuplocation').style.visibility = 'hidden';
		}
		var strbinAll=document.getElementById('popupsubstore');
		if(strbinAll!=null)
		{
			document.getElementById('popupsubstore').style.visibility ='hidden';
		}
		var strbinAll=document.getElementById('popupbox');
		if(strbinAll!=null)
		{
			document.getElementById('popupbox').style.visibility ='hidden';
		}
		var strbinAll=document.getElementById('popupBinAvailableAllowcation');
		if(strbinAll!=null)
		{
			document.getElementById('popupBinAvailableAllowcation').style.visibility = 'hidden';	
		}
		
		document.getElementById('popupBinAllowcation').style.visibility ='visible';
		return
	}

	catch(err)
	{        
	}

	
	if(bid!="")
	{
		showHtmlBinAllocation(bid,strBin)
		
/*		RemoveMatSubcategories()
		RemoveUnits()*/
		
		LoadMatSubCatogories();
		LoadUnits();

	}
	
}



function showBinWindow()
{
	if (document.getElementById("cboLocations").value=="")
	{
		alert("Please Select a Location")
		return false;
	}
	else
	{
		lid=document.getElementById("cboLocations").value;	
	}
	
	
	try
	{

		var strbinAll=document.getElementById('popupBinAllowcation');
		if(strbinAll!=null)
		{
			document.getElementById('popupBinAllowcation').style.visibility =  'hidden';
		}
		var strbinAll=document.getElementById('popuplocation');
		if(strbinAll!=null)
		{
			document.getElementById('popuplocation').style.visibility = 'hidden';
		}
		var strbinAll=document.getElementById('popupsubstore');
		if(strbinAll!=null)
		{
			document.getElementById('popupsubstore').style.visibility ='hidden';
		}
		var strbinAll=document.getElementById('popupbox');
		if(strbinAll!=null)
		{
			document.getElementById('popupbox').style.visibility ='hidden';
		}
		var strbinAll=document.getElementById('popupBinAvailableAllowcation');
		if(strbinAll!=null)
		{
			document.getElementById('popupBinAvailableAllowcation').style.visibility = 'hidden';	
		}
		
		document.getElementById('popupBins').style.visibility ='visible';
		
		
		
		var strBinTable="<table id=\"tblBins\" width=\"600\"  class=\"normalfnt2\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#99CCFF\" id=\"tblBins\">"+
						"<tr>"+
						"<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Serial</td>"+
						"<td width=\"50%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin</td>"+
						"<td width=\"25%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks</td>"+
						"<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Manage</td>"+
						"<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">View</td>"+
						"</tr>"+
						"</table>"
		document.getElementById("divBins").innerHTML=strBinTable
		
		LoadBins(lid)
		return;
	}
	catch(err)
	{        
	}
	

	
	var selectedLocation =  document.getElementById("cboLocations").options[document.getElementById("cboLocations").selectedIndex].text;
	
	LoadBins(document.getElementById("cboLocations").value);
	
/*	var myHtmlBinForm="<table width=\"500\" border=\"0\">"+
  "<tr>"+
    "<td width=\"486\" height=\"24\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Stores Location Wizard</td>"+
  "</tr>"+
  "<tr>"+
    "<td height=\"203\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
      "<tr>"+
      	"<td height=\"20\" colspan=\"3\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Store Bins For: " + selectedLocation + "</td>"+
        "</tr>"+
      "<tr>"+
        "<td width=\"48%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">Select</td>"+
        "<td width=\"4%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">&nbsp;</td>"+
        "<td width=\"48%\" bgcolor=\"#D6E7F5\" class=\"normalfnt2BI\">New</td>"+
      "</tr>"+
      "<tr>"+
        "<td height=\"141\" valign=\"top\"><select name=\"cboBins\" size=\"10\" class=\"txtbox\" id=\"cboBins\" style=\"width:225px\">"+
        "</select></td>"+
        "<td>&nbsp;</td>"+
        "<td valign=\"top\"><table width=\"100%\" border=\"0\" class=\"backcolorGreen\">"+
          "<tr>"+
            "<td class=\"normalfnt\">Name</td>"+
          "</tr>"+
          "<tr>"+
            "<td><input name=\"txtBinName\" type=\"text\" class=\"txtbox\" id=\"txtBinName\" size=\"35\" /></td>"+
          "</tr>"+
          "<tr>"+
            "<td class=\"normalfnt\">Remarks</td>"+
          "</tr>"+
          "<tr>"+
            "<td><textarea name=\"txtBinRemarks\" id=\"txtBinRemarks\" cols=\"25\" rows=\"3\"></textarea></td>"+
          "</tr>"+
          "<tr>"+
            "<td bgcolor=\"#D6E7F5\"><div align=\"right\"><img src=\"../../images/addsmall.png\" onClick=\"SaveNewBin(mid,sid,lid)\" alt=\"locationAdd\" width=\"95\" height=\"24\" /></div></td>"+
          "</tr>"+
          "</table></td>"+
      "</tr>"+
      "<tr>"+
        "<td height=\"15\" colspan=\"3\" class=\"normaltxtmidb2L\">&nbsp;</td>"+
        "</tr>"+
    "</table></td>"+
  "</tr>"+
  "<tr>"+
    "<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">"+
      "<tr>"+
        "<td width=\"25%\">&nbsp;</td>"+
        
		"<td width=\"25%\"><img src=\"../../images/back.png\" onClick=\"showLocationWindow();\" alt=\"BINClose\" width=\"95\" height=\"24\" border=\"0\/></td>"+
		
        "<td width=\"25%\"><img src=\"../../images/next.png\"  alt=\"BINNext\" width=\"95\" height=\"24\" border=\"0\/></td>"+
		
        "<td width=\"25%\">&nbsp;</td>"+
      "</tr>"+
    "</table></td>"+
  "</tr>"+
"</table>"*/
	
	
	var myBinForm="<table width=\"950\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
  "<tr>"+
    "<td>&nbsp;</td>"+
  "</tr>"+
  "<tr>"+
    "<td><table width=\"100%\" border=\"0\">"+
      "<tr>"+
        "<td width=\"15%\">&nbsp;</td>"+
        "<td width=\"55%\"><form>"+
          "<table width=\"75%\" border=\"0\">"+
            "<tr>"+
              "<td height=\"16\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Bin Management</td>"+
            "</tr>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"7\" bgcolor=\"#80AED5\" class=\"TitleN2white\"><div align=\"left\">Store Bin For : " + selectedLocation + "</div></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"165\"><table width=\"100%\" height=\"165\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr class=\"bcgl1\">"+
                    "<td width=\"100%\"><table width=\"94%\" border=\"0\" class=\"bcgl1\">"+
                        "<tr>"+
                          "<td colspan=\"3\"><div id=\"divBins\" style=\"overflow:scroll; height:130px; width:620px;\">"+
                              "<table id=\"tblBins\" width=\"600\"  class=\"normalfnt2\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#99CCFF\" id=\"tblBins\">"+
                                "<tr>"+
                                  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Serial</td>"+
                                  "<td width=\"50%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Bin</td>"+
                                  "<td width=\"25%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks</td>"+
                                  "<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Manage</td>"+
                                  "<td width=\"15%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">View</td>"+
                                "</tr>"+
                                "<tr>"+
                                  /*"<td><div align=\"center\">"+
								  "<td id=\"td1\" class=\"bcgl1 normalfnt style1\"></td>"+
                                  "<td id=\"td2\" class=\"normalfntMid\">&nbsp;</td>"+
                                  "<td id=\"td3\" class=\"normalfntMid\">&nbsp;</td>"+
                                  "<td  class=\"bcgl1\"><div align=\"center\"><img src=\"../../images/manage.png\" onclick=\"getRowNo(this.parentNode.parentNode)\" alt=\"MANAGE\" width=\"16\" height=\"16\" /></div></td>"+*/
 
 								"</tr>"+
                                /*"<tr>"+
                                  "<td class=\"normalfntMid\"></td>"+
                                  "<td class=\"normalfntMid\">&nbsp;</td>"+
                                  "<td class=\"normalfntMid\">&nbsp;</td>"+
                                  "<td class=\"bcgl1\"><div align=\"center\"><img src=\"../../images/manage.png\" alt=\"MANAGE\" width=\"16\" height=\"16\" /></div></td>"+
                                "</tr>"+
                                "<tr>"+
                                  "<td class=\"normalfntMid\"></td>"+
                                  "<td class=\"normalfntMid\">&nbsp;</td>"+
                                  "<td class=\"normalfntMid\">&nbsp;</td>"+
                                  "<td class=\"bcgl1\"><div align=\"center\"><img src=\"../../images/manage.png\" alt=\"MANAGE\" width=\"16\" height=\"16\" /></div></td>"+
                                "</tr>"+*/
                              "</table>"+
                          "</div></td>"+
                        "</tr>"+
                    "</table></td>"+
                  "</tr>"+
                  "<tr class=\"bcgl1\">"+
                    "<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl2Lbl\">"+
                      "<tr>"+
                        "<td height=\"17\" colspan=\"4\" class=\"normalfnBLD1 backcolorGreen\">New bin</td>"+
                        "</tr>"+
                      "<tr>"+
                        "<td width=\"18%\" height=\"26\" class=\"normalfnt\">Bin Name</td>"+
                        "<td width=\"31%\" class=\"normalfnt\"><input name=\"txtBinName\" type=\"text\" class=\"txtbox\" id=\"txtBinName\" /></td>"+
                        "<td width=\"13%\" class=\"normalfnt\">Remarks</td>"+
                        "<td width=\"38%\" class=\"normalfnt\"><input name=\"txtBinRemark\" type=\"text\" class=\"txtbox\" id=\"txtBinRemark\" size=\"30\" /></td>"+
                      "</tr>"+
                      "<tr>"+
                        "<td height=\"24\" bgcolor=\"#D6E7F5\">&nbsp;</td>"+
                        "<td bgcolor=\"#D6E7F5\">&nbsp;</td>"+
                        "<td bgcolor=\"#D6E7F5\">&nbsp;</td>"+
                        "<td bgcolor=\"#D6E7F5\"><div align=\"right\"><img src=\"../../images/addsmall.png\" onClick=\"SaveNewBin(mid,sid,lid)\" alt=\"add\" width=\"95\" height=\"24\" /></div></td>"+
                      "</tr>"+
                    "</table></td>"+
                  "</tr>"+
                  "<tr class=\"bcgl1\">"+
                    "<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">"+
                        "<tr>"+
                          "<td width=\"80%\">&nbsp;</td>"+
                          "<td width=\"20%\"><span class=\"normalfntp2\"><img src=\"../../images/close.png\" onClick=\"showLocationWindow();\" alt=\"close\" width=\"97\" height=\"24\" /></span></td>"+
                        "</tr>"+
                    "</table></td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>"+
        "</form></td>"+
        "<td width=\"30%\">&nbsp;</td>"+
      "</tr>"+
    "</table></td>"+
  "</tr>"+
  "<tr>"+
    "<td>&nbsp;</td>"+
  "</tr>"+
"</table>"
	
	var popupbox = document.createElement("div");
     popupbox.id = "popupBins";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 1;
     popupbox.style.left = 120 + 'px';
     popupbox.style.top = 50 + 'px';  
	 popupbox.innerHTML = myBinForm;     
     document.body.appendChild(popupbox);
	
}

function addRow(theLink)
{
		  theRow = theLink.parentNode.parentNode;
		  theBod=theRow.parentNode;
		//cboCategory Validation
		  var rowId=theBod.rows[theBod.rows.length-1].cells[0].firstChild.id;
		  //rowId=rowId.substring(0,11)+(parseInt(rowId.substring(11,rowId.length))+1);
		//cboUnit Validation
		  var rowId2=theBod.rows[theBod.rows.length-1].cells[1].firstChild.id;
		  //rowId2=rowId2.substring(0,7)+(parseInt(rowId2.substring(7,rowId2.length))+1);
		//txtQty Validation
		  var rowId3=theBod.rows[theBod.rows.length-1].cells[2].firstChild.id;
		  //rowId3=rowId3.substring(0,6)+(parseInt(rowId3.substring(6,rowId3.length))+1);
		//txtRemarks Validation
		  var rowId4=theBod.rows[theBod.rows.length-1].cells[3].firstChild.id;
		  //rowId4=rowId4.substring(0,9)+(parseInt(rowId4.substring(9,rowId4.length))+1);
		  
		  theTable=theRow.parentNode;
		  newRow = theRow.cloneNode(true);
		  theBod.appendChild(newRow);
		  
		  newRow.cells[0].firstChild.id=rowId;
		  newRow.cells[0].firstChild.name=rowId;
		  newRow.cells[0].firstChild.value=0;

          newRow.cells[1].firstChild.id=rowId2;
		  newRow.cells[1].firstChild.name=rowId2;
		  newRow.cells[1].firstChild.value=0;

		  newRow.cells[2].firstChild.id=rowId3;
		  newRow.cells[2].firstChild.name=rowId3;
		  newRow.cells[2].firstChild.value="";
		  
		  newRow.cells[3].firstChild.id=rowId4;
		  newRow.cells[3].firstChild.name=rowId4;
		  newRow.cells[3].firstChild.value="";
		  
		  return false;
}

function removeRow(theLink)
{
	var otable=document.getElementById("tblCats");
	var noOfRows=otable.rows.length
	if(noOfRows>2)
	{
		theRow = theLink.parentNode.parentNode;
		theBod=theRow.parentNode;
		var nod=theRow.rowIndex
		theBod.removeChild(theRow);
	}
	else
	{
		alert("You can not remove this row")
		return false
	}
}
	
	function clearAvlBinAllowcation()
	{
		var oDiv = document.getElementById('tblCats').rows.length

		try
		{
			document.getElementById('popupBins').style.visibility =  'visible';
			document.getElementById('popuplocation').style.visibility = 'hidden';
			document.getElementById('popupBinAllowcation').style.visibility ='hidden';
			document.getElementById('popupsubstore').style.visibility ='hidden';
			document.getElementById('popupbox').style.visibility ='hidden';	
		}
		catch(err)
		{
		}

		var row=document.getElementById('tblCats').getElementsByTagName("TR")
		for(var loop=1;loop<row.length;loop++)
		{
			var cell=row[loop].getElementsByTagName("TD")
			cell[0].firstChild.value=0
			cell[1].firstChild.value=0
			cell[2].firstChild.value=""
			cell[3].firstChild.value=""
		}
		
		for(var i=2;i<row.length;i++)
		{
			document.getElementById('tblCats').deleteRow(2);
		}

		showBinWindow()
	}
	
	
	
	function validate(f)
	{
		var qty=0 
		var Remark 
		var catagory 
		var units 
		var ctr=0;

		
		//deleteBinAllocation(bid)
		var row = document.getElementById('tblCats').getElementsByTagName("TR")
		for(var i=1;i<row.length;i++)
		{
			//alert(document.getElementById('tblCats').rows[i].cells[0].firstChild.value)
			var cell=row[i].getElementsByTagName("TD")
			
			//if(document.getElementById('tblCats').rows[i].cells[0].firstChild.value==0)
			if(cell[0].firstChild.value==0)
			{
				alert("You left this Sub Category blank..." );
				//document.getElementById('tblCats').rows[i].cells[0].firstChild.focus();
				cell[0].firstChild.focus()
				return false;
			}
			
			//else if(document.getElementById('tblCats').rows[i].cells[1].firstChild.value==0)
			else if(cell[1].firstChild.value==0)
			{
				alert("You left this Unit blank..." );
				//document.getElementById('tblCats').rows[i].cells[1].firstChild.focus();
				cell[1].firstChild.focus()
				return false;
			}
			
			//else if(document.getElementById('tblCats').rows[i].cells[2].firstChild.value=="")
			else if(cell[2].firstChild.value=="")
			{
				alert("You left this Quantity blank..." );
				//document.getElementById('tblCats').rows[i].cells[2].firstChild.focus();
				cell[2].firstChild.focus()
				return false;
			}
			else if(isNaN(cell[2].firstChild.value)==true)
			{
				alert(cell[2].firstChild.value)
				alert("Invalied Quantity..." );
				//document.getElementById('tblCats').rows[i].cells[2].firstChild.focus();
				cell[2].firstChild.focus()
				return false;
			}
			
			else
			{
			
			
			catagory=cell[0].firstChild.value	//document.getElementById('tblCats').rows[i].cells[0].firstChild.value
			units=cell[1].firstChild.value		//document.getElementById('tblCats').rows[i].cells[1].firstChild.value
			qty=parseFloat(cell[2].firstChild.value)		//document.getElementById('tblCats').rows[i].cells[2].firstChild.value
			Remark=cell[3].firstChild.value		//document.getElementById('tblCats').rows[i].cells[3].firstChild.value

			BinAllocationSave(catagory,units,qty,Remark)
			}	
		}
		
		alert("Bin (" + strBin + ") Allocated successfully.");
	}


function deleteBinAllocation(bid)
{
	createHtmlXmlBinAllocation();
    binAllowcationXmlHttp.onreadystatechange = HandleSaveBinAllocation;
	binAllowcationXmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=deleteBinAllocation&intBinID='+bid, true);
	binAllowcationXmlHttp.send(null);  
	
}

function BinAllocationSave(SubCatID,UnitID,Quantity,Remarks)
{
	createHtmlXmlBinAllocation();
    binAllowcationXmlHttp.onreadystatechange = HandleSaveBinAllocation;
	binAllowcationXmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=SaveBinAllocation&intMainID=' + mid + '&intSubID='+ sid +'&intLocID='+ lid +'&intBinID='+ bid +'&intSubCatID='+ SubCatID +'&strUnitID='+ UnitID +'&dblQty='+ Quantity +'&strRemarks=' +  Remarks, true);
    
	
	binAllowcationXmlHttp.send(null);  
	
}

function HandleSaveBinAllocation()
{
    if(binAllowcationXmlHttp.readyState == 4) 
    {
        if(binAllowcationXmlHttp.status == 200) 
        {  
			var XMLResult = binAllowcationXmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				//document.getElementById("txtname").value = "";
				//document.getElementById("txtremarks").value = "";
				//clearSelectControl("cboMainStores");
//				LoadMainStores();
				//alert("Bin (" + strBin + ") Allocated successfully.");
			}
			else
			{
				alert("Process Failed.");
			}
		}
	}
}


function showHtmlBinAllocation(intBinID,strBinName)
{
	
	try
	{
		
		var strBA=document.getElementById('popupBins');
		if(strBA!=null)
		{
			document.getElementById('popupBins').style.visibility =  'hidden';
		}
		var strBA=document.getElementById('popuplocation');
		if(strBA!=null)
		{
			document.getElementById('popuplocation').style.visibility = 'hidden';
		}
		var strBA=document.getElementById('popupsubstore');
		if(strBA!=null)
		{
			document.getElementById('popupsubstore').style.visibility ='hidden';
		}
		var strBA=document.getElementById('popupbox');
		if(strBA!=null)
		{
			document.getElementById('popupbox').style.visibility ='hidden';
		}
		var strBA=document.getElementById('popupBinAvailableAllowcation');
		if(strBA!=null)
		{
			document.getElementById('popupBinAvailableAllowcation').style.visibility ='hidden';
		}
		
		document.getElementById('popupBinAllowcation').style.visibility ='visible';
		
		return;
	}

	catch(err)
	{        
	}
	

//NEW HTML ===================================================================================

var newHtmlForm="<table id=\"tblCategories \" width=\"744\" height=\"160\" border=\"1\" bordercolor=\"#FFFFFF\"  >"+
	  "<tr>"+
		"<td height=\"32\" colspan=\"4\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >Bin Allocation</td>"+
	  "</tr>"+
	  "<tr>"+	
		"<td height=\"32\" colspan=\"4\" bgcolor=\"#80AED5\" class=\"TitleN2white\" ><div align=\"left\">Bin Allocation for :"+ strBinName +"</td>"+
	  "</tr>"+
	  "<tr bordercolor=\"#0000FF\">"+
		"<td colspan=\"4\"><table id=\"tblCats\" width=\"737\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">"+
		  "<tr>"+
			"<td bgcolor=\"#498CC2\"><div  align=\"center\" class=\"normaltxtmidb2\">Sub Category</div></td>"+
			"<td bgcolor=\"#498CC2\"><div align=\"center\" class=\"normaltxtmidb2\">Units</div></td>"+
			"<td width=\"60\" bgcolor=\"#498CC2\"><div align=\"center\" class=\"normaltxtmidb2\">Quantity</div></td>"+
			"<td width=\"212\" bgcolor=\"#498CC2\"><div align=\"center\" class=\"normaltxtmidb2\">Remarks</div></td>"+
			"<td bgcolor=\"#498CC2\"><div align=\"center\" class=\"normaltxtmidb2\">Add</div></td>"+
			"<td bgcolor=\"#498CC2\"><div align=\"center\" class=\"normaltxtmidb2\">Del</div></td>"+
		  "</tr>"+
		  "<tr>"+
			"<td width=\"250\" height=\"26\" bordercolor=\"#E6F2FF\"><select name=\"cboCategory1\" id=\"cboCategory1\" style=\"width:250px\" >"+
				"</select></td>"+
			"<td width=\"120\" bordercolor=\"#E6F2FF\"><select name=\"cboUnit1\" id=\"cboUnit1\" style=\"width:120px\"  >"+
			"</select></td>"+
			"<td><input type=\"text\" size=\"10\" id=\"txtQty1\" name=\"txtQty1\"></td>"+
			"<td><input type=\"text\" size=\"50\" id=\"txtRemark1\" name=\"txtRemark1\" style=\"width:210px\"></td>"+
			"<td width=\"27\" bordercolor=\"#E6F2FF\"><img src=\"../../images/add.png\"  alt=\"a\" width=\"16\" height=\"16\" onClick=\"addRow(this);return false;\"  onmouseover=\"highlight(this.parentNode)\" ></td>"+
			"<td width=\"30\" bordercolor=\"#E6F2FF\"><img src=\"../../images/del.png\"  alt=\"a\" width=\"15\" height=\"15\" onClick=\"removeRow(this);return false;\"  onmouseover=\"highlight(this.parentNode)\"></td>"+
		  "</tr>"+
		"</table></td>"+
	  "</tr>"+
	  "<tr>"+
		"<td eight=\"29\" colspan=\"4\" bgcolor=\"#D6E7F5\">&nbsp;</td>"+
	  "</tr>"+
	  "<tr bordercolor=\"#D6E7F5\">"+
		"<td width=\"460\" bordercolor=\"#0000FF\" bgcolor=\"#D6E7F5\">&nbsp;</td>"+
		"<td width=\"108\" bordercolor=\"#0000FF\" bgcolor=\"#D6E7F5\"><img src=\"../../images/save.png\" onClick=\"validate(this);\" width=\"95\" height=\"24\" /></td>"+
		"<td width=\"156\" bordercolor=\"#0000FF\" bgcolor=\"#D6E7F5\"><img src=\"../../images/close.png\" onClick=\"clearAvlBinAllowcation();\" width=\"95\" height=\"24\" />&nbsp;</td>"+
	  "</tr>"+
"</table>"

	var popupbox = document.createElement("div");
     popupbox.id = "popupBinAllowcation";
     popupbox.style.position = 'absolute';
     popupbox.style.zIndex = 1;
     popupbox.style.left = 120 + 'px';
     popupbox.style.top = 50 + 'px';  
	 popupbox.innerHTML = newHtmlForm;     
     document.body.appendChild(popupbox);
}


function BinAllocationPopupClose()
{
	try
	{
		document.getElementById('popupBins').style.visibility = 'visible';
		document.getElementById('popupBinAllowcation').style.visibility = 'hidden';
		
		return;
	}
	catch(err)
	{        
	}
}


//MAIN STOERS =========================================================================================================

function LoadMainStores()
{
	//clearSelectControl("cboMainStores");
	RemoveMainStores()
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleMainStores;
    xmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=GetMainStores', true);
	xmlHttp.send(null); 
}

function HandleMainStores()
{	
	
	if(xmlHttp.readyState == 4) 
    {
      
	   if(xmlHttp.status == 200) 
        {  
			
			var XMLStoreID = xmlHttp.responseXML.getElementsByTagName("StoreID");
			var XMLStoreName = xmlHttp.responseXML.getElementsByTagName("StoreName");

			for ( var loop = 0; loop < XMLStoreID.length; loop ++)
			 {

				var StoreID = XMLStoreID[loop].childNodes[0].nodeValue;
				var StoreName = XMLStoreName[loop].childNodes[0].nodeValue;
				var optStore = document.createElement("option");
				//alert(loop + " " + StoreName)
				optStore.text = StoreName;
				optStore.value = StoreID;
				document.getElementById("cboMainStores").options.add(optStore);
			 }
		}
	}
}

function SaveNewStore()
{
	if (!ValidateForm()) return;
	var LocationName = document.getElementById("txtname").value;
	var Remarks = document.getElementById("txtremarks").value;
	
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleSaveMainStores;
    xmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=SaveMainStore&Loca=' + LocationName + '&Remarks=' +  Remarks, true);
    xmlHttp.send(null);  
}

function HandleSaveMainStores()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				document.getElementById("txtname").value = "";
				document.getElementById("txtremarks").value = "";
				clearSelectControl("cboMainStores");
				LoadMainStores();
				alert("New Main Store added successfully.");
			}
			else
			{
				alert("Process Failed.");
			}
		}
	}
}

//SUB STOERS =========================================================================================================

function LoadSubStores(intMainID)
{
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleSubStores;
    altxmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=GetSubStores&MainID=' + 	intMainID, true);
    altxmlHttp.send(null);  
}

function HandleSubStores()
{
   if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  		
			var XMLStoreID = altxmlHttp.responseXML.getElementsByTagName("StoreID");
			var XMLStoreName = altxmlHttp.responseXML.getElementsByTagName("StoreName");			
			for ( var loop = 0; loop < XMLStoreID.length; loop ++)
			 {
				var StoreID = XMLStoreID[loop].childNodes[0].nodeValue;
				var StoreName = XMLStoreName[loop].childNodes[0].nodeValue;
				var optStore2 = document.createElement("option");
				optStore2.text = StoreName;
				optStore2.value = StoreID;
				document.getElementById("cboSubStores").options.add(optStore2);	
			 }
		}
	}
}

function SaveNewSubStore(mid)
{
	if (document.getElementById("cboMainStores").value=="")
	{
		alert("Please select a Main Store")
		return false;
	}
	else
	{
		mid=document.getElementById("cboMainStores").value;	
	}
	
	if (!ValidateSSForm()) return;
	var LocationName = document.getElementById("txtSubName").value;
	var Remarks = document.getElementById("txtSubRemarks").value;
	createAltXMLHttpRequest();
    altxmlHttp.onreadystatechange = HandleSaveSubStores;
    altxmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=SaveSubStore&intMainID=' + mid + '&strName=' + LocationName + '&strRemarks=' +  Remarks, true);
    altxmlHttp.send(null);
	
}

function HandleSaveSubStores()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {  
			var XMLResult = altxmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				document.getElementById("txtSubName").value = "";
				document.getElementById("txtSubRemarks").value = "";
				//clearSelectControl("cboSubStores");
				RemoveAvailableSubstoresList();
				LoadSubStores(mid);
				alert("New Sub Store added successfully.");
			}
			else
			{
				alert("Process Failed.");
			}
		}
	}
}


//LOCATIONS =========================================================================================================


function LoadLocations(intSubID)
{	
	createXMLHttpRequestLOC();
	locxmlHttp.onreadystatechange = HandleLocations;
    locxmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=GetLocations&SubID=' + intSubID, true);
    locxmlHttp.send(null);  
}

function HandleLocations()
{
    if(locxmlHttp.readyState == 4) 
    {
        if(locxmlHttp.status == 200) 
        {  
			
			var XMLStoreID = locxmlHttp.responseXML.getElementsByTagName("StoreID");
			var XMLStoreName = locxmlHttp.responseXML.getElementsByTagName("StoreName");
			for ( var loop = 0; loop < XMLStoreID.length; loop ++)
			 {
				var StoreID = XMLStoreID[loop].childNodes[0].nodeValue;
				var StoreName = XMLStoreName[loop].childNodes[0].nodeValue;
				var optStore3 = document.createElement("option");
				optStore3.text = StoreName;
				optStore3.value = StoreID;
				document.getElementById("cboLocations").options.add(optStore3);	
			 }
		}
	}
}


function SaveNewLocation(mid,sid)
{
	if (!ValidateLocForm()) return;
	var LocationName = document.getElementById("txtLocName").value;
	var Remarks = document.getElementById("txtLocRemarks").value;
	createXMLHttpRequestLOC();
    locxmlHttp.onreadystatechange = HandleSaveLocations;
    locxmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=SaveLocation&intMainID=' + mid + '&intSubID=' + sid + ' &strName=' + LocationName + '&strRemarks=' +  Remarks, true);
    locxmlHttp.send(null);  
}

function HandleSaveLocations()
{
	if(locxmlHttp.readyState == 4) 
    {
        if(locxmlHttp.status == 200) 
        {  
			var XMLResult = locxmlHttp.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				document.getElementById("txtLocName").value = "";
				document.getElementById("txtLocRemarks").value = "";
				//clearSelectControl("cboLocations");
				RemoveAvailableSLocationList();
				LoadLocations(sid);
				alert("New Location added successfully.");
			}
			else
			{
				alert("Process Failed.");
			}
		}
	}
}


// BINS  =========================================================================================================

function clearBinsList()
{
	//var oDiv = document.getElementById('tblBins').rows.length
	var otable=document.getElementById("tblBins");
	while(otable.rows.length>1) 
	{
	otable.deleteRow(otable.rows.length-1); 
	}
}

function LoadBins(intLocID)
{	
	createHtmlXmlBinObj();
	binxmlHttp.onreadystatechange = HandleBins;
	binxmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=GetBins&LocID=' + intLocID, true);
    binxmlHttp.send(null);
}

function HandleBins()
{
	if(binxmlHttp.readyState == 4) 
    {
        if(binxmlHttp.status == 200) 
        {  
			var XMLStoreID = binxmlHttp.responseXML.getElementsByTagName("StoreID");
			var XMLStoreName = binxmlHttp.responseXML.getElementsByTagName("StoreName");
			var XMLStoreRemark = binxmlHttp.responseXML.getElementsByTagName("StoreRemark");
		    
			 
			for ( var loop = 0; loop < XMLStoreID.length; loop ++)
			 {
				var StoreID = XMLStoreID[loop].childNodes[0].nodeValue;
				var StoreName = XMLStoreName[loop].childNodes[0].nodeValue;
				var StoreRemark = XMLStoreRemark[loop].childNodes[0].nodeValue;
		
				var row=document.getElementById("tblBins").insertRow(loop+1);
				//document.getElementById("tblBins").vAlign="center";
				//document.getElementById("bid").align="center";
				var a=row.insertCell(0);
				var b=row.insertCell(1);
				var c=row.insertCell(2);
				a.innerHTML=StoreID;
				b.innerHTML=StoreName;
				c.innerHTML=StoreRemark;
				
				var cellModify = row.insertCell(3);   
			    
				cellModify.innerHTML = "<td  align=\"center\" class=\"normaltxtmidb2\" ><img src=\"../../images/manage.png\" onclick=\"getRowNo(this.parentNode.parentNode)\" onmouseover=\"highlight(this.parentNode)\" id=\" + loop+1 + \" alt=\"manage\" width=\"15\" height=\"15\"  /></td>"
				
				var cellview = row.insertCell(4);   
			    
				cellview.innerHTML ="<td  align=\"center\" class=\"normaltxtmidb2\" ><img src=\"../../images/manage.png\" onclick=\"showBinAvailableAllowcation(this.parentNode.parentNode)\" onmouseover=\"highlight(this.parentNode)\" id=\" + loop+1 + \" alt=\"view\" width=\"15\" height=\"15\"  /></td>"

				//document.getElementById("cboBins").options.add(optStore3);*/
			 }
		}
	}
}

function highlight(o){
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


function SaveNewBin(mid,sid,lid)
{
	var LocationName = document.getElementById("txtBinName").value;
	var Remarks = document.getElementById("txtBinRemark").value;
	
	createHtmlXmlBinObj();
    binxmlHttp.onreadystatechange = HandleSaveBin;
    binxmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=SaveBin&intMainID=' + mid + '&intSubID=' + sid + ' &intLocID=' + lid + '&strName=' + LocationName + '&strRemarks=' +  Remarks, true);
    binxmlHttp.send(null);  
	
}


function HandleSaveBin()
{
    if(binxmlHttp.readyState == 4) 
    {
        if(binxmlHttp.status == 200) 
        {  
			var XMLResult = binxmlHttp.responseXML.getElementsByTagName("Result");
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
			}
		}
	}
}

//LOAD MAT SUB CATEGORY=============================================================================

function LoadMatSubCatogories()
{	
	//clearSelectControl('cboCategory1');
	//RemoveMatSubcategories()
	createHtmlXmlMatSubCat();
	matSubCatmlHttp.onreadystatechange = LoadMatSubCatsHandler;
    matSubCatmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=GetMatSubCatogeris', true);
    matSubCatmlHttp.send(null);  
}

function LoadMatSubCatsHandler()
{
    if(matSubCatmlHttp.readyState == 4) 
    {
        if(matSubCatmlHttp.status == 200) 
        {  
			//clearSelectControl('cboCategory1');
			RemoveMatSubcategories()
			var XMLStoreID = matSubCatmlHttp.responseXML.getElementsByTagName("SubCatNo");
			var XMLStoreName = matSubCatmlHttp.responseXML.getElementsByTagName("CatName");
			
			//--Default Value
			var optStore3 = document.createElement("option");
			optStore3.text = "(Select a Category)";
			optStore3.value = 0;
			document.getElementById("cboCategory1").options.add(optStore3);
			//----
			
			for ( var loop = 0; loop < XMLStoreID.length; loop ++)
			 {
				var SubCatNo = XMLStoreID[loop].childNodes[0].nodeValue;
				var CatName = XMLStoreName[loop].childNodes[0].nodeValue;
				var optStore3 = document.createElement("option");
				optStore3.text = CatName;
				optStore3.value = parseFloat(SubCatNo);
				document.getElementById("cboCategory1").options.add(optStore3);	
			 }
		}
	}
}

//LOAD AVAILABLE MAT SUB CATEGORIES ACCORDING TO THE SELECTED BIN =======================
function LoadAvlMatSubCatogories()
{	
	createHtmlXmlAvlMatSubCat();
	avlMatSubCatmlHttp.onreadystatechange = LoadAvlMatSubCatsHandler;
    avlMatSubCatmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=GetAvlMatSubCatogeris&bid='+bid, true);
    avlMatSubCatmlHttp.send(null); 
	
}

function LoadAvlMatSubCatsHandler()
{
    if(avlMatSubCatmlHttp.readyState == 4) 
    {
        if(avlMatSubCatmlHttp.status == 200) 
        {  
			var XMLMatCatID = avlMatSubCatmlHttp.responseXML.getElementsByTagName("MatCatID");
			var XMLMatCatName = avlMatSubCatmlHttp.responseXML.getElementsByTagName("MatCat");
			var XMLUnitID = avlMatSubCatmlHttp.responseXML.getElementsByTagName("UNITID");
			var XMLQty = avlMatSubCatmlHttp.responseXML.getElementsByTagName("QTY");
			var XMLRemark = avlMatSubCatmlHttp.responseXML.getElementsByTagName("REMARK");

			
			var strbinAvlAllowcated="<table width=\"737\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\" id=\"tblCats\">"+
				"<tr>"+
				"<td height=\"24\" bgcolor=\"#498CC2\"><div  align=\"center\" class=\"normaltxtmidb2\">Cat ID</div></td>"+
				"<td height=\"24\" bgcolor=\"#498CC2\"><div  align=\"center\" class=\"normaltxtmidb2\">Sub Category</div></td>"+
				"<td bgcolor=\"#498CC2\"><div align=\"center\" class=\"normaltxtmidb2\">Units</div></td>"+
				"<td width=\"202\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Remarks</div></td>"+
				"<td width=\"66\" bgcolor=\"#498CC2\"><div align=\"center\" class=\"normaltxtmidb2\">Quantity</div></td>"+
				"<td width=\"30\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Del</td>"+
				"</tr>"
				
				
				if(XMLMatCatID.length==0)
				{
					strbinAvlAllowcated+="</table>"
					document.getElementById("divBinAlloCats").innerHTML=strbinAvlAllowcated
					return;
				}
				
				else
				{
					for(var loop=0;loop<XMLMatCatID.length;loop++)
					{
						var MatCatID = XMLMatCatID[loop].childNodes[0].nodeValue;
						var MatCatName = XMLMatCatName[loop].childNodes[0].nodeValue;
						var UnitID = XMLUnitID[loop].childNodes[0].nodeValue;
						var Qty = XMLQty[loop].childNodes[0].nodeValue;
						var Remark = XMLRemark[loop].childNodes[0].nodeValue;
						
						/*var cell=row[loopT].getElementsByTagName("TD")
						cell[0].firstChild.value=parseFloat(MatCatID)
						cell[1].firstChild.value=UnitID
						cell[2].firstChild.value=Qty
						cell[3].firstChild.value=Remark*/
					strbinAvlAllowcated+="<tr>"+
											"<td width=\"50\" height=\"20\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" >" + MatCatID + "</td>"+
											"<td width=\"220\" height=\"20\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" >" + MatCatName + "</td>"+
											"<td width=\"131\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" >" + UnitID + "</td>"+
											"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" >" + Remark + "</td>"+
											"<td class=\"normalfnt\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\" >" + Qty + "</td>"+
											"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" ><img src=\"../../images/del.png\" onClick=\"deleteTheSelectedAllData(this);\" width=\"15\" height=\"15\" /></td>"+
											"</tr>"
																
						
					}
				
					strbinAvlAllowcated+="</table>"
					document.getElementById("divBinAlloCats").innerHTML=strbinAvlAllowcated
				}
		}
	}
}



//LOAD UNITS=============================================================================

function LoadUnits()
{	
	//clearSelectControl('cboUnit1');
	
	createHtmlXmlUnits();
	unitXmlHttp.onreadystatechange = LoadUnitsHandler;
    unitXmlHttp.open("GET", 'StoreLocatorWizard.php?RequestType=GetUnits', true);
    unitXmlHttp.send(null);  
}

function LoadUnitsHandler()
{
    if(unitXmlHttp.readyState == 4) 
    {
        if(unitXmlHttp.status == 200) 
        {  
			//clearSelectControl('cboUnit1');
			RemoveUnits()
			var XMLUnit = unitXmlHttp.responseXML.getElementsByTagName("strUnit");
			
			//--Default Value
			var optStore2 = document.createElement("option");
			optStore2.text = "(Select a Unit)";
			optStore2.value = 0;
			document.getElementById("cboUnit1").options.add(optStore2);
			//----
			
			for ( var loop = 0; loop < XMLUnit.length; loop ++)
			 {
				var unitID = XMLUnit[loop].childNodes[0].nodeValue;
				var optStore2 = document.createElement("option");
				optStore2.text = unitID;
				optStore2.value = unitID;
				document.getElementById("cboUnit1").options.add(optStore2);	
			 }
		}
	}
}



//============================================================================================
function ValidateForm()
{
	if (document.getElementById("txtname").value== "")
	{
		alert("Please Enter Name of Main Store.");
		document.getElementById("txtname").focus();
		return false;
	}
	else if (CheckitemAvailability(document.getElementById("txtname").value, document.getElementById("cboMainStores"), false))
	{
		alert("The Main Store Name already exists.");	
		document.getElementById("txtname").focus();
		return false;
	}
	return true;
}

function ValidateSSForm()
{
	if (document.getElementById("txtSubName").value=="")
	{
		alert("Please Enter Name of Sub Store.");
		document.getElementById("txtSubName").focus();
		return false;
	}
	else if (CheckitemAvailability(document.getElementById("txtSubName").value, document.getElementById("cboSubStores"), false))
	{
		alert("The Sub Store Name already exists.");	
		document.getElementById("txtSubName").focus();
		return false;
	}
	return true;
}

function ValidateLocForm()
{
	if (document.getElementById("txtLocName").value== "")
	{
		alert("Please Enter Name of Location.");
		document.getElementById("txtLocName").focus();
		return false;
	}
	else if (CheckitemAvailability(document.getElementById("txtLocName").value, document.getElementById("cboLocations"), false))
	{
		alert("The Location Name already exists.");	
		document.getElementById("txtLocName").focus();
		return false;
	}
	return true;
}

function ValidateBinForm()
{
	if (document.getElementById("txtBinName").value== "")
	{
		alert("Please Enter Name of Bin.");
		document.getElementById("txtBinName").focus();
		return false;
	}
	else if (CheckitemAvailability(document.getElementById("txtBinName").value, document.getElementById("cboBins"), false))
	{
		alert("The Bin Name already exists.");	
		document.getElementById("txtBinName").focus();
		return false;
	}
	return true;
}

function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text == itemName)
		{
			if (message)
				alert("The property \"" + itemName + "\" is already exists in the list.");
			return true;			
		}
	}
	return false;
}


//function clearSelectControl2(cboid)
//{
//	var selectObj = document.getElementById(cboid);
//	//var selectParentNode = selectObj.parentNode;
//	var newSelectObj = selectObj.cloneNode(false); 
//	selectParentNode.replaceChild(newSelectObj, selectObj);
//	return newSelectObj;
//}

function clearSelectControl(cboid)
{
   
   var select=document.getElementById(cboid);
   if(select!=null)
   {
	   var options=select.getElementsByTagName("option");
	   var i;
	   for (i=0; i<options.length; i++)
	   {
		  select.removeChild(options[0]);
	   }
   }
}


function checkParentValue(cboid)
{
	var prmid=(document.getElementById(cboid).value);	
	if(prmid=="")
	{
		alert("Please Select a Category");
		return false;
	}
	else
	{
		alert(prmid);
		return true;
	}
}

function RemoveAvailableSubstoresList()
{
	var optLength = document.getElementById("cboSubStores").options.length;
	for(var loop=0;loop<optLength ;loop++) 
	{
		document.getElementById("cboSubStores").options[0] = null;
	}
}

function RemoveAvailableSLocationList()
{
	var optLength = document.getElementById("cboLocations").options.length;
	for(var loop=0;loop<optLength ;loop++) 
	{
		document.getElementById("cboLocations").options[0] = null;
	}
}

function RemoveMatSubcategories()
{
	var optLength = document.getElementById("cboCategory1").options.length;
	for(var loop=0;loop<optLength ;loop++) 
	{
		document.getElementById("cboCategory1").options[0] = null;
	}
}


function RemoveUnits()
{
	var optLength = document.getElementById("cboUnit1").options.length;
	for(var loop=0;loop<optLength ;loop++) 
	{
		document.getElementById("cboUnit1").options[0] = null;
	}
}

function RemoveMainStores()
{
	var optLength = document.getElementById("cboMainStores").options.length;
	for(var loop=0;loop<optLength ;loop++) 
	{
		document.getElementById("cboMainStores").options[0] = null;
	}
}

function showBinAvailableAllowcation(obj)
{
	bid = obj.parentNode.cells[0].firstChild.nodeValue;
	strBinName= obj.parentNode.cells[1].firstChild.nodeValue;
	
	try
	{
		var strBA=document.getElementById('popupBinAllowcation');
		if(strBA!=null)
		{
			document.getElementById('popupBinAllowcation').style.visibility ='hidden';
		}
		var strBA=document.getElementById('popupBins');
		if(strBA!=null)
		{
			document.getElementById('popupBins').style.visibility =  'hidden';
		}		
		var strBA=document.getElementById('popuplocation');
		if(strBA!=null)
		{
			document.getElementById('popuplocation').style.visibility = 'hidden';
		}
		var strBA=document.getElementById('popupsubstore');
		if(strBA!=null)
		{
			document.getElementById('popupsubstore').style.visibility ='hidden';
		}
		var strBA=document.getElementById('popupbox');
		if(strBA!=null)
		{
			document.getElementById('popupbox').style.visibility ='hidden';		
		}

	
		document.getElementById('popupBinAvailableAllowcation').style.visibility ='visible';
		LoadAvlMatSubCatogories()
		
		return;
	}
	
	catch(err)
	{        
	}	
	
	var strBinAvlAllowcation="<table width=\"744\" height=\"160\"  bordercolor=\"#FFFFFF\"  id=\"tblCategories \"  >"+
						"<tr>"+
						"<td height=\"32\" colspan=\"4\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >Bin Allocation</td>"+
						"</tr>"+
						"<tr>	"+
						"<td height=\"32\" colspan=\"4\" bgcolor=\"#80AED5\" class=\"TitleN2white\" ><div align=\"left\">Bin Allocation for :"+ strBinName + "</td>"+
						"</tr>"+
						"<tr bordercolor=\"#0000FF\">"+
						"<td colspan=\"4\">"+
						"<div id=\"divBinAlloCats\" style=\"height:200px;overflow:scroll\" class=\"bcgl1\">"+
						"<table width=\"737\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\" id=\"tblCats\">"+
						"<tr>"+
						"<td height=\"24\" bgcolor=\"#498CC2\"><div  align=\"center\" class=\"normaltxtmidb2\">Cat ID</div></td>"+
						"<td height=\"24\" bgcolor=\"#498CC2\"><div  align=\"center\" class=\"normaltxtmidb2\">Sub Category</div></td>"+
						"<td bgcolor=\"#498CC2\"><div align=\"center\" class=\"normaltxtmidb2\">Units</div></td>"+
						"<td width=\"202\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><div align=\"center\">Remarks</div></td>"+
						"<td width=\"66\" bgcolor=\"#498CC2\"><div align=\"center\" class=\"normaltxtmidb2\">Quantity</div></td>"+
						"<td width=\"30\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Del</td>"+
						"</tr>"+
						"</table>"+
						"</div>"+
						"</td>"+
						"</tr>"+
						"<tr bordercolor=\"#D6E7F5\">"+
						"<td width=\"460\" bordercolor=\"#0000FF\" bgcolor=\"#D6E7F5\">&nbsp;</td>"+
						"<td width=\"108\" bordercolor=\"#0000FF\" bgcolor=\"#D6E7F5\">&nbsp;</td>"+
						"<td width=\"156\" bordercolor=\"#0000FF\" bgcolor=\"#D6E7F5\"><img src=\"../../images/close.png\" onClick=\"showBinWindow();\" width=\"97\" height=\"24\" />&nbsp;</td>"+
						"</tr>"+
						"</table>"
						
		var popupbox = document.createElement("div");
		popupbox.id = "popupBinAvailableAllowcation";
		popupbox.style.position = 'absolute';
		popupbox.style.zIndex = 1;
		popupbox.style.left = 120 + 'px';
		popupbox.style.top = 50 + 'px';  
		popupbox.innerHTML = strBinAvlAllowcation;     
		document.body.appendChild(popupbox);						
		LoadAvlMatSubCatogories()
		
}

function deleteTheSelectedAllData(obj)
{
	var row=obj.parentNode.parentNode
	var catID = obj.parentNode.parentNode.cells[0].firstChild.nodeValue;


	var answer = confirm("Do you want to dalete the selected category from allowcation..?")
	if (answer)
	{
		createHtmlXmlAvlMatSubCatDelete();
		catDelete.onreadystatechange = HandelDeleteCat;
		catDelete.open("GET", 'StoreLocatorWizard.php?RequestType=deleteAvlMatSubCatogeris&bid='+bid + '&catID=' + catID, true);
		catDelete.send(null); 	
	}
}
function HandelDeleteCat()
{
	if(catDelete.readyState == 4) 
    {
        if(catDelete.status == 200) 
        {  
			var XMLStoreID = catDelete.responseXML.getElementsByTagName("Result");
			var resDel=XMLStoreID[0].childNodes[0].nodeValue;
			if(resDel=="True")
			{
				alert("Selected category removes from this allocation successfully")
				LoadAvlMatSubCatogories()
				return;
			}
		}
	}
}
