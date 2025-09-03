let emojis = ['🐶', '🐱', '🐭', '🐹', '🦊', '🐻',
              '🦁', '🐮', '🐷', '🐸', '🐵', '🐴'];

function startGame() {
    let cards = [...emojis, ...emojis].sort(() => Math.random() - 0.5);
    const board = document.getElementById('game-board');
    const movesCounter = document.getElementById('moves-counter');
    let moves = 0;
    let firstCard = null;
    let lockBoard = false;

    board.innerHTML = '';
    movesCounter.textContent = `Movimentos: 0`;

    function updateMoves() {
    moves++;
    movesCounter.textContent = `Movimentos: ${moves}`;
    }

    function checkGameOver() {
    if (document.querySelectorAll('.matched').length === cards.length) {
        setTimeout(() => {
        confettiEffect();
    
        }, 500);
    }
    }

    function confettiEffect() {
    var duration = 3 * 1000;
    var end = Date.now() + duration;

    (function frame() {
        confetti({
        particleCount: 5,
        angle: 60,
        spread: 55,
        origin: { x: 0 }
        });
        confetti({
        particleCount: 5,
        angle: 120,
        spread: 55,
        origin: { x: 1 }
        });

        if (Date.now() < end) {
        requestAnimationFrame(frame);
        }
    })();
    }

    function createCard(emoji, index) {
    const card = document.createElement('div');
    card.classList.add('card');
    card.dataset.emoji = emoji;
    card.dataset.index = index;

    const inner = document.createElement('div');
    inner.classList.add('card-inner');

    const front = document.createElement('div');
    front.classList.add('card-front');

    const back = document.createElement('div');
    back.classList.add('card-back');
    back.textContent = emoji;

    inner.appendChild(front);
    inner.appendChild(back);
    card.appendChild(inner);

    card.addEventListener('click', flipCard);

    return card;
    }

    function flipCard() {
    if (lockBoard || this.classList.contains('flipped')) return;

    this.classList.add('flipped');

    if (!firstCard) {
        firstCard = this;
        return;
    }

    updateMoves();

    if (firstCard.dataset.emoji === this.dataset.emoji) {
        firstCard.classList.add('matched');
        this.classList.add('matched');
        firstCard = null;
        checkGameOver();
    } else {
        lockBoard = true;
        setTimeout(() => {
        firstCard.classList.remove('flipped');
        this.classList.remove('flipped');
        firstCard = null;
        lockBoard = false;
        }, 1000);
    }
    }

    cards.forEach((emoji, index) => {
    board.appendChild(createCard(emoji, index));
    });
}

// iniciar jogo
startGame();

// botão de reiniciar
document.getElementById('restart-btn').addEventListener('click', startGame);