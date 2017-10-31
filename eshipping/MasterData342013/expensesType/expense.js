var xmlHttp = [];

//<script ="../Bank/bank.js">

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


function ClearForm()
{


document.getElementById("txtExDesc").value = "";
document.getElementById("txtExType").value = "";


}


function doInsert(req,id)
{		
		var exid=id;
		var update=req;
		var exdesc=document.getElementById("txtExDesc").value;
		var extype=document.getElementById("txtExType").value ;
		
		
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
			
				alert(xmlHttp[0].responseText);
				setTimeout("location.reload(true);",100);	
				//updatetable(exid,exdesc,extype);
							
				}
		
		}		
		
		
		xmlHttp[0].open("GET",'expenseeditdb.php?DESC='+exdesc + '&ID=' +exid + '&REQUEST=' +update + '&TYPE=' +extype, true);
		xmlHttp[0].send(null);	
}


function saveData(id,no)
{
	
	if(validateForm())
		
	{	
			validatebd(id,no);
		
	}	
}


function validateForm()
	{
			
		if(document.getElementById("txtExDesc").value =="" )
			{
			alert("Please enter the description. ");
			document.getElementById("txtExDesc").focus();
			return false;
			}
			
		if(document.getElementById("txtExType").value =="" )
			{
			alert("Please enter the expensetype.");
			document.getElementById("txtExType").focus();
			return false;
			}
			
		
				
		else
			{
		
	
			return true;
			}
	}

	
	
function validatebd(idno,no)
{		
	var desc=	document.getElementById("txtExDesc").value;
	var type =	document.getElementById("txtExType").value;
	if (desc)
		{	
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'expensemiddle.php?request=checkdb&TYPE=' +type + '&DESC=' +desc + '&ID=' +idno,true);
		xmlHttp[0].send(null);
		}
		
	

}


function checkAvailability()
{
	if(xmlHttp[0].readyState == 4) 
	{
        if(xmlHttp[0].status == 200) 
        	{	
				 var res= xmlHttp[0].responseText;
				 if (res=="cant")
				 	{
						alert("Sorry! Record already exist. ")				 	
				 	}
				    
								 	
				else if (res=="insert")
				 	{	
				 		var req="insert";
						doInsert(req);					 	
				 	} 
				 	
				else
				 	{
						var ans=confirm("Record already exist, do you want to Update?");
						if (ans)
						{
							var req="update";
							
							doInsert(req,res);
						}
						 	
				 	} 
				    	  
				 		
      	}
    }	
}



function deleteData(id)
{
 	{ 
 	if(document.getElementById("txtExDesc").value!="")
 		{
		var exdesc=	document.getElementById("txtExDesc").value;
		var extype=	document.getElementById("txtExType").value;		
		var deleted = confirm("Are you sure you want to  delete '" +exdesc+ "'? \nexpensetype '" +extype+ "'");
 		
		if (deleted)		
			{
			var request="delete";
			
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
			if(xmlHttp[0].readyState == 4)
				{
				setTimeout("location.reload(true);",100);			
				alert(xmlHttp[0].responseText);	
				}
			}		
				xmlHttp[0].open("GET",'expenseeditdb.php?REQUEST=' +request +  '&ID=' +id , true);
				xmlHttp[0].send(null);	
		}	
			
		
	
		
	}				
}		
 
}

function editlist(expenseID,type,desc,no)
{	
	if(expenseID)
	{	
	createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
			if(xmlHttp[0].readyState == 4)
				{
				drawPopupArea(400,200,'expensewindow');	
				document.getElementById("expensewindow").innerHTML = xmlHttp[0].responseText;
				//alert(xmlHttp[0].responseText);
				document.getElementById("txtExDesc").value=desc;	
				document.getElementById("txtExType").value=type;
				document.getElementById("txtExType").value=type;		
				}
			}	
	}		
	else
	{
	
	createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
			if(xmlHttp[0].readyState == 4)
				{
				drawPopupArea(500,200,'expensewindow')	;
				document.getElementById("expensewindow").innerHTML = xmlHttp[0].responseText;
				}
			}	
	
	}			
			
				
				xmlHttp[0].open("GET",'popexpemse.php?&ID='+expenseID+ '&NO=' +no , true);
						
				xmlHttp[0].send(null);	
	
				
}


/*
function updatetable(exid)
{	
		var tbl = document.getElementById('tblExType');
   		//alert (tbl.rows.length);
   		
   		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
  		var rw = tbl.rows[loop];
  			alert(rw);
		  	var cel=	rw.cells[1].lastChild.nodeValue;	
			alert (cel);		  	
		  	
		/*
      var conPC = rw.cells[6].lastChild.nodeValue;
		var totalQty = parseInt(orderQty,10) * parseFloat(conPC,10);
		var cc = rw.cells[8].lastChild.nodeValue;
		rw.cells[8].lastChild.nodeValue = RoundNumbers(totalQty,4);
		var unitPrice = parseFloat(rw.cells[10].lastChild.nodeValue);
		var price = parseInt(orderQty,10) * parseFloat(conPC,10) * unitPrice;
		rw.cells[13].lastChild.nodeValue = RoundNumbers(price,4);
		var value = parseFloat(conPC) * unitPrice;
		rw.cells[14].lastChild.nodeValue = RoundNumbers(value,4);
	
	}
   	
   
}
*/