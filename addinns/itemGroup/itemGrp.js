// JavaScript Document
var xmlHttp;
var pubMaxID = 0;
var requestCount = 0;
var responseCount = 0;
var multixmlHttp = [];
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

function createXMLHttpRequestNext() 
{
	if (window.ActiveXObject) 
	{
		xmlHttpNext = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttpNext = new XMLHttpRequest();
	}
}
//End - configuring HTTP request

function createNewMultiXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        multixmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        multixmlHttp[index] = new XMLHttpRequest();
    }
}


//Start -Get GetXmlHttpObject
function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
 	{
 	// Firefox, Opera 8.0+, Safari
 		xmlHttp=new XMLHttpRequest();
 	}
	catch (e)
 	{
 	// Internet Explorer
 		try
  		{
  			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  		}
 	catch (e)
  	{
  		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
 	}
return xmlHttp;
}
//End -Get GetXmlHttpObject

function RomoveData(data)
{
		var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}

function getSubCatDetails()
{
	var mainCat = document.getElementById("cmbMainCat").value;
	RomoveData('cmbSubCat');
	if(mainCat == '')
	{
		alert("Select \"Main Category\"");
		return false;
	}
	//alert(mainCat);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = SubCatDetails;
	xmlHttp.open("GET",'itemGrpxml.php?RequestType=LoadSubCatDetails&mainCat='+mainCat ,true);
	xmlHttp.send(null);
}

function SubCatDetails()
{
	if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)	
			{
				var XMLMainID =xmlHttp.responseXML.getElementsByTagName("SubID");
				var XMLName =xmlHttp.responseXML.getElementsByTagName("Name");
				
					var opt = document.createElement("option");
						opt.text = "Select SubCategory";						
						document.getElementById("cmbSubCat").options.add(opt);	
										
					for ( var loop = 0; loop < XMLName.length; loop ++)
			 		{	
						
						var opt = document.createElement("option");
						opt.text = XMLName[loop].childNodes[0].nodeValue;
						opt.value = XMLMainID[loop].childNodes[0].nodeValue;
						document.getElementById("cmbSubCat").options.add(opt);			
			 		}
			}
		}
}

function getItemDetails()
{
	var mainCat = document.getElementById("cmbMainCat").value;	
	var SubCat  = document.getElementById("cmbSubCat").value;	
	var tbl = document.getElementById("tblItem");
				tbl.deleteRow(0);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = ItemDetails;
	xmlHttp.open("GET",'itemGrpxml.php?RequestType=LoadItemDetails&mainCat='+mainCat+'&SubCat='+SubCat,true);
	xmlHttp.send(null);
}

function ItemDetails()
{
	if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)	
			{
				var XMLMatDetailId = xmlHttp.responseXML.getElementsByTagName("ItemSerial");
				var XMLItemCode = xmlHttp.responseXML.getElementsByTagName("ItemCode");
				var XMLItemDescription = xmlHttp.responseXML.getElementsByTagName("ItemName");
				//document.getElementById("tblItem").innerHTML = "";
				
				var strTxt = "<table width=\"550\" border=\"0\" bgcolor=\"#996F03\" cellspacing=\"1\" id=\"tblItem\">"+
           " <tr >"+
             "<td width=\"10%\" class=\"mainHeading4\" bgcolor=\"#D1A739\">Select </td>"+
            "<td width=\"20%\" class=\"mainHeading4\" bgcolor=\"#D1A739\">Item Code</td>"+
             " <td width=\"70%\" class=\"mainHeading4\" bgcolor=\"#D1A739\">Item Name</td>"+
             
            "</tr>";
				for (var loop =0; loop < XMLMatDetailId.length; loop ++)
				{
					strTxt += "<tr>"+
					"<td  bgcolor=\"#FFFFFF\"><div align=\"center\">"+
							  "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" />"+
						  "</div></td>"+
				"<td id=\""+XMLMatDetailId[loop].childNodes[0].nodeValue+"\" bgcolor=\"#FFFFFF\" class=\"normalfnt\">"+XMLItemCode[loop].childNodes[0].nodeValue+" </td>"+
				"<td  bgcolor=\"#FFFFFF\" class=\"normalfnt\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>"+
				
				   "</tr>";
				
				
				}
				strTxt += "</table>";
				document.getElementById("divItem").innerHTML =strTxt;
			}
		}
}


