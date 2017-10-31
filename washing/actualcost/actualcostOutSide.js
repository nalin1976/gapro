// JavaScript Document

function loadActCostTypeData(obj){
	if(obj.value==0){
		loadCompanyInHouse();
	}
	else{
		loadCompanyOutSide();
	}
}
function loadCompanyOutSide(){
	var controlc="cboCustomer";
	var controls="cboStyleId";
	var controlPo="cboOrderNo";
	
	var sqlc="select intCompanyID,strName from was_outside_companies where intStatus=1 order by strName;";
	loadCombo(sqlc,controlc);
	
	var sqls="SELECT DISTINCT was_outsidepo.strStyleNo,was_outsidepo.strStyleDes FROM was_oustside_issuedtowash Inner Join was_outsidepo ON was_oustside_issuedtowash.intPoNo = was_outsidepo.intId where was_oustside_issuedtowash.intPoNo not in (SELECT BCH.intStyleId From was_actualcostheader BCH WHERE (intStatus = 1));";
	loadCombo(sqls,controls);
	
	var sqlPo="SELECT DISTINCT was_outsidepo.intId,was_outsidepo.intPONo FROM was_oustside_issuedtowash  Inner Join was_outsidepo ON was_oustside_issuedtowash.intPoNo = was_outsidepo.intId where was_oustside_issuedtowash.intPoNo not in (SELECT BCH.intStyleId From was_actualcostheader BCH WHERE intStatus = 1);";
	loadCombo(sqlPo,controlPo);
	
}

function loadCompanyInHouse(){
	var controlc="cboCustomer";
	var controls="cboStyleId";
	var controlPo="cboOrderNo";
	
	var sqlc="select intCompanyID,strName from companies where intStatus=1 order by strName;";
	
	loadCombo(sqlc,controlc);
	var sqls="SELECT  DISTINCT O.strStyle,O.strStyle FROM   orders O INNER JOIN  was_washpriceheader WPH ON O.intStyleId = WPH.intStyleId WHERE   (O.intStyleId NOT IN (SELECT BCH.intStyleId From was_actualcostheader BCH WHERE (intStatus = 1)));";
	loadCombo(sqls,controls);
	
	var sqlPo="SELECT  DISTINCT O.intStyleId,O.strOrderNo FROM orders O INNER JOIN  was_washpriceheader WPH ON O.intStyleId = WPH.intStyleId WHERE (O.intStyleId NOT IN (SELECT BCH.intStyleId From was_actualcostheader BCH WHERE (intStatus = 1)));";
	loadCombo(sqlPo,controlPo);

}
