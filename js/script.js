document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("DOMContentLoaded", function () {
        let carousel = document.querySelector("#carouselLivros");
        new bootstrap.Carousel(carousel, {
            interval: false,
            wrap: true
        });
    });
    

    document.querySelector("#bt-next-livros").addEventListener("click", function () {
        carouselInstance.next();
    });

    document.querySelector("#bt-prev-livros").addEventListener("click", function () {
        carouselInstance.prev();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("DOMContentLoaded", function () {
        let carousel = document.querySelector("#carouselMaterias");
        new bootstrap.Carousel(carousel, {
            interval: false,
            wrap: true
        });
    });
    

    document.querySelector("#bt-next-materias").addEventListener("click", function () {
        carouselInstance.next();
    });

    document.querySelector("#bt-prev-materias").addEventListener("click", function () {
        carouselInstance.prev();
    });
});

//modal;
// const btModalLivros = document.querySelector("#bt-Modal-livros");
// btModalLivros.addEventListener('click', ()=>{
//     let modalLivros = document.querySelector("#modalLivros");
//     modalLivros.style.display = 'flex';
// })




// References to DOM Elements
const prevBtn = document.querySelector("#prev-btn");
const nextBtn = document.querySelector("#next-btn");
const book = document.querySelector("#book");

const paper1 = document.querySelector("#p1");
const paper2 = document.querySelector("#p2");
const paper3 = document.querySelector("#p3");

// Event Listener
prevBtn.addEventListener("click", goPrevPage);
nextBtn.addEventListener("click", goNextPage);

// Business Logic
let currentLocation = 2;
let numOfPapers = 2;
let maxLocation = numOfPapers + 1;


function goNextPage() {
    if(currentLocation < maxLocation) {
        switch(currentLocation) {
            
            case 2:
                paper2.classList.add("flipped");
                paper2.style.zIndex = 2;
                paper1.style.zIndex = 0;
                break;
            case 3:
                paper3.classList.add("flipped");
                paper3.style.zIndex = 3;
               
                break;
            default:
                throw new Error("unkown state");
        }
        currentLocation++;
    }
}

function goPrevPage() {
    if(currentLocation > 1) {
        switch(currentLocation) {
            
            case 3:
                paper2.classList.remove("flipped");
                paper2.style.zIndex = 2;
                break;
            case 4:
                // openBook();
                paper3.classList.remove("flipped");
                paper3.style.zIndex = 1;
                break;
            default:
                throw new Error("unkown state");
        }

        currentLocation--;
    }
}

//area de login:
const container = document.getElementById('container-login');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

for (let i=0; i< 1000; i++) {
    const star = document.createElement ('div');
    star.className = 'star';
    document.body.appendChild(star);
    star.style.left = `${Math.random()* 100}vw`;
    star.style.top = `${Math.random()* 100}vh`;
    star.style.width = `${Math.random() * 3 + 1}px`;
    star.style.height = star.style.width;
    star.style.animationDuration = `${Math.random()* 6 + 4}s`;
}

function Login(){
    alert("Login realizado com sucesso!")
    window.location.href = "index.html"
    
}

function Cadastro(){
    alert("Cadastro realizado com sucesso! Volte para a página de login")
}

function proximapag(){
    // window.location.href = "esqueci_senha.html"
}

