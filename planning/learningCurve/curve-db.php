<?php
session_start();


include "../../Connector.php";
$intCompanyId		=$_SESSION["FactoryID"];

$id=$_GET["id"];

if($id=="deleteCurve"){

    $cboCurve    	= $_GET["cboCurve"];
	$delSQL1 = "DELETE from plan_learningcurvedetails
	WHERE id=$cboCurve";
	echo $delSQL1;
	$delResult1 = $db->RunQuery($delSQL1);
	
	$delSQL2 = "DELETE from plan_learningcurveheader
	WHERE id= $cboCurve";
	//echo $delSQL2;
	$delResult2 = $db->RunQuery($delSQL2);
	

		if ($delResult2==1)
			echo $delResult2;
		else
		{
			/////// sending error emails to my mail /////////////////////////
			//$_GET["body"]= $SQL;
//			include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
			echo "Saving-Error1";
			
		}
}


if($id=="saveCurve")
{
		
	$curveId   	= $_GET["curveId"];
	$curveName	= $_GET["curveName"];
	//$eff		= array($_GET['values']);
	$eff		= split(',',$_GET['values']);
	
	//echo $eff;
	
	$sql = "delete from plan_learningcurvedetails  where id=$curveId ";
	$result = $db->RunQuery($sql);
	
	//$sql = "delete from plan_learningcurveheader where id=$curveId and intCompanyId=$intCompanyId";
	//$result = $db->RunQuery($sql);

	if($curveId=='')
	{
		$sql = "insert into plan_learningcurveheader(strCurveName,intCompanyId) values('$curveName','$intCompanyId')";
		$curveId = $db->AutoIncrementExecuteQuery($sql);
	}

	for($i=0;$i<count($eff);$i++)
	{
		$n = $i+1;
		$sql = "insert into plan_learningcurvedetails(id,intCurveDay,dblEfficency) values('$curveId','$n','$eff[$i]')";
		$result = $db->RunQuery($sql);
	}
			
	echo 'Saved Successfully.';
}
?>
