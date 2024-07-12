<?php
ob_start(); // Mulai output buffering
include('partials-front/menu.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
date_default_timezone_set('Asia/Jakarta');

require 'vendor/autoload.php'; // Autoload PHPMailer menggunakan Composer

function formatRupiah($angka) {
    return 'Rp.' . number_format($angka, 2, ',', '.');
}


// Cek jika ada parameter food_id dari URL
if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];

        // Simpan informasi produk ke dalam sesi
        $_SESSION['selected_products'][$food_id] = [
            'title' => $title,
            'price' => $price,
            'image_name' => $image_name
        ];
    } else {
        header('location:'.SITEURL); // Ganti dengan halaman yang sesuai
        exit;
    }
    // Proses penghapusan produk dari sesi
    if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['food_id'])) {
        $food_id = $_GET['food_id'];
        if (isset($_SESSION['selected_products'][$food_id])) {
            unset($_SESSION['selected_products'][$food_id]);
        }
        header('location: order.php'); // Redirect kembali ke halaman order.php setelah menghapus
        exit;
    }
}

?>

<section class="food-search-order">
    <div class="container">
        <h2 class="text-center">Form Pemesanan</h2>

        <form action="" method="POST" class="order" enctype="multipart/form-data">
            <fieldset>
                <legend>Produk Terpilih</legend>
                <?php if (!empty($_SESSION['selected_products'])): ?>
                    <?php foreach ($_SESSION['selected_products'] as $food_id => $product): ?>
                        <div class="food-menu-img">
                            <img src="<?php echo SITEURL;?>images/food/<?php echo $product['image_name']; ?>" alt="<?php echo $product['title']; ?>" class="img-responsive">
                        </div>
                        <div class="food-menu-desc">
                            <h3><?php echo $product['title']; ?></h3>
                            <input type="hidden" name="selected_products[<?php echo $food_id; ?>][title]" value="<?php echo $product['title']; ?>">
                            <p class="food-price"><?php echo formatRupiah($product['price']); ?></p>
                            <input type="hidden" name="selected_products[<?php echo $food_id; ?>][price]" value="<?php echo $product['price']; ?>">
                            <div class="order-label">Quantity</div>
                            <input type="number" name="selected_products[<?php echo $food_id; ?>][qty]" class="input-responsive qty-input" data-id="<?php echo $food_id; ?>" data-price="<?php echo $product['price']; ?>" value="1" required>
                            <a href="order.php?action=hapus&food_id=<?php echo $food_id; ?>" class="btn btn-primary">Hapus Produk</a><br><br><br>
                        </div>
                    <?php endforeach; ?>
                    <div class="text-center">
                        <a href="foods.php" class="btn btn-primary">Tambah Produk Lainnya</a>
                    </div>

                <?php else: ?>
                    <p>Belum ada produk yang dipilih.</p>
                <?php endif; ?>
            </fieldset>
            <fieldset>
                <legend>Isian Form</legend>
                <div class="order-label">Nama Lengkap</div>
                <input type="text" name="full-name" placeholder="Masukkan Nama Lengkap" class="input-responsive" required>
                <div class="order-label">No. Telepon</div>
                <input type="tel" name="contact" placeholder="Masukkan No Telp" class="input-responsive" required>
                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="Masukkan Email" class="input-responsive" required>
                <div class="order-label">Alamat</div>
                <textarea name="address" rows="10" placeholder="Masukkan Alamat Pengiriman" class="input-responsive" required></textarea>
                <div class="total-price">
                        <h4>Total Harga:</h4>
                        <?php
                        $total_price = 0;
                        foreach ($_SESSION['selected_products'] as $food_id => $product) {
                            $price = $product['price'];
                            $qty = 1; // Default quantity jika tidak ada
                            $total = $price * $qty;
                            $total_price += $total;
                        }
                        ?>
                        <p id="total-price"><?php echo formatRupiah($total_price); ?></p><br>
                    </div>
                <div class="order-label">Metode Pembayaran</div>
                <select name="payment-method" id="payment-method" class="input-responsive" required>
                    <option value="COD">Cash on Delivery (COD)</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>

                <div id="bank-info" style="display:none;">
                    <div class="order-label">No. Rekening Bank: 1234567890</div>
                    <div class="order-label">Bank: BCA</div>
                </div>

                <div id="ewallet-info" style="display:none;">
                    <div class="order-label">No. HP E-Wallet: 0895321373849</div>
                </div>

                <div id="upload-proof" style="display:none;">
                    <div class="order-label">Unggah Bukti Pembayaran</div>
                    <input type="file" name="payment-proof" class="input-responsive">
                </div>
                <script>
                document.getElementById('payment-method').addEventListener('change', function() {
                    var paymentMethod = this.value;
                    document.getElementById('bank-info').style.display = 'none';
                    document.getElementById('ewallet-info').style.display = 'none';
                    document.getElementById('upload-proof').style.display = 'none';
                    if (paymentMethod === 'Transfer Bank') {
                        document.getElementById('bank-info').style.display = 'block';
                        document.getElementById('upload-proof').style.display = 'block';
                    } else if (paymentMethod === 'E-Wallet') {
                        document.getElementById('ewallet-info').style.display = 'block';
                        document.getElementById('upload-proof').style.display = 'block';
                    }
                });
                
                </script>
                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary"><br><br>
                <div class="order-label">Note : <br><br><p>Setelah menekan tombol Confirm Order, Tunggu beberapa saat hingga kembali ke menu utama. Pembayaran bisa dilakukan secara COD ketika produk sudah sampai.</p></div>
            </fieldset>
        </form>

        <!-- Menampilkan total harga -->
        <script>
            document.querySelectorAll('.qty-input').forEach(function(input) {
                input.addEventListener('input', function() {
                    var totalPrice = 0;
                    var allInputsValid = true; // Menyimpan status validasi semua input

                    document.querySelectorAll('.qty-input').forEach(function(innerInput) {
                        var qty = parseInt(innerInput.value) || 0;
                        var price = parseFloat(innerInput.getAttribute('data-price'));


                        totalPrice += qty * price;

                        // Update kuantitas di session menggunakan AJAX
                        var food_id = innerInput.getAttribute('data-id');
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "update_quantity.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("food_id=" + food_id + "&qty=" + qty);
                    });

                    document.getElementById('total-price').textContent = 'Rp.' + totalPrice.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                });
            });
        </script>


            </fieldset>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $selected_products = $_POST['selected_products'];
            $customer_name = $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];
            $payment_method = $_POST['payment-method'];
            $payment_proof = "";
            
                // Validasi minimal satu produk dipilih
                if (empty($selected_products)) {
                    $_SESSION['order'] = "<div class='error text-center'>Silakan pilih setidaknya satu produk sebelum mengonfirmasi pesanan.</div>";
                    header('location:'.SITEURL);
                    exit;   
                }

            if ($payment_method != "COD" && isset($_FILES['payment-proof']['name'])) {
                $payment_proof = $_FILES['payment-proof']['name'];
                $payment_proof_temp = $_FILES['payment-proof']['tmp_name'];
                $destination = "images/payment-proof/".$payment_proof;
                $upload = move_uploaded_file($payment_proof_temp, $destination);
                if (!$upload) {
                    $_SESSION['order'] = "<div class='error text-center'>Pesanan Berhasil, tetapi gagal mengunggah bukti pembayaran.</div>";
                    header('location:'.SITEURL);
                    exit;
                }
            }


            // Timestamp pesanan
            $order_date = date("Y-m-d h:i:sa");

            // Inisialisasi variabel untuk pesan kesalahan atau sukses
            $pesan_error = "";
            $pesan_sukses = "";

            // Total harga
            $total_price = 0;

            // Mulai transaksi SQL
            mysqli_autocommit($conn, false);
            $error = false;

            try {
                // Iterasi setiap produk yang dipilih
                foreach ($selected_products as $food_id => $product) {
                    $food = $product['title'];
                    $price = $product['price'];
                    $qty = $product['qty'];
                    $total = $price * $qty; // hitung total harga untuk produk ini
                    $status = 'Pesanan Masuk'; // Misalnya, status pending


                    // Tambahkan total harga produk ke total harga keseluruhan
                    $total_price += $total;

                    // Query untuk memasukkan pesanan ke dalam tabel tbl_order
                    $sql_insert = "INSERT INTO tbl_order (food, price, qty, total, order_date, status, customer_name, customer_contact, customer_email, customer_address, payment_method, payment_proof)
                                    VALUES ('$food', '$price', '$qty', '$total', '$order_date', '$status', '$customer_name', '$customer_contact', '$customer_email', '$customer_address', '$payment_method', '$payment_proof')";

                    // Eksekusi query
                    $result = mysqli_query($conn, $sql_insert);

                    if (!$result) {
                        $error = true;
                        $pesan_error = "Gagal menambahkan pesanan ke database.";
                        throw new Exception(mysqli_error($conn));
                    }
                }

                // Commit transaksi jika tidak ada error
                if (!$error) {
                    mysqli_commit($conn);

                    // Kirim email notifikasi
                    $mail = new PHPMailer(true);
                    try {
                        // Konfigurasi server SMTP
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';  // Set host SMTP
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'anandaandraadrianto@gmail.com'; // SMTP username
                        $mail->Password   = 'xjluenyyojjwzoiw'; // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587; // TCP port yang digunakan
    
                        // Pengirim dan penerima
                        $mail->setFrom('anandaandraadrianto@gmail.com', 'Ananda Andra');
                        $mail->addAddress('anandaandraadrianto@gmail.com', 'Admin'); // Alamat email admin
    
                        // Konten email
                        $mail->isHTML(true);
                        $mail->Subject = 'Pesanan Baru Diterima';
                        $mail->Body    = "Halo admin,<br><br>
                                        Ada pesanan baru nih, silahkan cek admin panel untuk memperbarui status pesanannya";
    
                        if ($payment_proof != "") {
                            $mail->Body .= "Bukti Pembayaran: <a href='".SITEURL."images/payment-proof/".$payment_proof."'>Lihat Bukti Pembayaran</a>";
                        }
    
                        $mail->send();
                        unset($_SESSION['selected_products']);
                        $_SESSION['order'] = "<div class='success text-center' style='font-weight: bold; font-size: 24px;'>Pesanan Berhasil dan Tunggu Pesanan Diproses Oleh Penjual. <br> Silahkan Cek Menu Lacak Pesanan untuk mengetahui Status Pesanan.</div>";
                    } catch (Exception $e) {
                        $_SESSION['order'] = "<div class='error text-center'>Pesanan Berhasil, tapi email tidak terkirim. Mailer Error: {$mail->ErrorInfo}</div>";
                    }
                    header('location:'.SITEURL);
                    exit;
                } else {
                    $_SESSION['order'] = "<div class='error text-center'>Pesanan Gagal.</div>";
                    header('location:'.SITEURL);
                    exit;
                }
    

            } catch (Exception $e) {
                $pesan_error = "<div class='error text-center'>Terjadi kesalahan dalam menambahkan pesanan. Silakan coba lagi.</div>";
            }

            // Tampilkan pesan sukses atau error
            if (!empty($pesan_sukses)) {
                echo $pesan_sukses;
            } elseif (!empty($pesan_error)) {
                echo $pesan_error;
            }

            // Redirect kembali ke halaman utama
            header('location:'.SITEURL);
        }
        ?>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>

<?php ob_end_flush(); // Akhiri output buffering ?>
