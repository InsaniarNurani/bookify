<h3>Pembayaran Ongkir</h3>

<form method="post" action="<?= base_url('peminjaman/bayar/' . $id) ?>">

    <p>Pilih Metode:</p>

    <button type="submit" name="metode" value="dana"
        style="background:#00c853;color:white;padding:10px;border:none;">
        Bayar via DANA
    </button>

    <button type="submit" name="metode" value="transfer"
        style="background:#2962ff;color:white;padding:10px;border:none;">
        Transfer Bank
    </button>

</form>