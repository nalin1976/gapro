var xmlHttp				= [];

function createXMLHttpRequest(index){
	if (window.ActiveXObject) 
	{
		xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp[index] = new XMLHttpRequest();
	}
}

function RomoveData(data){
	var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}

function ClearForm()
{	
	setTimeout("location.reload(true);",0);
}

function LoadSubCategory(){		
	var MainCatID =document.getElementById('cboMainCat').value;
	createXMLHttpRequest(1);
	RomoveData('cboMatSubCat')
	xmlHttp[1].onreadystatechange=LoadBuyerPoNoRequest;
	xmlHttp[1].open("GET",'ageanalysisreportxml.php?RequestType=LoadSubCategory&MainCatID=' + MainCatID ,true);
	xmlHttp[1].send(null);
}
	function LoadBuyerPoNoRequest(){
		if (xmlHttp[1].readyState==4){
			if (xmlHttp[1].status==200){
				
						var opt = document.createElement("option");
						opt.text ="";
						document.getElementById("cboMatSubCat").options.add(opt);
						
				var XMLSubCatNo =xmlHttp[1].responseXML.getElementsByTagName('SubCatNo');
				var XMLCatName =xmlHttp[1].responseXML.getElementsByTagName('CatName');
				
					for ( var loop = 0; loop < XMLSubCatNo.length; loop ++){							
						var opt = document.createElement("option");
						opt.text = XMLCatName[loop].childNodes[0].nodeValue;	
						opt.value = XMLSubCatNo[loop].childNodes[0].nodeValue;						
						document.getElementById('cboMatSubCat').options.add(opt);						
			 		}
			}
		}
	}
	
function LoadMatDescription(){		
	var MainCatID =document.getElementById('cboMainCat').value;
	var MatSubCatID =document.getElementById('cboMatSubCat').value;
	
	RomoveData('cboMatDescription')
	
	createXMLHttpRequest(2);	
	xmlHttp[2].onreadystatechange=LoadMatDescriptionRequest;
	xmlHttp[2].open("GET",'ageanalysisreportxml.php?RequestType=LoadMatDescription&MainCatID=' + MainCatID+ '&MatSubCatID=' +MatSubCatID ,true);
	xmlHttp[2].send(null);
}
	function LoadMatDescriptionRequest(){
		if (xmlHttp[2].readyState==4){
			if (xmlHttp[2].status==200){
						var opt = document.createElement("option");
						opt.text ="";
						document.getElementById("cboMatDescription").options.add(opt);
						
				var XMLMatDetaiID =xmlHttp[2].responseXML.getElementsByTagName('MatDetaiID');
				var XMLItemDescription =xmlHttp[2].responseXML.getElementsByTagName('ItemDescription');
				
					for ( var loop = 0; loop < XMLMatDetaiID.length; loop ++){							
						var opt = document.createElement("option");
						opt.text = XMLItemDescription[loop].childNodes[0].nodeValue;	
						opt.value = XMLMatDetaiID[loop].childNodes[0].nodeValue;						
						document.getElementById('cboMatDescription').options.add(opt);						
			 		}
			}
		}
	}
	
function ViewReport()
{	
	var MainId			= document.getElementById('cboMainCat').value;
	var SubCatID		= document.getElementById('cboMatSubCat').value;
	var MatDetaiID		= document.getElementById('cboMatDescription').value;
	var Color			= document.getElementById('cboColor').options[document.getElementById('cboColor').selectedIndex].text;
	var Size			= document.getElementById('cboSize').options[document.getElementById('cboSize').selectedIndex].text;
	var CompanyId		= document.getElementById('cboCompany').value;
	
	if(MainId!=""){			
		newwindow=window.open('ageanalysisnote.php?MainId='+MainId+ '&SubCatID=' +SubCatID+ '&MatDetaiID=' +MatDetaiID+ '&Color=' +Color+ '&Size=' +Size+ '&CompanyId=' +CompanyId ,'name');
			if (window.focus) {newwindow.focus()}
	}
}