$(document).ready(function () {
    updateTime();
    setInterval(updateTime, 1000);
})

function updateTime() {
    var date = new Date(); // gets actual time

    function formatTime(x) {  // format if less then seconds to format 00
        if (x < 10) {
            return x = '0' + x;
        } else {
            return x;
        }
    }

    var h = formatTime(date.getHours()); // Hour
    var m = formatTime(date.getMinutes()); // Minutes
    var s = formatTime(date.getSeconds()); // Seconds

    $('#timeClock').text(h + ':' + m + ':' + s);
}