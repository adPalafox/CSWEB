var add_ingredient = document.getElementById("addingr")
var add_step = document.getElementById("addstep")

var sub_ingredient = document.getElementById("subingr")
var sub_step = document.getElementById("substep")

var ingr_container = document.getElementById("ingr_box")
var step_container = document.getElementById("step_box")

var x = 1;
var y = 1;

add_ingredient.onclick = function () {
    var input = document.createElement("input");
    input.type = "text";
    input.name = "ingredients" + x;
    input.id = "x" + x;
    input.classList.add("input");
    ingr_container.appendChild(input);
    x++;
    localStorage.setItem("X", x)
}

add_step.onclick = function () {
    var input1 = document.createElement("textarea");
    input1.cols = "40";
    input1.rows = "3";
    input1.name = "steps" + y;
    input1.id = "y" + y;
    input1.classList.add("input");
    step_container.appendChild(input1);
    y++;
    localStorage.setItem("Y", y)
}


sub_ingredient.onclick = function () {
    if (x == 1){
        document.getElementById("x0").value = "";
    }
    if (x > 1) {
        ingr_container.removeChild(ingr_container.lastChild);
        x--;
        localStorage.setItem("X", x)
    }

}


sub_step.onclick = function () {
    if (y == 1){
        document.getElementById("y0").value = "";
    }
    if (y > 1) {
        step_container.removeChild(step_container.lastChild);
        y--;
        localStorage.setItem("Y", y)
    }

}
