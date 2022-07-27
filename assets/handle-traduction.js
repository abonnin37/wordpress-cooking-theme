const { __, _x, _n, _nx } = wp.i18n;

(function () {
    /*const frenchSelector = document.getElementById("locale-fr_FR");
    const portugueseSelector = document.getElementById("locale-pt_BR");

    frenchSelector.addEventListener("click", event => {
        const params = getQueryParams();

        if (params.locale === "pt_BR") {
            window.location.href =  "/" + (getNewQueryParams(params) === "" ? "" : "?" + getNewQueryParams(params));

        }
    });

    portugueseSelector.addEventListener('click', event => {
        const params = getQueryParams();


        if (params.locale !== "pt_BR") {
            window.location.href =  "/?locale=pt_BR" + (getNewQueryParams(params) === "" ? "" : "&" + getNewQueryParams(params));
        }
    });*/
})()

const getQueryParams = () => {
    return new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });
}

const getNewQueryParams = (params) => {
    return (params.s && params.s !== "" ? params.s + "&" : "") +
        (params.wprm_course && params.wprm_course !== "" ? "wprm_course=" + params.wprm_course + "&" : "") +
        (params.wprm_cuisine && params.wprm_cuisine !== "" ? "wprm_cuisine=" + params.wprm_cuisine + "&" : "") +
        (params.wprm_keyword && params.wprm_keyword !== "" ? "wprm_keyword=" + params.wprm_keyword + "&" : "") +
        (params.wprm_ingredient && params.wprm_ingredient !== "" ? "wprm_ingredient=" + params.wprm_ingredient : "");
}