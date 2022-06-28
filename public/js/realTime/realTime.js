$(document).ready(function (){
    var conn;

    $.ajax({
        url:'/setUserToken',
        type:'PUT',
        success:function (data)
        {
            if(data['status_code'] == 200)
            {
                conn = new WebSocket('ws://localhost:4444?token='+data['token']);
            }
        }
    });

    conn.onopen = function (e){
        console.log("Connection success!");
    }

    conn.onmessage = function (e){
        console.log( JSON.parse(e.data));
    }

    conn.onclose = function (e){
    }

    conn.onerror = function (e){
    }

    $(document).on('click', '.btn-send-mess', function (){
        console.log('click')
        var data = {
            userId: '2',
            msg: 'aasdfkjkhbaskdfjk',
        }
        conn.send(JSON.stringify(data));
    })

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