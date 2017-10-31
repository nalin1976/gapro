<?php
	$backwardseperator ='../';
	include "../Connector.php";
	
	$styleid           = $_POST["cboOrderNo"];
	$description       = $_POST["txtDescription"];
	$designer          = $_POST["txtDesigner"];
	$date              = $_POST["txtdate"];
	$customer          = $_POST["lblcust"];
	$size              = $_POST["txtsize"];
	$fabricSupplier    = $_POST["lblsuppl"];
	$quality           = $_POST["txtquality"];
	$price             = $_POST["txtprice"];
	$composition       = $_POST["txtcomposition"];
	$lining            = $_POST["txtlining"];
	$button            = $_POST["txtbutton"];
	$zip               = $_POST["txtzip"];
	$additionaldetails = $_POST["txtaradditional"];
	
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sample Definition Report - Gapro GSL</title>


<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="SampleDefinitionJS.js"></script>
<script src="../javascript/script.js" type="text/javascript"></script>

<style type="text/css">
	.style_border{height:auto; padding-bottom:5px;  border:1px solid #cccccc;}
	.style_border2{height:auto; padding-bottom:5px;  margin-top:1px; border:1px solid #cccccc;}
	.style_border3{height:96px; margin-top:1px; border:1px solid #cccccc; }
	.style_border5{height:35px;  border:1px solid #cccccc;}
	.style_border4{height:35px;  border:1px solid #cccccc;}
	.style_borderBlank{height:15px;  margin-top:1px; border:1px solid #cccccc;}
</style>

</head>

<body>
                              

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"></td>
  </tr>
  <tr>
  	<td width="100%"><?php include '../reportHeader.php'?></td>
  </tr>
</table>
<div>
 
	<div align="center">
    
		<div class="trans_layoutLayout" style="padding-bottom:20px;">
        
			<div class="trans_text"><h3>Style Definition Report</h3></div>
		  
            <table border="0">
				<tr>
					<td> 
                    
						<div style="float:left; padding:1px; width:800px; height:600px; border:1px solid #cccccc;">
							<div class="style_border5" style="float:left; width:230px;">
							  <label class="normalfnt" style="margin-left:2px;">Style No :</label> 
							  <label><?php echo $styleid;?></label>
							</div>
							<div class="style_border4" style="float:left; margin-left:1px; width:565px;">
								<label class="normalfnt" style="margin-left:2px;">Description :</label>
								
									<label><?php echo $description;?></label>
								
							</div>
                           
                            
							<div style="margin-left:1px; margin-top:43px; height:550px; border:1px solid #cccccc; width:796px;">
                            
       
       
                            
                            <div style="margin-left:1px;  height:550px; border:1px solid #cccccc; width:796px;">
  <div id="canvasDiv"></div>                          
                      
 
                              <?php
			if($styleid!="")
			{	
				$filePath='../styleDocument/'.$styleid.'/Sketch/'; 
				
				$dir = opendir($filePath); 
				
				while ($file = readdir($dir)) 
				{ 
  					if (eregi("(.+\.jpg)|(.+\.JPG)|(.+\.jpeg)|(.+\.JPEG)|(.+\.gif)|(.+\.GIF)|(.+\.bmp)|(.+\.BMP)|(.+\.png)|(.+\.PNG)",$file)) 
					{ 
    					
  					
			?>
            
            	<div class="pd_hold">
                
                      			<!--<div id="clr"> 
									<div style="background-color:black;"></div> 
									<div style="background-color:red;"></div> 
									<div style="background-color:green;"></div> 
									<div style="background-color:orange;"> </div> 
								</div> -->
                                <!--<canvas id="can" width="298" height="300"></canvas>-->
                            
                <img class="mainImage" id="imgid" name="<?php echo $file; $currentfile=$file;?>" align="middle" width="795" height="550" src="<?php echo $filePath."".$file;?>" alt=""/>&nbsp;&nbsp;<br />
            	</div>
            
            <?php 
					}
				}
			}
			?>
                            </div>
                            
                            </div>
                                
							</div>
                            	
                        <td>    	
			
						<div style="float:left; padding:1px; width:230px; height:600px; margin-left:1px; border:1px solid #cccccc;">
						  
                          <div class="style_border">
					    <label class="normalfnt" style="margin-left:2px;">Designer :</label>
							
									<label><?php echo $designer;?></label>
								
							</div><div class="style_borderBlank"></div>
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Date :</label>
								
									<label><?php echo $date;?></label>
								
							</div><div class="style_borderBlank"></div>
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Customer :</label>
								
									<label><?php echo $customer;?></label>
								
							</div>
							<div class="style_borderBlank">
							  
						  </div>
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Size :</label>
								
									<label><?php echo $size;?></label>
								
							</div><div class="style_borderBlank"></div>
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Fabric Supplier :</label>
								
									<label><?php echo $fabricSupplier;?></label>
								
							</div>
							<div class="style_borderBlank"></div>
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Quality :</label>	
								
									<label><?php echo $quality;?></label>
								
							</div><div class="style_borderBlank"></div>
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Price :</label>
								
									<label><?php echo $price;?></label>
								
							</div><div class="style_borderBlank"></div>
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Composition :</label>
								
									<label><?php echo $composition;?></label>
								
							</div><div class="style_borderBlank"></div>
							
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Lining :</label>
								
									<label><?php echo $lining;?></label>
								
							</div><div class="style_borderBlank"></div>
							
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Button :</label>
								
									<label><?php echo $button;?></label>
								
							</div><div class="style_borderBlank"></div>
							<div class="style_border2">
								<label class="normalfnt" style="margin-left:2px;">Zip :</label>
								
									<label><?php echo $zip;?></label>
								
							</div><div class="style_borderBlank"></div>
						
							<div class="style_border3"><label class="normalfnt" style="margin-left:2px;">Additional Details :</label>
                            <label><?php echo $additionaldetails;?></label>
                            </div>
                            
						</div>
                        </td>
					</td>
				</tr>
			</table>
            <table>
             		<tr>
                      <td width="10%">
                      			
                      </td>
                      <td width="10%">&nbsp;</td>
                      
                      <td width="10%"></td>
                      <td width="10%"></td>
                      <td width="10%">&nbsp;</td>
					          <td width="10%" class="normalfnt"></td>
                      <td width="10%" id="td_coDelete"><a href="../main.php"></a></td>
                      <td width="50%">&nbsp;</td>
                     
              </tr>
          </table>
		</div>
        
	</div>
</div>

</body>
</html>