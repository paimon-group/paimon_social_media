$(document).ready(function (){
    //mini-size and max-size of box chat
    $('.btn-collapse-chat-box').click(function (){
        if($(this).parent().parent().hasClass('chat-box-mini-animation'))
        {
            $(this).parent().parent().removeClass('chat-box-mini-animation');
            $(this).parent().parent().addClass('chat-box-max-animation');
            $('.btn-collapse-chat-box i').removeClass('bi-chevron-up');
            $('.btn-collapse-chat-box i').addClass('bi-chevron-down');
        }
        else
        {
            $(this).parent().parent().removeClass('chat-box-max-animation');
            $(this).parent().parent().addClass('chat-box-mini-animation');
            $('.btn-collapse-chat-box i').removeClass('bi-chevron-down');
            $('.btn-collapse-chat-box i').addClass('bi-chevron-up');
        }
    });

})