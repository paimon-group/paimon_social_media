$(document).ready(function (){

    //send invite friend
    $('#send_invite_friend').click(function (){
        var userId = $(this).data('user-id');

        $.ajax({
            url:'/sendInviteFriend',
            type:'PUT',
            data:{'userId':userId},
            success:function (data){
                if(data['status'] == 200)
                {
                    console.log(data);
                }
                else
                {
                    console.log(data['Message']);
                }
            }
        })
    })

    //accept friend
    $('btn_accept_invite_friend').click(function (){
        var senderId = $(this).data('sender-id');

        $.ajax({
            url:'/sendInviteFriend',
            type:'PUT',
            data:{'senderId':senderId},
            success:function (data){
                if(data['status'] == 200)
                {
                    console.log(data);
                }
                else
                {
                    console.log(data['Message']);
                }
            }
        })
    })

})
