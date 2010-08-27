$(document).ready(function() {
    
    // Expand Panel
    $("#open, #contactme").click(function(e){
        e.preventDefault();
        $("div#panel").slideDown("slow");   
    }); 
    
    // Collapse Panel
    $("#close").click(function(e){
        e.preventDefault();
        $("div#panel").slideUp("slow"); 
        $("#contact_response").html('');
    });     
    
    // Switch buttons from "Log In | Register" to "Close Panel" on click
    $("#pulldown a, #contactme").click(function (e) {
        e.preventDefault();
        $("#pulldown a").toggle();
    }); 

    // jquery Cycle calls
    if ( $.fn.cycle ) {
      $('#stack').cycle( {
        pager: '#pager',
        pagerAnchorBuilder: function(idx, slide) {
          return '<li><a href="#">' + slide.title + '</a></li>';
        }
      });
    }

    var contact = {
      validate: function () {
       // Validate Form
        var emailRegEx = /^([A-Za-z0-9_\-\.\+])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var email = $('#email').val();
        if(emailRegEx.test(email) == true)
            return true;
        return false;
      }
    }

    // Handle Contact Form
    $("#comment_submit").click(function (e) {
        e.preventDefault();
        if(contact.validate()) {
          $.post('/php/send-email.php',
            $('#contact form').serialize() + "&action=send",
            function (response) {
              if ($.trim(response) == 'OK') {
                $(':input', '#contact form')
                  .not(':button')
                  .val('');
                $('#contact_response')
                  .html("Thank you for your comment!")
                  .css("color","white");
              }
              else {
                $('#contact_response')
                  .html("Whoops, something went wrong")
                  .css("color", "red");
              }
            }
          );
        }
        else {
          $('#contact_response')
            .html("Email Address Invalid")
            .css("color", "red");
        }
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

