// JavaScript Document
var xmlHttp;
var xmlHttp1 		= [];
var pub_intxmlHttp_count=0;

function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function ConfirmInvoicePrice(POno, POYear,GRNNo,GRNyear)
{
	var tblPOdet = document.getElementById('poDetails');
	pub_intxmlHttp_count = tblPOdet.rows.length-1;
	
	for(var loop=1;loop<tblPOdet.rows.length;loop++)
		{
			var row = tblPOdet.rows[loop];
			
			//alert();
			
			createXMLHttpRequest1(loop);
			xmlHttp1[loop].onreadystatechange=ConfirmPrice;
			xmlHttp1[loop].num = loop;
			xmlHttp1[loop].rowIndex = row.rowIndex;
			
			//alert(xmlHttp1[loop].num);
			var color1 = row.cells[3].lastChild.nodeValue;
		var url  = "POPriceConfrmMiddle.php?id=ConfirmInvoicePrice";
			url  += "&POno="+POno;
			url +="&POYear="+POYear;
			url +="&GRNNo="+GRNNo;
			url +="&GRNyear="+GRNyear;
			url += "&strStyleID="+row.cells[0].id;//URLEncode(row.cells[1].lastChild.nodeValue);
			url += "&strBuyerPOid="+URLEncode(row.cells[1].id);
			url += "&intMatDetailID="+row.cells[2].id;
			url += "&strColor="+URLEncode(color1);
			url += "&strUnit="+row.cells[4].lastChild.nodeValue;
			url += "&strSize="+URLEncode(row.cells[5].lastChild.nodeValue);
			url += "&dblQty="+row.cells[6].lastChild.nodeValue;
			url += "&POprice="+row.cells[7].lastChild.nodeValue;
			url += "&dblInvoicePrice="+row.cells[8].childNodes[0].value;
			
			//alert(url);
			xmlHttp1[loop].open("GET", url, true);
			xmlHttp1[loop].send(null);	
		}
}

function ConfirmPrice()
{
	if(xmlHttp1[this.num].readyState == 4) //this.index
    {
        if(xmlHttp1[this.num].status == 200) 
        {  
			 var text= xmlHttp1[this.num].responseText;
					 var status = text.split('->')[0];
					 var msg = text.split('->')[1];
					 
					 if(status=='error')
					 {
						//rollback();
						alert(msg);	
						//closeWaitingWindow();
					 }
					 else
					 {
						// commit();
						pub_intxmlHttp_count=pub_intxmlHttp_count-1;
						if (pub_intxmlHttp_count ==0)
						{
							alert("Saved Successfully.");
						}
					 }
		}
	}
}