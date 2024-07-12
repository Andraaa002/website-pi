<?php include('partials-front/menu.php') ?>

    <!-- Welcome Section Starts Here -->
    <section class="welcome text-center">
        <div class="container">

            <?php
            if(isset($_SESSION['order']))
            {
                echo $_SESSION['order'];
                unset ($_SESSION['order']);
            }
            ?>
            <p>Selamat datang di</p>
            <h1>Andya Bakery</h1><br><br><br>
            <p style="color: #eab475";>Ingin roti apa hari ini?.</p><br>
            <a href="foods.php" class="btn-lihat-menu">Lihat Produk</a>
        </div>
    </section>
    <!-- Welcome Section Ends Here -->

    <!-- Div untuk Pembatas Antar Div Section Starts Here -->
    <section class="container text-center" style="background: #fff9ef; width: 100%; padding: 0%;" >
        <div class="baru fade-in-out" >
            <h2 style="font-size: 2.5rem; margin-bottom: 20px;" >Informasi</h2>
            <p style="font-size: 1.2rem; margin-bottom: 20px;" >Toko Buka Setiap Hari</p>
        </div>
    </section>
    <!-- Div untuk Pembatas Antar Div Section Ends Here -->





    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search-home text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Produk Yang Dicari.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->


    <!-- CAtegories Section Starts Here -->
    <section class="categories-home">
        <div class="container">
            <h2 class="text-center">Kategori Favorite</h2>

            <?php
                //Create SQL Query to Display Categories from Database
                $sql = "SELECT * FROM tbl_category WHERE active='Ya' AND featured='Ya' LIMIT 3";
                //Execute the Query
                $res = mysqli_query($conn, $sql);
                //Count Rows to check whether teh category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //Categories Avialable
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the Values like id, title, image_name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                    //Check whether Image is Available or not
                                    if($image_name=="")
                                    {
                                        //Display Message
                                        echo "<div class='error'>Gambar Tidak Tersedia.</div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                

                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    //Categories not Available
                    echo "<div class='error'>Kategori Tidak Ditemukan.</div>";
                }
            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Produk Favorite</h2>

            <?php
            // Fungsi untuk memformat harga ke dalam bentuk Rupiah
            function formatRupiah($angka) {
                return 'Rp.' . number_format($angka, 2, ',', '.');
            }
            

            //Getting Foods from Database that are active and featured
            //SQL Query
            $sql2 = "SELECT * FROM tbl_food WHERE active='Ya' AND featured='Ya' LIMIT 6";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Count Rows
            $count2 = mysqli_num_rows($res2);

            //Check whether food available or not
            if($count2>0)
            {
                //Food Available
                while($row=mysqli_fetch_assoc($res2))
                {
                    //Get all the
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                                //Check whether image available or not
                                if($image_name=="")
                                {
                                    //Image not Available
                                    echo "<div class='error'>Gambar Tidak Tersedia.</div>";
                                }
                                else
                                {
                                    //Image Available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>

                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price"><?php echo formatRupiah ($price); ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Pesan Sekarang</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                //Food Not Available
                echo "<div class='error'>Makanan Tidak Tersedia.</div>";
            }

            ?>


            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="<?php echo SITEURL; ?>foods.php">Lihat Produk Lainnya</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<script>
        // Kode JavaScript untuk peringatan
        document.addEventListener('DOMContentLoaded', function() {
            var alertSection = document.getElementById('alert-section');
            var closeBtn = document.getElementById('close-alert');
            var navbar = document.querySelector('.navbar');
            var welcomeSection = document.querySelector('.welcome');
            var navbarHeight = navbar.offsetHeight; // Tinggi navbar saat ini
            
            alertSection.style.display = 'block'; // Menampilkan peringatan saat halaman dimuat
            navbar.classList.add('fixed'); // Menambahkan kelas fixed pada navbar
            welcomeSection.style.marginTop = navbarHeight + 60 +'px'; // Atur margin atas welcome section sesuai dengan tinggi navbar

            closeBtn.addEventListener('click', function() {
                alertSection.style.display = 'none'; // Menyembunyikan peringatan saat tombol "X" diklik
                navbar.classList.remove('fixed'); // Menghapus kelas fixed dari navbar
                welcomeSection.style.marginTop = '130px'; // Kembalikan margin atas welcome section ke 0
            });
        });

        // Kode JavaScript untuk mengganti gambar latar belakang
        document.addEventListener('DOMContentLoaded', function() {
            var images = [
                'images/back.jpg',
                'images/back2.jpg',
                'images/mockup.jpg',
            ];

            var currentIndex = 0;
            var welcomeSection = document.querySelector('.welcome');
            var backgroundLayers = [];

            images.forEach(function(image, index) {
                var bgDiv = document.createElement('div');
                bgDiv.classList.add('background');
                bgDiv.style.backgroundImage = 'url(' + image + ')';
                if (index === 0) bgDiv.classList.add('active');
                welcomeSection.appendChild(bgDiv);
                backgroundLayers.push(bgDiv);
            });

            function changeBackgroundImage() {
                backgroundLayers.forEach(function(layer, index) {
                    layer.classList.toggle('active', index === currentIndex);
                });
                currentIndex = (currentIndex + 1) % images.length;
            }
            setInterval(changeBackgroundImage, 4500); // Ganti setiap 4.5 detik

        });
    </script>