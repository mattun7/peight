document.addEventListener("DOMContentLoaded", function(){
    var date = getSysDate();
    $('instrumentationDays').value = date;
})

function checkMessage() {
    if(confirm('体重情報を登録してよろしいですか')) {
        window.location.href = 'DetailGraph.html';
    }
}