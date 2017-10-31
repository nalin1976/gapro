// JavaScript Document

function loadPoDetails()
{
	if(document.getElementById('txt_povalue').value=='')
		alert("Please Enter a PO number.");
	else
	{
		var styleNo=document.getElementById('txt_povalue').value;
		var url="upload-db.php?request=load_OrderNo";
	   		url+="&styleNo="+styleNo;
			
		var xml_http_obj	= $.ajax({url:url,async:false});
		var xml_StyleNo    	= xml_http_obj.responseXML.getElementsByTagName('StyleNo');
		var xml_PoNo    	= xml_http_obj.responseXML.getElementsByTagName('PoNo');
		
		var tblPoDetails=document.getElementById('tblPoDetails');
		
		for(i=0; i<xml_StyleNo.length; i++)
		{
			var lastRow 		= tblPoDetails.rows.length;
			var row 			= tblPoDetails.insertRow(lastRow);
			row.className	= 'bcgcolor-tblrowWhite';
			var rowCell = row.insertCell(0);
			rowCell.className = "normalfntMid";
			rowCell.innerHTML ="<input type=\"checkbox\" class=\"txtbox\" align='center' />";	
			
			
			var rowCell = row.insertCell(1);
			rowCell.className = "normalfntMid";
			rowCell.innerHTML =xml_StyleNo[i].childNodes[0].nodeValue;	
			
				
			var rowCell = row.insertCell(2);
			rowCell.className = "normalfntMid";
			rowCell.innerHTML =xml_PoNo[i].childNodes[0].nodeValue;
		}
	}
}