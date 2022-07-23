let closeBtnIsShowed = false;

const removeCloseBtn = () => {
    const inputEl = document.getElementById("searchbox-main-input-container");
    const closeBtnEl = document.getElementById("close-btn-container");
    inputEl.removeChild(closeBtnEl);
    closeBtnIsShowed = false;
}

const addCloseBtn = () => {
    const inputEl = document.getElementById("searchbox-main-input-container");
    inputEl.appendChild(getCloseBtn());
    closeBtnIsShowed = true;
}

const getCloseBtn = () => {
    const closeBtnContainer = document.createElement('div');
    closeBtnContainer.classList.add("close-btn-container");
    closeBtnContainer.id = "close-btn-container";

    const stickContainer = document.createElement('div');
    stickContainer.classList.add('stick-container');

    const rightStickEl = document.createElement('div');
    rightStickEl.classList.add("left-stick", "stick");

    const leftStickEl = document.createElement('div');
    leftStickEl.classList.add("right-stick", "stick");

    stickContainer.appendChild(rightStickEl);
    stickContainer.appendChild(leftStickEl);
    closeBtnContainer.appendChild(stickContainer);

    closeBtnContainer.addEventListener('click', event => {
        clearMainInputField();
    });

    return closeBtnContainer;
}

const clearMainInputField = () => {
    const searchInputEl = document.getElementById("searchbox-main-input");
    removeCloseBtn();
    searchInputEl.value = "";
}

(function () {
    const searchInputEl = document.getElementById("searchbox-main-input");

    if (searchInputEl.value !== "" && !closeBtnIsShowed) {
        addCloseBtn();
    }

    searchInputEl.onkeyup = event => {
        if (searchInputEl.value === "") {
            removeCloseBtn();
        } else if (searchInputEl.value !== "" && !closeBtnIsShowed) {
            addCloseBtn();
        }
    };
})()