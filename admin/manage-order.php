<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Pengelolaan Pesanan</h1>

        <br /><br /><br />

        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>

        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>No.</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal Pesanan</th>
                <th>Status</th>
                <th>Nama Customer</th>
                <th>No.Telp</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Metode Pembayaran</th>
                <th>Bukti Pembayaran</th>
                <th>Tindakan</th>
            </tr>

            <?php
            // Fungsi untuk memformat harga ke dalam bentuk Rupiah
            function formatRupiah($angka)
            {
                return 'Rp.' . number_format($angka, 2, ',', '.');
            }

            //Get all the orders from database
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //Display the Latest Order at First
            //Execute Query
            $res = mysqli_query($conn, $sql);
            //Count the Rows
            $count = mysqli_num_rows($res);

            $sn = 1; //Create a Serial Number and set its initial value as 1

            if ($count > 0) {
                //Order Available
                while ($row = mysqli_fetch_assoc($res)) {
                    //Get all the order details
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                    $payment_method = $row['payment_method'];
                    $payment_proof = $row['payment_proof'];

                    ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $food; ?></td>
                        <td><?php echo formatRupiah($price); ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo formatRupiah($total); ?></td>
                        <td><?php echo $order_date; ?></td>

                        <td>
                            <?php
                            //Pesanan Diterima, Pesanan Diproses, Sedang Dikirim, Diterima, Batal
                            if ($status == "Pesanan Masuk") {
                                echo "<label>$status</label>";
                            } elseif ($status == "Pesanan Diproses") {
                                echo "<label style='color: blue;'>$status</label>";
                            } elseif ($status == "Sedang Dikirim") {
                                echo "<label style='color: orange;'>$status</label>";
                            } elseif ($status == "Diterima") {
                                echo "<label style='color: green;'>$status</label>";
                            } elseif ($status == "Batal") {
                                echo "<label style='color: red;'>$status</label>";
                            }
                            ?>
                        </td>

                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td><?php echo $payment_method; ?></td>
                        <td>
                            <?php
                            if ($payment_proof != "") {
                                echo "<a href='" . SITEURL . "images/payment-proof/" . $payment_proof . "' target='_blank'>Lihat Bukti</a>";
                            } else {
                                echo "Tidak ada bukti";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Pesanan</a>
                        </td>
                    </tr>

                <?php
                }
            } else {
                //Order not Available
                echo "<tr><td colspan='14' class='error'>Tidak ada Pesanan.</td></tr>";
            }
            ?>

        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
