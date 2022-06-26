$(document).ready(function (){
    
    $('#count-friend').click(function (){
        var userId =  $(this).data('user-id');
        location.assign('/friendList/' + userId)
    });

    $('#count-posts').click(function (){
        var userId =  $(this).data('user-id');
        location.assign('/profile/' + userId)
    });

});