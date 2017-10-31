// JavaScript Document
function loadOrders()
{
	
	var stylename = document.getElementById('cbostyleno').value;
	document.getElementById('txtfilename').value=stylename;
	var url = "StyleDocumentXML.php?RequestType=loadOders&stylename="+stylename;
	
	var resText = $.ajax({url:url,async:false});
	
	document.getElementById('cbooders').innerHTML = resText.responseText;

}

function viewDocuments()
{
	
	
	var stylename      = document.getElementById('cbostyleno').value;
	var styleid        = document.getElementById('cbooders').value;
	var documentname   = document.getElementById('cbodocument').value;
	
	if(stylename=="" || styleid=="")
	{
		alert("Select Style No and Order No !");
	}
	else
	{
		document.forms["frmupload1"].submit();
	}
}
function uploadfile()
{
	var stylename      = document.getElementById('cbostyleno').value;
	var styleid        = document.getElementById('cbooders').value;
	var documentname   = document.getElementById('cbodocument').value;
	var filename       = document.getElementById('txtfilename').value;
	var filepath       = document.getElementById('filepath').value;
	
	if(stylename=="" || styleid=="" || filename=="" || filepath=="")
	{
		alert("Select Document, File Name and Browse a file !");
	}
	else
	{
			var fileInput = $("#filepath")[0];
            var imgbytes  = fileInput.files[0].fileSize;
		
		if(imgbytes>50000000)	
			alert("Sorry ! File size must less than 50MB.");
		else
			document.forms["frmupload1"].submit();
	}
	
}

function deleteImage(obj,stylID,doc)
{
	
	var res = confirm("Are you sure ?"+"\n"+"Do you want to delete this image");
	
	if(res)
	{
		var url = "StyleDocumentXML.php?RequestType=deleteImage&filename="+obj.id+"&styleid="+stylID+"&doc="+doc;
	
		$.ajax({url:url,async:false});
		
		alert("File Deleted Successfully !");
		
		var cbostyleno  = document.getElementById('cbostyleno').value;
		var cbooders    = document.getElementById('cbooders').value;
		var cbodocument = document.getElementById('cbodocument').value;
		
		document.getElementById('txtfilename').value="";
		document.forms["frmupload1"].submit();

	}
	else
	{
		window.location.reload();
	}
}


