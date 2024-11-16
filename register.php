<?php include_once 'C:\xampp\htdocs\motors\vendors/functions.php';?>
<?php include_once 'C:\xampp\htdocs\motors\vendors/config.php';?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once './shared/head.php';
$message = null;
if(isset($_POST['register'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hash_password = password_hash($password , PASSWORD_DEFAULT);
  // check if there's same email
  $select = "SELECT * FROM `user` WHERE `email`='$email' ";
  $data = mysqli_query($connect ,$select);
  $num_row = mysqli_num_rows($data);
  if($num_row == 1){
    echo 'that email has already exist';
  }else{
  $image_name = rand(0, 255) . $_FILES['image']['name'];
  $tmp_name = $_FILES['image']['tmp_name'];
  $location_img = "./app/users/upload/$image_name";
  move_uploaded_file($tmp_name,$location_img); 
  $insert = "INSERT INTO user VALUES (NULL , '$name','$email','$hash_password','$image_name', DEFAULT)";
  mysqli_query($connect , $insert);

  redirect('login.php');  
  };

}
?>
<body>


  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form class="row g-3 needs-validation" method="POST" enctype="multipart/form-data">
                    <div class="col-12">
                      <label for="yourName" class="form-label">Your Name</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                    </div>



                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <label  class="form-label">your image</label>
                      <input type="file" name="image" accept="image/*" class="form-control btn btn-warning"  required>
                    </div>


                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="register" type="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="<?= base_url("login.php")?>">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->






  <?php include_once './shared/script.php';?>




</body>

</html>