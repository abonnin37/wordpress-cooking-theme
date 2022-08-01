let ingredientsListToSearch = [];
const ingredientsHiddenInput = document.getElementById("wprm_ingredient");

/**
 * Add an ingredient to the input field
 *
 * @param ingredientName Name of the ingredient to add
 * @param ingredientsTermsList Element that contain all the ingredient item elements
 * @param ingredientHiddenInput Input that contain the list of ingredient to search for
 */
const addIngredient = (ingredientName, ingredientsTermsList, ingredientHiddenInput) => {
    // Close icon element
    let newIngredientCloseElement = document.createElement('span');
    let closeIconElement = document.createElement('i');
    closeIconElement.classList.add("fa-solid", "fa-xmark");
    closeIconElement.dataset.parentId = "ingredient-term-" + getSlugFromIngredientName(ingredientName);
    closeIconElement.dataset.ingredientName = ingredientName;
    addRemoveEventListener(closeIconElement, ingredientsTermsList, ingredientHiddenInput);
    newIngredientCloseElement.classList.add("ingredient-term-close");
    newIngredientCloseElement.appendChild(closeIconElement);

    // New ingredient element
    let newIngredientElement = document.createElement('li');
    newIngredientElement.classList.add("ingredient-term");
    newIngredientElement.id = "ingredient-term-" + getSlugFromIngredientName(ingredientName);
    newIngredientElement.innerHTML = ingredientName;
    newIngredientElement.appendChild(newIngredientCloseElement);

    // Add new ingredient element to the ingredient list
    ingredientsTermsList.appendChild(newIngredientElement);
}

/**
 * Add an eventListener on the close icon element at his creation to handle the remove action
 *
 * @param closeIconElement Close icon element
 * @param ingredientsTermsList DOM list from what the element has to be removed
 */
const addRemoveEventListener = (closeIconElement, ingredientsTermsList) => {
    closeIconElement.addEventListener('click', event => {
        ingredientsListToSearch.splice(ingredientsListToSearch.indexOf(closeIconElement.dataset.ingredientName), 1);
        ingredientsTermsList.removeChild(document.getElementById(event.target.dataset.parentId));
        ingredientsHiddenInput.value = ingredientsListToSearch.join(',');

        // Notify that the ingredient input has change
        ingredientsHiddenInput.dispatchEvent(new Event('change'));
    });
}

/**
 * Get slug from ingredient name
 * @param ingredientName Ingredient Name
 */
const getSlugFromIngredientName = (ingredientName) => {
    return ingredientName.toLowerCase().replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,'').replace(/ /g, '-');
}

/**
 * Get ingredient list from back end in function of the name and selected ingredients.
 * Add event listener on each new ingredient
 */
