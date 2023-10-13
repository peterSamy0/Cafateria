<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once '../vendor/autoload.php';
    use App\Classes\Users;

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else{
        $id = 0;
    }
    $users = new Users();
    $user = $users->show($id);
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
            width: 25% !important;
            background-color: #1f262d !important;
            color: #fff !important;
            font-weight: bold !important;
            vertical-align: middle !important;
            text-align: center;
        }
      td {
          vertical-align: middle !important;
          
        }
    </style>
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
              <h4 class="page-title">All Users</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                    <a href="addUser.php">Add New</a></li>
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
                      <td><?php echo $user['user_id']?></td>
                    </tr>
                    <tr>
                      <th scope="row">name</th>
                      <td><?php echo $user['user_name']?></td>
                    </tr>
                    <tr>
                      <th scope="row">Email</th>
                      <td><?php echo $user['email']?></td>
                    </tr>
                    <tr>
                      <th scope="row">Phone</th>
                      <td><?php echo $user['phone']?></td>
                    </tr>
                    <tr>
                      <th scope="row">image</th>
                      <td>
                          <?php
                              $imagePath = '../assets/images/users/';
                              $imageFilename = $user['profileImg'] ;
                              $imageFullPath = $imagePath . $imageFilename;
                              
                              // Check if the image file exists
                              if (file_exists($imageFullPath)) {
                                echo '<img src="' . $imageFullPath . '" alt="" width="60px" height="60px">';
                              } else {
                                // If the image file doesn't exist, display a default image
                                echo '<img src="' . $imagePath . 'default.png" alt="" width="60px" height="60px">';
                              }
                            ?>
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
