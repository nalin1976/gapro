// JavaScript Document
function savedetails()
{
	var  styleid			= $('#cboOrderNo').val();
	var  customer    		= $('#cboCustomer').val();
	var  stylenumber 		= $('#txtStyleNo').val()+"-"+$('#txtRepeatNo').val();
	var  ordernumber 		= $('#txtPoNo').val();
	var  fabsupplier 		= $('#cboMill').val();
	var  description 		= $('#txtDescription').val();
	var  designer    		= $('#txtDesigner').val();
	var  date        		= $('#txtdate').val();
	var  size        		= $('#txtsize').val();
	var  quality     		= $('#txtquality').val();
	var  sampletype			= $('#cboType').val();	
	var  price       		= $('#txtprice').val();
	var  composition 		= $('#txtcomposition').val();
	var  lining      		= $('#txtlining').val();
	var  button      		= $('#txtbutton').val();
	var  zip         		= $('#txtzip').val();
	var  additionaldetails  = $('#txtaradditional').val();
	
	
	var url = "StyleDefinitionXML.php?RequestType=save";
	
	url +="&styleid="+styleid;
	url +="&customer="+customer;
	url +="&stylenumber="+stylenumber;
	url +="&ordernumber="+ordernumber;
	url +="&fabsupplier="+fabsupplier;
	url +="&description="+description;
	url +="&designer="+designer;
	url +="&date="+date;
	url +="&size="+size;
	url +="&quality="+quality;
	url +="&sampletype="+sampletype;
	url +="&price="+price;
	url +="&composition="+composition;
	url +="&lining="+lining;
	url +="&button="+button;
	url +="&zip="+zip;
	url +="&additionaldetails="+additionaldetails;
	
	var resobj = $.ajax({url:url,async:false});
	
	if(resobj.responseText==1)
	{
		alert("Data Saved Successfully !");
		window.location.reload();
	}
	if(resobj.responseText==2)
	{
		alert("Order number and Style number already exist !");
		//window.location.reload();
	}
}


function uploadfile()
{
	var canvas     = document.getElementById('imageView');
	//var imagesrc  = document.getElementById('imgid').name;
	//var ctx = canvas.getContext;
	
	if(canvas)
	{
		alert("Sketch already exist ! \nDelete the current Sketch and try again !");
	}
	else
	{
		document.frmsampledef.action ="StyleDefinition.php";
		document.frmsampledef.target ='_self';
		var styleid = document.getElementById('cboOrderNo').value;
		
		if(styleid=="")
		{
			alert("Select Style ID !");
		}
		else if(document.getElementById('filepath').value=="")
		{
			alert("Browse a file !");
		}
	
		else
		{
			//document.getElementById('filepath').value="";
			loadSketch();
		}
	}
}




function loadSketch()
{
	document.frmsampledef.action ="StyleDefinition.php";
	document.frmsampledef.target ='_self';
	document.forms["frmsampledef"].submit();
}

function deleteImage()
{
	
	document.frmsampledef.action ="StyleDefinition.php";
	document.frmsampledef.target ='_self';
	var styleid    = document.getElementById('cboOrderNo').value;
	
	if(styleid=="")
	{
		alert("Select Style ID !");
	}
	
	else
	{
		
		try
		{
			var imagename  = document.getElementById('imgid').name;
			if(imagename=="")
			{
				alert("No image to delete !");
			}
			
			else
			{
				var res = confirm("Are you sure ?"+"\n"+"Do you want to delete this image");
	
				if(res)
				{
					var url = "StyleDefinitionXML.php?RequestType=deleteImage&styleid="+styleid+"&imagename="+imagename;
	
					$.ajax({url:url,async:false});
		
					alert("File Deleted Successfully !");
					document.getElementById('imgid').src="";
					document.getElementById('imgid').name="";
					document.getElementById('filepath').value="";
					window.location.reload();
					//loadSketch();
				}
			}
		}
		catch(err)
		{
			alert("No image to delete !");
			
		}
	}

}

function viewImage(fpath)
{
	document.frmsampledef.action ="StyleDefinition.php";
	document.frmsampledef.target ='_self';
	
	var styleid    = document.getElementById('cboOrderNo').value;
	window.open('SampleDocumentView.php?img='+fpath+'&styleid='+styleid);
}

