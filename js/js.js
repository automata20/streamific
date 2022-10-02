$(document).ready(function(){
   if (check=="signup") {
        // $('.register-info-box').fadeOut(); 
        // $('.login-info-box').fadeIn      
        $('.white-panel').addClass('right-log');
        $('.white-panel').addClass('auto');
        $('.register-show').addClass('show-log-panel');
        $('.login-show').removeClass('show-log-panel');
        $(".login-reg-panel").css("background-image","linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%)");
                
        $('.login-reg-panel input[type="radio"]').on('change', function() {
            if($('#log-login-show').is(':checked')) {
                $('.register-info-box').fadeOut(); 
                $('.login-info-box').fadeIn();
                
                $('.white-panel').addClass('right-log');
                $('.white-panel').addClass('auto');
                $('.register-show').addClass('show-log-panel');
                $('.login-show').removeClass('show-log-panel');
                $(".login-reg-panel").css("background-image","linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%)");
                
            }
            else if($('#log-reg-show').is(':checked')) {
                $('.register-info-box').fadeIn();
                $('.login-info-box').fadeOut();
                
                $('.white-panel').removeClass('right-log');
                $('.white-panel').removeClass('auto');
                $('.login-show').addClass('show-log-panel');
                $('.register-show').removeClass('show-log-panel');
                $(".login-reg-panel").css("background-image","linear-gradient(280deg, rgb(2, 0, 36) 0%, rgb(9, 9, 121) 35%, rgb(0, 161, 255) 100%)");
            }
        });
        
   }else{
        $('.login-info-box').fadeOut(); 
        $('.register-info-box').fadeIn();     
        $('.login-show').addClass('show-log-panel');
        $('.register-show').removeClass('show-log-panel');
        $(".login-reg-panel").css("background-image","linear-gradient(280deg, rgb(2, 0, 36) 0%, rgb(9, 9, 121) 35%, rgb(0, 161, 255) 100%)");
                
        $('.login-reg-panel input[type="radio"]').on('change', function() {
            if($('#log-login-show').is(':checked')) {
                $('.register-info-box').fadeOut(); 
                $('.login-info-box').fadeIn();
                
                $('.white-panel').addClass('right-log');
                $('.white-panel').addClass('auto');
                $('.register-show').addClass('show-log-panel');
                $('.login-show').removeClass('show-log-panel');
                $(".login-reg-panel").css("background-image","linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%)");
                
            }
            else if($('#log-reg-show').is(':checked')) {
                $('.register-info-box').fadeIn();
                $('.login-info-box').fadeOut();
                
                $('.white-panel').removeClass('right-log');
                $('.white-panel').removeClass('auto');
                $('.login-show').addClass('show-log-panel');
                $('.register-show').removeClass('show-log-panel');
                $(".login-reg-panel").css("background-image","linear-gradient(280deg, rgb(2, 0, 36) 0%, rgb(9, 9, 121) 35%, rgb(0, 161, 255) 100%)");
            }
        });       

   }
});


   