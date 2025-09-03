

const rows = 10;
const cols = 10;
let grid = [];

// Lista de palavras alvo
const targetWords = ["LITERATURA", "APRENDER", "TECNOLOGIA", "INOVAR"];

// Cria a grade com letras aleatórias
for (let i = 0; i < rows; i++) {
    grid[i] = [];
    for (let j = 0; j < cols; j++) {
    grid[i][j] = String.fromCharCode(65 + Math.floor(Math.random() * 26));
    }
}

// Inserção das palavras com posições definidas (sem sobreposição inadequada):

// 1. "HTML" na linha 1, colunas 1 a 4
let word1 = "LITERATURA";
for (let k = 0; k < word1.length; k++) {
    grid[3][0 + k] = word1[k];
}

// 2. "CSS" na vertical: coluna 8, linhas 3, 4 e 5
let word2 = "APRENDER";
for (let k = 0; k < word2.length; k++) {
    grid[1 + k][4] = word2[k];
}

// 3. "JAVASCRIPT" na linha 6, colunas 0 a 9
let word3 = "TECNOLOGIA";
for (let k = 0; k < word3.length; k++) {
    grid[9][k] = word3[k];
}

// 4. "WEB" na linha 8, colunas 4 a 6
let word4 = "INOVAR";
for (let k = 0; k < word4.length; k++) {
    grid[0][3 + k] = word4[k];
}

// Variável para armazenar a seleção atual
let selectedCells = [];

// Função que verifica se a seleção forma uma palavra alvo (considerando também a inversa)
function checkSelection() {
    let currentWord = selectedCells.map(item => item.letter).join('');
    let reversedWord = [...currentWord].reverse().join('');
    
    if (targetWords.includes(currentWord) || targetWords.includes(reversedWord)) {
    // Marcar a palavra na lista
    document.querySelectorAll(".word-list li").forEach(li => {
        if (li.textContent.toUpperCase() === currentWord.toUpperCase() || 
            li.textContent.toUpperCase() === reversedWord.toUpperCase()) {
        li.classList.add("found");
        }
    });
    // Reinicia a seleção: desmarca todas as células selecionadas
    selectedCells.forEach(item => {
        let cell = document.querySelector(`.puzzle-cell[data-row="${item.row}"][data-col="${item.col}"]`);
        if(cell) cell.classList.remove("selected");
    });
    selectedCells = [];
    }
}

// Função para lidar com o clique em cada célula
function handleCellClick(event) {
    const cell = event.target;
    const row = cell.getAttribute("data-row");
    const col = cell.getAttribute("data-col");
    
    // Se a célula já estiver selecionada, desmarca
    if (cell.classList.contains("selected")) {
    cell.classList.remove("selected");
    selectedCells = selectedCells.filter(item => !(item.row === row && item.col === col));
    } else {
    cell.classList.add("selected");
    selectedCells.push({ row, col, letter: cell.textContent });
    }
    
    checkSelection();
    // Para depuração:
    console.log("Seleção atual:", selectedCells.map(item => item.letter).join(''));
}

// Renderiza a grade na div "puzzle"
const puzzleDiv = document.getElementById("puzzle");
for (let i = 0; i < rows; i++) {
    for (let j = 0; j < cols; j++) {
    const cell = document.createElement("div");
    cell.className = "puzzle-cell";
    cell.textContent = grid[i][j];
    cell.setAttribute("data-row", i);
    cell.setAttribute("data-col", j);
    cell.addEventListener("click", handleCellClick);
    puzzleDiv.appendChild(cell);
    }
}

