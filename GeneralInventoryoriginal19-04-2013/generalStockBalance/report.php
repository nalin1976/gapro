<?php
 session_start();
 $backwardseperator = "../../";
include "../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Stock Balance-Summery Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->

</style>
</head>
<body>
<table width="900" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../../reportHeader.php";?></td>

              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  


  <tr>
    <td colspan="5" style="text-align:center">


<table width="100%" border='1' cellpadding="3" cellspacing="0" rules="all">

	   <?php

 $cboMainCat = $_GET['cboMainCat']; 
 $cboSubCat  = $_GET['cboSubCat']; 
 $cboMatItem = $_GET['cboMatItem']; 
 $cboCompany = $_GET['cboCompany'];
 $bal        = $_GET['bal']; 
 $status1 = 0;	
 $status2 = 0;	
 $status3 = 0;	
 $status4 = 0;
 if($cboMainCat != "" || $cboSubCat != "" || $cboMatItem != ""){
     $sql1 = "SELECT 	
			genmatmaincategory.strDescription,
			genmatsubcategory.StrCatName,
			genmatitemlist.strItemDescription,
			SUM(genstocktransactions.dblQty)AS dblQty
			FROM
			genmatmaincategory
			Inner Join genmatsubcategory ON genmatmaincategory.intID = genmatsubcategory.intCatNo
			Inner Join genmatitemlist ON genmatitemlist.intMainCatID = genmatmaincategory.intID AND genmatitemlist.intSubCatID = genmatsubcategory.intSubCatNo
			Inner Join genstocktransactions ON genmatitemlist.intItemSerial = genstocktransactions.intMatDetailId
			left Join companies ON genstocktransactions.strMainStoresID = companies.intCompanyID";
		
			
	if($cboMainCat != "" AND $cboSubCat != "" AND $cboMatItem != "" AND $cboCompany != ""){		
	 $sql1 .= " WHERE genmatmaincategory.intID = '$cboMainCat' AND genmatsubcategory.intSubCatNo = '$cboSubCat' AND genmatitemlist.intItemSerial = '$cboMatItem' AND                genstocktransactions.strMainStoresID = '$cboCompany'";
	 $status4 = 1;		
	 }	
	 		
	 if($cboMainCat != "" AND $cboSubCat != "" AND $cboMatItem != ""){	
	 if($status4 == 0)		
	 $sql1 .= " WHERE genmatmaincategory.intID = '$cboMainCat' AND genmatsubcategory.intSubCatNo = '$cboSubCat' AND genmatitemlist.intItemSerial = '$cboMatItem'";
	 $status3 = 1;		
	 }		
	 
	 if($cboMainCat != "" AND $cboSubCat != ""){	
	 if($status3 == 0)	
	 $sql1 .= " WHERE genmatmaincategory.intID = '$cboMainCat' AND genmatsubcategory.intSubCatNo = '$cboSubCat'";
	 $status2 = 1;		
	 }
	 
	 		
	 if($cboMainCat != ""){
	 if($status2 == 0 AND $status3 == 0 AND $status4 == 0)		
	 $sql1 .= " WHERE genmatmaincategory.intID = '$cboMainCat'";	
	 }
	 
	 if($cboSubCat != ""){
	 if($status2 == 0 AND $status3 == 0 AND $status4 == 0)		
	 $sql1 .= " WHERE genmatsubcategory.intSubCatNo = '$cboSubCat'";		
	 }
	 
	 if($cboMatItem != ""){	
	 if($status2 == 0 AND $status3 == 0 AND $status4 == 0)		
	 $sql1 .= " WHERE genmatitemlist.intItemSerial = '$cboMatItem'";		
	 }
			
	 $sql1 .= " GROUP BY	genstocktransactions.intMatDetailId ORDER BY genmatmaincategory.strDescription";	
	// echo $sql1;
		    $result1 = $db->RunQuery($sql1);
   $j=0;	
   if(mysql_num_rows($result1)){		
   while($fields = mysql_fetch_array($result1, MYSQL_BOTH)) 
   { 		
	$strDescriptionMainCat   = $fields['strDescription'];	
    $StrCatNameSubCat        = $fields['StrCatName'];
	$strItemDescriptionMat   = $fields['strItemDescription'];  
    $dblQty                  = $fields['dblQty'];	
	
   if($j == 0 )
   {	    
    echo "<br><table width='100%' border='0' align='center'>";
    echo "<tr align='center'>";
    echo "<td align='center'><font  style='font-size: 15px;'><b>General Stock Balance-Summery Report</font></b></td>";
    echo "</tr>";
    echo "</table>";
   
    echo "<br><table width='100%' border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >";
    echo "<tr align='center'>";
    echo "<td class='normalfntMid' width='1'>No</td>";
	echo "<td class='normalfntMid'>Main Category</td>";
	echo "<td class='normalfntMid'>Sub Category</td>";
    echo "<td class='normalfntMid'>Item Description</td>";
	echo "<td class='normalfntMid'>Qty</td>";
    echo "</tr>";   
   }
   //with and without 0 balance
   if($bal == 1){
    if( $dblQty != 0) {
     echo "<tr>";
     echo "<td class='normalfntMid'>".($j+1)."."."</td>"; 
	 echo "<td class='normalfnt'>$strDescriptionMainCat</td>";  
     echo "<td class='normalfnt'>$StrCatNameSubCat</td>";
     echo "<td class='normalfnt'>$strItemDescriptionMat</td>";
     echo "<td class='normalfntRite'>".number_format($dblQty,2)."</td>";     
     echo "</tr>";  
	 }
	 }else{
	 echo "<tr>";
     echo "<td class='normalfntMid'>".($j+1)."."."</td>"; 
	 echo "<td class='normalfnt'>$strDescriptionMainCat</td>";  
     echo "<td class='normalfnt'>$StrCatNameSubCat</td>";
     echo "<td class='normalfnt'>$strItemDescriptionMat</td>";
     echo "<td class='normalfntRite'>".number_format($dblQty,2)."</td>";     
     echo "</tr>";  
	 }
   $j++;	
  }
 }else{
     echo "<br><table width='100%' border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >";
    echo "<tr align='center'>";
    echo "<td class='normalfntMid' width='1'>No</td>";
	echo "<td class='normalfntMid'>Sub Category</td>";
    echo "<td class='normalfntMid'>Item Description</td>";
	echo "<td class='normalfntMid'>Qty</td>";
    echo "</tr>";    
   echo "</table>";
 }
}else{
	if($bal == 0){		
    $sql2 = "SELECT	
			genmatmaincategory.strDescription,
			genmatsubcategory.StrCatName,
			genmatitemlist.strItemDescription,
			SUM(genstocktransactions.dblQty)AS dblQty
			FROM
			genmatmaincategory
			left Join genmatsubcategory ON genmatmaincategory.intID = genmatsubcategory.intCatNo
			left Join genmatitemlist ON genmatitemlist.intMainCatID = genmatmaincategory.intID AND genmatitemlist.intSubCatID = genmatsubcategory.intSubCatNo
			left Join genstocktransactions ON genmatitemlist.intItemSerial = genstocktransactions.intMatDetailId
			left Join companies ON genstocktransactions.strMainStoresID = companies.intCompanyID";

	 if($cboCompany != ""){		
	 $sql2 .= " WHERE genstocktransactions.strMainStoresID = '$cboCompany'";		
	 }	
	$sql2 .= " GROUP BY genstocktransactions.intMatDetailId ORDER BY genmatmaincategory.strDescription";					
  	     
 // echo"$sql2<br>"; 
  $result2 = $db->RunQuery($sql2);
  
  if(mysql_num_rows($result2))
  {
   $flg_newpgyn  = ""; 
   $flg_firstyn  = "";
   $flg_newdocyn = "";
   $te_docmain   = ""; 
   
   $flg_newpgyn2  = ""; 
   $flg_firstyn2  = "";
   $flg_newconyn2 = "";
  	
   $totQty = 0;
   $totQtyHelp = 0;
   $j = 0;

   while($fields = mysql_fetch_array($result2, MYSQL_BOTH)) 
   { 
    $strDescriptionMainCat   = $fields['strDescription'];	
    $StrCatNameSubCat        = $fields['StrCatName'];
	$strItemDescriptionMat   = $fields['strItemDescription'];  
    $dblQty                  = $fields['dblQty'];
 
	  
    $te_totamt   += $dblQty;
    
   if($j == 0 )
   {	    
    echo "<br><table width='100%' border='0' align='center'>";
    echo "<tr align='center'>";
    echo "<td align='center'><font  style='font-size: 15px;'><b>General Stock Balance-Summery Report</font></b></td>";
    echo "</tr>";
    echo "</table>";
   
    echo "<br><table width='100%' border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >";
    echo "<tr align='center'>";
    echo "<td class='normalfntMid' width='1'>No</td>";
	echo "<td class='normalfntMid'>Sub Category</td>";
    echo "<td class='normalfntMid'>Item Description</td>";
	echo "<td class='normalfntMid'>Qty</td>";
    echo "</tr>";   
   }
           
   #---------------------------
    if($te_docmain != $strDescriptionMainCat)
    {
     $flg_newdocyn = "y";
    }
    else
    {
     $flg_newdocyn = "n";  
    }
    $te_docmain = $strDescriptionMainCat; 
        
    #---------------------------
    if( $te_docmain != $strDescriptionMainCat)
    {
     $flg_newconyn2 = "y";
    }
    else
    {
     $flg_newconyn2 = "n"; 
    }
         
    #---------------------------[ subtotal ]------------------------------
	/*
    if($flg_newdocyn== "y")
    {
 	 if($flg_firstyn  == "n")
	 {	  
      echo "<tr>";
	  echo "<td align='right' colspan=4 ><font  style='font-size: 15px;'>SUB TOTAL :</font></td>";    
	  echo "<td align='right' ><font  style='font-size: 15px;'>".number_format($totQty,2)."</font></td>";     
	  echo "<td align='right'><font  style='font-size: 15px;'>".number_format($totQtyHelp,2)."</font></td>";   
	  echo "<td align='right'width=''></td>"; 
      echo "</tr>";
      $totQty = 0;

     }	    
    }  */   
	
    if($flg_newdocyn== "y" || $flg_newpgyn == "y")
    {	 
     echo "<tr>";
     echo "<td colspan='7' class='normalfnt'><b>Main Category : $strDescriptionMainCat</td>";
     echo "</tr>"; 
	 }
    
     echo "<tr>";
     echo "<td class='normalfntMid'>".($j+1)."."."</td>";   
     echo "<td class='normalfnt'>$StrCatNameSubCat</td>";
     echo "<td class='normalfnt'>$strItemDescriptionMat</td>";
     echo "<td class='normalfntRite' width='50'>".number_format($dblQty,2)."</td>";     
     echo "</tr>";  

     $flg_firstyn  = "n";
     $flg_firstyn2 = "n";          
     $j++;    
   }//end while 
       
  
  }
  else
  {
    echo "<br><table width='100%' border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >";
    echo "<tr align='center'>";
    echo "<td class='normalfntMid' width='1'>No</td>";
	echo "<td class='normalfntMid'>Sub Category</td>";
    echo "<td class='normalfntMid'>Item Description</td>";
	echo "<td class='normalfntMid'>Qty</td>";
    echo "</tr>";    
   echo "</table>";
  }
  }
  
  if($bal ==1){
      $sql2 = "select * from(SELECT	
			genmatmaincategory.strDescription,
			genmatsubcategory.StrCatName,
			genmatitemlist.strItemDescription,
			SUM(genstocktransactions.dblQty)AS dblQty
			FROM
			genmatmaincategory
			left Join genmatsubcategory ON genmatmaincategory.intID = genmatsubcategory.intCatNo
			left Join genmatitemlist ON genmatitemlist.intMainCatID = genmatmaincategory.intID AND genmatitemlist.intSubCatID = genmatsubcategory.intSubCatNo
			left Join genstocktransactions ON genmatitemlist.intItemSerial = genstocktransactions.intMatDetailId
			left Join companies ON genstocktransactions.strMainStoresID = companies.intCompanyID ";

	 if($cboCompany != ""){		
	 $sql2 .= " WHERE genstocktransactions.strMainStoresID = '$cboCompany'";		
	 }	
	 
	$sql2 .= " GROUP BY genstocktransactions.intMatDetailId ORDER BY genmatmaincategory.strDescription ) as stock where stock.dblQty>0";					
  	     
  //echo"$sql2<br>"; 
  $result2 = $db->RunQuery($sql2);
  
  if(mysql_num_rows($result2))
  {
   $flg_newpgyn  = ""; 
   $flg_firstyn  = "";
   $flg_newdocyn = "";
   $te_docmain   = ""; 
   
   $flg_newpgyn2  = ""; 
   $flg_firstyn2  = "";
   $flg_newconyn2 = "";
  	
   $totQty = 0;
   $totQtyHelp = 0;
   $j = 0;

   while($fields = mysql_fetch_array($result2, MYSQL_BOTH)) 
   { 
    $strDescriptionMainCat   = $fields['strDescription'];	
    $StrCatNameSubCat        = $fields['StrCatName'];
	$strItemDescriptionMat   = $fields['strItemDescription'];  
    $dblQty                  = $fields['dblQty'];
 
	  
    $te_totamt   += $dblQty;
    
   if($j == 0 )
   {	    
    echo "<br><table width='100%' border='0' align='center'>";
    echo "<tr align='center'>";
    echo "<td align='center'><font  style='font-size: 15px;'><b>General Stock Balance-Summery Report</font></b></td>";
    echo "</tr>";
    echo "</table>";
   
    echo "<br><table width='100%' border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >";
    echo "<tr align='center'>";
    echo "<td class='normalfntMid' width='1'>No</td>";
	echo "<td class='normalfntMid'>Sub Category</td>";
    echo "<td class='normalfntMid'>Item Description</td>";
	echo "<td class='normalfntMid'>Qty</td>";
    echo "</tr>";   
   }
           
   #---------------------------
    if($te_docmain != $strDescriptionMainCat)
    {
     $flg_newdocyn = "y";
    }
    else
    {
     $flg_newdocyn = "n";  
    }
    $te_docmain = $strDescriptionMainCat; 
        
    #---------------------------
    if( $te_docmain != $strDescriptionMainCat)
    {
     $flg_newconyn2 = "y";
    }
    else
    {
     $flg_newconyn2 = "n"; 
    }
         
    #---------------------------[ subtotal ]------------------------------
	/*
    if($flg_newdocyn== "y")
    {
 	 if($flg_firstyn  == "n")
	 {	  
      echo "<tr>";
	  echo "<td align='right' colspan=4 ><font  style='font-size: 15px;'>SUB TOTAL :</font></td>";    
	  echo "<td align='right' ><font  style='font-size: 15px;'>".number_format($totQty,2)."</font></td>";     
	  echo "<td align='right'><font  style='font-size: 15px;'>".number_format($totQtyHelp,2)."</font></td>";   
	  echo "<td align='right'width=''></td>"; 
      echo "</tr>";
      $totQty = 0;

     }	    
    }  */   
	
    if($flg_newdocyn== "y" || $flg_newpgyn == "y")
    {	 
     echo "<tr>";
     echo "<td colspan='7' class='normalfnt'><b>Main Category : $strDescriptionMainCat</td>";
     echo "</tr>"; 
	 }
    
     echo "<tr>";
     echo "<td class='normalfntMid'>".($j+1)."."."</td>";   
     echo "<td class='normalfnt'>$StrCatNameSubCat</td>";
     echo "<td class='normalfnt'>$strItemDescriptionMat</td>";
     echo "<td class='normalfntRite' width='50'>".number_format($dblQty,2)."</td>";     
     echo "</tr>";  

     $flg_firstyn  = "n";
     $flg_firstyn2 = "n";          
     $j++;    
   }//end while 
       
  
  }
  else
  {
    echo "<br><table width='100%' border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >";
    echo "<tr align='center'>";
    echo "<td class='normalfntMid' width='1'>No</td>";
	echo "<td class='normalfntMid'>Sub Category</td>";
    echo "<td class='normalfntMid'>Item Description</td>";
	echo "<td class='normalfntMid'>Qty</td>";
    echo "</tr>";    
   echo "</table>";
  }
  }
  }
  /*
   echo "<br><table width='50%' border='0'>";
   echo "<tr class='lbl'>";
   echo"<td align='left' width='50%'> <font  size='3'><b>TOTAL S.M.V</font></td>";
   echo"<td align='left'> <font  size='3'><b>  ".number_format($te_totamt,2)."</b></font></td>";
   echo"</tr>";  
   echo "</table>";*/
?>
					
    </table></td>
  </tr>
  </table>
</body>
</html>
