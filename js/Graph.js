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
})