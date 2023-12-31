window.addEventListener('DOMContentLoaded', () => {
    let input = document.querySelector('.contribute__input');
    let nbCharac = input.value.lenght;
    let label = document.querySelector('.contribute__label');

    input.addEventListener('input', () => {
        nbCharac = input.value.length;

        if (nbCharac < 50) {
            label.innerText = nbCharac - 50;
            label.style.color = "red";
        } else {
            label.innerText = 280 - nbCharac;

            if (nbCharac > 280) {
                label.style.color = "red";
            } else {
                label.style.color = "";
            }
        }

        autoResize();
    })

    function autoResize() {
        input.style.height = "auto"; // Reset the height to auto to determine the natural height
        input.style.height = (input.scrollHeight) + "px"; // Set the height to match the content height
    }
})