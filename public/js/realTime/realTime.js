$(document).ready(function (){

    var conn = new WebSocket('ws://localhost:4444');

    conn.onopen = function (e){
        console.log("Connection success!");
    }

    conn.onmessage = function (e){
        var data = JSON.parse(e.data);
        addNewMessage(data);
    }
    function addNewMessage(data)
    {
        var style = 'style="float: left; margin-left: 1rem"';
        if(data.from === 'me')
        {
            style = 'style="float: right; margin-right: 1rem; background-color: rgb(127, 203, 175)"';
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
        var avatar = $('#avatar_user').val()
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
    }
})