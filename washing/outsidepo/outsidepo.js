$(document).ready(function() 
{
		$('#btnSave').click(function()
		{
			saveData();			
		});
		
		$('#btnDelete').click(function()
		{
			deleteData();			
		});
		
		$('#btnNew').click(function()
		{
				clearData();
				
		});
});

function loadDetails()
{
	 var cboFabric = document.getElementById("cboFabric").value;
	 if(cboFabric=="")
	 {
		
		 document.getElementById("txtStyleNo").value="";
		 document.getElementById("cboDivision").value="";
		 document.getElementById("cboColor").value="";
		 document.getElementById("cboGarment").value="";
		 document.getElementById("cboMill").value="";
		 document.getElementById("cboWashType").value="";
		 document.getElementById("cboFactory").value="";
		 document.getElementById("txtFabricDes").value="";
		 document.getElementById("txtFabricCon").value="";
		

	 }
		var path  = "outsidepo_xml.php?request=loadDetails&cboFabric="+cboFabric;
		htmlobj=$.ajax({url:path,async:false});
		
		var xml_style=htmlobj.responseXML.getElementsByTagName('Style');
		//var xml_division=htmlobj.responseXML.getElementsByTagName('Division');
		var xml_divisionid=htmlobj.responseXML.getElementsByTagName('Divisionid');
		var xml_color=htmlobj.responseXML.getElementsByTagName('Color');
		//var xml_garment=htmlobj.responseXML.getElementsByTagName('Garment');
		var xml_garmentid=htmlobj.responseXML.getElementsByTagName('Garmentid');
		var xml_FabricDes=htmlobj.responseXML.getElementsByTagName('FabricDes');
		var xml_FabricCon=htmlobj.responseXML.getElementsByTagName('FabricCon');
		//var xml_Mill=htmlobj.responseXML.getElementsByTagName('Mill');
		var xml_Millid=htmlobj.responseXML.getElementsByTagName('Millid');
		//var xml_WashType=htmlobj.responseXML.getElementsByTagName('WashType');
		var xml_WashTypeid=htmlobj.responseXML.getElementsByTagName('WashTypeid');
		//var xml_Factory=htmlobj.responseXML.getElementsByTagName('Factory');
		var xml_Factoryid=htmlobj.responseXML.getElementsByTagName('Factoryid');
		
		if(xml_style.length > 0){
			//document.getElementById("cboStyle").innerHTML="";
			//var opt = document.createElement("option");
			//opt.value 	= xml_style[0].childNodes[0].nodeValue;	
			//opt.text 	= xml_style[0].childNodes[0].nodeValue;*/	
			document.getElementById("txtStyleNo").value=xml_style[0].childNodes[0].nodeValue;
			$('#cboDivision').val(xml_divisionid[0].childNodes[0].nodeValue);
			$('#cboColor').val(xml_color[0].childNodes[0].nodeValue);
			$('#cboGarment').val(xml_garmentid[0].childNodes[0].nodeValue);
			document.getElementById("txtFabricDes").value=xml_FabricDes[0].childNodes[0].nodeValue;
			document.getElementById("txtFabricCon").value=xml_FabricCon[0].childNodes[0].nodeValue;
			$('#cboMill').val(xml_Millid[0].childNodes[0].nodeValue);
			$('#cboWashType').val(xml_WashTypeid[0].childNodes[0].nodeValue);
			$('#cboFactory').val(xml_Factoryid[0].childNodes[0].nodeValue);
		}
		
}

function saveData()
{
	if(validateData())
	{
	var PLNo = $('#txtPONo').val();
	var fabricID = $('#cboFabric').val();
	var styleNo = $('#txtStyleNo').val();
	var division = $('#cboDivision').val();
	var color = $('#cboColor').val();
	var garment = $('#cboGarment').val();
	var size = $('#cboSize').val();
	var orderQty = $('#txtOrderQty').val();
	var cutQty = $('#txtCutQty').val();
	var washQty = $('#txtWashQty').val();
	var date = $('#txtDate').val();
	var styleName = $('#txtStyleName').val();
	var mill = $('#cboMill').val();
	var washType = $('#cboWashType').val();
	var factory = $('#cboFactory').val();
	var Ex = $('#txtEx').val();
	
	var url	='outsidepodb.php?request=saveData&PLNo='+URLEncode(PLNo)+'&fabricID='+URLEncode(fabricID)+'&styleNo='+URLEncode(styleNo)+'&division='+URLEncode(division)+'&color='+URLEncode(color)+'&garment='+URLEncode(garment)+'&size='+URLEncode(size)+'&orderQty='+URLEncode(orderQty)+'&cutQty='+URLEncode(cutQty)+'&washQty='+URLEncode(washQty)+'&date='+URLEncode(date)+'&styleName='+URLEncode(styleName)+'&mill='+URLEncode(mill)+'&washType='+URLEncode(washType)+'&factory='+URLEncode(factory)+'&Ex='+URLEncode(Ex);
	
	var xml_http_obj =$.ajax({url:url,async:false});
	if(xml_http_obj.responseText=="saved")
	{
		alert("saved successfully.")
		loadCmb();
		clearData();
	}
	else if(xml_http_obj.responseText=="update")
	{
		
		alert("updated successfully.");
		loadCmb();
		clearData();
													
	}
	else
		{
			alert("error");
		
		}
	
}
	else
	{
		return false;
	}
		
}

