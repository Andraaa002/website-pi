<?php include('partials-front/menu.php'); ?>

<section class="track-order">
    <br><br>
    <div class="container-track" style="margin-top: 135px">
        <div class="track-order">
            <h2>Lacak Pesanan Kamu</h2>

            <!-- Form untuk melacak pesanan -->
            <form action="" method="POST" class="track-form">
                <label for="customer_name">Nama Customer:</label>
                <input type="text" id="customer_name" name="customer_name" required>

                <label for="customer_contact">Nomor Telepon:</label>
                <input type="text" id="customer_contact" name="customer_contact" required>

                <br>

                <button type="submit" name="track_order">Lacak Pesanan</button>
            </form>

            <!-- Tabel untuk menampilkan pesanan -->
            <table class="tbl-full" style="background-color: #ffffff;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Nama Customer</th>
                        <th>Alamat</th>
                        <th>Total Harga Produk</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // Fungsi untuk format Rupiah
                    function formatRupiah($angka)
                    {
                        return 'Rp.' . number_format($angka, 2, ',', '.');
                    }

                    // Cek apakah form telah disubmit
                    if (isset($_POST['track_order'])) {
                        $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
                        $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);

                        // Query untuk mencari pesanan berdasarkan nama customer dan nomor telepon
                        $sql = "SELECT * FROM tbl_order WHERE customer_name LIKE '%{$customer_name}%' AND customer_contact = '{$customer_contact}' ORDER BY id DESC";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);

                        if ($count > 0) {
                            $i = 1;
                            $total_price = 0; // Variabel untuk menghitung total harga

                            while ($row = mysqli_fetch_assoc($res)) {
                                $food = $row['food'];
                                $status = $row['status'];
                                $customer_name = $row['customer_name'];
                                $customer_address = $row['customer_address'];
                                $price_per_item = $row['price']; // Harga per item dari tabel, asumsi ada kolom 'price'
                                $quantity = $row['qty']; // Jumlah item dari tabel, asumsi ada kolom 'qty'

                                // Hitung total harga per item
                                $total_item_price = $price_per_item * $quantity;

                                // Tambahkan total harga per item ke total harga keseluruhan
                                $total_price += $total_item_price;

                                // Tampilkan data dalam tabel
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $food; ?> (<?php echo $quantity; ?> items)</td>
                                    <td><?php echo $status; ?></td>
                                    <td><?php echo $customer_name; ?></td>
                                    <td><?php echo $customer_address; ?></td>
                                    <td><?php echo formatRupiah($total_item_price); ?></td>
                                </tr>
                                <?php
                            }

                            // Tampilkan baris untuk total harga di luar loop
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: right; font-weight: bold;">Total Harga:</td>
                                <td style="font-weight: bold;"><?php echo formatRupiah($total_price); ?></td>
                            </tr>
                            <?php

                        } else {
                            ?>
                            <tr>
                                <td colspan="8">Pesanan Tidak Ditemukan.</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</section>


<?php include('partials-front/footer.php'); ?>

