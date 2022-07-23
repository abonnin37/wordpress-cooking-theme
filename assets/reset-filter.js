const countryInput = document.getElementById("wprm_cuisine");
const recipeTypeInput = document.getElementById("wprm_course");

/**
 * Check if all the filters are empty
 */
const isAllFiltersEmpty = () => {
    if (
        (ingredientsHiddenInput.value && ingredientsHiddenInput.value !== "") ||
        (specialRegimeHiddenInput.value && specialRegimeHiddenInput.value !== "") ||
        (countryInput.value && countryInput.value !== "") ||
        (recipeTypeInput.value && recipeTypeInput.value !== "")
    ) {
        return false;
    } else {
        return true;
    }
}

const handleResetBtn = () => {
    const resetBtnEl = document.getElementById("resetBtn");

    if (isAllFiltersEmpty()) {
        if (resetBtnEl.classList.contains("show")) {
            resetBtnEl.classList.remove("show");
        }
    } else {
        if (!resetBtnEl.classList.contains("show")) {
            resetBtnEl.classList.add("show");
        }
    }
}

const clearAllFilters = () => {
    // The easiest one
    countryInput.value = "";
    recipeTypeInput.value = "";

    // Erase all ingredient in the visual list
    const ingredientVisualListEl = document.getElementById("ingredients-terms-list");
    ingredientVisualListEl.innerHTML = "";
    ingredientsHiddenInput.value = "";
    ingredientsListToSearch = [];

    // Erase all "checked" propriety from all special regime card
    const specialRegimeItems = document.getElementsByClassName("special-regime-item");
    Array.from(specialRegimeItems).map(specialRegimeItem => {
        if (specialRegimeItem.dataset["checked"] === "checked") {
            specialRegimeItem.dataset["checked"] = "";
        }
    });
    specialRegimeHiddenInput.value = "";
}

(function () {
    handleResetBtn();

    // Detect all changes on inputs fields
    ingredientsHiddenInput.addEventListener("change", event => {
        handleResetBtn();
    });

    specialRegimeHiddenInput.addEventListener("change", event => {
        handleResetBtn();
    });

    countryInput.addEventListener("input", event => {
        handleResetBtn();
    });

    recipeTypeInput.addEventListener("input", event => {
        handleResetBtn();
    });

    const resetBtnEl = document.getElementById("resetBtn");
    resetBtnEl.addEventListener('click', event => {
        if (!isAllFiltersEmpty() && resetBtnEl.classList.contains("show")) {
            resetBtnEl.classList.remove("show");
            clearAllFilters();

        }
    });

})()