function clearData()
{
		
		  document.outsidepo.reset();
}

function validateData()
{
	if($('#txtPONo').val()=="")
	{
		alert("please enter a PO No.");
		$('#txtPONo').focus();
		return false;
	}
	if($('#cboFabric').val()=="")
	{
		alert("please select a fabric ID.");
		$('#cboFabric').focus();
		return false;
	}
	if($('#txtOrderQty').val()=="")
	{
		alert("please enter a order quantity.");
		$('#txtOrderQty').focus();
		return false;
	}
	if($('#txtCutQty').val()=="")
	{
		alert("please enter a cut quantity.");
		$('#txtCutQty').focus();
		return false;
	}
	if($('#txtWashQty').val()=="")
	{
		alert("please enter a wash quantity.");
		$('#txtWashQty').focus();
		return false;
	}
	else
	return true;
}

function searchData()
{
	if($('#cboSearch').val()=="" )
	{
		clearData();
	}
	else
	{
	var searchcmb =  $('#cboSearch').val();
	
	var url='outsidepo_xml.php?request=searchData&searchcmb='+searchcmb;
	var xml_http_obj =$.ajax({url:url,async:false});
	
		$('#txtPONo').val(xml_http_obj.responseXML.getElementsByTagName('PONo')[0].childNodes[0].nodeValue);
		$('#cboFabric').val(xml_http_obj.responseXML.getElementsByTagName('Fabrid')[0].childNodes[0].nodeValue);		
		$('#txtStyleNo').val(xml_http_obj.responseXML.getElementsByTagName('strStyleNo')[0].childNodes[0].nodeValue);			
	//	$('#cboFabric').val(xml_http_obj.responseXML.getElementsByTagName('FabID')[0].childNodes[0].nodeValue);		
		$('#cboDivision').val(xml_http_obj.responseXML.getElementsByTagName('Divisionid')[0].childNodes[0].nodeValue)	;	
		$('#cboColor').val(xml_http_obj.responseXML.getElementsByTagName('Color')[0].childNodes[0].nodeValue);		
		$('#cboGarment').val(xml_http_obj.responseXML.getElementsByTagName('Garmentid')[0].childNodes[0].nodeValue);		
		$('#cboSize').val(xml_http_obj.responseXML.getElementsByTagName('Size')[0].childNodes[0].nodeValue)	;		
		$('#txtOrderQty').val(xml_http_obj.responseXML.getElementsByTagName('OrderQty')[0].childNodes[0].nodeValue)	;	
		$('#txtCutQty').val(xml_http_obj.responseXML.getElementsByTagName('CutQty')[0].childNodes[0].nodeValue)	;	
		$('#txtWashQty').val(xml_http_obj.responseXML.getElementsByTagName('WashQty')[0].childNodes[0].nodeValue);		
		$('#txtDate').val(xml_http_obj.responseXML.getElementsByTagName('Date')[0].childNodes[0].nodeValue)	;		
		$('#txtStyleName').val(xml_http_obj.responseXML.getElementsByTagName('StyleName')[0].childNodes[0].nodeValue);
		$('#txtFabricDes').val(xml_http_obj.responseXML.getElementsByTagName('FabricDes')[0].childNodes[0].nodeValue);
		$('#txtFabricCon').val(xml_http_obj.responseXML.getElementsByTagName('FabricCon')[0].childNodes[0].nodeValue)	
		$('#cboMill').val(xml_http_obj.responseXML.getElementsByTagName('Millid')[0].childNodes[0].nodeValue)	;	
		$('#cboWashType').val(xml_http_obj.responseXML.getElementsByTagName('WashTypeid')[0].childNodes[0].nodeValue)	;	
		$('#cboFactory').val(xml_http_obj.responseXML.getElementsByTagName('Factoryid')[0].childNodes[0].nodeValue);
		$('#txtEx').val(xml_http_obj.responseXML.getElementsByTagName('Ex')[0].childNodes[0].nodeValue);
	}
}

function deleteData()
{
	if($('#cboSearch').val()=="")
	{
		alert("please select a PO No.");
		$('#cboSearch').focus();
		return false;
	}
	else
	{
		var deletepo =  $('#cboSearch').val();
		var deletepotxt = $("#cboSearch option:selected").text();
		
		var url='outsidepodb.php?request=deleteData&deletepo='+deletepo;
		var xml_http_obj =$.ajax({url:url,async:false});
		
		if(xml_http_obj.responseText=="delete")
		{
			var ans=confirm("Are you sure you want to  delete '" +deletepotxt+ "' ?");        		       	
        		 	if(ans)
					{		alert("deleted successfully.")
							loadCmb();
							clearData();				
					}								
				
		}
		else 
		{
				
			alert("Error.");
			
													
		}
		
	}
}

function loadCmb()
{
	var sql = "select intId,intPONo from was_outsidepo order by intPONo;";
	var control = "cboSearch";
	loadCombo(sql,control);
}