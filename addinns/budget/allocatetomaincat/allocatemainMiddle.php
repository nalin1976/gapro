<?php
require_once('../../../Connector.php');
$request=$_GET['req'];
	if ($request=="searchCategory")
	{
		$id=$_GET['id'];
		/*$htm="<thead><tr bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"><td width=\"33\" height=\"20\" class=\"grid_header\" >No</td><td width=\"368\" class=\"grid_header\" >Main Category </td><td width=\"197\" class=\"grid_header\" >Add GL</td></tr></thead>";*/
		
		$sql="select intID,strDescription from genmatmaincategory where status=1 AND strDescription like '%$id%' order by strDescription;";
		$result=$db->RunQuery($sql);
		$i=1;
		
		//$htm .="<tbody>";
		
		while($row=mysql_fetch_array($result))
		{
			if(($i%2)==1){$color='grid_raw';}else{$color='grid_raw2';}
			
			$htm .="<tr class=\"bcgcolor-tblrowWhite\" id=".$i." >";
			$htm .="<td class=".$color.">".$i."</td>";
			$htm .="<td style=\"width:300px;text-align:left;\" class=".$color.">".$row['strDescription']."</td>";
			$htm .="<td align=\"center\" class=".$color." id=".$row['intID'].">"."<img src=\"../../../images/additem2.png\" onclick=\"loadGLPopUp(this,event);\" style=\"cursor:pointer;\"/>";
			$htm .="</td></tr>";
			$i++;
		}
		//$htm.="</tbody>";
		echo $htm;
	}
	
	if ($request=="searchGLAcc")
	{
		$id			= $_GET['id'];
		$cboid		= $_GET['cboid'];
		$mainCat	= $_GET["MainCat"];
		$sql="select intGLAccID,strAccID,strDescription from glaccounts where intStatus=1 and $cboid like '%$id%' order by strDescription ";
		$result=$db->RunQuery($sql);
		$i=1;
		while($row=mysql_fetch_array($result))
		{
			if(($i%2)==1){$color='grid_raw';}else{$color='grid_raw2';}
			$req = CheckAvailable($mainCat,$row["intGLAccID"]);
			
			$htm .="<tr class=\"bcgcolor-tblrowWhite\" id=".$i." style=\"height:20px;cursor:pointer;\">";
			$htm .="<td class=".$color.">"."<input type=\"checkbox\" name=\"checkGL2\" id=\"checkGL2\" ".$req."/>"."</td>";
			$htm .="<td style=\"width:300px;text-align:left;\" class=".$color." id=".$row["intGLAccID"].">".$row['strAccID']."</td>";
			$htm .="<td class=".$color." style=\"width:10px;text-align:left\">".$row['strDescription']."</td>";
			$htm .="</tr>";
			$i++;
		}
		echo $htm;
	}
	
function CheckAvailable($mainCat,$glId)
{
global $db;
$checked = "";
	$sql="select intMatCatId,intGlId from budget_glallocationtomaincategory where intMatCatId='$mainCat' and intGlId ='$glId';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$checked = "checked=\"checked\"";
	}
	return $checked;
}
?>