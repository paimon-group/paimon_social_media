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
                    console.log($('#count_tym_post_id_'+id).html())
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
                    console.log(data)
                    var countLike = $('#count_tym_post_id_'+id).html();
                    $('#count_tym_post_id_'+id).html(parseInt(countLike) - 1);
                }
            }
        })
    }
});