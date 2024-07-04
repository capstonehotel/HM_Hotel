<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;"
        >
            <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
            <div style="display: flex; width: 100%; justify-content: flex-end;">
                <a href="index.php?view=add" class="btn btn-sm btn-primary">Add New User</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Account Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Contact </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tbluseraccount ";
                        $result = mysqli_query($connection, $query);
                        if ($result) {
                            $number = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $number ++;
                    ?>
                        <tr>
                            <td align="center"><?php echo $number; ?> </td>
                            <td align="center"><?php echo $row['UNAME'];?></td>
                            <td align="center"><?php echo $row['USER_NAME'];?></td>
                            <td align="center"><?php echo $row['ROLE'];?></td>
                            <td align="center"><?php echo $row['PHONE'];?></td>
                            <td style="display: flex;">
                                <a class="btn-sm btn btn-primary mr-2" href="index.php?view=edit&id=<?php echo $row['USERID']; ?>">View/Edit</a>
                                <a class="btn-sm btn btn-danger mr-2" href="index.php?view=delete&id=<?php echo $row['USERID']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>