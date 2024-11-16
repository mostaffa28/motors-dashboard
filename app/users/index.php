<?php include_once 'C:\xampp\htdocs\motors\vendors/functions.php';
include_once 'C:\xampp\htdocs\motors\vendors/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once '../../shared/head.php';
auth();
$count = 1;
$select = "SELECT * FROM `user`";
$allUsers = mysqli_query($connect,$select);
if (isset($_GET['delete'])){
  $id = $_GET['delete'];
  $deleteUser = "SELECT * FROM `user` WHERE `id` ='$id' ";
  $connectDeleteUser = mysqli_query($connect, $deleteUser);
  $deleteUserData = mysqli_fetch_assoc($connectDeleteUser);

  echo $id ;
  $old_img= $deleteUserData['image'];
  unlink("C:/xampp/htdocs/motors/app/users/upload/$old_img");
  $delete = "DELETE FROM `user` WHERE id= '$id' ";
  mysqli_query($connect,$delete);
  redirect('app/users/index.php');
  
};


?>
<body>
  <?php include_once '../../shared/header.php';
  include_once '../../shared/aside.php';

  ?>



  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Data Tables</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">


              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>
                      <b>N</b>ame
                    </th>
                    <th>email</th>
                    <th class="text-center" colspan="2">functions</th>



                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allUsers as $item):?>
                  <tr>
                    <td><?=$count++?></td>
                    <td><?=$item['name']?></td>
                    <td><?=$item['email']?></td>
                    <td class="text-center"><a href="./edit.php?edit=<?=  $item['id'] ?>"> <i class="ri-edit-box-line"></i></a></td>
                    <td class="text-center text-danger"><a href="index.php?delete=<?=  $item['id'] ?>" class="text-danger"> <i class="ri-close-circle-fill"></i></a></td>


                  </tr>
                    <?php endforeach;?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
          <a class="btn btn-info" href="<?=base_url('app/users/create.php')?>">add</a>

        </div>
      </div>
    </section>

  </main><!-- End #main -->


  <?php include_once '../../shared/footer.php';?>
  <?php include_once '../../shared/script.php';?>




</body>

</html>