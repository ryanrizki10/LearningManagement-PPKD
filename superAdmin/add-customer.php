<?php
if (isset($_POST['save'])) {
    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $customer_address = $_POST['customer_address'];

    $insert = mysqli_query($koneksi, "INSERT INTO customers (customer_name, customer_phone, customer_address)
    VALUES('$customer_name','$customer_phone','$customer_address')");
    if ($insert) {
        header("location:?page=customer&add=success");
    }
}

if (isset($_POST['edit'])) {
    $id = $_GET['edit'];
    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $customer_address = $_POST['customer_address'];

    $update = mysqli_query($koneksi, "UPDATE customers 
    SET customer_name ='$customer_name', customer_phone='$customer_phone', 
    customer_address='$customer_address' WHERE id ='$id'");
    if ($update) {
        header("location:?page=customer&update=success");
    }
}

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM customers WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>Create Customer</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Customer Name *</label>
                        <input
                            value="<?php echo isset($_GET['edit']) ? $rowEdit['customer_name'] : '' ?>"
                            type="text" class="form-control"
                            name="customer_name" required placeholder="Enter Customer Name">
                    </div>
                    <div class="mb-3">
                        <label for="">Customer Phone *</label>
                        <input type="number" class="form-control"
                            value="<?php echo isset($_GET['edit']) ? $rowEdit['customer_phone'] : '' ?>"
                            name="customer_phone" required placeholder="Enter Customer Phone">
                    </div>
                    <div class="mb-3">
                        <label for="">Customer Address </label>
                        <input type="text" class="form-control"
                            value="<?php echo isset($_GET['edit']) ? $rowEdit['customer_address'] : '' ?>"
                            name="customer_address" placeholder="Enter Customer Address">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'save' ?>">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>