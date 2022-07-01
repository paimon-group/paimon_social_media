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
       var reportId = $(this).data('report-id');

       $.ajax({
          url:'/reportDetail',
          type: 'GET',
          data:{reportId:reportId},
          success:function (data){
             console.log(data.reportDetail[0])
             openReportTable(data.reportDetail[0])
          }
       });
   });
   //open report table
   function openReportTable(data)
   {
      if(data.total_like === 'null')
      {
         data.total_like = 0;
      }
      if(data.total_comment === 'null')
      {
         data.total_comment = 0;
      }
      var reportTable =
          '<div class="modal fade" id="reprot_detail_table" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
          '    <div class="modal-dialog modal-dialog-custom">\n' +
          '        <div class="modal-content">\n' +
          '            <div class="modal-header">\n' +
          '                <h5 class="modal-title" id="exampleModalLabel">Report Detail</h5>\n' +
          '                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn_close_report_table"></button>\n' +
          '            </div>\n' +
          '            <div class="modal-body">\n' +
          '                <div class="report-table">\n' +
          '                    <div class="img-post-in-table">\n' +
          '                        <img src="../image/post/'+data.image+'" alt="" id="img_preview">\n' +
          '                    </div>\n' +
          '                    <div class="caption-post-in-table">\n' +
          '                        <textarea readonly name="captionPost" id="caption_post_in_table" cols="35" rows="11" class="text-area-caption-in-table">'+data.caption+'</textarea>\n' +
          '                    </div>\n' +
          '                    <div class="block-reaction-post-report">\n' +
          '                        <div class="avatar-user-send-report" style="vertical-align: top; transform: translate(2rem, -0.4rem);">\n' +
          '                            <img src="../image/post/'+data.user_reported_avatar+'" alt="">\n' +
          '                        </div>\n' +
          '                        <div class="tym-post">\n' +
          '                            <div><i class="bi-heart-fill" style="color: red"></i></div>\n' +
          '                            <div class="count-tym-post">'+data.total_like+'</div>\n' +
          '                        </div>\n' +
          '                        <div class="comment-post">\n' +
          '                            <div><i class="bi-chat-right-dots" ></i></div>\n' +
          '                            <div class="count-comment-post">'+data.total_comment+'</div>\n' +
          '                        </div>\n' +
          '                    </div>\n' +
          '                </div>\n' +
          '                <div class="sender-report-detail">\n' +
          '                    <div class="avatar-user-send-report" style="vertical-align: top;"><img src="../image/post/'+data.user_send_report_avatar+'" alt=""></div>\n' +
          '                    <div class="content-report">'+data.reason+'</div>\n' +
          '                </div>\n' +
          '                <div class="modal-footer">\n' +
          '                    <button type="button" class="btn btn-warning" id="btn_delete_post" data-post-id="'+data.post_id+'" data-report-id="'+data.id+'">Delete Post</button>\n' +
          '                    <button type="button" class="btn  btn-success" id="btn_harmless_post" data-report-id="'+data.id+'">harmless</button>\n' +
          '                </div>\n' +
          '            </div>\n' +
          '        </div>\n' +
          '    </div>\n' +
          '</div>';

         $('.root-admin').append(reportTable);
         $('#open_report_table').click();

   }
   //delete post rule violation
   $(document).on('click', '#btn_delete_post', function (){
      var postId = $(this).data('post-id');
      var reportId = $(this).data('report-id');

      $.ajax({
         url:'/deletePostIsRuleViolation',
         type:'DELETE',
         data:{postId:postId, reportId:reportId},
         success:function (data){
            if(data.status_code == 200)
            {
               location.href = '/reportManager';
            }
         }
      })

   });

   //post is harmless
   $(document).on('click', '#btn_harmless_post', function (){
      var reportId = $(this).data('report-id');

      $.ajax({
         url:'/postIsHarmless',
         type:'DELETE',
         data:{reportId:reportId},
         success:function (data){
            console.log(data)
            if(data.status_code == 200)
            {
               location.href = '/reportManager';
            }
         }
      })

   })
   // remove old report table when close
   $(document).on('click', function (e) {
      if ($(e.target).closest('.modal-content').length === 0) {
         if($('body').hasClass('modal-open'))
         {
            $("#reprot_detail_table").remove();
         }
      }
   });
   $(document).on('click', '.btn-close', function (){
      $("#reprot_detail_table").remove();
   })
});