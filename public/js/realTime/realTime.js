$(document).ready(function (){
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