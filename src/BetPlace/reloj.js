 $(document).ready(function(){
     setInterval(ajaxcall, 1000);
 });
 function ajaxcall(){
     $.ajax({
         url: 'gettime.php',
         success: function(data) {
             data = data.split(':');
             $('#hours').html(data[0]);
             $('#minutes').html(data[1]);
             $('#seconds').html(data[2]);
         }
     });
 }

