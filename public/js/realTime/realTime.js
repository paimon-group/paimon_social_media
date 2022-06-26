$(document).ready(function (){

    var conn = new WebSocket('ws://localhost:4444');
    conn.onopen = function (){
        console.log("Connection success!");
    }

    conn.onmessage = function (){
    }

    conn.onclose = function (){
    }

    conn.onerror = function (){
    }

    function getUrl()
    {
        var locationCurrent = $(location).attr("href");
        var indexSubstring = locationCurrent.lastIndexOf('/');

        return url = locationCurrent.substring(indexSubstring);
    }
    if(getUrl() == '/home')
    {
        document.title = "Paimon";
    }
    else
    {
        document.title = "Profile";
    }
})