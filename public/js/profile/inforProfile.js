$(document).ready(function (){
    
    $('#count-friend').click(function (){
        var userId =  $(this).data('user-id');
        location.assign('/friendList/' + userId)
    });

    $('#count-posts').click(function (){
        var userId =  $(this).data('user-id');
        location.assign('/friendList/' + userId)
    });

    $('.friend-in-list-profile').click(function (){
        var userId = $(this).data('user-id');

        location.href = '/profile/' + userId;
    });

});