$(document).ready(function (){

    document.title = "Profile";

    $('#count-friend').click(function (){
        location.assign('/friendList')
    });

    $('#count-posts').click(function (){
        location.assign('/profile')
    });

});