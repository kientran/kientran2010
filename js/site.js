$(document).ready(function() {
    
    // Expand Panel
    $("#open").click(function(e){
        e.preventDefault();
        $("div#panel").slideDown("slow");   
        //$("div#pulldown").css("background", "#031740");
    }); 
    
    // Collapse Panel
    $("#close").click(function(e){
        e.preventDefault();
        $("div#panel").slideUp("slow"); 
        //$("div#pulldown").css("background", "#010d26");
    });     
    
    // Switch buttons from "Log In | Register" to "Close Panel" on click
    $("#pulldown a").click(function (e) {
        e.preventDefault();
        $("#pulldown a").toggle();
    }); 
        
    // Fade Footer In

    $(window).scroll(function(){
//      var scrollTop = $(window).scrollTop();

      var position = ($(document).scrollTop() + $(window).height())
        - $(document).height();
      if(position != 0)
        $('#site_footer').stop().animate({'opacity':'0.0'},400);
      else    
        $('#site_footer').stop().animate({'opacity':'0.8'},400);
      });

    $('#site_footer').hover(
      function (e) {
        var position = ($(document).scrollTop() + $(window).height())
        - $(document).height();
        if(position != 0){
          $('#site_footer').stop().animate({'opacity':'0.8'},400);
        }
      },
        function (e) {
        var position = ($(document).scrollTop() + $(window).height())
        - $(document).height();
        if(scrollTop != 0){
          $('#site_footer').stop().animate({'opacity':'0.0'},400);
        }
      });


});

