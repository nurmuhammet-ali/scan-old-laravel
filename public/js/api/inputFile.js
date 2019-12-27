

var form = document.querySelector('.form-wrapper');

form.addEventListener('change',function(e) {
    var target = e.target;

    if(!target.classList.contains("input-span-input")) return;

    var file = target.value;
    file = file.replace(/\\/g, "/").split('/').pop();

    target.previousSibling.previousSibling.innerHTML = ' Faýlyň ady: ' + file;
});
