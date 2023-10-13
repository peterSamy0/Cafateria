<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once '../vendor/autoload.php';
  use App\Classes\Orders; 
  $orders = new Orders();
  $i = 0;
  $orders_array = $orders->getAll();
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
      td {
          vertical-align: middle !important;
          text-align: center;
        }
      th{
        text-align: center;
        background-color: gray !important;
        color: white !important;
        font-weight: bolder !important;
        font-size: 16px;
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
              <h4 class="page-title">Departments</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../home.php">Home</a></li>
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
                <div class="card-body">
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Order ID</th>
                          <th>User Name</th>
                          <th>Total Price</th>
                          <th>Order date</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($orders_array as $order ){ ?>
                        <tr>
                          <td><?php echo $order['order_id'] ?></td>
                          <td><?php echo $order['user_name'] ?></td>
                          <td></td>
                          <td><?php echo $order['order_date']?></td>
                          <td>
                            <a href="showOrder.php?id=<?php echo $order['order_id'] ?>" class="btn btn-primary">show</a>
                            <a href="deleteOrder.php?id=<?php echo $order['order_id'] ?>" class="btn btn-danger" onclick="if(!confirm('Are you sure')){return false; }">delete</a>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
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
