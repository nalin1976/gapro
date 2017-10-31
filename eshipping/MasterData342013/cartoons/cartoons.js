// JavaScript Document
function setCartoonValue()
{
	var length  = document.getElementById("txtLength").value;
	var width   = document.getElementById("txtWidth").value;
	var heigth  = document.getElementById("txtheight").value;
	
	if(length!="" && width!="" && heigth!="" )
	{
		document.getElementById("txtCartoons").value = length+' x '+width+' x '+heigth;
	}
	else
	{
		document.getElementById("txtCartoons").value = "";
	}
}
function saveData()
{
	if(!validateSave())
		return;
	
	if(!ValidatecartoonBeforeSave())
		return;
	
	var cartoonId	= $('#cboCartoons').val();
	var length 		= $('#txtLength').val();
	var width 		= $('#txtWidth').val();
	var height 		= $('#txtheight').val();
	var cartoon 	= $('#txtCartoons').val();
	var weigtht	 	= $('#txtWeight').val();
	var description = $('#textareaDes').val();
	
	var url	    = 'cartoonsdb.php?request=saveData&cartoonId='+cartoonId+'&length='+length+'&width='+width+'&height='+height+'&cartoon='+URLEncode(cartoon)+'&weigtht='+weigtht+'&description='+URLEncode(description);
	var htmlobj = $.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	if(htmlobj.responseText=="saved")
	{
		alert("saved Successfully.");
		//loadCombo('select intCartoonId,strCartoon from cartoon order by strCartoon;','cboCartoons');
		clearFeilds();
	}
	else
	{
		alert("error in Saving.");
		return;
	}
	
}
function validateSave()
{
	if(document.getElementById("txtLength").value=="")
	{
		alert("Please enter a Length.");
		document.getElementById("txtLength").focus();
		return;
	}
	if(document.getElementById("txtWidth").value=="")
	{
		alert("Please enter a Width.");
		document.getElementById("txtWidth").focus();
		return;
	}
	if(document.getElementById("txtheight").value=="")
	{
		alert("Please enter a Height.");
		document.getElementById("txtheight").focus();
		return;
	}
	return true;
}
function ValidatecartoonBeforeSave()
{
	var cartoonId = $('#cboCartoons').val();
	var cartoon   = $('#txtCartoons').val();
	
	var url = 'cartoonsdb.php?request=checkcartoonAvailble&cartoonId='+cartoonId+'&cartoon='+URLEncode(cartoon);
	var htmlobj  = $.ajax({url:url,async:false});
	if(htmlobj.responseText==true)
	{
		alert("\""+cartoon+"\" is already exist.");	
		return false;
	}
	return true;
}
function clearData()
{
	document.frmCartoons.reset();
}
function loadData(cartoonId)
{
	if(cartoonId=="")
	{
		clearData();
		return;
	}
	var url = 'cartoonsdb.php?request=loadData&cartoonId='+cartoonId;
	var xml_http_obj = $.ajax({url:url,async:false});
	
	$('#txtLength').val(xml_http_obj.responseXML.getElementsByTagName('length')[0].childNodes[0].nodeValue);
	$('#txtWidth').val(xml_http_obj.responseXML.getElementsByTagName('width')[0].childNodes[0].nodeValue);
	$('#txtheight').val(xml_http_obj.responseXML.getElementsByTagName('height')[0].childNodes[0].nodeValue);
	$('#txtCartoons').val(xml_http_obj.responseXML.getElementsByTagName('cartoon')[0].childNodes[0].nodeValue);
	$('#txtWeight').val(xml_http_obj.responseXML.getElementsByTagName('weight')[0].childNodes[0].nodeValue);
	$('#textareaDes').val(xml_http_obj.responseXML.getElementsByTagName('Description')[0].childNodes[0].nodeValue);

}

function clearFeilds()
{
	$('#txtLength').val('');
	$('#txtWidth').val('');
	$('#txtheight').val('');
	$('#txtCartoons').val('');
	$('#txtWeight').val('');
	$('#textareaDes').val('');

}