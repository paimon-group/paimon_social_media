$(document).ready(function (){

    //change tym of post
    $(document).on('click',  '.icon-tym-post-home', function(){
        //get id post
        var id = $(this).data('post-id');

        if($(this).hasClass('has-tym'))
        {
            $(this).removeClass('has-tym');
            $(this).css('color', 'black');
            unLike(id);
        }
        else
        {
            $(this).addClass('has-tym');
            $(this).css('color', 'red');
            likePost(id);
        }
    });

    function likePost(id)
    {
        $.ajax({
            url:'/reaction/like',
            type:'PUT',
            data:{'idPost':id, 'optionLike':'like'},
            success:function (data){
                console.log(data)
                if(data['status_code'] == 200)
                {
                    var countLike = $('#count_tym_post_id_'+id).html();
                    if(countLike == '')
                    {
                        $('#count_tym_post_id_'+id).html(1);
                    }
                    else
                    {
                        $('#count_tym_post_id_'+id).html(parseInt(countLike) + 1);
                    }
                }
            }
        })
    }

    function unLike(id)
    {
        $.ajax({
            url:'/reaction/like',
            type:'PUT',
            data:{'idPost':id, 'optionLike':'unlike'},
            success:function (data){
                console.log(data)
                if(data['status_code'] == 200)
                {
                    var countLike = $('#count_tym_post_id_'+id).html();
                    $('#count_tym_post_id_'+id).html(parseInt(countLike) - 1);
                }
            }
        })
    }

    $(document).on('click', '.comment-post-home', function (){
       var commentPostId =  $(this).data('post-id');
        $('#comment_post_'+commentPostId).show();
    })

    $(document).on('click',  '.btn-send-comment-post', function(){
        var postId = $(this).data('btn-send-comment-id');
        var content = $('#txt_comment_post_home_'+postId).val();
        console.log(content);
        // $.ajax({
        //
        // })
    });
});