<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>🎲 Coin Flip Game</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
      text-align: center;
      padding: 40px;
      color: #333;
    }
    h1 {
      font-size: 2em;
      margin-bottom: 20px;
    }
    .coin {
      width: 120px;
      height: 120px;
      margin: 20px auto;
      position: relative;
      perspective: 1000px;
    }
    .coin div {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background: gold;
      border: 4px solid #444;
      line-height: 120px;
      font-size: 20px;
      font-weight: bold;
      color: #333;
      backface-visibility: hidden;
      position: absolute;
      top: 0;
      left: 0;
    }
    .heads { background: gold; }
    .tails { background: silver; transform: rotateY(180deg); }
    .coin.animate {
      animation: flip 2s ease-out forwards;
    }
    @keyframes flip {
      0%   { transform: rotateY(0); }
      100% { transform: rotateY(1800deg); }
    }
    .controls {
      margin: 20px 0;
    }
    input, select, button {
      padding: 10px;
      margin: 10px;
      font-size: 16px;
      border-radius: 6px;
      border: 1px solid #666;
    }
    button {
      background: #007bff;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
    #result {
      margin-top: 20px;
      font-size: 20px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<h1>🪙 Coin Flip Game</h1>

<div class="coin" id="coin">
  <div class="heads">Heads</div>
  <div class="tails">Tails</div>
</div>

<div class="controls">
  <select id="playerPrediction">
    <option value="">-- Pilih --</option>
    <option value="Heads">Heads</option>
    <option value="Tails">Tails</option>
  </select>
  <input type="number" id="betAmount" placeholder="Taruhan (misal: 100000)">
  <button onclick="playGame()">Flip!</button>
</div>

<div id="result"></div>

<script>
function placeBetFair(playerPrediction, betAmount) {
    const randomNumber = Math.random();
    const actualResult = randomNumber < 0.5 ? 'Heads' : 'Tails';
    const didPlayerWin = (playerPrediction === actualResult);
    const payout = didPlayerWin ? betAmount * 2 : 0;
    return { actualResult, didPlayerWin, payout };
}

function playGame() {
    const coin = document.getElementById('coin');
    const playerPrediction = document.getElementById('playerPrediction').value;
    const betAmount = parseFloat(document.getElementById('betAmount').value);

    if (!playerPrediction || isNaN(betAmount) || betAmount <= 0) {
        alert('Masukkan pilihan dan jumlah taruhan yang valid!');
        return;
    }

    // Animasi koin
    coin.classList.remove('animate');
    void coin.offsetWidth; // trigger reflow biar animasi bisa diulang
    coin.classList.add('animate');

    // Hasil keluar setelah animasi selesai
    setTimeout(() => {
        const result = placeBetFair(playerPrediction, betAmount);

        document.getElementById('result').innerHTML = result.didPlayerWin
            ? `🎉 Selamat! Hasilnya <b>${result.actualResult}</b>. Anda menang $${result.payout}!`
            : `❌ Sayang sekali! Hasilnya <b>${result.actualResult}</b>. Anda kalah $${betAmount}.`;

        // Update tampilan koin sesuai hasil
        if (result.actualResult === 'Heads') {
            coin.style.transform = 'rotateY(0deg)';
        } else {
            coin.style.transform = 'rotateY(180deg)';
        }
    }, 2000);
}
</script>

</body>
</html>
