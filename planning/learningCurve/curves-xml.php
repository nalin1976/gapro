<?php
 session_start();
 include "../../Connector.php";
 $intCompanyId		=$_SESSION["FactoryID"];
 

$id = $_GET["id"];

if($id=='curveDetails')
{
	$curveId = $_GET["curveId"];
	
		$sql="	SELECT
				*
				FROM
				plan_learningcurveheader
				Inner Join plan_learningcurvedetails ON plan_learningcurveheader.id = plan_learningcurvedetails.id
				WHERE
				plan_learningcurveheader.id =  '$curveId' AND
				intCompanyId =  '$intCompanyId'";
		//echo $sql;		
		$result = $db->RunQuery($sql);
		$text = " <table  width=\"400\" height=\"20\" cellpadding=\"0\" cellspacing=\"0\" class=\"normalfnt\" id=\"tblCurve\">
						  <tr >
						  	<td height=\"10\" colspan=\"4\" class=\"backcolorGreen\" align=\"center\"><b>Curve List</b></td>
						  </tr>
						  <tr>
                              <td width=\"60\"  class=\"grid_raw\"><b>Del</b></td>
                              <td width=\"171\"  class=\"grid_raw\"><b>Day No</b></td>  
                              <td width=\"167\"  class=\"grid_raw\"><b>Efficency</b></td>
                            </tr>
						  ";
		while($row = mysql_fetch_array($result))
		{
			$text.="<tr>
					  <td align=\"center\" valign=\"middle\" class=\"normalfntMid\" onclick=\"removeRow(this);\"><div align=\"center\"><img  src=\"../../images/del.png\" /></div></td>
					  <td class=\"normalfntMid\">".$row["intCurveDay"]."</td>
					  <td class=\"normalfntMid\" onclick=\"loadTextBox(this);\" onKeyPress=\"return enter(event,this)\">".$row["dblEfficency"]."</td>
					</tr>";
		}
		
			$text.="</table>";
			
			echo $text;
							
}

if($id=='checkAvailability')
{
 	$cboCurve = $_GET["cboCurve"];
			$sql="SELECT * FROM plan_learningcurve
				WHERE
				plan_learningcurve.strCurve =  '$cboCurve' AND
				plan_learningcurve.intCompanyId =  '$intCompanyId'";
		//echo $sql;		
		$result = $db->RunQuery($sql);
		
  if(mysql_num_rows($result)) 
  {
   echo "1";
  }else{
   echo "0";
  }
}
?>