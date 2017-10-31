
var xmlHttp =[];
var current_node="";
var current_iou="";

function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}

function confirmCancel(nod)
{
	var iouno=nod.parentNode.parentNode.childNodes[1].childNodes[0].nodeValue;
	current_node=nod;
	current_iou=iouno;
	createNewXMLHttpRequest(16);
		xmlHttp[16].onreadystatechange=function()
		{	
			if(xmlHttp[16].readyState==4 && xmlHttp[16].status==200)
   		 { 
        		
				drawPopupArea(320,185,'frmNewOrganize');
				document.getElementById('frmNewOrganize').innerHTML=xmlHttp[16].responseText;
				
			
		 }
			
		}
		xmlHttp[16].open("GET",'ConfirmCamcellation.php?iouno='+iouno,true);
		xmlHttp[16].send(null);	
	
}


function docancel()
{
	//alert(current_node.parentNode.parentNode.childNodes[11].innerHTML);
	var reason=document.getElementById("txtReason").value;
			
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
		{	
			if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
			 { 		
				current_node.parentNode.parentNode.childNodes[11].innerHTML=reason;
				current_node.parentNode.parentNode.childNodes[9].innerHTML="<div style='color:#CC0000'>Canceled</div>";
				closeWindow();	     	
				
			 }
			
		}
		xmlHttp[1].open("GET",'cancelioudb.php?request=cancel&iouno='+current_iou+'&reason='+reason,true);
		xmlHttp[1].send(null);	
	
	
}