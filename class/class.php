<?php
class Pembayaran {
    private $totalBayar;
    private $diskon;

    public function __construct($totalBayar, $diskon) {
        $this->totalBayar = $totalBayar;
        $this->diskon = $diskon;
    }

    public function hitungTotalBersih() {
        $diskonNominal = $this->totalBayar * ($this->diskon / 100);
        return $this->totalBayar - $diskonNominal;
    }
}

$totalBersih = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalBayar = isset($_POST['totalBayar']) ? floatval($_POST['totalBayar']) : 0;
    $diskon = isset($_POST['diskon']) ? floatval($_POST['diskon']) : 0;

    $pembayaran = new Pembayaran($totalBayar, $diskon);
    $totalBersih = $pembayaran->hitungTotalBersih();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        form {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="number"] {
            width: 96%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #e7f3fe;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Perhitungan Pembayaran</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="totalBayar">Total Bayar:</label>
        <input type="number" id="totalBayar" name="totalBayar" required step="0.01">

        <label for="diskon">Diskon (%):</label>
        <input type="number" id="diskon" name="diskon" required step="0.01">

        <input type="submit" value="Hitung Total Bersih">
    </form>

    <?php if ($totalBersih !== null): ?>
    <div class="result">
        <p>Total Bersih Pembayaran: Rp <?php echo number_format($totalBersih, 2, ',', '.'); ?></p>
    </div>
    <?php endif; ?>
</body>
</html>