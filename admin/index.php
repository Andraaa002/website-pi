<?php include('partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
         <div class = "main-content">
            <div class = "wrapper">
                <h1>Dashboard</h1>
                <br /><br />
                <?php 
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }

                    if(isset($_SESSION['order']))
                    {
                        echo $_SESSION['order'];
                        unset($_SESSION['order']);
                    }
                ?>

                <br><br>
                
                <div class = "col-4 text-center">

                    <?php
                        //SQL Query 
                        $sql = "SELECT * FROM tbl_category";
                        //Execute Query
                        $res = mysqli_query($conn, $sql);
                        //Count Rows
                        $count = mysqli_num_rows($res);
                    ?>

                    <h1><?php echo $count; ?></h1>
                    <br />
                    Kategori Produk
                </div>

                <div class = "col-4 text-center">

                        <?php
                            //SQL Query 
                            $sql2 = "SELECT * FROM tbl_food";
                            //Execute Query
                            $res2 = mysqli_query($conn, $sql2);
                            //Count Rows
                            $count2 = mysqli_num_rows($res2);
                        ?>

                    <h1><?php echo $count2; ?></h1>
                    <br />
                    Produk
                </div>

                <div class = "col-4 text-center">

                    <?php
                         //SQL Query 
                        $sql3 = "SELECT * FROM tbl_order";
                        //Execute Query
                        $res3 = mysqli_query($conn, $sql3);
                        //Count Rows
                        $count3 = mysqli_num_rows($res3);
                    ?>

                    <h1><?php echo $count3; ?></h1>
                    <br />
                    Order
                </div>

                <div class = "col-4 text-center">

                    <?php 

                        // Fungsi untuk memformat harga ke dalam bentuk Rupiah
                        function formatRupiah($angka) {
                            return 'Rp.' . number_format($angka, 2, ',', '.');
                        }

                        //Create SQL Query to Get Total Revenue Generated
                        //Aggregate Function in SQL
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Diterima'";

                        //Execute the Query
                        $res4 = mysqli_query($conn, $sql4);

                        //Get the Value
                        $row4 = mysqli_fetch_assoc($res4);

                        //Get the Total Revenue
                        $total_revenue = $row4['Total'];

                    ?>

                    <h1><?php echo formatRupiah ($total_revenue); ?></h1>
                    <br />
                    Pendapatan
                </div>

                <div class="clearfix"></div>

            </div>
         </div>
        <!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>
