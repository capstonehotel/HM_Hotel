
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Accomodation List</h6>
            <div style="display: flex; width: 100%; justify-content: flex-end;">
                <a href="index.php?view=add" class="btn btn-sm btn-primary">Add New Accomodation</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tblaccomodation";
                        $result = mysqli_query($connection, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['ACCOMODATION'];?></td>
                            <td><?php echo $row['ACCOMDESC'];?></td>
                            <td style="display: flex;">
			            		<a class="btn-sm btn btn-primary mr-2" href="index.php?view=edit&id=<?php echo $row['ACCOMID']; ?>">View/Edit</a>
			            		<a class="btn-sm btn btn-danger mr-2" href="index.php?view=delete&id=<?php echo $row['ACCOMID']; ?>">Delete</a>
			            	</td>
                        </tr>
                    <?php } }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>