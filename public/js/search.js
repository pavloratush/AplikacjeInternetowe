const search = document.querySelector('input[placeholder="search movie"]');
const moviesContainer = document.querySelector(".movies");

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response){
            return response.json();
        }).then(function (movies){
            moviesContainer.innerHTML="";

            loadMovies(movies)
        });
    }
});

function loadMovies(movies) {
    movies.forEach(movie => {
        console.log(movie);
        createProject(movie);
    });
}

function createProject(movie) {
    const template = document.querySelector("#movie-template");

    const clone = template.content.cloneNode(true);
    const div = clone.querySelector("div");
    div.id = movie.id;
    const image = clone.querySelector("img");
    image.src = `/public/img/movies/${movie.image}`;
    const title = clone.querySelector("h2");
    title.innerHTML = movie.title;
    const like = clone.querySelector(".fa-heart");
    like.innerText = movie.likes;
    const dislike = clone.querySelector(".fa-min" +
        "us-square");
    dislike.innerText = movie.dislikes;

    moviesContainer.appendChild(clone);
}