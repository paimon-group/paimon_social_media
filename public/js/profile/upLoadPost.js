$(document).ready(function (){

    //add image for post
    $('#btn_add_img_post_in_table').on('click', function() {
        $('#input_up_img').click();

    });

    //image preview before up post
    $('#input_up_img').change(function (){

        PreviewImage()
        $('#img_preview').show();

    })
    function PreviewImage() {
        var imageReader = new FileReader();
        imageReader.readAsDataURL(document.getElementById("input_up_img").files[0]);

        imageReader.onload = function (oFREvent) {
            document.getElementById("img_preview").src = oFREvent.target.result;
        };
    };

    //change image up post
    $('.img-post-in-table').mouseenter(function (){
        if($('#img_preview').attr('src') != '')
        {
            $('#btn_add_img_post_in_table').html('change image');
            $('#img_preview').hide();
        }
    })
    $('.img-post-in-table').mouseleave(function (){
        if($('#img_preview').attr('src') != '')
        {
            $('#img_preview').show();
        }
    })

    //if post content is empty will not up post
    $('#new_post_form').submit(function(e){
        var caption = $('.text-area-caption-in-table').val();
        var image = $('#input_up_img')[0].files.length;

        if(caption == '' && image === 0)
        {
            $('.error-message').html('please enter caption or choose image');
            e.preventDefault();
        }
    });

});