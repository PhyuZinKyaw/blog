<?php
    include "layouts/nav_sidebar.php";
    include "../dbconnection.php";

    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();    

    //var_dump($posts);
?>
            <!-- <div id="layoutSidenav_content"> -->
                <main>
                    <div class="container-fluid py-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- <i class="fas fa-table me-1"></i> -->
                                Users Lists
                                <a class="btn btn-primary float-end" href="create_user.php">Create User</a>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User Password</th>
                                            <th>User Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($users as $user)
                                            {
                                        ?>
                                        <tr>
                                            <td><?= $user['id']?></td>
                                            <td><?= $user['name']?></td>
                                            <td><?=$user['email']?></td>
                                            <td><?=$user['password']?></td>
                                            <td><?=$user['photo']?></td>
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