$(document).ready(function (){

   $('.item-controll-dashboard').click(function (){
      $('.item-controll-dashboard').removeClass('active')
      $(this).addClass('active');
   })

   function getLocation()
   {
      var location =  window.location.href;
      var indexCut = location.lastIndexOf("/");
      location = location.substring(indexCut);

      return location;
   }

   if(getLocation() == '/statificalManager')
   {
      $('#statifical_item').addClass('active');
   }
   if(getLocation() == '/reportManager')
   {
      $('#report_item').addClass('active');
   }

   //check report
   $('.btn-get-report-detail').click(function (){

   })

});