
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>Sender</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tblcontact";
                        $result = mysqli_query($connection, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['CONT_CREATED_AT'];?></td>
                            <td><?php echo $row['CONT_NAME'];?></td>
                            <td><?php echo $row['CONT_EMAIL'];?></td>
                            <td><?php echo $row['CONT_MESSAGE'];?></td>
                            <td style="display: flex;">
                                
                                <a class="btn-sm btn btn-danger mr-2" href="index.php?view=delete&id=<?php echo $row['CONTID']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>