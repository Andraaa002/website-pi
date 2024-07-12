<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andya Bakery Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Alert Section Starts Here -->
    <section id="alert-section" class="alert-section text-center" style="background-color: #ebb576; padding: 10px 0; display: none; font-family: Arial, sans-serif;">
        <div class="container">
            <p><strong>PENTING!</strong> Pesanan tidak bisa dikirim di hari yang sama (maksimal melakukan pesanan sebelum pukul 17.00)</p>
            <button id="close-alert" class="close-btn">X</button>
        </div>
    </section>
    <!-- Alert Section Ends Here -->

    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="images/Andya.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>">Beranda</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Kategori</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>foods.php">Produk</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>order.php">Keranjang</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>about-us.php">Tentang Kami</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>track-order.php">Lacak Pesanan</a>
                    </li>
                    
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->

<script>
    window.addEventListener('beforeunload', function() {
        window.scrollTo(0, 0);
    });
</script>

</body>
</html>
