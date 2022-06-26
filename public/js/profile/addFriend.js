$(document).ready(function (){

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

})
