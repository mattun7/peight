document.addEventListener("DOMContentLoaded", function(){

    //let weightList = $('weightList').value;
    let a = $('json_weightList').value
    let weightList = JSON.parse(a);


    var graph = c3.generate({
        bindto: '#graph',
        data: {
            columns: [
                ['jeri', 130, 133, 134, 136, 140]
            ]
        }
    })
})

function formSubmit(action) {
    let form = $('form');
    form.action = action;

    form.submit();
}