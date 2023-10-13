<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once '../vendor/autoload.php';
    use App\Classes\Users;

    $user = new Users();

    if(isset($_POST['add'])){
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->phone = $_POST['phone'];
        $user->passwd = $_POST['password'];
        $img_name = time().$_FILES['image']['name'];
        $user->profileImg = $img_name;
        $img_tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($img_tmp, '../assets/images/users/'.$img_name);
        $user->add();
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <?php include_once '../includes/head.php' ?>
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
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      <header class="topbar" data-navbarbg="skin5">
        <?php include_once '../includes/main_header.php' ?>
      </header>
      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <?php include_once '../includes/aside.php' ?>
        </aside>
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <?php if(isset($inserResult)){ ?>
            <div class="alert alert-success">Added..</div>
            <?php } ?>

            <?php if(isset($errors) && !empty($errors)){ ?>
            <div class="alert alert-danger">
              <ul>
                <?php foreach($errors as $error){ ?>
                  <li><?php echo $error; ?></li>
                <?php } ?>
              </ul>
            </div>
            <?php } ?>

            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Add Employee</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php">All Employees</a>
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Start Page Content -->
          <!-- ============================================================== -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form class="form-horizontal" enctype="multipart/form-data" method="POST">
                  <div class="card-body">
                  <div class="form-group row">
                      <label
                        for="ssn"
                        class="col-sm-3 text-end control-label col-form-label"
                        >User Name</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="name"
                          placeholder="User Name"
                          name="name"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="price"
                        class="col-sm-3 text-end control-label col-form-label"
                        >User Email</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="email"
                          class="form-control"
                          id="price"
                          placeholder="User Email"
                          name="email"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                        <label
                            for="isAvailable"
                            class="col-sm-3 text-end control-label col-form-label"
                            >Phone</label
                        >
                        <div class="col-sm-9">
                            <input type="number" name='phone' placeholder="user phone">
                            <br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label
                            for="isAvailable"
                            class="col-sm-3 text-end control-label col-form-label"
                            >Password</label
                        >
                        <div class="col-sm-9">
                            <input type="password" name='password' placeholder="user password">
                            <br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label
                            for="isAvailable"
                            class="col-sm-3 text-end control-label col-form-label"
                            >Confirm Password</label
                        >
                        <div class="col-sm-9">
                            <input type="password" name='confirmPass' placeholder="Confirm Password">
                            <br>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="image"
                        class="col-sm-3 text-end control-label col-form-label"
                        >image</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="file"
                          class="form-control"
                          id="image"
                          placeholder="choose the image..."
                          name="image"
                        />
                      </div>
                    </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-primary" name="add">
                        Add
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- End Page Content -->

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
          <?php include_once '../includes/footer.php' ?>
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php include_once '../includes/scripts.php' ?>
    <!-- This Page JS -->

  </body>
</html>
