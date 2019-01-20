document.addEventListener("DOMContentLoaded", function(){
    let json_weightList = JSON.parse($('json_weightList').value);
    dispDetailGraph(json_weightList);
})

function dispDetailGraph(weightList) {
    let result = weightList.map((keisoku, index) => {
        return {INSTRUMENTANTION_DAYS: keisoku['INSTRUMENTANTION_DAYS'], 
                weight: parseInt(keisoku['WEIGHT'])};
    });

    var graph = c3.generate({
        data: {
            json: result
            ,
            keys:{
                x: 'INSTRUMENTANTION_DAYS',
                value: ['WEIGHT']
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
}

function formSubmit(action) {
    let form = $('form');
    form.action = action;

    form.submit();
}

function ajaxGraph() {
   let req = new XMLHttpRequest();

   req.onreadystatechange = function() {
       if(req.readyState == 4) {
            if(req.status == 200) {
                var json_weightList = JSON.parse(eval('(' + req.responseText + ')'));
            } else {
               
            }
       }
   }
   req.open('GET'
           ,'/logic/DetailGraphLogic.php?'        
                   + 'start=' + encodeURIComponent($('start').value) + '&'
                   + 'end=' + encodeURIComponent($('end').value)
           ,true);
   req.send();
}