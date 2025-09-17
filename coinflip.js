// SIMULASI GAME "COIN FLIP" YANG ADIL
function placeBetFair(playerPrediction, betAmount) {
    // 1. Generate hasil lemparan acak yang jujur (50:50)
    const randomNumber = Math.random(); // Math.random() menghasilkan angka antara 0 - 1
    const actualResult = randomNumber < 0.5 ? 'Heads' : 'Tails';

    // 2. Tentukan apakah pemain menang
    const didPlayerWin = (playerPrediction === actualResult);

    // 3. Hitung payout
    let payout = 0;
    if (didPlayerWin) {
        // Jika menang, dapatkan 2x taruhan (taruhan kembali + kemenangan)
        payout = betAmount * 2;
        console.log(`🎉 SELAMAT! Hasilnya ${actualResult}. Anda menang $${payout}!`);
    } else {
        // Jika kalah, dapatkan 0
        payout = 0;
        console.log(`❌ SAYANG SEKALI! Hasilnya ${actualResult}. Anda kalah $${betAmount}.`);
    }

    // 4. Kembalikan hasilnya (biasanya dikirim ke database)
    return { actualResult, didPlayerWin, payout };
}

// Contoh Pemanggilan:
placeBetFair('Heads', 100000); // Player bertaruh 100k pada Heads
// Kemungkinan Output: "🎉 SELAMAT! Hasilnya Heads. Anda menang $200000!"
// Kemungkinan Output: "❌ SAYANG SEKALI! Hasilnya Tails. Anda kalah $100000."