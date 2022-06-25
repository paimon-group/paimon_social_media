$(document).ready(function ()
{
    console.log("ready");

    //change logo status
    $('.brand').mouseenter(function (){
        $("#logo").attr('src', '/image/decorate/logo2.png');
    });
    $('.brand').mouseleave(function (){
        $("#logo").attr('src', '/image/decorate/logo.png');
    });


    $(document).on('click',  '.comment-post-home', function(){
        console.log($(this).data('comment_id'));
        id = $(this).data('comment_id');
       $('#user_comments_'+id).show();
    });

    $('#post_notification').click(function (){

        if($('.post-notification-table').hasClass('show-post-notification-table'))
        {
            $('.post-notification-table').removeClass('show-post-notification-table')
        }
        else
        {
            $('.post-notification-table').addClass('show-post-notification-table')
            $('.friend-notification-table').removeClass('show-friend-notification-table')
        }
    })

    $('#friend_notification').click(function (){

        if($('.friend-notification-table').hasClass('show-friend-notification-table'))
        {
            $('.friend-notification-table').removeClass('show-friend-notification-table')
        }
        else
        {
            $('.friend-notification-table').addClass('show-friend-notification-table')
            $('.post-notification-table').removeClass('show-post-notification-table')
        }
    })

});

