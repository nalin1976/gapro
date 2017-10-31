/*var xmlHttp[];
var boolPageLoad=true;
var intCount=0;
var i=1;

function saveDetails()
{
	while(i<=10){
		
		//boolPageLoad=true;
		
		//alert("Begin");
		GetXmlHttpObject(i);
		if (xmlHttp[i]==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 
		var url="db.php";
	
		xmlHttp[i].onreadystatechange=stateChanged;
		//alert("Loop");
		xmlHttp[i].open("GET",url,true);
		xmlHttp[i].send(null);
		
		i++;
		//alert(intCount);
		
		

	}
} 

function stateChanged() 
{ 

var intx=0;

if (xmlHttp[this.index].readyState==4 || xmlHttp[this.index].readyState=="complete")
 { 
 	//if (boolPageLoad){
		intCount = xmlHttp.responseText;
		//alert(xmlHttp.index );
		document.getElementById("all").innerHTML=intCount;
		document.getElementById("notcompleted").innerHTML=intCount;
		document.getElementById("completed").innerHTML=0;
		document.getElementById("search").innerHTML="";
		
		//alert("state changed");
		//boolPageLoad=false;
		
	//}
		//setTimeout("stateChanged()",1000);
		
///*		for(intx=1;intCount>=intx;intx++){
//			
//			document.getElementById("completed").innerHTML=intx;
//			document.getElementById("notcompleted").innerHTML=intCount-intx;
//			
//			//alert(intx+" Done");
//		//

 } 
}


function GetXmlHttpObject(index)
{
var xmlHttp[index]=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp[index]=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp[index]=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp[index]=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
}
*/

// ===================================================================================================================================


var xmlHttp = [];
var count 	= 0;
var intMax = 10;


function saveDetails()
{    
		document.getElementById("butLoading").style.visibility = "visible";//visible
		createXMLHttpRequest(1);
		xmlHttp[1].onreadystatechange = HandleRequest;
		xmlHttp[1].index = 1;
		xmlHttp[1].open("GET", 'new_DB.php' , true);
		xmlHttp[1].send(null);

	
}

function getData()
{
	createXMLHttpRequest(0);
	 xmlHttp[0].onreadystatechange = HandleCountRequest;
			xmlHttp[0].open("GET", 'db_count.php', true);
			document.getElementById("all").innerHTML=0;
			document.getElementById("completed").innerHTML=0;
		xmlHttp[0].send(null);
}

function HandleCountRequest()
{	
    if(xmlHttp[0].readyState == 4) 
    {
        if(xmlHttp[0].status == 200) 
        {  
			intMax = parseInt(xmlHttp[0].responseText);
			//alert(intMax);
			document.getElementById("all").innerHTML=intMax;
			document.getElementById("search").innerHTML="";
			if(intMax>0)
			{
				saveDetails();
			}
			else
			{
				saveDetails();
				document.getElementById("search").innerHTML="Record Not Found";
				document.getElementById("butLoading").style.visibility = "hidden";//visible
			}
			
				
		}
	}
	
}

function HandleRequest()
{	

    if(xmlHttp[this.index].readyState == 4) 
    {
        if(xmlHttp[this.index].status == 200) 
        {  
			//alert("not");
			document.getElementById("butLoading").style.visibility = "hidden";
			var count = xmlHttp[this.index].responseText;
			//alert(count);
			var arr	  = count.split("<---->");
			if (arr[2] > 0)
			{
				//getData();
			}
			//alert(count);
			//if (this.index == 0) intMax=count;
					if (count > 0)
					{
						document.getElementById("all").innerHTML=parseInt(document.getElementById("all").innerHTML)-count;
					    document.getElementById("completed").innerHTML=parseInt(document.getElementById("completed").innerHTML)+parseInt(count);
						saveDetails();
					}
					else{
						document.getElementById("imgContinue").style.visibility = "visible";
						document.getElementById("txtHint").innerHTML=  arr[2]; 
						document.getElementById("completed").innerHTML=  parseInt(document.getElementById("completed").innerHTML)+parseInt(arr[0]); 
						document.getElementById("notcompleted").innerHTML= '1'; 
						document.getElementById("imgContinue").index	= arr[1];
						document.getElementById("all").innerHTML=parseInt(document.getElementById("all").innerHTML)-arr[0];
					}
					//document.getElementById("errMessage").innerHTML=count;
					
					//break;
					//errMessage

					//****** for get output string....
					//document.getElementById("notcompleted").innerHTML= document.getElementById("notcompleted").innerHTML + count; 
					
		}
	}
	
}

function passError(id)
{
	document.getElementById("imgContinue").style.visibility = "hidden";//txtHint
		document.getElementById("txtHint").innerHTML = '';
		createXMLHttpRequest(2);
	 	xmlHttp[2].onreadystatechange = updateRequest;
			xmlHttp[2].open("GET", 'updateQuery.php?queryID='+id, true);
			//document.getElementById("all").innerHTML=0;
			document.getElementById("completed").innerHTML=0;
		xmlHttp[2].send(null);
}
function updateRequest()
{
	if(xmlHttp[2].readyState == 4) 
    {
        if(xmlHttp[2].status == 200) 
        {  
			var x = parseInt(xmlHttp[2].responseText);
			//document.frmBuyers.submit();		
			saveDetails();
		}	
	}
}
function IsNumeric(sText)

{
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }


function createXMLHttpRequest(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

