<?php
    
    include "../dbconnection.php";

    $sql="SELECT * FROM categories";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $categories=$stmt->fetchall();

    $id=$_GET['id'];

    //echo $id;

    $sql = "SELECT posts.*, categories.name as c_name,users.name as u_name FROM posts INNER JOIN categories ON posts.category_id=categories.id INNER JOIN users ON posts.user_id=users.id WHERE posts.id=:id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);   

    if($_SERVER['REQUEST_METHOD']=='POST'){

    $id=$_POST['id'];
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $user_id = 2;
    $description = $_POST['description'];
    $photo_arr = $_FILES['new_photo'];
    $old_photo = $_POST['photo'];

    if(isset($photo_arr) && $photo_arr['size']>0)
    {
        $dir='images/';
        $photo = $dir.$photo_arr['name'];

        $temp_name = $photo_arr['tmp_name'];
        move_uploaded_file($temp_name,$photo);
    }else{
        $photo = $old_photo;
    }

    $sql = "UPDATE posts SET title = :title, category_id=:category,user_id=:user,photo=:photo,description=:description WHERE  id=:id";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':title',$title);
    $stmt->bindParam(':category',$category_id);
    $stmt->bindParam(':user',$user_id);
    $stmt->bindParam(':photo',$photo);
    $stmt->bindParam(':description',$description);
    $stmt->execute();

    header("location:post.php");
    }
    else
    {
        include "layouts/nav_sidebar.php";
        //var_dump($post);
?>
    <div class="container-fluid">
        <div class="card my-5">
            <div class="card-header">
                <p class="d-inline">Post Create</p>
                <a href="posts.php" class="btn btn-sm btn-danger float-end">Cancel</a>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $id?>" name="id">
                    <div class="mb-3">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $post['title']?>">
                    </div>
                    <div class="mb-3">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="photo-tab" data-bs-toggle="tab" data-bs-target="#photo-tab-pane" type="button" role="tab" aria-controls="photo-tab-pane" aria-selected="true">Photo</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="new_photo-tab" data-bs-toggle="tab" data-bs-target="#new_photo-tab-pane" type="button" role="tab" aria-controls="new_photo-tab-pane" aria-selected="false">New Photo</button>
                        </li>
                    </ul>
                        <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="photo-tab-pane" role="tabpanel" aria-labelledby="photo-tab" tabindex="0">
                            <img src="<?= $post['photo'] ?>" alt="" class="img-fluid w-50 h-50 py-5">
                            <input type="hidden" value="<?= $post['photo'] ?>" name="photo">
                        </div>
                        <div class="tab-pane fade" id="new_photo-tab-pane" role="tabpanel" aria-labelledby="new_photo-tab" tabindex="0">
                            <input type="file" class="form-control my-5" id="photo" name="new_photo">
                        </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="category_id">
                            <option selected>Select Category</option>
                            <?php
                                foreach ($categories as $category){

                            ?>
                            <option value="<?= $category['id']?>" 
                                    <?php 
                                        if($category['id']==$post['category_id'])
                                        {
                                            echo "selected";
                                        }
                                    ?>>
                            <?= $category['name']?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="10"><?= $post['description'] ?></textarea>
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