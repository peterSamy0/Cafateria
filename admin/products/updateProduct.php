<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once '../vendor/autoload.php';
    use App\Classes\Products;

    $product = new Products();
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else{
        $id = 0;
    }
    $item = $product->show($id);
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
                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
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
              <form class="form-horizontal" enctype="multipart/form-data" method="post">
                  <div class="card-body">
                  <div class="form-group row">
                      <label
                        for="ssn"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Product Name</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="name"
                          placeholder="Product Name"
                          name="name"
                          value="<?php echo $item['name']; ?>"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="price"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Product Price</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="number"
                          class="form-control"
                          id="price"
                          placeholder="Product Price"
                          name="price"
                          value="<?php echo $item['price']; ?>"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="isAvailable"
                        class="col-sm-3 text-end control-label col-form-label"
                        >is Available</label
                      >
                      <div class="col-sm-9">
                          <input 
                          type="radio" 
                          name='isAvailable' 
                          value="1" 
                          id="true"
                          <?php echo ($item['isAvailable']) ? "checked" : "unchecked" ?>
                          >
                          <label for="true">True</label>
                        <br>
                        <input 
                        type="radio" 
                        name="isAvailable" 
                        value="0" 
                        id="false"
                        <?php echo (!$item['isAvailable']) ? "checked" : "unchecked" ?>
                        />
                        <label for="false">False</label>
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
                          value="<?php echo $item['name']; ?>"
                        />
                      </div>
                    </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                    <button type="submit" class="btn btn-primary" name="update">
                        Update
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

     
     <?php
     error_reporting(E_ALL);
     ini_set('display_errors', 1);
         if(isset($_POST['update'])){
            // Uncommented code for updating the product
            $product->name = $_POST['name'];
            $product->price = $_POST['price'];
            $img_name = time().$_FILES['image']['name'];
            $product->image = $img_name;
            $img_tmp = $_FILES['image']['tmp_name'];
            move_uploaded_file($img_tmp, '../assets/images/product/'.$img_name);
            if ($_POST['isAvailable'] == 1) {
                $product->isAvailable = 1;
            } else {
                $product->isAvailable = 0;
            }
            $product->update($id);
            // Redirect to index.php
            header("Location:index.php");
        }
     ?>

  </body>
</html>
