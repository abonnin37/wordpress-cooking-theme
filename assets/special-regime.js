const specialRegimeHiddenInput = document.getElementById("wprm_keyword");

(function () {
    const specialRegimes = document.getElementsByClassName("special-regime-item");
    let specialRegimeListToSearch = specialRegimeHiddenInput.value ? specialRegimeHiddenInput.value.split(',') : [];


    Array.from(specialRegimes).map(specialRegime => {
        specialRegime.addEventListener('click', event => {
            const index = specialRegimeListToSearch.indexOf(specialRegime.dataset["value"]);

            if(specialRegime.dataset["checked"] === "checked") {
                if (index >= 0 && index < specialRegimeListToSearch.length) {
                    specialRegimeListToSearch.splice(index, 1);
                    specialRegime.dataset["checked"] = "";
                }
            } else {
                specialRegimeListToSearch.push(specialRegime.dataset["value"]);
                specialRegime.dataset["checked"] = "checked";
            }

            specialRegimeHiddenInput.value = specialRegimeListToSearch.join(",");

            // Notify that the special regime input has change
            specialRegimeHiddenInput.dispatchEvent(new Event('change'));
        });
    });
})()