<?php include_once 'C:\xampp\htdocs\motors\vendors/functions.php';?>
<?php include_once 'C:\xampp\htdocs\motors\vendors/config.php';?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once './shared/head.php';

print_r($jsonArrayCookie);

if(isset($_GET['logout'])){
  setcookie('auth_user',$user_data['id'],time() - 8755 , '/');
  redirect('login.php');
};

if(isset($_POST['login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];

  $select = "SELECT * FROM `user` WHERE `email`='$email' ";
  $data = mysqli_query($connect ,$select);
  $user_data = mysqli_fetch_assoc($data);
  $hashed_pass = $user_data['password'];
  $verify_pass = password_verify($password ,$hashed_pass);
  // echo "$verify_pass";

  $num_row = mysqli_num_rows($data);
  if($num_row == 1 && $verify_pass){

    $array = array(
        "id" => $user_data['id'],
        "name" => $user_data['name'],
        "email" => $user_data['email'],
        "image" => $user_data['image']
    );
    $jsonCookieAssoc= json_encode($array);
    setcookie('auth_user',"$jsonCookieAssoc",time() + (86400 * 30) , '/');
    // $jsonArrayCookie=json_decode($_COOKIE['auth_user'],true);



    // setcookie('auth_user',$user_data['id'],time() + (86400 * 30) , '/');
    // setcookie('auth_name',$user_data['name'],time() + (86400 * 30) , '/');
    // setcookie('auth_email',$user_data['id'],time() + (86400 * 30) , '/');
    // setcookie('auth_image',$user_data['id'],time() + (86400 * 30) , '/');

    // $_SESSION['auth']=[
    //     "id" => $user_data['id'],
    //     "name" => $user_data['name'],
    //     "email" => $user_data['email'],
    //     "image" => $user_data['image']
    // ];
    redirect();
  }else{
    echo 'wrong pass or email';
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
                <a href="<?=base_url()?>" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/motors.jpg" alt="">
                  <!-- <span class="d-none d-lg-block">NiceAdmin</span> -->
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>


                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="login" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="<?= base_url("register.php")?>">Create an account</a></p>
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