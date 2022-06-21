$(document).ready(function () {

    $('.title-login').click(function (){
        $('.title-login').addClass('active');
        $('.title-sign-up').removeClass('active');
        document.title = 'Sign In'

        $('.register-form').hide();
        $('.login-form').show();
    })

    $('.title-sign-up').click(function (){
        $('.title-sign-up').addClass('active');
        $('.title-login').removeClass('active');
        document.title = 'Sign Up';

        $('.login-form').hide();
        $('.register-form').show();
    })
})