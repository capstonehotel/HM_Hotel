<?php
echo '<script src="../sweetalert.js"></script>';

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

            // Check if the room name already exists in the database
            $query = "SELECT COUNT(*) as count FROM tblroom WHERE ROOM = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("s", $ROOM);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                // Room name already exists, show error message
                echo "<script>
                        swal({
                            title: 'Error!',
                            text: 'Room name already exists. Please choose a different name.',
                            icon: 'error'
                        });
                      </script>";
            } else {
                // Room name is unique, proceed with file upload and database insertion
                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $sql = "INSERT INTO tblroom (ROOMIMAGE, ROOM, ACCOMID, ROOMDESC, NUMPERSON, PRICE, ROOMNUM)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("ssisidi", $ROOMIMAGE, $ROOM, $ACCOMID, $ROOMDESC, $NUMPERSON, $PRICE, $ROOMNUM);

                    // Execute the statement
                    if ($stmt->execute()) {
                        echo "<script>
                                swal({
                                    title: 'Saved!',
                                    text: 'New room saved successfully!',
                                    icon: 'success'
                                }).then(() => {
                                    window.location = 'index.php';
                                });
                              </script>";
                    } else {
                        echo "<script>
                                swal({
                                    title: 'Error!',
                                    text: 'Error adding new room: " . $stmt->error . "',
                                    icon: 'error'
                                });
                              </script>";
                    }

                    // Close the statement and the database connection
                    $stmt->close();
                    $connection->close();
                } else {
                    echo "<script>
                            swal({
                                title: 'Error!',
                                text: 'Error uploading file',
                                icon: 'error'
                            });
                          </script>";
                }
            }
        } else {
            echo "<script>
                    swal({
                        title: 'Error!',
                        text: 'File upload error. Error code: " . $file['error'] . "',
                        icon: 'error'
                    });
                  </script>";
        }
    } else {
        echo "<script>
                swal({
                    title: 'Warning!',
                    text: 'No file was uploaded.',
                    icon: 'warning'
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
              <h6 class="m-0 font-weight-bold text-primary">Add New Room</h6>
              <div class=" text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
                  <button type="submit" name="save_room" class="btn btn-success btn-sm mr-2">Save Room</button>
              </div>
          </div>
          <div class="card-body">
              <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                      <label class="col-md-4 control-label" for="ROOM">Name:</label>
                      <div class="col-md-12">
                          <input required class="form-control input-sm" id="ROOM" name="ROOM" placeholder="Room Name" type="text" value="">
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                      <label class="col-md-4 control-label" for="ROOM">Accomodation:</label>
                      <div class="col-md-12">
                          <select class="form-control input-sm" name="ACCOMID" id="ACCOMID"> 
                              <?php
                              $query = "SELECT * FROM tblaccomodation";
                              $result = mysqli_query($connection, $query);
                              while ($row = mysqli_fetch_assoc($result)) {
                                  echo '<option value='.$row['ACCOMID'].'>'.$row['ACCOMODATION'].' (' .$row['ACCOMDESC'].')</option>';
                              }
                              ?>
                          </select> 
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                      <label class="col-md-4 control-label" for="ROOM">Description:</label>
                      <div class="col-md-12">
                          <input required class="form-control input-sm" id="ROOMDESC" name="ROOMDESC" placeholder="Description" type="text" value="">
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                      <label class="col-md-4 control-label" for="ROOM">Number of Person:</label>
                      <div class="col-md-12">
                          <input required class="form-control input-sm" id="NUMPERSON" name="NUMPERSON" placeholder="Number of Person" type="text" value="" onkeyup="javascript:checkNumber(this);">
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                      <label class="col-md-4 control-label" for="ROOM">Price:</label>
                      <div class="col-md-12">
                          <input required class="form-control input-sm" id="PRICE" name="PRICE" placeholder="Price" type="text" value="" onkeyup="javascript:checkNumber(this);">
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                      <label class="col-md-4 control-label" for="ROOM">No. of Rooms:</label>
                      <div class="col-md-12">
                          <input required class="form-control input-sm" id="ROOMNUM" name="ROOMNUM" placeholder="Room #" type="text" value="">
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12 col-sm-12 ">
                      <label class="col-md-4 control-label" for="ROOM">Upload Image:</label>
                      <div class="col-md-12">
                          <input required type="file" name="image" id="image" accept="image/*">
                          <img src="#" alt="Image Preview" id="image-preview" style="display: none; max-width: 100%; max-height: 200px;">
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
