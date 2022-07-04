$(document).ready(function ()
{
    //change logo status
    $('.brand').mouseenter(function (){
        $("#logo").attr('src', '/image/decorate/logo2.png');
    });
    $('.brand').mouseleave(function (){
        $("#logo").attr('src', '/image/decorate/logo.png');
    });

    //show notification
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

    //search user by full name
    $('#txt_search_user_home_left').keyup(function (e)
    {
        if(e.keyCode == 13)
        {
            searchUserWithFUllname();
        }
    });
    $('#btn_search_user').click(function (){
        searchUserWithFUllname();
    })
    function searchUserWithFUllname()
    {
        var fullname = $('#txt_search_user_home_left').val();

        $.ajax({
            url:'/searchUser',
            type:'GET',
            data:{'fullname':fullname},
            success:function (data){
                if(data['status_code'] == 200)
                {
                    $('#txt_search_user_home_left').css('outline-color', 'green');
                    showUserList(data['userList']);
                }
                else
                {
                    $('#txt_search_user_home_left').css('outline-color', 'red');
                }
            }
        })
    }
    function showUserList(data)
    {
        $('#root-post').hide();
        $('.user-list-found').remove();

        var userFoundBody =
            '<div class="user-list-found">\n' +
            '    <div class="body-user-list-found">\n' +
            '    </div>\n' +
            '</div>';
        $('.root-body-home').append(userFoundBody);

        var userList = '';
        for (i = 0; i < data.length; i++)
        {
            var user =
            '        <div class="item-user-list-found" data-user-id="'+ data[i]['id'] +'">\n' +
            '            <div class="avatar-user-found"><img src="/image/post/'+ data[i]['avatar'] +'" alt="avatar"></div>\n' +
            '            <div class="fullname-user-found">'+ data[i]['fullname'] +'</div>\n' +
            '        </div>\n';

            userList += user;
        }
        var titleSearchFriend = '<div class="title-found-user-banner">Found matching data</div>';

        $('.body-user-list-found').append(titleSearchFriend);
        $('.body-user-list-found').append(userList);
    }

    //view profile of other user when search
    $(document).on('click', '.item-user-list-found', function (){
        var userId = $(this).data('user-id');
        location.href = '/profile/' + userId;
    })

    //go to invite friend sender
    $('.item-friend-notification-table').click(function (){
        var senderId = $(this).data('sender-id');
        location.href = '/profile/' + senderId;
    })

    //seen like and comment notification
    $('#post_notification').click(function (){
        $.ajax({
            url:'/seenNotification',
            type:'PUT',
            success:function (data){
                if(data['status_code'] == 200)
                {
                   $('.count-notification-post').hide();
                   $('.count-notification-post').html(0);
                }
            }
        })
    })

    //go to friend profile when click friend inlist
    $('.friend-in-list').click(function (){
        var friendId = $(this).data('friend-id');

        location.href = '/profile/'+friendId;
    })

    //go to user profile when click on user reation list
    $('.item-post-notification-table').click(function (){
        var userId = $(this).data('user-reaction-id');

        location.href = '/profile/'+userId;
    })

});