function getGruopItemDetails()
{
	var groupid = document.getElementById("cmbGroup").value;
	var subCat = document.getElementById("cmbSubCat").value;
	
	var tbl = document.getElementById("tblItem");
	var Count = tbl.rows.length;
					
	createXMLHttpRequestNext();
	xmlHttpNext.onreadystatechange = groupedDetails;
	xmlHttpNext.open("GET",'itemGrpxml.php?RequestType=getGroupedItemDetails&groupid='+ groupid+'&subCat='+subCat,true);
	xmlHttpNext.send(null);
}

function groupedDetails()
{
	if (xmlHttpNext.readyState==4)
		{
			if (xmlHttpNext.status==200)	
			{
				var XMLResult =xmlHttpNext.responseXML.getElementsByTagName("matID");
				var tbl = document.getElementById("tblItem");
						var Count = tbl.rows.length;
				//var result =  XMLResult[0].childNodes[0].nodeValue;
				if( XMLResult.length>0)
				{
					//var matID='';
					for (var loop = 0; loop < XMLResult.length; loop++)
					{
						var result =  XMLResult[loop].childNodes[0].nodeValue;
						
						for(var no=1; no<Count; no++)
						{
							var matId = tbl.rows[no].cells[1].id;
							if(matId == result)
							{
								tbl.rows[no].cells[0].childNodes[0].childNodes[0].checked=true;
								}
						}
					}
				}
				else
				{
					for(var no=1; no<Count; no++)
						{
							tbl.rows[no].cells[0].childNodes[0].childNodes[0].checked=false;
						}
					}
			}
		}
}

function SaveGroup()
{
	//var groupName = document.getElementById("txtGroup").value;
	var groupName=prompt("Please enter Group Name","");
	if(groupName == "")
	{
		alert("Please Enter Group Name");
		return false;
		}
		
		createXMLHttpRequest();
	xmlHttp.onreadystatechange = GroupDetails;
	xmlHttp.open("GET",'itemGrpxml.php?RequestType=SaveGroup&groupName='+ URLEncode(groupName),true);
	xmlHttp.send(null);
}

function GroupDetails()
{
	if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)	
			{
				var XMLResponse = xmlHttp.responseXML.getElementsByTagName("GroupSave");
				//alert(XMLResponse[0].childNodes[0].nodeValue);
				if(XMLResponse[0].childNodes[0].nodeValue == 'Save')
				{
						var xmlMaxid = xmlHttp.responseXML.getElementsByTagName("GroupMaxID"); 
						//var maxId    = xmlMaxid[0].childNodes[0].nodeValue;
						pubMaxID     = xmlMaxid[0].childNodes[0].nodeValue;
						/*xmlHttp.MaxId = maxId;
						alert(xmlHttp.MaxId);*/
					createXMLHttpRequest();
					xmlHttp.onreadystatechange = GroupCombDetails;
					xmlHttp.open("GET",'itemGrpxml.php?RequestType=GroupComb',true);
					xmlHttp.send(null);	
				}
				else
				{
					alert("Group Already Available");
					return false;
				}
			}
		}
}

function GroupCombDetails()
{
	if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)	
			{
				RomoveData('cmbGroup');
				var XMLGroupID =xmlHttp.responseXML.getElementsByTagName("GroupID");
				var XMLGroupName =xmlHttp.responseXML.getElementsByTagName("GroupName");
				
					/*var opt = document.createElement("option");
						opt.text = "Select SubCategory";						
						document.getElementById("cmbGroup").options.add(opt);	*/
										
					for ( var loop = 0; loop < XMLGroupID.length; loop ++)
			 		{	
						
						var opt = document.createElement("option");
						opt.text = XMLGroupName[loop].childNodes[0].nodeValue;
						opt.value = XMLGroupID[loop].childNodes[0].nodeValue;
						document.getElementById("cmbGroup").options.add(opt);			
			 		}
					//alert(xmlHttp.MaxId);
					document.getElementById("cmbGroup").value = pubMaxID;
					//document.getElementById("txtGroup").value = " ";
			}
		}
}

