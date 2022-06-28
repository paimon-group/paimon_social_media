$(document).ready(function (){

    //open chat box
    $('#btn_open_chat_box').click(function (){
        $('.block-chat').show();
    })
    //close chat box
    $('.btn-close-chat-box').click(function (){
        $('.block-chat').hide();
    })

    //mini-size and max-size of box chat
    $('.btn-collapse-chat-box').click(function (){
        $('.chat-box').removeAttr("style");
        //box is mini-size
        if($(this).parent().parent().hasClass('chat-box-mini-animation'))
        {
            $(this).parent().parent().removeClass('chat-box-mini-animation');
            $(this).parent().parent().addClass('chat-box-max-animation');
            $('.btn-collapse-chat-box i').removeClass('bi-chevron-up');
            $('.btn-collapse-chat-box i').addClass('bi-chevron-down');
            $('.header-chat-box').removeClass('animatio-message-notification');
        }
        //box is max-size
        else
        {
            $(this).parent().parent().removeClass('chat-box-max-animation');
            $(this).parent().parent().addClass('chat-box-mini-animation');
            $('.btn-collapse-chat-box i').removeClass('bi-chevron-down');
            $('.btn-collapse-chat-box i').addClass('bi-chevron-up');
        }
    });

})