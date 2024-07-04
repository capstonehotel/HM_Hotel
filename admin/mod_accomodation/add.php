<?php
echo '<script src="../sweetalert.js"></script>';
if (isset($_POST['save_accomodation'])) {

  $ACCOMODATION = $_POST['ACCOMODATION'];
  $ACCOMDESC = $_POST['ACCOMDESC'];

    $sql = "INSERT INTO tblaccomodation (ACCOMODATION, ACCOMDESC) VALUES ('$ACCOMODATION', '$ACCOMDESC')";
    if ($conn->query($sql) === TRUE) {
        // echo "<script>alert('New Accomodation saved successfully!');</script>";
        //  redirect("index.php");
         echo "<script>
                            swal({
                                title: 'Saved!',
                                text: 'New Accomodation saved successfully!',
                                icon: 'success'
                            }).then(() => {
                                window.location = 'index.php';
                            });
                          </script>";

                          
    } else {
        echo "<script>alert('Error adding new Accomodation: ". $stmt->error . "');</script>";
    }

}
?>


<div class="container-fluid">
  <form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header py-3"  style="display: flex;align-items: center;">
              <h6 class="m-0 font-weight-bold text-primary">Add New Accomodation</h6>

              <div class=" text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
            <button type="submit" name="save_accomodation" class="btn btn-success btn-sm mr-2">Save Accomodation</button>
              </div>
          </div>
            <div class="card-body" >
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Name:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="ACCOMODATION" name="ACCOMODATION" placeholder=
                          "Accomodation" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Description:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="ACCOMDESC" name="ACCOMDESC" placeholder=
                          "Description" type="text" value="">
                    </div>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </form>
</div>