document.addEventListener("DOMContentLoaded", function(){
    // Select.phpで選択した品種を設定する
    const type = Number($('type').value);
    $('type').selectedIndex = type;

    // Select.phpで選択した色を設定する
    const selectedExecuitonColor = sessionStorage.getItem('selectedExecuitonColor');
    let selectedColor = selectedExecuitonColor !== '' ?
                        selectedExecuitonColor : sessionStorage.getItem('selectedColor');

    setColor(Number(selectedColor));
})

function setColor(selectedColor) {
    const host = location.host;

    const typeId = $('type').value;
    const json_petTypeColorResult = JSON.parse($('json_petTypeColorResult').value);

    let petTypeColorList = json_petTypeColorResult.filter((petTypeColor) => {
        return petTypeColor[DbName.pet_type_id(host)] == typeId;
    });

    let color = $('color');

    while(color.lastChild) {
        color.removeChild(color.lastChild);
    }

    // セレクトボックス作成
    setOption('color', '', '');

    for(let i=0, length=petTypeColorList.length; i < length; i++) {
        let petTypeColor = petTypeColorList[i];
        let id = petTypeColor[DbName.id(host)];
        let color = petTypeColor[DbName.color(host)];
        setOption('color', id, color);
    }

    // 引数が存在する場合、引数の番号を初期選択状態にする
    if(!(typeof selectedColor === 'undefined' || selectedColor == null)) {
        color.selectedIndex = selectedColor;
    }
}

function setSelectedColorIndex() {
    // 現在選択中の色をセッションに保存
    const selectedColor = $('color').value;
    sessionStorage.setItem('selectedExecuitonColor', selectedColor);
}

function formSubmit(id) {
    // submit
    let form = $('petInfo_' + id);
    form.submit();
}