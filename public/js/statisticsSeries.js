const likeButtons = document.querySelectorAll(".fa-heart");
const dislikeButtons = document.querySelectorAll(".fa-minus-square");
const addButtons = document.querySelectorAll(".fa-clipboard-list");

function giveLike() {
    const likes = this;
    const container = likes.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");

    fetch(`/likeSeries/${id}`).then(function () {
        likes.innerHTML = parseInt(likes.innerHTML) + 1;
    })
}

function giveDislike() {

    const dislikes = this;
    const container = dislikes.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");

    fetch(`/dislikeSeries/${id}`).then(function () {
        dislikes.innerHTML = parseInt(dislikes.innerHTML) + 1;
    })
}

function addToWatched() {
    const add = this;
    const container = add.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");
    console.log(id);
    fetch(`/addToWatchedSeries/${id}`).then(function () {
    })

    add.style.color="#eb5030";
}


likeButtons.forEach(button => button.addEventListener("click", giveLike));
dislikeButtons.forEach(button => button.addEventListener("click", giveDislike));
addButtons.forEach(button => button.addEventListener("click", addToWatched));