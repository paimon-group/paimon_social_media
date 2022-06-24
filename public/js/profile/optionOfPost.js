$(document).ready(function (){
    var idPost = '';

    //get url
    function getUrl()
    {
        var locationCurrent = $(location).attr("href");
        var indexSubstring = locationCurrent.lastIndexOf('/');

        return url = locationCurrent.substring(indexSubstring);
    }

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
                    if(getUrl() == '/profile')
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