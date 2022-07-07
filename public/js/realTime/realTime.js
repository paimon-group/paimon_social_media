$(document).ready(function (){

    var conn = new WebSocket('ws://localhost:4444');

    conn.onopen = function (e){
        console.log("Connection success!");
    }

    conn.onmessage = function (e){
        var data = JSON.parse(e.data);
        addNewMessage(data);
        saveMess(data)
    }
    function addNewMessage(data)
    {
        var style = 'style="float: left; margin-left: 1rem"';
        if(data.from === 'me')
        {
            style = 'style="float: right; margin-right: 1rem; background-color: rgb(212, 237, 228)"';
            var blockMessage =
                '                <div class="block-message" '+style+' >\n' +
                '                    <div class="content-message">'+data.message+'</div>\n' +
                '                    <div class="time-message">'+data.time+'</div>\n' +
                '                </div>'
        }
        else
        {
            var blockMessage =
                '                <div class="block-message" '+style+' >\n' +
                '                    <img src="../image/post/'+data.avatar+'" alt="avatar">\n' +
                '                    <div class="fullname-user-message" data-user-id="'+data.userId+'">'+data.fullname+'</div>\n' +
                '                    <div class="content-message">'+data.message+'</div>\n' +
                '                    <div class="time-message">'+data.time+'</div>\n' +
                '                </div>'
        }

        $('.body-chat-box').append(blockMessage);
        $('.body-chat-box').scrollTop($('.body-chat-box')[0].scrollHeight);

        if($('.chat-box').hasClass('chat-box-mini-animation') )
        {
            $('.header-chat-box').addClass('animatio-message-notification');
        }
    }
    function saveMess(data)
    {
        $.ajax({
            url:'/saveMessage',
            type:'PUT',
            data:{userId:data.userId, content:data.message, time:data.time},
        })
    }

    //send mess
    $(document).on('click', '.btn-send-mess', function (){
        sendMess();
    })
    $('.txt-chat-box').keyup(function (e)
    {
        if(e.keyCode == 13)
        {
            sendMess();
        }
    });
    function sendMess()
    {
        var userId = $('#btn_go_to_profile_header').data('user-id');
        var message = $('.txt-chat-box').val();
        var fullname = $('#fullname_user').val();
        var avatar = $('#avatar_user').val();

        if(message !== '')
        {
            var data = {
                userId: userId,
                message: message,
                fullname:fullname,
                avatar:avatar
            }
            conn.send(JSON.stringify(data));
            $('.txt-chat-box').val('');

        }
    }

    //get message
    $('#btn_open_chat_box').click(function (){
        if(!$('#btn_open_chat_box').hasClass('has-data'))
        {
            $.ajax({
                url:'/getMessage',
                type: 'GET',
                success:function (data){
                    console.log(data)
                    getMess(data[0]);
                }
            })
            $('#btn_open_chat_box').addClass('has-data');
        }
    })
    function getMess(data)
    {
        var userId = $('#btn_go_to_profile_header').data('user-id');
        var dataMess = '';
        for (i=0; i < data.length; i++)
        {
            var style = 'style="float: left; margin-left: 1rem"';

            if (data[i].user_id == userId)
            {
                style = 'style="float: right; margin-right: 1rem; background-color: rgb(212, 237, 228)"';
                var blockMessage =
                    '                <div class="block-message" ' + style + ' >\n' +
                    '                    <div class="content-message">' + data[i].message + '</div>\n' +
                    '                    <div class="time-message">' + data[i].time + '</div>\n' +
                    '                </div>';

                dataMess += blockMessage;
            }
            else
            {
                var blockMessage =
                    '                <div class="block-message" ' + style + ' >\n' +
                    '                    <img src="../image/post/' + data[i].avatar + '" alt="avatar">\n' +
                    '                    <div class="fullname-user-message" data-user-id="' + data[i].userId + '">' + data[i].fullname + '</div>\n' +
                    '                    <div class="content-message">' + data[i].message + '</div>\n' +
                    '                    <div class="time-message">' + data[i].time + '</div>\n' +
                    '                </div>';

                dataMess += blockMessage;
            }

        }

        $('.body-chat-box').append(dataMess);
        $('.body-chat-box').scrollTop($('.body-chat-box')[0].scrollHeight);
    }


    $(document).on('click', '.fullname-user-message', function (){
        var friendId = $(this).data('user-id');
        location.href = '/profile/'+friendId;
    })

    function getUrl()
    {
        var locationCurrent = $(location).attr("href");
        var indexSubstring = locationCurrent.lastIndexOf('/');

        return url = locationCurrent.substring(indexSubstring);
    }
    if(getUrl() == '/home')
    {
        document.title = "Paimon";
    }
    else
    {
        document.title = "Profile";
        //hide message feature
        $('#btn_open_chat_box').remove();
    }
})