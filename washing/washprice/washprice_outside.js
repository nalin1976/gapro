// JavaScript Document
function loadWashPriceTypeData(obj){
	if(obj.value==0){
		clearDryProcessData();
		loadPoInHouse();
	}
	else{
		clearDryProcessData();
		loadPoOutSide();
	}
}

function loadPoOutSide(){
	var sql="select distinct wopo.intId,wopo.intPoNo from  was_oustside_issuedtowash woi inner join was_outsidepo wopo on wopo.intId=woi.intPoNo and woi.intPoNo not in(SELECT was_washpriceheader.intStyleId FROM was_washpriceheader) order by wopo.intPOno;";
	var control="cboPoNo";
	loadCombo(sql,control);

}

function loadPoInHouse(){
	var sql="SELECT DISTINCT orders.intStyleId,orders.strOrderNo FROM was_issuedtowashheader Inner Join orders ON was_issuedtowashheader.intStyleNo = orders.intStyleId WHERE orders.intStyleId  NOT IN ( SELECT orders.intStyleId FROM  orders INNER JOIN was_washpriceheader ON orders.intStyleId = was_washpriceheader.intStyleId) order by orders.strOrderNo;";
	var control="cboPoNo";
	loadCombo(sql,control);

}

function loadOutSideWashPriceData(){
	var path="washPriceOutSideXml.php?req=loadOutSideWashPriceDet&po="+document.getElementById('cboPoNo').value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLStyle		=	htmlobj.responseXML.getElementsByTagName('Style');
	var XMLStyleDes		=	htmlobj.responseXML.getElementsByTagName('StyleDes');
	var XMLColor		=	htmlobj.responseXML.getElementsByTagName('Color');
	var XMLFactory		=	htmlobj.responseXML.getElementsByTagName('Factory');
	var XMLGarment		=	htmlobj.responseXML.getElementsByTagName('Garment');
	var XMLFabricDes	=	htmlobj.responseXML.getElementsByTagName('FabricDsc');
	var XMLWashType		=	htmlobj.responseXML.getElementsByTagName('WashType');
	
	var opt = document.createElement("option");
		opt.value 	= XMLStyle[0].childNodes[0].nodeValue;	
		opt.text 	= XMLStyleDes[0].childNodes[0].nodeValue;	
		document.getElementById("cboStyleName").options.add(opt);
		
	document.getElementById('txtStyleNo').value=XMLStyle[0].childNodes[0].nodeValue;
	
	var opt = document.createElement("option");
		opt.value 	= XMLColor[0].childNodes[0].nodeValue;	
		opt.text 	= XMLColor[0].childNodes[0].nodeValue;	
		document.getElementById("cboColor").options.add(opt);

	
	document.getElementById('txtFabricDes').value=XMLFabricDes[0].childNodes[0].nodeValue;
	document.getElementById('txtFactory').value=XMLFactory[0].childNodes[0].nodeValue;
	document.getElementById('cboGmtType').value=XMLGarment[0].childNodes[0].nodeValue;
	document.getElementById('cboWashType').value=XMLWashType[0].childNodes[0].nodeValue;
}