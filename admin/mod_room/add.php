<?php
echo '<script src="../sweetalert.js"></script>';

if (isset($_POST['save_room'])) {
    $uploadDir = 'rooms/'; // Set the directory where you want to save uploaded files
    $ROOM = $_POST['ROOM'];
    $ACCOMID = $_POST['ACCOMID'];
    $ROOMDESC = $_POST['ROOMDESC'];
    $NUMPERSON = $_POST['NUMPERSON'];
    $PRICE = $_POST['PRICE'];
    $ROOMNUM = $_POST['ROOMNUM'];
    $imageError = false;
    $imagePath = '';

    // Check for duplicate room name
    $query = "SELECT * FROM tblroom WHERE ROOM = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $ROOM);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                swal({
                    title: 'Error!',
                    text: 'Room name already exists. Please choose a different name.',
                    icon: 'error'
                }).then(() => {
                    document.getElementById('ROOM').value = '';
                });
              </script>";
    } else {
        // Check if a file was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $filename = basename($file['name']);
            $uploadPath = $uploadDir . $filename;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $ROOMIMAGE = "rooms/$filename";
                $imagePath = $ROOMIMAGE;
            } else {
                echo "<script>
                        swal({
                            title: 'Error!',
                            text: 'Error uploading file',
                            icon: 'error'
                        });
                      </script>";
                $imageError = true;
            }
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== 0) {
            echo "<script>
                    swal({
                        title: 'Error!',
                        text: 'File upload error. Error code: " . $_FILES['image']['error'] . "',
                        icon: 'error'
                    });
                  </script>";
            $imageError = true;
        }

        if (!$imageError) {
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
        }
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
              <div class="text-right" style="display: flex; justify-content: right; align-items: right; width: 100%;">
                <button type="submit" name="save_room" class="btn btn-success btn-sm mr-2">Save Room</button>
              </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOM">Name:</label>
                <div class="col-md-12">
                   <input required class="form-control input-sm" id="ROOM" name="ROOM" placeholder="Room Name" type="text" value="<?php echo isset($_POST['ROOM']) ? htmlspecialchars($_POST['ROOM']) : ''; ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ACCOMID">Accommodation:</label>
                <div class="col-md-12">
                   <select class="form-control input-sm" name="ACCOMID" id="ACCOMID">
                      <?php
                      $query = "SELECT * FROM tblaccomodation";
                      $result = mysqli_query($connection, $query);
                      while ($row = mysqli_fetch_assoc($result)) {
                        $selected = isset($_POST['ACCOMID']) && $_POST['ACCOMID'] == $row['ACCOMID'] ? 'selected' : '';
                        echo '<option value='.$row['ACCOMID'].' '.$selected.'>'.$row['ACCOMODATION'].' (' .$row['ACCOMDESC'].')</option>';
                      }
                      ?>
                    </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOMDESC">Description:</label>
                <div class="col-md-12">
                   <input required class="form-control input-sm" id="ROOMDESC" name="ROOMDESC" placeholder="Description" type="text" value="<?php echo isset($_POST['ROOMDESC']) ? htmlspecialchars($_POST['ROOMDESC']) : ''; ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="NUMPERSON">Number of Person:</label>
                <div class="col-md-12">
                   <input required class="form-control input-sm" id="NUMPERSON" name="NUMPERSON" placeholder="Number of Person" type="text" value="<?php echo isset($_POST['NUMPERSON']) ? htmlspecialchars($_POST['NUMPERSON']) : ''; ?>" onkeyup="javascript:checkNumber(this);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="PRICE">Price:</label>
                <div class="col-md-12">
                   <input required class="form-control input-sm" id="PRICE" name="PRICE" placeholder="Price" type="text" value="<?php echo isset($_POST['PRICE']) ? htmlspecialchars($_POST['PRICE']) : ''; ?>" onkeyup="javascript:checkNumber(this);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="ROOMNUM">No. of Rooms:</label>
                <div class="col-md-12">
                   <input required class="form-control input-sm" id="ROOMNUM" name="ROOMNUM" placeholder="Room #" type="text" value="<?php echo isset($_POST['ROOMNUM']) ? htmlspecialchars($_POST['ROOMNUM']) : ''; ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 col-sm-12">
                <label class="col-md-4 control-label" for="image">Upload Image:</label>
                <div class="col-md-12">
                  <input required type="file" name="image" id="image" accept="image/*">
                  <img src="<?php echo isset($imagePath) && !$imageError ? htmlspecialchars($imagePath) : '#'; ?>" alt="Image Preview" id="image-preview" style="display: <?php echo isset($imagePath) && !$imageError ? 'block' : 'none'; ?>; max-width: 100%; max-height: 200px;">
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
