<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Pesanan</h1>
        <br><br>

        <?php
            // Fungsi untuk memformat harga ke dalam bentuk Rupiah
            function formatRupiah($angka) {
                return 'Rp.' . number_format($angka, 2, ',', '.');
            }

            //Check whether id is set or not
            if(isset($_GET['id']))
            {
                //Get the Order Details
                $id=$_GET['id'];

                //Get all other details based on this id
                //SQL QUery to get the order details
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                //Execute Query
                $res = mysqli_query($conn, $sql);
                //Count Rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Detail Available
                    $row = mysqli_fetch_assoc($res);

                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];

                }
                else
                {
                    //Detail not Available
                    //Redirect to Manage Order
                    header('location:'.SITEURL.'admin/manage-oder.php');
                }
            }
            else
            {
                //Redirect to Manage Order Page
                header('location:'.SITEURL.'admin/manage-oder.php');
            }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Produk : </td>
                    <td><b><?php echo $food; ?> </b></td>
                </tr>
 
                <tr>
                    <td>Harga : </td>
                    <td>
                        <b> <?php echo formatRupiah ($price); ?> </b>
                    </td>
                </tr>

                <tr>
                    <td>Jumlah : </td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status : </td>
                    <td>
                        <select name="status">
                            <Option <?php if($status=="Pesanan Masuk") {echo "selected";} ?> value="Pesanan Masuk">Pesanan Masuk</Option>
                            <Option <?php if($status=="Pesanan Diproses") {echo "selected";} ?> value="Pesanan Diproses">Pesanan Diproses</Option>
                            <Option <?php if($status=="Sedang Dikirim") {echo "selected";} ?> value="Sedang Dikirim">Sedang Dikirim</Option>
                            <Option <?php if($status=="Diterima") {echo "selected";} ?> value="Diterima">Diterima</Option>
                            <Option <?php if($status=="Batal") {echo "selected";} ?> value="Batal">Batal</Option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Nama Customer : </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>No.Telp : </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Email : </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Alamat : </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php 
            //Check whether Update Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //Get All the Values from Form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $price * $qty;

                $status = $_POST['status'];

                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = $_POST['customer_address'];

                //UPDATE THE VALUES

                $sql2 = "UPDATE tbl_order SET
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address' 
                    WHERE id = $id
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);


                //Check whether update or not
                //And Redirect to Manage Order with Message
                if($res2==true)
                {
                    //Updated
                    $_SESSION['update'] = "<div class='success'>Pesanan Berhasil Diupdate.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
                else
                {
                    //Failed to Update
                    $_SESSION['update'] = "<div class='error'>Gagal MengUpdate Pesanan.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
        ?>


    </div>
</div>

<?php include('partials/footer.php');?>