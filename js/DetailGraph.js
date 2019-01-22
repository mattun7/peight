document.addEventListener("DOMContentLoaded", function(){
    let json_weightList = JSON.parse($('json_weightList').value);
    dispDetailGraph(json_weightList);
})

function dispDetailGraph(weightList) {
    let result = weightList.map((keisoku, index) => {
        return {INSTRUMENTANTION_DAYS: keisoku['INSTRUMENTANTION_DAYS'], 
                WEIGHT: parseInt(keisoku['WEIGHT'])};
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
                let json_weightList = JSON.parse(req.responseText);
                dispDetailGraph(json_weightList);
            } else {
               
            }
       }
   }
   
   const id = $('id').value;
   const start = $('start').value;
   const end = $('end').value;

   req.open('GET'
           ,'logic/DetailGraphLogic.php?'  
                   + 'id=' + encodeURIComponent(id) + '&'
                   + 'start=' + encodeURIComponent(start) + '&'
                   + 'end=' + encodeURIComponent(end)
           ,true);
   req.send();
}