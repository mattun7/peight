function fileName() {
    let filenameList = $('pet_image').value.split('\\');
    $('file_name').textContent = filenameList[filenameList.length - 1];
}