const getIngredientListFromWordpressApi = () => {
    const ingredientInput = document.getElementById('ingredients-input');
    const ingredientList = document.getElementById('ingredient-list');

    fetch('https://' + window.location.hostname + '/wp-json/casalbbb/v1/taxonomies-by-name?name='+ ingredientInput.value +'&selected_ingredients='+ ingredientsListToSearch.join(','), {
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => {
            cleanIngredientList();

            if (data["status"] === 200 ) {
                if (data["length"] > 0) {
                    data["ingredients"].map(ingredientName => {
                        // New ingredient element
                        let newIngredientOption = document.createElement('option');
                        newIngredientOption.value = ingredientName;
                        newIngredientOption.innerHTML = ingredientName;

                        addIngredientToSearchList(newIngredientOption);

                        // Add new ingredient element to the ingredient list
                        ingredientList.appendChild(newIngredientOption);
                    });
                } else {
                    addErrorMessageToIngredientList(__("Aucun ingrédient n'a été trouvé pour la recherche : \"", 'casalbbb') + ingredientInput.value + "\"");
                }
            } else {
                addErrorMessageToIngredientList(__("Aucun ingrédient n'a été trouvé pour la recherche : \"", 'casalbbb') + ingredientInput.value + "\"");
            }
        })
        .catch(error => {
            addErrorMessageToIngredientList(__("Aucun ingrédient n'a été trouvé pour la recherche : \"", 'casalbbb') + ingredientInput.value + "\"");
        });
}

/**
 * Replace some caracters by ASCII code
 *
 * @param text Text to check
 * @returns {*} Text with special caracters changed
 */
const escapeHtml = (text) => {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

/**
 * Add ingredient to the search list with a click event listener
 *
 * @param ingredientEl Option element that contain the value of the ingredient
 */
const addIngredientToSearchList = (ingredientEl) => {
    const ingredientsListContainer = document.getElementById('ingredient-list');
    const ingredientsTermsList = document.getElementById("ingredients-terms-list");
    const ingredientInput = document.getElementById('ingredients-input');

    ingredientEl.addEventListener('click', event => {
        const ingredientIndex = ingredientsListToSearch.indexOf(ingredientEl.innerText);

        if (ingredientIndex < 0) {
            addIngredient(ingredientEl.innerText, ingredientsTermsList, ingredientsHiddenInput);
            // We escape html of ingredientEl.innerText because the plugin WPRM store ingredients with ASCII code
            ingredientsListToSearch.push(escapeHtml(ingredientEl.innerText));

            // Update hidden input field
            ingredientsHiddenInput.value = ingredientsListToSearch.join(',');

            // Ocult the search list
            ingredientsListContainer.style.display = 'none';

            // Clean input field
            ingredientInput.value = "";

            // Notify that the ingredient input has change
            ingredientsHiddenInput.dispatchEvent(new Event('change'));
        }
    });
}

const cleanIngredientList = () => {
    const ingredientList = document.getElementById('ingredient-list');
    let lastChild = ingredientList.lastElementChild;

    while (lastChild) {
        ingredientList.removeChild(lastChild);
        lastChild = ingredientList.lastElementChild;
    }
}

const addSpinnerToIngredientList = () => {
    const ingredientList = document.getElementById('ingredient-list');
    ingredientList.appendChild(getSpinner());
}

const addErrorMessageToIngredientList = (message) => {
    const ingredientList = document.getElementById('ingredient-list');

    const errorMessageContainer = document.createElement('div');
    errorMessageContainer.classList.add("ingredient-error-message-container");
    errorMessageContainer.appendChild(document.createTextNode(message));

    ingredientList.appendChild(errorMessageContainer);
}

const getSpinner = () => {
    const flexContainer = document.createElement('div');
    flexContainer.classList.add("d-flex", "justify-content-start", "align-items-center", "spinner-container");

    const spinnerContainer = document.createElement('div');
    spinnerContainer.classList.add('spinner-border', 'spinner-border-sm', 'spinner-element');
    spinnerContainer.role = "status";

    const spinnerEl = document.createElement('span');
    spinnerEl.classList.add('visually-hidden');
    spinnerEl.appendChild(document.createTextNode("En chargement ..."));

    spinnerContainer.appendChild(spinnerEl);
    flexContainer.appendChild(spinnerContainer);
    flexContainer.appendChild(document.createTextNode(__('En cours de recherche ...', 'casalbbb')))

    return flexContainer;
}

(function () {
    const ingredientInputContainer = document.getElementById('ingredients-input-container');
    const ingredientInput = document.getElementById('ingredients-input');
    const ingredientsListContainer = document.getElementById('ingredient-list');
    const ingredientsEls = ingredientsListContainer.getElementsByTagName("option");

    const ingredientsTermsList = document.getElementById("ingredients-terms-list");
    ingredientsListToSearch = ingredientsHiddenInput.value ? ingredientsHiddenInput.value.split(',') : [];

    // Display the search list
    let lastKeyPressEventDate = new Date();
    let timeout = null;
    ingredientInput.onkeyup = event => {
        // Prevent to do anything if Enter key is hit
        if (
            event.key === "Enter" ||
            event.keyCode === 13 ||
            event.key === "ArrowUp" ||
            event.key === "ArrowDown" ||
            event.key === "ArrowLeft" ||
            event.key === "ArrowRight"
        ) {
            return;
        }

        if (ingredientInput.value === "") {
            ingredientsListContainer.style.display = 'none';
        } else {
            const actualKeypressDate = new Date();

            if (actualKeypressDate - lastKeyPressEventDate > 800) {
                cleanIngredientList();
                addSpinnerToIngredientList();

                timeout = setTimeout(getIngredientListFromWordpressApi, 800);
            } else {
                clearTimeout(timeout);
                timeout = setTimeout(getIngredientListFromWordpressApi, 800);
            }

            lastKeyPressEventDate = actualKeypressDate;
            ingredientsListContainer.style.display = 'block';
        }
    }

    // Avoid the user to submit the form with Enter key on the ingredient search input field
    ingredientInput.addEventListener('keydown', event => {
        if (event.key === "Enter" || event.keyCode === 13) {
            event.preventDefault();
        }
    });

    // As we have desactivate the submit action we can test if the "clear" event is triggered to dismiss the search list
    ingredientInput.addEventListener('search', event => {
        ingredientsListContainer.style.display = 'none';
    });

    // When the user click on the input field the result has to show
    ingredientInput.addEventListener('click', event => {
        if (ingredientInput.value !== "") {
            ingredientsListContainer.style.display = 'block';
        }
    });

    // Ocult the search list
    document.addEventListener('click', event => {
        if (!ingredientInputContainer.contains(event.target)) {
            ingredientsListContainer.style.display = 'none';
        }
    });

    // When document is ready set the ingredients in the url
    document.addEventListener("DOMContentLoaded", event => {
        ingredientsListToSearch.map(ingredient => {
            addIngredient(ingredient, ingredientsTermsList, ingredientsHiddenInput);
        });
    });

    // Create the visual ingredient list when the user click on an ingredient in the search list
    Array.from(ingredientsEls).map(ingredientEl => {
        addIngredientToSearchList(ingredientEl);
    });
})()