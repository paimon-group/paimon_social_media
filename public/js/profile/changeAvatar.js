$(document).ready(function (){
    //add image for avatar
    $('#btn_add_img_change_avatar_in_table').on('click', function() {
        $('#input_up_img_avatar').click();
    });

    //delete preview img avatar
    $('#btn_delete_preview_img_avatar_in_table').click(function (){
        $('#img_preview_atavar').attr('src', '');
        $('#input_up_img_avatar').val('');
    })

    //image preview before up avatar
    $('#input_up_img_avatar').change(function (){
        PreviewImage()
        $('#img_preview_atavar').show();

    })
    function PreviewImage() {
        var imageReader = new FileReader();
        imageReader.readAsDataURL(document.getElementById("input_up_img_avatar").files[0]);

        imageReader.onload = function (oFREvent) {
            document.getElementById("img_preview_atavar").src = oFREvent.target.result;
        };
    };

    //change image avatar
    $('.img-post-in-table').mouseenter(function (){
        if($('#img_preview_atavar').attr('src') != '')
        {
            $('#btn_add_img_change_avatar_in_table').html('change image');
            $('#img_preview_atavar').hide();
        }
    })
    $('.img-post-in-table').mouseleave(function (){
        if($('#img_preview_atavar').attr('src') != '')
        {
            $('#img_preview_atavar').show();
        }
    })

    //if post content is empty will not update avatar
    $('#change_avatar_model').submit(function(e){
        var caption = $('.text-area-caption-in-table').val();
        var image = $('#input_up_img_avatar')[0].files.length;

        if(caption == '' || image === 0)
        {
            $('.error-message').html('please enter caption or choose avatar');
            e.preventDefault();
        }
    });
});