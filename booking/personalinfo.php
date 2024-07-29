
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

					 <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "name">Avatar</label>

			              <div class="col-md-8">
			              	<input name="" type="hidden" value="">
			              	<input required type="file" name="image" id="image" accept=".jpg, .jpeg, .png" onchange="previewImage(event)">
			              </div>
			              <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 300px; max-height: 300px;">

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
			          </div> 

					  <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "name">First Name:</label>

			              <div class="col-md-8">
			              	<input name="" type="hidden" value="">
			                <input onkeyup="capitalizeInput(this)" name="name" type="text" class="form-control input-sm" id="name" /  maxlength="16">
			              </div>
			            </div>
			          </div> 

			            <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "last">Last Name:</label>

			              <div class="col-md-8">
			                <input onkeyup="capitalizeInput(this)" name="last" type="text" class="form-control input-sm" id="last" / maxlength="16" required>
			              </div>
			            </div>
			          </div>
					  <div class="form-group">
    <div class="col-md-8">
        <label class="col-md-4 control-label" for="gender">Gender:</label>
        <div class="col-md-8">
            <select name="gender" class="form-control input-sm" id="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
               
            </select>
        </div>
    </div>
</div>

			      

			           <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "city">City:</label>

			              <div class="col-md-8">
			                <input onkeyup="capitalizeInput(this)" name="city" type="text" class="form-control input-sm" id="city" />
			              </div> 
			            </div>
			          </div>
			           <div class="form-group">
			            <div class="col-md-8">
			              <label  class="col-md-4 control-label" for=
			              "address">Address:</label>

			              <div class="col-md-8">
			                <input onkeyup="capitalizeInput(this)" name="address" type="text" class="form-control input-sm" id="address" / maxlength="50">
			              </div>
			            </div>
			          </div> 

			            <div class="form-group  ">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "dbirth">Date of Birth:</label>

			              <div class="col-md-8">
							    <input type="date"
							           required
							           name="dbirth"
							           value=""
							           max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"
							           class="form-control input-sm">
							</div>

			              
			            </div>
			          </div>

					  <div class="form-group">
  <div class="col-md-8">
    <label class="col-md-4 control-label" for="phone">Phone:</label>
    <div class="col-md-8">
      <input 
        name="phone" 
        required 
        pattern="09\d{9}" 
        type="tel" 
        class="form-control input-sm" 
        id="phone" 
        value="09" 
        oninput="this.value = this.value.replace(/\D/, ''); if(this.value.length > 11) this.value = this.value.slice(0, 11);" 
      />
    </div>
  </div>
</div>


			           <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "nationality">Nationality:</label>

			              <div class="col-md-8">
			                <input onkeyup="capitalizeInput(this)" name="nationality" type="text" class="form-control input-sm" id="nationality" /  maxlength="17">
			              </div>
			            </div>
			          </div>
			         
			             <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "company">Company:</label>

			              <div class="col-md-8">
			                <input onkeyup="capitalizeInput(this)" name="company" type="text" class="form-control input-sm" id="company" / required>
			              </div>
			            </div>
			          </div>
			              <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "caddress">Address:</label>

			              <div class="col-md-8">
			                <input onkeyup="capitalizeInput(this)" name="caddress" type="text" class="form-control input-sm" id="caddress" / required>
			              </div>
			            </div>
			          </div>
			    
			         
			            <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "username">Username:</label>

			              <div class="col-md-8">
			                <input name="username" type="email" class="form-control input-sm" id="username" / placeholder="User@gmail.com">
			              </div>
			            </div>
			       		 </div>
			  <!--     
			          <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "cemail">CONFRIM E-MAIL:</label>

			              <div class="col-md-8">
			                <input name="cemail" type="text" class="form-control input-sm" id="cemail" />
			              </div>
			            </div>
			          </div> -->
			          <div class="form-group">
    <div class="col-md-8">
        <label class="col-md-4 control-label" for="password">Password:</label>
        <div class="col-md-8" style="position: relative;">
            <div style="position: relative;">
                <input name="pass" type="password" class="form-control input-sm" id="password" onkeyup="validatePassword()" required placeholder="Ex@mple123" style="padding-right: 30px;">
                <span toggle="#password" class="fa fa-fw fa-eye" onclick="togglePasswordVisibility()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #aaa; font-size: 1em; z-index: 2;"></span>
            </div>
            <span id="password-error" style="color: red;"></span>
        </div>
    </div>
</div>




			          <div class="form-group">
			            <div class="col-md-8">
			              <label class="col-md-4 control-label" for=
			              "zip">Zip Code:</label>

			              <div class="col-md-8">
			                <input name="zip" type="number" class="form-control input-sm" id="zip" / maxlength="4" minlength="4" required="">
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

    // Regular expressions for criteria
    var hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
    var hasNumber = /\d/.test(password);
    var hasCapital = /[A-Z]/.test(password);

    // Initialize the error message
    var errorMessage = "";

    // Check password length
    if (password.length < 6) {
        errorMessage = "Password must be at least 6 characters long.";
    } else if (!hasSpecialChar) {
        errorMessage = "Password must contain at least one special character.";
    } else if (!hasNumber) {
        errorMessage = "Password must contain at least one number.";
    } else if (!hasCapital) {
        errorMessage = "Password must contain at least one capital letter.";
    }

    // Display the error message if there is any, otherwise clear it
    passwordError.textContent = errorMessage;
    passwordInput.setCustomValidity(errorMessage ? errorMessage : "");
}
</script>


<script>
	function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var toggleIcon = document.querySelector(".toggle-password");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}
</script>
			
 