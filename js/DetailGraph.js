document.addEventListener("DOMContentLoaded", function(){
    // 現在日付を計測日に設定
    var date = getSysDate();
    $('instrumentationDays').value = date;
    // 体重グラフをアクティブに設定
    $('a_DetailGraph').classList.add('is-active');
    $('InsertBodyWeight').style.display = 'none';
    // グラフ設定
    let json_weightList = JSON.parse($('json_weightList').value);
    dispDetailGraph(json_weightList);
})

function dispDetailGraph(weightList) {
    let result = weightList.map((keisoku, index) => {
        return {'計測日': keisoku['INSTRUMENTANTION_DAYS'].substr(5), 
                '体重': parseInt(keisoku['WEIGHT'])};
    });

    var graph = c3.generate({
        data: {
            json: result
            ,
            keys:{
                x: '計測日',
                value: ['体重']
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

function changePage(pageName) {
    switch (pageName) {
        case 'InsertBodyWeight':
            $('a_InsertBodyWeight').classList.add('is-active');
            $('a_DetailGraph').classList.remove('is-active');
            $('InsertBodyWeight').style.display = 'block';
            $('DetailGraph').style.display = 'none';
            break;
        case 'DetailGraph':
            $('a_DetailGraph').classList.add('is-active');
            $('a_InsertBodyWeight').classList.remove('is-active');
            $('DetailGraph').style.display = 'block';
            $('InsertBodyWeight').style.display = 'none';
            break;
    }
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

function ajaxInsertBodyWeight() {
    let req = new XMLHttpRequest();
 
    req.onreadystatechange = function() {
        if(req.readyState == 4) {
             if(req.status == 200) {
                 alert('登録が完了しました。');
                 let json_weightList = JSON.parse(req.responseText);
                 dispDetailGraph(json_weightList);
             } else {
                
             }
        }
    }

    const id = $('id').value;
    const start = $('start').value;
    const end = $('end').value;
    const instrumentationDays = $('instrumentationDays').value;
    const weight = $('weight').value;

    req.open('GET'
            ,'logic/InsertBodyWeightLogic.php?'  
                + 'id=' + encodeURIComponent(id) + '&'
                + 'instrumentationDays=' + encodeURIComponent(instrumentationDays) + '&'
                + 'weight=' + encodeURIComponent(weight) + '&'
                + 'start=' + encodeURIComponent(start) + '&'
                + 'end=' + encodeURIComponent(end)
            ,true);
    req.send();
}