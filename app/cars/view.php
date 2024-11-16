<?php include_once 'C:\xampp\htdocs\motors\vendors/functions.php';
include_once 'C:\xampp\htdocs\motors\vendors/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once '../../shared/head.php';
auth();



if (isset($_GET['view'])){
  $id = $_GET['view'];
  $showUser = "SELECT * FROM `cars` WHERE `id` ='$id' ";
  $connectshowUser = mysqli_query($connect, $showUser);
  $showUserData = mysqli_fetch_assoc($connectshowUser);
  $title_car= $showUserData['title'];
  $model_car= $showUserData['model_year'];
  $speed_car= $showUserData['km'];
  $color_car= $showUserData['color'];
  $image_car= $showUserData['image'];
  $desc_car= $showUserData['description'];
  $price_car= $showUserData['price'];
  $status_car= $showUserData['status'];
  // $brand_car= $showUserData['status'];


  
};


?>
<body>
  <?php include_once '../../shared/header.php';
  include_once '../../shared/aside.php';

  ?>




<main id="main" class="main">

  <div class="pagetitle">
    <h1><?=$title_car?></h1>

  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">


      <div class="col-lg-8">

        <div class="card">
          <div class="card-body">


            <!-- Vertical Form -->

              <div class="col-12">

                <img src="<?=base_url("app/cars/upload/$image_car")?>" alt="">
                <h4><?=$image_car?></h4>
              </div>
              <div class="col-12">
                <label for="inputNanme4" class="form-label">model year</label>
                <h4><?=$model_car?></h4>
              </div>
              <div class="col-12">
                <label for="inputNanme4" class="form-label">avg speed</label>
                <h4><?=$speed_car?></h4>
              </div>
              <div class="col-12">
                <label for="inputNanme4" class="form-label">color</label>
                <h4><?=$color_car?></h4>
              </div>
              <div class="col-12">
                <label for="inputNanme4" class="form-label">description</label>
                <h4><?=$desc_car?></h4>
              </div>
              <div class="col-12">
                <label for="inputNanme4" class="form-label">price</label>
                <h4><?=$price_car?><span class="text-success">$</span></h4>
              </div>
              <div class="col-12">
                <label for="inputNanme4" class="form-label">status car</label>
                <h4><?=$status_car?></h4>
              </div>

              <div class="text-center">
                <a   class="btn btn-primary" href="<?=base_url('app/cars/')?>" >back</a>

              </div>


          </div>
        </div>




      </div>
    </div>
  </section>

</main><!-- End #main -->


  <?php include_once '../../shared/footer.php';?>
  <?php include_once '../../shared/script.php';?>




</body>

</html>