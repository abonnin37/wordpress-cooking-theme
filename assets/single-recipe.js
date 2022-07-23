(function () {
    const homepagebtns = document.getElementsByClassName("single-recipe-homepage-btn");

    Array.from(homepagebtns).map(homepagebtn => {
        homepagebtn.addEventListener('click', event => {
            window.location.href = "/";
        })
    });
})()