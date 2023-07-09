<?php
    
    include "../dbconnection.php";

    $sql="SELECT * FROM categories";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $categories=$stmt->fetchall();

    if($_SERVER['REQUEST_METHOD']=='POST'){

    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $user_id = 2;
    $description = $_POST['description'];
    $photo_arr = $_FILES['photo'];

    //echo "$title and $category_id and $user_id and $description";
    //print_r($photo_arr);

    if(isset($photo_arr) && $photo_arr['size']>0)
    {
        $dir='images/';
        $photo = $dir.$photo_arr['name'];

        $temp_name = $photo_arr['tmp_name'];
        move_uploaded_file($temp_name,$photo);
    }

    $sql = "INSERT INTO posts(title,category_id,user_id,photo,description) VALUES(:title, :category, :user, :photo, :description)";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':title',$title);
    $stmt->bindParam(':category',$category_id);
    $stmt->bindParam(':user',$user_id);
    $stmt->bindParam(':photo',$photo);
    $stmt->bindParam(':description',$description);
    $stmt->execute();

    header("location:creat_post.php");
    }
    else
    {
        include "layouts/nav_sidebar.php";

?>
    <div class="container-fluid">
        <div class="card my-5">
            <div class="card-header">
                <p class="d-inline">Post Create</p>
                <a href="posts.php" class="btn btn-sm btn-danger float-end">Cancel</a>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="category_id">
                            <option selected>Select Category</option>
                            <?php
                                foreach ($categories as $category){

                            ?>
                            <option value="<?= $category['id']?>" ><?= $category['name']?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
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