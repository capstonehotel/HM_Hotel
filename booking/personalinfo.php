
<?php
if (isset($_POST['submit'])){

	$targetDirectory = "../images/user_avatar/";  // Directory where uploaded images will be stored
  $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
  $fileName = basename($_FILES["image"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
      echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
  } else {
      echo "Sorry, there was an error uploading your file.";
  }
	    


 $arival   = $_SESSION['from']; 
  $departure = $_SESSION['to'];
  /*$adults = $_SESSION['adults'];
  $child = $_SESSION['child'];*/
  // $adults = 1;
  // $child = 1;
  $ROOMID = $_SESSION['ROOMID'];
 $_SESSION['image']   		= $fileName;
 $_SESSION['name']   		= $_POST['name'];
 $_SESSION['last']   		= $_POST['last'];
 $_SESSION['gender']   		= $_POST['gender'];
 $_SESSION['dbirth']   		= $_POST['dbirth'];
 $_SESSION['nationality']   = $_POST['nationality'];
 $_SESSION['city']   		= $_POST['city'];
 $_SESSION['address'] 		= $_POST['address'];
 $_SESSION['company']  		= $_POST['company'];
 $_SESSION['caddress']  	= $_POST['caddress'];
 $_SESSION['zip']   		= $_POST['zip'];
 $_SESSION['phone']   		= $_POST['phone'];
 $_SESSION['username']		= $_POST['username'];
 $_SESSION['pass']  		= $_POST['pass'];
 $_SESSION['pending']  		= 'pending';


  // $name   = $_SESSION['name']; 
  // $last   = $_SESSION['last'];
  // $country= $_SESSION['country'];
  // $city   = $_SESSION['city'] ;
  // $address =$_SESSION['address'];
  // $zip    =  $_SESSION['zip'] ;
  // $phone  = $_SESSION['phone'];
  // $email  = $_SESSION['email'];
  // $password =$_SESSION['pass'];


  // $days = dateDiff($arival,$departure);

  
redirect('index.php?view=payment');
}
?>

 
                 <?php //include'navigator.php';?>


			 
					<?php
					if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
							echo '<ul class="err">';
							foreach($_SESSION['ERRMSG_ARR'] as $msg) {
								echo '<li>',$msg,'</li>'; 
							}
							echo '</ul>';
							unset($_SESSION['ERRMSG_ARR']);
						}
					?>
					<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   
         		<form class="form-horizontal" action="index.php?view=logininfo" method="post"  name="personal" enctype="multipart/form-data">
					 <h2>Personal Details</h2> 

					 <div class="row">
					 
        <!-- First Column -->
        <div class="col-md-6 col-sm-12">
            <!-- Avatar -->
            <div class="form-group">
                <label for="image">Avatar <span class="text-danger">*</span></label>
                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" class="form-control-file" required onchange="previewImage(event)">
                <img id="imagePreview" src="#" alt="Image Preview" class="mt-2 img-fluid" style="display: none; max-width: 100%; height: auto;">
            

