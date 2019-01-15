document.addEventListener("DOMContentLoaded", function(){
    // Select.phpで選択した品種を設定する
    const type = Number($('pet_type').value);
    $('type').selectedIndex = type;

    // Select.phpで選択した色を設定する
    const selectedColor = sessionStorage.getItem('selectedExecuitonColor');
    setColor(Number(selectedColor));
})

function setColor(selectedColor) {
    const typeId = $('type').value;
    const json_petTypeColorResult = JSON.parse($('json_petTypeColorResult').value);

    let petTypeColorList = json_petTypeColorResult.filter((petTypeColor) => {
        return petTypeColor['PET_TYPE_ID'] == typeId;
    });

    let color = $('color');

    while(color.lastChild) {
        color.removeChild(color.lastChild);
    }

    // セレクトボックス作成
    setOption('color', '', '');

    for(let i=0, length=petTypeColorList.length; i < length; i++) {
        let petTypeColor = petTypeColorList[i];
        let id = petTypeColor['ID'];
        let color = petTypeColor['COLOR'];
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