$(document).ready(function (){
    //change tym of post
    $(document).on('click',  '.icon-tym-post-home', function(){
        //get id post
        var id = $(this).data('post-id');

        if($(this).hasClass('has-tym'))
        {
            $(this).removeClass('bi-heart-fill has-tym');
            $(this).addClass('bi-heart');
            $(this).css('color', 'black');
            unLike(id);
        }
        else
        {
            $(this).removeClass('bi-heart');
            $(this).addClass('bi-heart-fill has-tym');
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
                if(data['status_code'] == 200)
                {
                    var countLike = $('#count_tym_post_id_'+id).html();
                    var increaseLike = $('#count_tym_post_id_'+id).html(parseInt(countLike) + 1);
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
                if(data['status_code'] == 200)
                {
                    var countLike = $('#count_tym_post_id_'+id).html();
                    var increaseLike = $('#count_tym_post_id_'+id).html(parseInt(countLike) - 1);
                }
            }
        })
    }
});