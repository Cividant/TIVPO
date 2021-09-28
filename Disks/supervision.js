var back = 0;
function dothis() {
    //для поднятия мидл блока
    (document.getElementById("block").style.top = "5%");
    (document.getElementById("block").style.height = "90%");
    (document.getElementById("all").style.display = "inline-block");
    (document.getElementById("back1").style.display = "inline-block");
    (document.getElementById("imgb").style.display = "none");
    (document.getElementById("gov").style.display = "none");
}
function dothisback() {
    //возвращает элемент мидл блок в изначальное положение и скрывает всё лишнее
    (document.getElementById("block").style.top = "50%");
    (document.getElementById("block").style.height = "10vh");
    (document.getElementById("all").style.display = "none");
    (document.getElementById("back1").style.display = "none");
    (document.getElementById("imgb").style.display = "none");
    (document.getElementById("gov").style.display = "none");
}
function num(a) {
    //функция для записи в невидимый элемент var
    back = a;
    document.getElementById('goto').value = back;
}

