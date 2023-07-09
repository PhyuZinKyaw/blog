<?php
    
    include "../dbconnection.php";

    $sql="SELECT * FROM users";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $users=$stmt->fetchall();

    if($_SERVER['REQUEST_METHOD']=='POST'){

    //$u_id = $_POST['u_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $photo_arr = $_FILES['photo'];

    if(isset($photo_arr) && $photo_arr['size']>0)
    {
        $dir='images/';
        $photo = $dir.$photo_arr['name'];

        $temp_name = $photo_arr['tmp_name'];
        move_uploaded_file($temp_name,$photo);
    }

    $sql = "INSERT INTO users(name,email,password,profile) VALUES('$name','$email','$password','$photo')";
    $stmt=$conn->prepare($sql);
    $stmt->execute();

    header("location:create_user.php");
    }
    else
    {
        include "layouts/nav_sidebar.php";

?>
    <div class="container-fluid">
        <div class="card my-5">
            <div class="card-header">
                <p class="d-inline">User Create</p>
                <a href="posts.php" class="btn btn-sm btn-danger float-end">Cancel</a>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- <div class="mb-3">
                        <label for="" class="form-label">User ID</label>
                        <input type="number" class="form-control" id="u_id" name="u_id">
                    </div> -->
                    <div class="mb-3">
                        <label for="" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">User Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">User Passwrod</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
            
<?php
    include "layouts/footer.php";

    }
?>