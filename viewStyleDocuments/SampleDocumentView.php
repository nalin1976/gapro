<?php
$fpath   = $_GET['img'];
$styleid = $_GET['styleid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sample Document View</title>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<style type="text/css">
{
    margin:1;
    -webkit-user-select: none;
    font-family: Georgia, sans-serif;
}
canvas{
    cursor:auto;
	
    border:black solid 1px;
 }
#clr div{
    cursor: pointer;
    cursor:hand;
    width:20px;
    height:20px;
    float:left;
}

</style>
<script>
$(document).ready(function() {
        var draw= false;
       
        var canvas = document.getElementById("can");
        var ctx = canvas.getContext("2d");
        ctx.strokeStyle = 'red';
		ctx.strokeStyle.bold();

        //set it true on mousedown
        $("#can").mousedown(function(){draw=true;});

        //reset it on mouseup
        $("#can").mouseup(function(){draw=false;});

        $("#can").mousemove(function(e) {
            if(draw==true){
                    ctx.lineWidth = 3;
                    ctx.lineCap = "round";
                    ctx.beginPath();
                    ctx.moveTo(e.pageX-10,e.pageY-9);
                    ctx.lineTo(e.pageX-10,e.pageY-9);
					ctx.fillStyle.bold();
                    ctx.stroke();
					
            }    
       });

        
       //code for color pallete
        $("#clr > div").click(
        function(){
               ctx.strokeStyle = $(this).css("background-color");
        });
     
        //Eraser
        $("#eraser").click(function(){
        ctx.strokeStyle = '#fff';
        });

        //Code for save the image
        $("#save").click(function(){ 
            $("#result").append("<br /><br /><img src="+canvas.toDataURL()+" /><br /><a href="+canvas.toDataURL()+" target='_blank'>show</a>");
});
$("#clear").click(function(){
                 ctx.fillStyle = "#fff";
                 ctx.fillRect(0, 0, canvas.width, canvas.height);
                 ctx.strokeStyle = "red";
                 ctx.fillStyle = "red";
            }
            );
});
 
			
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div style="background-image: url(../styleDocument/<?php echo $styleid;?>/Sketch/<?php echo $fpath;?>); height: 590px; width: 700px; border: 1px solid black;">
<canvas id="can" width="700" height="590" ></canvas>
</div> 
<div id="clr"> 
<div style="background-color:black;"></div> 
<div style="background-color:red;"></div> 
<div style="background-color:green;"></div> 
<div style="background-color:orange;"> </div> ... 
</div> 
 <a id="save" href="#">Done</a> <a id="eraser" href="#">Eraser</a> <span id="result" ></span>

</body>
</html>
