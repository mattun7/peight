function setColor() {
    const typeId = $('type').value;
    const json_petTypeColorResult = JSON.parse($('json_petTypeColorResult').value);

    let petTypeColorList = json_petTypeColorResult.filter((petTypeColor) => {
        return petTypeColor['PET_TYPE_ID'] == typeId;
    });
}