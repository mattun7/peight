document.addEventListener("DOMContentLoaded", function(){
    const selectedColor = sessionStorage.getItem('selectedColor');
    sessionStorage.setItem('selectedExecuitonColor', '');
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

    setOption('color', '', '');

    for(let i=0, length=petTypeColorList.length; i < length; i++) {
        let petTypeColor = petTypeColorList[i];
        let id = petTypeColor['ID'];
        let color = petTypeColor['COLOR'];
        setOption('color', id, color);
    }
    if(!(typeof selectedColor === 'undefined' || selectedColor == null)) {
        color.selectedIndex = selectedColor;
    }
}

function setSelectedColorIndex() {
    const selectedColor = $('color').value;
    sessionStorage.setItem('selectedColor', selectedColor);
}