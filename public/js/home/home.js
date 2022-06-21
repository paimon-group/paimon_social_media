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

    //change tym of post
    $(document).on('click',  '.icon-tym-post-home', function(){
        console.log($(this).data('post_id'));
        id = $(this).data('post_id');
        if($('#tym_'+id).hasClass('has-tym'))
        {
            $('#tym_'+id).removeClass('bi-heart-fill has-tym');
            $('#tym_'+id).addClass('bi-heart');
            $('#tym_'+id).css('color', 'black');
        }
        else
        {
            $('#tym_'+id).removeClass('bi-heart');
            $('#tym_'+id).addClass('bi-heart-fill has-tym');
            $('#tym_'+id).css('color', 'red');
        }
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

