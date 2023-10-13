<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once '../vendor/autoload.php';
    use App\Classes\Orders;

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else{
        $id = 0;
    }
    $order = new Orders();
    $items = $order->show($id);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <?php include_once '../includes/head.php' ?>
    <link
      href="../assets/css/dataTables.bootstrap4.css"
      rel="stylesheet"
    />
    <style>
        table{
            margin-bottom: 0 !important;
        }
        th{
            background-color: #1f262d !important;
            color: #fff !important;
            font-weight: bold !important;
        }
        td{
          vertical-align: middle;
        }
    </style>
  </head>

  <body>

    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >

      <header class="topbar" data-navbarbg="skin5">
       <?php include_once '../includes/main_header.php' ?>
      </header>

      <aside class="left-sidebar" data-sidebarbg="skin5">
        <?php include_once "../includes/aside.php" ?>
      </aside>

      <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Employees</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../home.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                    <a href="add.php">Add New</a></li>
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- End Bread crumb -->

        <!-- Container fluid -->
        <div class="container-fluid">
          <!-- Start Page Content -->
          <div class="row">
            <div class="col-12">
            <div class="card">
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">ID no</th>
                            <th scope="row">Name</th>
                            <th scope="row">Products</th>
                            <th scope="row">Quantity</th>
                            <th scope="row">Price / one</th>
                            <th scope="row">Total Price</th>
                        </tr>
                        <tr> 
                            <td><?php echo $items[0]['order_id']; ?></td>
                            <td><?php echo $items[0]['user_name']; ?></td>
                            <td>
                                <?php foreach($items as $item): ?>
                                <?php echo $item['product_name']; ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach($items as $item): ?>
                                <?php echo $item['quantity']; ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach($items as $item): ?>
                                <?php echo $item['price']; ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                            <?php
                                $totalPrice = 0;
                                foreach($items as $item):
                                    $totalPrice += $item['price'] * $item['quantity'];
                                endforeach;
                                ?>

                                <?php echo $totalPrice ." E.L"; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- End Page Content -->

        </div>
        <!-- End Container fluid -->

        <!-- footer -->
        <footer class="footer text-center">
          <?php include_once '../includes/footer.php' ?>
        </footer>
        <!-- End footer -->
        
      </div>
      <!-- End Page wrapper -->
    </div>
    <!-- End Wrapper -->

    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php include_once '../includes/scripts.php' ?>
    
    <!-- this page js -->
    <script src="../assets/js/datatables.min.js"></script>
    <script>
      /****************************************
       *       Basic Table                   *
       ****************************************/
      $("#zero_config").DataTable();
    </script>
  </body>
</html>
