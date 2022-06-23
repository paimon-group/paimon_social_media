$(document).ready(function (){
    var idPost = '';

    //delete post
    $(document).on('click', '.delete-option-post-profile', function (){
        idPost = $(this).data('post-id');
    })
    $('#btn_confirm_delete_post').click(function (){
        $.ajax({
            url:'/profile/deletePost',
            type:'POST',
            dataType: 'json',
            data: {'idPost':idPost},
            success: function (data){
                if(data['notification'] == 'success')
                {
                    console.log('success')
                    if($(location).attr("href") == 'https://localhost:8000/profile')
                    {
                        location.href = '/profile';
                    }
                    else
                    {
                        location.href = '/home';
                    }
                }
                else
                {
                    console.log('false')
                }
            }
        })
    })

})