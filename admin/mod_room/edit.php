<?php
echo '<script src="../sweetalert.js"></script>';
$id = $_GET['id'];
$sql = $query = "SELECT * FROM tblroom INNER JOIN tblaccomodation ON tblroom.ACCOMID = tblaccomodation.ACCOMID WHERE ROOMID = $id";
$result = $connection->query($sql);
$row = $result->fetch_assoc();

if (isset($_POST['save_room'])) {
    $uploadDir = 'rooms/'; // Set the directory where you want to save uploaded files

    // Check if a file was uploaded
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];

        // Check for errors during file upload
        if ($file['error'] === 0) {
            $filename = basename($file['name']);
            $uploadPath = $uploadDir . $filename;

            $ROOMIMAGE = "rooms/$filename";
            $ROOM = $_POST['ROOM'];
            $ACCOMID = $_POST['ACCOMID'];
            $ROOMDESC = $_POST['ROOMDESC'];
            $NUMPERSON = $_POST['NUMPERSON'];
            $PRICE = $_POST['PRICE'];
            $ROOMNUM = $_POST['ROOMNUM'];


            // Move the uploaded file to the desired directory
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $sql = "UPDATE tblroom SET 
                ROOMIMAGE = ?,
                ROOM = ?,
                ACCOMID = ?,
                ROOMDESC = ?,
                NUMPERSON = ?,
                PRICE = ?,
                ROOMNUM = ?
                WHERE ROOMID = $id";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ssisidi", $ROOMIMAGE, $ROOM, $ACCOMID, $ROOMDESC, $NUMPERSON, $PRICE, $ROOMNUM);

                // Execute the statement
                if ($stmt->execute()) {
                    // echo "<script>alert('New rooms saved successfully!');</script>";
                    // redirect("index.php");
                    echo "<script>
                    swal({
                        title: 'Saved!',
                        text: 'New rooms saved successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location = 'index.php';
                    });
                  </script>";

                } else {
                    // echo "<script>alert('Error adding new rooms: ". $stmt->error . "');</script>";
                    echo "<script>
                    swal({
                        title: 'Error!',
                        text: 'Error adding new rooms',
                        icon: 'error'
                    });
                  </script>";
                }

                // Close the statement and the database connection
                $stmt->close();
                $connection->close();
            } else {
                // echo "<script>alert('Error uploading file');</script>";
                echo "<script>
                swal({
                    title: 'Error!',
                    text: 'Error uploading file',
                    icon: 'error'
                });
              </script>";
            }
        } else {
            $ROOMIMAGE = $row["ROOMIMAGE"];
            $ROOM = $_POST['ROOM'];
            $ACCOMID = $_POST['ACCOMID'];
            $ROOMDESC = $_POST['ROOMDESC'];
            $NUMPERSON = $_POST['NUMPERSON'];
            $PRICE = $_POST['PRICE'];
            $ROOMNUM = $_POST['ROOMNUM'];
            $id = $_GET['id'];
            $sql = "UPDATE tblroom SET 
                ROOMIMAGE = ?,
                ROOM = ?,
                ACCOMID = ?,
                ROOMDESC = ?,
                NUMPERSON = ?,
                PRICE = ?,
                ROOMNUM = ?
                WHERE ROOMID = $id ";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ssisidi", $ROOMIMAGE, $ROOM, $ACCOMID, $ROOMDESC, $NUMPERSON, $PRICE, $ROOMNUM);

                // Execute the statement
                if ($stmt->execute()) {
                    // echo "<script>alert('New rooms updated successfully!');</script>";
                    // redirect("index.php");
                    echo "<script>
                            swal({
                                title: 'Updated!',
                                text: 'Room updated successfully!',
                                icon: 'success'
                            }).then(() => {
                                window.location = 'index.php';
                            });
                          </script>";

                } else {
                    // echo "<script>alert('Error adding new rooms: ". $stmt->error . "');</script>";
                    "<script>
                            swal({
                                title: 'Error!',
                                text: 'Error adding new rooms: ". $stmt->error . "',
                                icon: 'error'
                            });
                          </script>";
                }

                // Close the statement and the database connection
                $stmt->close();
                $connection->close();
        }
    } else {
        // echo "<script>alert('No file was uploaded.');</script>";
        echo "<script>
        swal({
            title: 'Error!',
            text: 'No file was uploaded.',
            icon: 'error'
        });
      </script>";
    }
}
?>


