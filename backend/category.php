<?php
    include "layouts/nav_sidebar.php";
    include "../dbconnection.php";

    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();    

    //var_dump($posts);
?>
            <!-- <div id="layoutSidenav_content"> -->
                <main>
                    <div class="container-fluid py-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- <i class="fas fa-table me-1"></i> -->
                                Categories Lists
                                <a class="btn btn-primary float-end" href="create_category.php">Create Category</a>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Category ID</th>
                                            <th>Created Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($categories as $category)
                                            {
                                        ?>
                                        <tr>
                                            <td><?= $category['id']?></td>
                                            <td><?= $category['name']?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
<?php
    include "layouts/footer.php";
?>