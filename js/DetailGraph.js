document.addEventListener("DOMContentLoaded", function(){
    var graph = c3.generate({
        bindto: '#graph',
        data: {
            columns: [
                ['jeri', 130, 133, 134, 136, 140],
                ['hima', 145, 145, 146, 147, 150]
            ]
        }
    })

    // 体重表示日程設定
    let sysDate = getSysDate();
    $('end').value = sysDate;
    let date = new Date();
    date.setMonth(date.getMonth() + 1);
    date.setDate(date.getDate() - 10);
    $('start').value = date.getFullYear() + '-' 
                     + date.getMonth() + '-'
                     + date.getDate();
})