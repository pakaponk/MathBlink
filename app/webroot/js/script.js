$js = jQuery.noConflict(true);
setInterval(function(){
    var today = $js('#date').html();
    if (today == '00:00:00')
    {
        $js('#submit').trigger('click');
    }
    else
    {
        var hours = today.substr(0,2);
        var minutes = today.substr(3,2);
        var seconds = today.substr(6,2);
        if (seconds>0)
        {
            seconds = seconds-1;
        }
        else
        {
            minutes = minutes-1;
            seconds = 59;
        }
        minutes = addZero(parseInt(minutes));
        seconds = addZero(seconds);
        $js('#date').html(hours+":"+minutes+":"+seconds);
    }
} , 1000);
$js('document').ready(function(){
    $js('#show').click(function(){
        $js('#date').toggle();
    });
});


function addZero(time){
    if (time<10)
    {
        time = "0"+time;
    }
    return time;
}