<div class="container-fluid">
  <form action="#" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header py-3"  style="display: flex;align-items: center;">
              <a class="btn btn-primary btn-sm mr-2" href="index.php">Back</a>
              <h6 class="m-0 font-weight-bold text-primary">Update Room</h6>

              <div class=" text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
            <button type="submit" name="save_room" class="btn btn-success btn-sm mr-2">Update Room</button>
              </div>
          </div>
            <div class="card-body" >
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Name:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="ROOM" name="ROOM" placeholder=
                          "Room Name" type="text" value="<?php echo $row["ROOM"]; ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Accomodation:</label>

                    <div class="col-md-12">
                       <select class="form-control input-sm" name="ACCOMID" id="ACCOMID" > 
                        <option value="<?php echo $row["ACCOMID"]; ?>"><?php echo $row["ACCOMODATION"]; ?> (<?php echo $row["ACCOMDESC"]; ?>)</option>
                          <?php
                          $query = "SELECT * FROM tblaccomodation";
                          $result = mysqli_query($connection, $query);
                          while ($rows = mysqli_fetch_assoc($result)) {
                            echo '<option value='.$rows['ACCOMID'].'>'.$rows['ACCOMODATION'].' (' .$rows['ACCOMDESC'].')</OPTION>';
                          }
                          ?>
                        </select> 
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Description:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="ROOMDESC" name="ROOMDESC" placeholder=
                    "Description" type="text" value="<?php echo $row["ROOMDESC"]; ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Number of Person:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="NUMPERSON" name="NUMPERSON" placeholder=
                    "Number of Person" type="text" value="<?php echo $row["NUMPERSON"]; ?>" onkeyup="javascript:checkNumber(this);">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Price:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="PRICE" name="PRICE" placeholder=
                    "Price" type="text" value=" &#8369 <?php echo $row["PRICE"]; ?>" onkeyup="javascript:checkNumber(this);">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">No. of Rooms:</label>

                    <div class="col-md-12">
                       <input required class="form-control input-sm" id="ROOMNUM" name="ROOMNUM" placeholder=
                    "Room #" type="text" value="<?php echo $row["ROOMNUM"]; ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                    <label class="col-md-4 control-label" for=
                    "ROOM">Upload Image:</label>

                    <div class="col-md-12">

                      <input type="file" name="image" id="image" accept="image/*">
                      <?php if ($row["ROOMIMAGE"]){; ?>
                        <img src="<?php echo $row["ROOMIMAGE"]?>" alt="Image Preview" id="image-preview" style=" display: flex;max-width: 100%; max-height: 200px;">
                        <?php } ?>
                        <img src="<?php echo $row["ROOMIMAGE"]?>" alt="Image Preview" id="image-preview" style="display: none; max-width: 100%; max-height: 200px;">
                        <script>
                          const fileInput = document.getElementById('image');
                          const imagePreview = document.getElementById('image-preview');

                          fileInput.addEventListener('change', function () {
                            const file = fileInput.files[0];

                            if (file) {
                              const reader = new FileReader();

                              reader.onload = function (e) {
                                imagePreview.src = e.target.result;
                                imagePreview.style.display = 'block';
                              };

                              reader.readAsDataURL(file);
                            } else {
                              imagePreview.src = '#';
                              imagePreview.style.display = 'none';
                            }
                          });
                        </script>

                    </div>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </form>
</div>