document.addEventListener("DOMContentLoaded", function(){

    let json_weightList = JSON.parse($('json_weightList').value);

    let weightList = [];
    let dataList = [];

    weightList.push('じぇり');
    dataList.push('x');

    for(let i=0, length=json_weightList.length; i<length; i++){
        //weightList.push(parseInt(json_weightList[i]['WEIGHT']));
        //dataList.push(json_weightList[i]['INSTRUMENTANTION_DAYS']);

    }

    let list = json_weightList.map((keisoku, index) => {
        return {INSTRUMENTANTION_DAYS: keisoku['INSTRUMENTANTION_DAYS'], 
                weight: parseInt(keisoku['WEIGHT'])};
    });

    var graph = c3.generate({
        //bindto: '#graph',
        //bindto: '#chart',
        data: {
            json: list
            ,
            keys:{
                x: 'INSTRUMENTANTION_DAYS',
                value: ['weight']
            }
        },
        axis: {
            x: {
                type: 'category',
                label: {
                    text: '計測日',
                    position: 'outer-right',
                },
            },
            y: {
                lebel: {
                    text: '体重',
                    position: 'outer-right'
                }
            }
        }
    });
/*
    var chart = c3.generate({
        data: {
            rows: [
                ['data1', 'data2', 'data3'],
                [90, 120, 300],
                [40, 160, 240],
                [50, 200, 290],
                [120, 160, 230],
                [80, 130, 300],
                [90, 220, 320],
            ]
        }
    });*/
})

function formSubmit(action) {
    let form = $('form');
    form.action = action;

    form.submit();
}