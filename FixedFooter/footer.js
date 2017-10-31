$(window).bind("load", function() { 

	   //setup the height and position for your sticky footer
        	footerHeight = 0,
           footerTop = 0,
           $footer = $("#footer");

       positionFooter();

       function positionFooter() {

                footerHeight = $footer.height();
                footerTop = ($(window).scrollTop()+$(window).height()-footerHeight)+"px";

              // if ( ($(document.body).height()+footerHeight) < $(window).height()) {
                   $footer.css({
                        position: "absolute",
						 top: footerTop
                   })
				   
				   /*.animate({
                        top: footerTop,
						duration: 0

						
                   })
               } else {
                   $footer.css({
                        position: "static"
						//z-index:100;
                   })
               }*/

       }

       $(window)
               .scroll(positionFooter)
               .resize(positionFooter)

})