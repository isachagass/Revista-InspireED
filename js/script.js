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

//mural:
function allowDrop(event) {
    event.preventDefault(); // Permite que o card seja solto no quadro
}

function drag(event) {
    event.dataTransfer.setData("text", event.target.id); // Armazena o ID do card arrastado
}

function drop(event) {
    event.preventDefault();
    const taskId = event.dataTransfer.getData("text"); // Recupera o ID do card arrastado
    const task = document.getElementById(taskId);
    
    if (task) {
        const board = document.getElementById("board");
        const rect = board.getBoundingClientRect();
        const offsetX = event.clientX - rect.left;
        const offsetY = event.clientY - rect.top;

        // Ajusta a posição do card baseado na posição do mouse
        task.style.left = `${offsetX - task.offsetWidth / 2}px`;
        task.style.top = `${offsetY - task.offsetHeight / 2}px`;
    }
}


//reviisar noticias:
