<?php
    
    include "../dbconnection.php";

    $sql="SELECT * FROM categories";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $categories=$stmt->fetchall();

    if($_SERVER['REQUEST_METHOD']=='POST'){

    $c_id = $_POST['c_id'];
    $name = $_POST['name'];

    $sql = "INSERT INTO categories(id,name) VALUES($c_id,'$name')";
    $stmt=$conn->prepare($sql);
    $stmt->execute();

    header("location:create_category.php");
    }
    else
    {
        include "layouts/nav_sidebar.php";

?>
    <div class="container-fluid">
        <div class="card my-5">
            <div class="card-header">
                <p class="d-inline">Category Create</p>
                <a href="posts.php" class="btn btn-sm btn-danger float-end">Cancel</a>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="" class="form-label">Category ID</label>
                        <input type="number" class="form-control" id="c_id" name="c_id">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name">
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