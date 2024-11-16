<?php include_once 'C:\xampp\htdocs\motors\vendors/functions.php';?>
<?php include_once 'C:\xampp\htdocs\motors\vendors/config.php';?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once './shared/head.php';
auth();
// extract the data from data base
$id_user = $jsonArrayCookie['id'];

$data_user= "SELECT * FROM user WHERE id = '$id_user'";

$data= mysqli_query($connect,$data_user);
$show_data = mysqli_fetch_assoc($data);

$image_user = $show_data['image'];
$name_user = $show_data['name'];
$email_user = $show_data['email'];
$password_user = $show_data['password'];
// end (extract the data from data base)


// edit the user information
if(isset($_POST['edit'])){
  $new_email = $_POST['new_email'];
  $new_name=$_POST['new_name'];

  $check_email_sql="SELECT * FROM `user` WHERE `email` = '$new_email'";

  $conn = mysqli_query($connect , $check_email_sql);
  $num_row= mysqli_num_rows($conn);
  //check if the new email has no repeated in the database
  if($num_row ==1 && $new_email != $email_user){
    
    echo <<<'HTML'
            <div class="shadow-lg p-3 mb-5 w-25 position-fixed top-50 start-50 translate-middle z-3 alert alert-warning bg-warning border-0 alert-dismissible fade show" role="alert">
                that email has already exist
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
        HTML;

  }else{ 
    // image code
    if(empty($_FILES['image']['name'])) { 
      $img_name=$jsonArrayCookie['image'];
    }else{
    $old_img= $jsonArrayCookie['image'];
    unlink("C:/xampp/htdocs/motors/app/users/upload/$old_img");


    $img_name= rand(0,255) . $_FILES['image']['name'];
    $img_tmp_name=$_FILES['image']['tmp_name'];
    $location = "C:/xampp/htdocs/motors/app/users/upload/$img_name";

    move_uploaded_file($img_tmp_name,$location);
  }
  $edit_user_sql = "UPDATE `user` SET `name` = '$new_name', `email` = '$new_email' , `image` = '$img_name' WHERE id = '$id_user'";
  mysqli_query($connect,$edit_user_sql);
  //save the data in session to can show it
  $jsonArrayCookie['image']=$img_name;
  $jsonArrayCookie['name'] =$new_name;
  $jsonArrayCookie['email']=$new_email;
  redirect('profile.php');
  // echo $img_name;

  }

};
//edit the password
if(isset($_POST['confirmPassword'])){
  $current_password=$_POST['password'];
  $new_password=$_POST['newpassword'];
  $reenter_password=$_POST['renewpassword'];
  //get the hashed current password
  $password_user = $show_data['password'];
  //verify the current password
  $verify_pass = password_verify($current_password ,$password_user);
  if($verify_pass && $new_password == $reenter_password){
    $hashed_pass= password_hash($new_password,PASSWORD_DEFAULT);
    $update_password_sql = "UPDATE `user` SET `password` = '$hashed_pass' WHERE id = '$id_user'";
    mysqli_query($connect,$update_password_sql);
    setcookie('auth_user',$user_data['id'],time() - 8755 , '/');
    redirect('login.php');
  }else{
    echo <<<'HTML'
            <div class=" w-25 position-fixed top-50 start-50 translate-middle z-3 alert alert-danger bg-warning border-0 alert-dismissible fade show" role="alert">
                some thing wrong please try again
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
        HTML;
  }

}
?>
<body>
  <?php 
  include_once './shared/header.php';
  include_once './shared/aside.php';?>


<main id="main" class="main">.

  <div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>">Home</a></li>
        <li class="breadcrumb-item">Users</li>
        <li class="breadcrumb-item active">Profile</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="<?= base_url("app/users/upload/$image_user")?>" alt="Profile" class="rounded-circle">
            <h2><?= $name_user?></h2>
            <h3>Web Designer</h3>
            <div class="social-links mt-2">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>



              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">

                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8"><?=$name_user?></div>
                </div>



                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Job</div>
                  <div class="col-lg-9 col-md-8">Web Designer</div>
                </div>






                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8"><?=$email_user?></div>
                </div>

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form method="post" enctype="multipart/form-data">

                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                      <img src="<?= base_url("app/users/upload/$image_user")?>" alt="Profile">
                      <div class="pt-2">
                        <input type="file" accept="image/*" class="btn btn-warning btn-sm" value="Upload new profile image" name="image">
                        <button  class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></button>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="new_name" type="text" class="form-control" id="fullName" value="<?=$name_user?>">
                    </div>
                  </div>










                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="new_email" type="email" class="form-control" id="Email" value="<?=$email_user?>">
                    </div>
                  </div>



                  <div class="text-center">
                    <button type="submit" name="edit" class="btn btn-primary">Save Changes</button>
                  </div>


                </form><!-- End Profile Edit Form -->

              </div>



              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form method="post">

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" name="confirmPassword" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>

</main> <!-- End #main -->



  <?php include_once './shared/footer.php';?>
  <?php include_once './shared/script.php';?>




</body>

</html>