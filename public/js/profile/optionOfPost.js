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
    });

    //edit post
    $(document).on('click', '.edit-option-post-profile', function (){
        idPost = $(this).data('post-id');
        getInforPost(idPost);

    })
    function getInforPost(idPost)
    {
        $.ajax({
            url: '/post/getInforPost',
            type: 'GET',
            dataType:'json',
            data:{'idPost': idPost},
            success: function (data){
                console.log(idPost);

                console.log(data);
                // var editTable =
                //     ' <div class="modal fade" id="edit_post_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                //     '        <div class="modal-dialog modal-dialog-custom-new-post">\n' +
                //     '            <div class="modal-content">\n' +
                //     '                <div class="modal-header">\n' +
                //     '                    <h5 class="modal-title" id="exampleModalLabel">New Post</h5>\n' +
                //     '                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn_close_table_new_post"></button>\n' +
                //     '                </div>\n' +
                //     '                <form method="post" action="/post/edit" enctype="multipart/form-data" id="new_post_form">\n' +
                //     '                <div class="modal-body new-post-table-body">\n' +
                //     '                        <div class="new-post-table">\n' +
                //     '                            <div class="img-post-in-table">\n' +
                //     '                                <div class="btn-add-img-post-in-table" id="btn_add_img_post_in_table">Add image</div>\n' +
                //     '                                <div class="btn-add-img-post-in-table" id="btn_delete_preview_img_in_table">Delete</div>\n' +
                //     '                                <input type="file" id="input_up_img" name="imgPost" hidden>\n' +
                //     '                                <img src="" alt="" id="img_preview">\n' +
                //     '                            </div>\n' +
                //     '                            <div class="caption-post-in-table">\n' +
                //     '                                <textarea placeholder="write something..." name="captionPost" id="caption_post_in_table" cols="30" rows="10" class="text-area-caption-in-table"></textarea>\n' +
                //     '                            </div>\n' +
                //     '                        </div>\n' +
                //     '                </div>\n' +
                //     '                <div class="modal-footer">\n' +
                //     '                        <div class="error-message" id="error_up_post" style="transform: translateX(-20rem); color: red">\n' +
                //     '                        </div>\n' +
                //     '                    <button type="submit" class="btn btn-primary" id="btn_submit_post">Post</button>\n' +
                //     '                </div>\n' +
                //     '                </form>\n' +
                //     '            </div>\n' +
                //     '        </div>\n' +
                //     '    </div>'
                // $('.root-body-profile').append()
                // $(this).click();
            }
        })


    }

})