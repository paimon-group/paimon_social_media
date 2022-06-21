$(document).ready(function (){
   $('.item-controll-dashboard').click(function (){
      $('.item-controll-dashboard').removeClass('active')
      $(this).addClass('active');
   })

   if($(location).attr("href") == 'http://localhost:8000/admin/home')
   {
      $('#statifical_item').addClass('active');
   }
   if($(location).attr("href") == 'http://localhost:8000/admin/report')
   {
      $('#report_item').addClass('active');
   }
   if($(location).attr("href") == 'http://localhost:8000/admin/changepassword')
   {
      $('#change_pass_item').addClass('active');
   }
});