function SaveGroupItem()
{
	var groupName = document.getElementById("cmbGroup").value;
	if(groupName == "")
	{
		alert("Please Enter Group Name");
		return false;
		}
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = DelDetails;
	xmlHttp.open("GET",'itemGrpxml.php?RequestType=DeleteResponse&groupName='+ groupName,true);
	xmlHttp.send(null);
   /* var tbl = document.getElementById("tblItem");
	var Count = tbl.rows.length;
	requestCount = 0;
	responseCount = 0;
	
	for(var no=1; no<Count; no++)
	{
		//alert(groupName);
		var chkBox =tbl.rows[no].cells[0].childNodes[0].childNodes[0].checked;
		//alert(chkBox);
		if (chkBox==true)
		{
			var matId = tbl.rows[no].cells[1].id;
			var url = "itemGrpxml.php?RequestType=SaveGroupMatItemDetails";
	url +="&matId="+matId;
	url +="&groupName="+groupName;
	
		createNewMultiXMLHttpRequest(requestCount);
	
		multixmlHttp[requestCount].onreadystatechange = GetSaveResponse;
		multixmlHttp[requestCount].index = requestCount;
		multixmlHttp[requestCount].open("GET",url,true);
	multixmlHttp[requestCount].send(null);	
	requestCount++;
	
		}
	}*/
}
function DelDetails()
{
	if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)	
			{
				var XMLResult =xmlHttp.responseXML.getElementsByTagName("Delresult");
				var result =  XMLResult[0].childNodes[0].nodeValue;
				//alert(result);
				if(result == 'del' || result == 'NA')
				{
					var tbl = document.getElementById("tblItem");
					var Count = tbl.rows.length;
					requestCount = 0;
					responseCount = 0;
					var groupName = document.getElementById("cmbGroup").value;
						for(var no=1; no<Count; no++)
						{
							//alert(groupName);
							var chkBox =tbl.rows[no].cells[0].childNodes[0].childNodes[0].checked;
							//alert(chkBox);
							if (chkBox==true)
							{
								var matId = tbl.rows[no].cells[1].id;
								var url = "itemGrpxml.php?RequestType=SaveGroupMatItemDetails";
								url +="&matId="+matId;
								url +="&groupName="+groupName;
						
							createNewMultiXMLHttpRequest(requestCount);
						
							multixmlHttp[requestCount].onreadystatechange = GetSaveResponse;
							multixmlHttp[requestCount].index = requestCount;
							multixmlHttp[requestCount].open("GET",url,true);
							multixmlHttp[requestCount].send(null);	
							requestCount++;
						
							}
						}
					}
			}
		}
}
function GetSaveResponse()
{
	if(multixmlHttp[this.index].readyState == 4)
	{
		if(multixmlHttp[this.index].status == 200)
		{
			responseCount ++;
			 if(requestCount == responseCount)
			 {
				alert("Saved successfully.");
				clearItemGroup();
				}
			//alrt(xmlHttp.responseText);
			else if (this.index == requestCount )	
				alert("Not Saved.");
			 //document.getElementById("txtmessage").innerHTML=xmlHttp.responseText;
			 //alert("pass")	;					
		}
	}
}


function viewGroupDetails()
{
	var groupid = document.getElementById("cmbGroup").value;
	
	if(groupid == "")
	{
		alert("Please Enter Group Name");
		return false;
		}
		var groupName = (document.getElementById("cmbGroup").options[document.getElementById('cmbGroup').selectedIndex].text)
	var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];
	path += "/itemGroup/viewGroupDetails.php?groupid="+groupid+"&groupName="+URLEncode(groupName);
	//alert(path);
	var win2=window.open(path,'win');	
}

function deleteGroup(){
	var groupid = document.getElementById("cmbGroup").value;
	var groupname = document.getElementById("cmbGroup").options[document.getElementById("cmbGroup").selectedIndex].text;

	if(document.getElementById("cmbGroup").value == ""){
	alert("Please select group name");	
	document.getElementById("cmbGroup").focus();
	return;
	}
	
	var answer = confirm ("Are you sure to delete")
    if (answer){
	var path = "itemGrpDB.php?RequestType=deleteGroup&groupid="+groupid+"&groupname="+groupname;
	htmlobj=$.ajax({url:path,async:false});
	
	if(htmlobj.responseText == 1){
	alert("Deleted successfully");	
	var tbl = document.getElementById("tblItem");	 
	var binCount	=	tbl.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
			tbl.deleteRow(loop);
			binCount--;
			loop--;
	}
	loadCombo("select matItemGroupId,matItemGroupName from matitemgroup ORDER BY matItemGroupName",'cmbGroup');	
    document.frmItemGroup.reset();
	}
   }
}

function clearItemGroup()
{
	document.frmItemGroup.reset();
	document.getElementById('cmbMainCat').focus();
	getItemDetails();
}