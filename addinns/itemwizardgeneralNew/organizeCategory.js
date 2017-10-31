// JavaScript Document

var xmlHTTP=[];
var category="";

function generateHTTPRequest(index)
{
	if (window.ActiveXObject){
		xmlHTTP[index]=new ActiveXObject("Microsoft.XMLHTTP");}
	else if (window.XMLHttpRequest){
		xmlHTTP[index]= new XMLHttpRequest();}
}


function saveOrganizedCantent()
{
		var category="cat";
		var index="index";
		generateHTTPRequest(0);
		xmlHTTP[0].onreadytatechange=function(){}
		xmlHTTP[0].open("GET",'organizedmiddle.php?REQUEST=saveCategory&category='+URLEncode(category)+'&index='+URLEncode(index),true);
		xmlHTTP[0].send(null);
}

function viewArranged()
{
	
	
	generateHTTPRequest(2);
	xmlHTTP[2].onreadystatechange = function()
	{
		 if(xmlHTTP[2].readyState == 4) 
   		 {
        	if(xmlHTTP[2].status == 200) 
        	{
				drawArrangedPopupArea(490,228,'frmNewOrganize');
				document.getElementById('frmNewOrganize').innerHTML=xmlHTTP[2].responseText;
				
				var tbl = document.getElementById('tblContent');
				var counted=0;
    			for ( var loop = 0 ;loop < tbl.rows.length ; loop ++)
  				{
					
					if(tbl.rows[loop].cells[1].childNodes[0].value != 0)
						{
						var tblcat=document.getElementById('tblOranizedCategory');
					
								
						var lastRow 		= tblcat.rows.length;
					
						var row 			= tblcat.insertRow(lastRow);
					
						/*if(count % 2 ==0)
						row.className ="bcgcolor-tblrow";
						else
						row.className ="bcgcolor-tblrowWhite";*/
					
						var rowCell = row.insertCell(0);
						rowCell.className ="normalfnt";			
						rowCell.innerHTML =tbl.rows[loop].cells[0].childNodes[0].nodeValue ;
						var rowCell = row.insertCell(1);
						rowCell.className ="normalfntRite";			
						rowCell.innerHTML =tbl.rows[loop].cells[1].childNodes[0].value+"%" ;
						//if(counted==0)
						 //tbl.deleteRow(0);
						count++;
						}
					
					}
				
					var table = document.getElementById('tblOranizedCategory');
					var tableDnD = new TableDnD();
					tableDnD.init(table);
				}
			}
		
		}
	xmlHTTP[2].open("GET",'organizeCategory.php?',true);
	xmlHTTP[2].send(null);
}

function saveContentName()
{
	//createAltXMLHttpRequest();
   // altxmlHttp.onreadystatechange = HandleContentSaving;
	if (document.getElementById('txtContentName').value == "" || document.getElementById('txtContentName').value == null)
	{
		alert("No content name generated to save.");
		return false;
	}
	
	var tbl = document.getElementById('tblContent');
	var sum = 0;
    for ( var loop = 0 ;loop < tbl.rows.length ; loop ++ )
  	{
		if(tbl.rows[loop].cells[1].childNodes[0].value != 0)
			sum += parseInt(tbl.rows[loop].cells[1].childNodes[0].value);
	}
	if (sum != 100)
	{
		alert("Please check your given percentages. The content name not satisfied.")
		return false;
	}
	viewArranged();
	//var contentName = document.getElementById('txtContentName').value;
    //altxmlHttp.open("GET", 'wizardmiddle.php?str=SaveNewContent&contentName=' + URLEncode(contentName), true);
    //altxmlHttp.send(null); 
}

function HandleContentSaving()
{	
    if(xmlHTTP[3].readyState == 4) 
    {
        if(xmlHTTP[3].status == 200) 
        {
			var result = xmlHTTP[3].responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
			var message = xmlHTTP[3].responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue;
			if(result == "True")
			{
				var contentName = document.getElementById('txtContentName').value;
				var opt = document.createElement("option");
				opt.text = category;
				opt.value = contentName;
				document.getElementById("itemwizard_cboFabricContent").options.add(opt);
				alert(message);
				closeWindow();closeOrderWindow();
			}
			else
			{
				alert(message);
			}
			
			
		}
	}
}



function saveinDB()
{
	var tblcat=document.getElementById('tblOranizedCategory');
	category="";
	
	for (var j=0; j<tblcat.rows.length; j++)
	{
		category+=tblcat.rows[j].cells[1].childNodes[0].nodeValue+ " " + tblcat.rows[j].cells[0].childNodes[0].nodeValue+" ";
	}
	
	generateHTTPRequest(3);
	xmlHTTP[3].onreadystatechange = HandleContentSaving;
	
	var index = document.getElementById('txtContentName').value;
   	xmlHTTP[3].open("GET", 'wizardmiddle.php?str=SaveNewContent&index=' + URLEncode(index)+'&contentName='+ URLEncode(category), true);
   	xmlHTTP[3].send(null); 
	
}

function closeOrderWindow()
{
	try
	{
		var box = document.getElementById('popupbox2');
		box.parentNode.removeChild(box);
		//alert(box)
	}
	catch(err)
	{        
	}	
}

function drawArrangedPopupArea(width,height,popupname)
{
	
	 var popupbox = document.createElement("div");
     popupbox.id = "popupbox2";
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