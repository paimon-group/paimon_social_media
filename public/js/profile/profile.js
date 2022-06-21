$(document).ready(function (){
    if($(location).attr("href") == 'http://localhost:8000/home')
    {
        document.title = "Paimon";
    }
    if($(location).attr("href") == 'http://localhost:8000/profile')
    {
        document.title = "nguyen nhat khang";
    }

    $('#count-friend').click(function (){
        location.assign('/profile/friend-list')
        console.log('click')
    })

    $('#count-posts').click(function (){
        location.assign('/profile')
    })

});