$(document).ready(function (){
    $('#btn_add_img_post_in_table').on('click', function() {
        $('#input_up_img').click();


    });
    $('#input_up_img').change(function (){
        var imageSelected = $('#input_up_img').files;

        PreviewImage();
        $('#img_preview').show();
    })

    function PreviewImage() {
        var imageReader = new FileReader();
        imageReader.readAsDataURL(document.getElementById("input_up_img").files[0]);

        imageReader.onload = function (oFREvent) {
            document.getElementById("img_preview").src = oFREvent.target.result;
        };
    };

    $('.img-post-in-table').mouseenter(function (){
        if($('#img_preview').attr('src') != '')
        {
            $('#btn_add_img_post_in_table').html('change image');
            $('#img_preview').hide();
        }
    })
    $('.img-post-in-table').mouseleave(function (){
        $('#img_preview').show();
    })
});