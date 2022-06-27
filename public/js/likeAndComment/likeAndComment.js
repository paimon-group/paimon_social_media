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

    //show comment block
    $(document).on('click', '.comment-post-home', function (){
       var commentPostId =  $(this).data('post-id');
        $('#comment_post_'+commentPostId).show();
    })

    //send comment
    $(document).on('click',  '.btn-send-comment-post', function(){
        var postId = $(this).data('btn-send-comment-id');
        var content = $('#txt_comment_post_home_'+postId).val();

        $.ajax({
            url: '/sendCommentPost',
            type: 'PUT',
            data:{'postId':postId, 'content':content},
            success:function (data){
                console.log(data)
                addNewComment(data);
            }
        })
    });
    function addNewComment(data)
    {
        var NewComment =
            '<div class="other-user-comment">\n' +
            '                            <div class="avatar-other-user-home">\n' +
            '                                <img src="{{ asset( image_dir ~ comment.avatar) }}" alt="avatar">\n' +
            '                            </div>\n' +
            '                            <div class="comment-content-post">\n' +
            '                                <h5 class="full-name-user-comment" data-user-id="{{ comment.id  }}">{{ comment.fullname }}</h5>\n' +
            '                                <p>{{ comment.comment_content }}</p>\n' +
            '                                <div class="time-comment-post-home">{{ comment.upload_time }}</div>\n' +
            '                            </div>\n' +
            '                        </div>';

    }

    //go to profile of user comment
    $('.full-name-user-comment').click(function (){
        var userId = $(this).data('user-id');

        location.href = '/profile/'+userId;
    });
});