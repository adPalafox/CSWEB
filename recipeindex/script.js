const btns = document.querySelectorAll('.btn')
const lists = document.querySelectorAll('.recipe_list')

btns.forEach(btn => {
    btn.addEventListener("click", () => {

        btns.forEach(btn => btn.classList.remove("active"));
        lists.forEach(recipe_list => recipe_list.classList.remove("active"));

        btn.classList.add("active");
        document.querySelector(btn.dataset.target).classList.add("active");
    })
})