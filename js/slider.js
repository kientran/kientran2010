$(document).ready(function() {
    
    // Expand Panel
    $("#open").click(function(){
        $("div#panel").slideDown("slow");   
        //$("div#pulldown").css("background", "#031740");
    }); 
    
    // Collapse Panel
    $("#close").click(function(){
        $("div#panel").slideUp("slow"); 
        //$("div#pulldown").css("background", "#010d26");
    });     
    
    // Switch buttons from "Log In | Register" to "Close Panel" on click
    $("#pulldown a").click(function () {
        $("#pulldown a").toggle();
    }); 
        
});

