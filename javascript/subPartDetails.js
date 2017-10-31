var xmlHttp;
var xmlHttp2 = [];
//start - configuring HTTP request
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
//End - configuring HTTP request

//Start-close popup window
function closeWindow()
{
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
}
//End-close popup window

//start - configuring HTTP2 request
function createXMLHttpRequest2(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp2[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp2[index] = new XMLHttpRequest();
    }
}
//End - configuring HTTP2 request

function ShowSubContractWindow()
{
	var StyleId	 = document.getElementById("txtStyleNo").value;	
	
	//createXMLHttpRequest();
	//xmlHttp.onreadystatechange=ShowSubContractWindowRequest;
	var url ='subPartDetails.php?StyleId=' + URLEncode(StyleId);
	var xmlHttp = $.ajax({url:url,async:false});
	drawPopupArea(445,244,'frmSubPartDetails');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmSubPartDetails').innerHTML=HTMLText;		
	//xmlHttp.send(null);
}

	/*function ShowSubContractWindowRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				drawPopupArea(445,244,'frmSubPartDetails');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmSubPartDetails').innerHTML=HTMLText;				
			}
		}
	}*/
	
function Save()
{
		tblMain=document.getElementById("tblSubContractors");
	
	for(loop=1;loop<tblMain.rows.length;loop++)
	{
		var StyleId	  = document.getElementById("txtStyleNo").value;				
		var PartNo    = tblMain.rows[loop].cells[1].childNodes[0].nodeValue;
		var PartName  = tblMain.rows[loop].cells[2].childNodes[0].value;
		var CM        = tblMain.rows[loop].cells[3].childNodes[0].value;
		var Transport = tblMain.rows[loop].cells[4].childNodes[0].value;
		
		createXMLHttpRequest2(loop);		
		xmlHttp2[loop].open("GET",'subPartDetailsXml.php?RequestType=SaveSubContractorDetails&StyleId=' +StyleId+ '&PartNo=' +PartNo+ '&PartName=' +PartName+ '&CM=' +CM+ '&Transport=' +Transport ,true);
		xmlHttp2[loop].send(null);
	}
	closeWindow();
}
function RemoveSubRowItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode;

		var td = obj.parentNode;
		//var tro = td.parentNode;
		var tt=td.parentNode;		
		tt.parentNode.removeChild(tt);				
		DeleteSubPartRow(obj);
	}
}
function DeleteSubPartRow(obj)
{
	var StyleId	= document.getElementById("txtStyleNo").value;
	var rw		=obj.parentNode.parentNode;
	var PartNo  = rw.cells[1].childNodes[0].nodeValue;
	
	createXMLHttpRequest();
	xmlHttp.open("GET",'subPartDetailsXml.php?RequestType=DeleteRow&StyleId=' +StyleId+ '&PartNo=' +PartNo ,true);
	xmlHttp.send(null);
}

function AddRow()
{	
	var  tblIssueList = document.getElementById('tblSubContractors');
	var NO=0;
		for(loop=1;loop<tblIssueList.rows.length;loop++)
		{
			 NO=parseInt(tblIssueList.rows[loop].cells[1].childNodes[0].nodeValue);
		}
	var lastRow = tblIssueList.rows.length;	
	var row = tblIssueList.insertRow(lastRow);
	
	var cellSubcontractor = row.insertCell(0);
	cellSubcontractor.className = "normalfntMid";	
	cellSubcontractor.innerHTML ="<img src=\"images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveSubRowItem(this)\"/>";
	
	var cellSubcontractor = row.insertCell(1);
	cellSubcontractor.className = "normalfntMid";	
	cellSubcontractor.innerHTML = NO+1;
	
	var cellSubcontractor = row.insertCell(2);
	cellSubcontractor.className = "normalfnt";	
	cellSubcontractor.innerHTML = "<input type=\"text\" name=\"txtpart\" id=\"txtpart\" class=\"txtbox\" size=\"20\" style=\"text-align:left\" value=\"\" />";
	
	var cellSubcontractor = row.insertCell(3);
	cellSubcontractor.className = "normalfntMid";	
	cellSubcontractor.innerHTML = "<input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\"0\" />";
	
	var cellSubcontractor = row.insertCell(4);
	cellSubcontractor.className = "normalfntMid";	
	cellSubcontractor.innerHTML ="<input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\"0\" />";
}