function viewReport()
{
	document.frmsampledef.action ="SampleDefinitionReport.php";
	document.frmsampledef.target ='_blank';
	document.forms["frmsampledef"].submit();
}

function saveImg()
{
	
	var canvas  = document.getElementById("imageView");
	var context = canvas.getContext("2d");
	var img     = canvas.toDataURL("image/png");
	//alert(img);
	var  stylenumber = $('#cboOrderNo').val();
	var  filename    = $('#labfilename').text();
	//alert(stylenumber);
	//alert(filename);
	var ajax = new XMLHttpRequest();
	ajax.open("POST",'StyleDefinitionXML.php?stylenumber='+stylenumber+'&filename='+filename,false);
	ajax.setRequestHeader('Content-Type', 'application/upload');
	ajax.send(img);
	//document.write('<img src="'+img+'"/>');
	context.clearRect (0,0,790,690);
	$('#imageView').remove();
	alert("Sketch saved successfully !");
	document.getElementById('filepath').value="";
	//window.location.reload();
	loadSketch();
}

function deleteSketch()
{
	var  stylenumber = $('#cboOrderNo').val();
	var  filename    = $('#labfilename').text();
	
	var url = "StyleDefinitionXML.php?RequestType=delete";
	
	url +="&stylenumber="+stylenumber;
	url +="&filename="+filename;
	
	var resobj = $.ajax({url:url,async:false});
	
	if(resobj.responseText==1)
	{
		alert("Data Deleted Successfully !");
	}
}

function eracer1()
{
	var drcombo = document.getElementById("dtool");
	drcombo.value = "eracer";
	
}

function LoadStyleCustomer()
{
	//clearDropDown('cboStyleNoFind');
	
	var buyerID=document.getElementById('cboBuyerFind').value;
	
	var url="StyleDefinitionXML.php";
					url=url+"?RequestType=getStyleCustomer";
					url += '&buyerID='+URLEncode(buyerID);
					
	var htmlobj = $.ajax({url:url,async:false});
	var OrderNo = htmlobj.responseXML.getElementsByTagName("StyleNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboStyleNoFind').innerHTML =  OrderNo;
 	
}

function loadBuyerwiseOrderNo()
{
	//clearDropDown('cboOrderNo');
	var buyerID=document.getElementById('cboBuyerFind').value;
	
	var url="StyleDefinitionXML.php";
					url=url+"?RequestType=getBuyerOrderNo";
					url += '&buyerID='+URLEncode(buyerID);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
}

function changeOrderNo()
{
	var stytleName = document.getElementById('cboStyleNoFind').value.trim();
	var url="StyleDefinitionXML.php";
					url=url+"?RequestType=getStyleWiseOrderNoOrderinquiry";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
}


function setValuetoStyleBox()
{
	//var StyleNo=document.getElementById("cboStyleNoFind").value;
	var StyleNo=document.getElementById("cboOrderNo").value;
	
	loadDetailsForStyle(StyleNo);
	//alert(StyleNo);
}

function loadDetailsForStyle(StyleNo)
{
	
}


function addlable()
{
	
	document.getElementById("lblcust").value=$("#cboBuyerFind option:selected").text();
	
}

function showFonts()
{
	
	document.getElementById('cbofontsize').style.visibility = 'visible';
	document.getElementById('cbofontname').style.visibility = 'visible';
	document.getElementById('bold1').style.visibility       = 'visible';
	document.getElementById('italic1').style.visibility     = 'visible';
	document.getElementById('underline1').style.visibility  = 'visible';
}

function hiddenFonts()
{
	  
	document.getElementById('bold1').style.background       = '';
	document.getElementById('italic1').style.background     = '';
	document.getElementById('underline1').style.background  = '';
	document.getElementById('cbofontsize').style.visibility = 'hidden';
	document.getElementById('cbofontname').style.visibility = 'hidden';
	document.getElementById('bold1').style.visibility       = 'hidden';
	document.getElementById('italic1').style.visibility     = 'hidden';
	document.getElementById('underline1').style.visibility  = 'hidden';
}

function newStyle()
{
	window.location.href = "StyleDefinition.php";
}