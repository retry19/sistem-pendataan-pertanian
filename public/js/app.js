$(window).bind("load", function() { 
  $('#loader').fadeOut(); 
});

let headers = {
  'Accept': 'application/json, text-plain, */*',
  'X-Requested-With': 'XMLHttpRequest',
  'X-CSRF-TOKEN': document.querySelector(`meta[name='csrf-token']`).getAttribute('content')
};

function removeClassNameByClass(className, classToRemove){
  let elements = document.getElementsByClassName(className);
  for (const element of elements) 
    element.classList.remove(classToRemove);
}

function removeInnerHTMLByIds(Ids, isError = false){
  Ids.forEach(id => 
    document.getElementById(isError ? `error-${id}` : id).innerHTML = ''
  );
}

// Fungsi untuk preview image
// ketika pengguna memilih image untuk diupload
function loadImage(event) {
  let div = document.getElementById('preview-image');
  let output = document.getElementById('preview-image-output');
  output.src = URL.createObjectURL(event.target.files[0]);
  output.onload = function() {
    URL.revokeObjectURL(output.src);
    div.style.display = 'flex';
  }
}

// Fungsi untuk menghapus seluruh value dari input
// Menghapus preview image
function clearAllInput() {
  document.getElementById('preview-image').style.display = 'none';
  document.getElementById('preview-image-output').src = '';
  
  document.getElementById('image').value = '';
  let elements = document.getElementsByClassName('form-control');
  for (const element of elements) 
    element.value = null;
}

// fungsi untuk select option 
// berdasarkan value
function selectOptionByValue(elmnt, value) {
  for(var i=0; i < elmnt.options.length; i++) {
    if(elmnt.options[i].value == value)
      elmnt.selectedIndex = i;
  }
}