<script>
function previewImage(event) {
  const input = event.target;
  const imagePreview = document.getElementById('imagePreview');
  
  if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
      imagePreview.style.display = 'block';
      imagePreview.src = e.target.result;
    };

    reader.readAsDataURL(input.files[0]);
  } else {
    imagePreview.style.display = 'none';
    imagePreview.src = '#';
  }
}
</script>
									
			            </div>
			        

					           <!-- First Name -->
							   <div class="form-group">
                <label for="name">First Name <span class="text-danger">*</span></label>
                <input name="name" type="text" class="form-control" id="name" maxlength="16" onkeyup="capitalizeInput(this)" required>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="last">Last Name <span class="text-danger">*</span></label>
                <input name="last" type="text" class="form-control" id="last" maxlength="16" onkeyup="capitalizeInput(this)" required>
            </div>

            <!-- Gender -->
            <div class="form-group">
                <label for="gender">Gender <span class="text-danger">*</span></label>
                <select name="gender" class="form-control" id="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <!-- Add more options if needed -->
                </select>
            </div>
        </div>

       
            <!-- Date of Birth -->
            <div class="form-group">
                <label for="dbirth">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" name="dbirth" class="form-control" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" required>
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label for="phone">Phone <span class="text-danger">*</span></label>
                <input 
                    name="phone" 
                    type="tel" 
                    class="form-control" 
                    id="phone" 
                    pattern="09\d{9}" 
                    value="09" 
                    required 
                    oninput="this.value = this.value.replace(/\D/g, '').slice(0,11)"
                    placeholder="09XXXXXXXXX"
                >
                <small class="form-text text-muted">Format: 09XXXXXXXXX</small>
            </div>

            <!-- Nationality -->
            <div class="form-group">
                <label for="nationality">Nationality <span class="text-danger">*</span></label>
                <input name="nationality" type="text" class="form-control" id="nationality" maxlength="17" onkeyup="capitalizeInput(this)" required>
            </div>
 <!-- Second Column -->
 <div class="col-md-6 col-sm-12">
            <!-- Company -->
            <div class="form-group">
                <label for="company">Company <span class="text-danger">*</span></label>
                <input name="company" type="text" class="form-control" id="company" onkeyup="capitalizeInput(this)" required>
            </div>

            <!-- Company Address -->
            <div class="form-group">
                <label for="caddress">Company Address <span class="text-danger">*</span></label>
                <input name="caddress" type="text" class="form-control" id="caddress" onkeyup="capitalizeInput(this)" required>
            </div>
        </div>
    </div>

    <!-- Additional Fields (Address, City, etc.) -->
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <!-- City -->
            <div class="form-group">
                <label for="city">City <span class="text-danger">*</span></label>
                <input name="city" type="text" class="form-control" id="city" onkeyup="capitalizeInput(this)" required>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address">Address <span class="text-danger">*</span></label>
                <input name="address" type="text" class="form-control" id="address" maxlength="50" onkeyup="capitalizeInput(this)" required>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <!-- Email -->
            <div class="form-group">
                <label for="username">Email <span class="text-danger">*</span></label>
                <input name="username" type="email" class="form-control" id="username" placeholder="User@gmail.com" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input name="pass" type="password" class="form-control" id="password" placeholder="Ex@mple123" required onkeyup="validatePassword()">
                <span id="password-error" class="text-danger"></span>
                <small class="form-text text-muted">
                    Password must be at least 6 characters long, include a capital letter, a number, and a special character.
                </small>
            </div>

            <!-- Zip Code -->
            <div class="form-group">
                <label for="zip">Zip Code <span class="text-danger">*</span></label>
                <input name="zip" type="number" class="form-control" id="zip" minlength="4" maxlength="4" required>
            </div>
        </div>
    </div>
 
					 &nbsp; &nbsp;
				 <div class="form-group">
			        <div class="col-md-6">
					<p>
				I <input type="checkbox" name="condition" value="checkbox" />
					 <small>Agree the <a class="toggle-modal"  onclick="OpenPopupCenter('terms_condition.php','Terms And Codition','600','600')" ><b>TERMS AND CONDITION</b></a> of this Hotel</small>
			
					 <br />
						<!-- <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ><a href='javascript: refreshCaptcha();'><img src="<?php echo WEB_ROOT;?>images/refresh.png" alt="refresh" border="0" style="margin-top:5px; margin-left:5px;" /></a>
						<br /><small>If you are a Human Enter the code above here :</small><input id="6_letters_code" name="6_letters_code" type="text" class="form-control input-sm" width="20"></p><br/>
					 -->	<div class="col-md-4">
					    	<input name="submit" type="submit" value="Confirm"  class="btn btn-primary" onclick="return personalInfo();"/>
					    </div>
					</div>
					NOTE: 
					We recommend that your password should be at least 6 characters long and should be different from your username.
					Your e-mail address must be valid. We use e-mail for communication purposes (order notifications, etc). Therefore, it is essential to provide a valid e-mail address to be able to use our services correctly.
					All your private data is confidential. We will never sell, exchange or market it in any way. For further information on the responsibilities of both parties, you may refer to us.
			    </div>

			</form>   


<script type="text/javascript">
function capitalizeInput(input) {
    var inputValue = input.value;
    input.value = inputValue.charAt(0).toUpperCase() + inputValue.slice(1);
}
</script>

<script>
function validatePassword() {
    var passwordInput = document.getElementById("password");
    var password = passwordInput.value;
    var passwordError = document.getElementById("password-error");
    
    var hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
    var hasNumber = /\d/.test(password);
    var hasCapital = /[A-Z]/.test(password);
    
    if (password.length < 6) {
        passwordError.textContent = "Password must be at least 6 characters long.";
        passwordInput.setCustomValidity("Password must be at least 6 characters long.");
    } else if (!hasSpecialChar) {
        passwordError.textContent = "Password must contain at least one special character.";
        passwordInput.setCustomValidity("Password must contain at least one special character.");
    } else if (!hasNumber) {
        passwordError.textContent = "Password must contain at least one number.";
        passwordInput.setCustomValidity("Password must contain at least one number.");
    } else if (!hasCapital) {
        passwordError.textContent = "Password must contain at least one capital letter.";
        passwordInput.setCustomValidity("Password must contain at least one capital letter.");
    } else {
        passwordError.textContent = "";
        passwordInput.setCustomValidity("");
    }
}
</script>

			
 