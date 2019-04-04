<div class="content-wrapper" style="min-height: 916px;">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body" id="regpage">
            <div id="headlogo" class="row">
            <div class="col-lg-12"><img class="img-responsive"src="../logo/head.png" alt="darheader"></div>
            </div>

            <br><br>
					<form method="post" role="form" id="register-user" autocomplete="on" action="../server/regis111.er_user.php" >

					<div class="form-header">
					<h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-user"></span> Register New User</h3>
					</div>

					<div class="form-body"><br>

					  <!-- json response will be here -->
					  <div id="errorDiv"></div>
					  <!-- json response will be here -->

						<br>
						<label>Personal Information</label>

					  <div class="row">

							<div class="form-group col-md-4">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
							   <input id="first_name" onfocusin="focus()" name="first_name" pattern="[A-Za-z ]{2,20}" title="Must Contain letters only" required type="text" class="form-control" placeholder="First Name">
							   </div>
							   <span class="help-block" id="error"></span>
							</div>
							<div class="form-group col-md-4">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
							   <input id="middle_name" name="middle_name" type="text" class="form-control" placeholder="Middle Name" pattern="[A-Za-z ]{2,20}" title="Must Contain letters only" required> 
							   </div>
							   <span class="help-block" id="error"></span>
							</div>
							<div class="form-group col-md-4">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
							   <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Last Name" pattern="[A-Za-z ]{2,20}" title="Must Contain letters only" required>
							   </div>
							   <span class="help-block" id="error"></span>
							</div>
					  </div>
						<div class="row">
							<div class="form-group col-md-8">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
							   <input name="email" id="email" onkeypress="checkEmail(this.value)"  onfocusin="focus()"  type="email" class="form-control" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required >
							   </div> 
							   <span class="help-block" id="error"></span>
							</div>
							<div class="form-group col-md-4">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
							   <input name="phone" id="phone" type="text" class="form-control" placeholder="Phone Number" pattern="[0-9]{11}" title="Must contain 11 digit number" required>
							   </div>
							   <span class="help-block" id="error"></span>
							</div>
						</div>

					  <div class="row">
						  <div class="form-group col-md-6">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>

								   <input id="province" name="province" value="" required type="text" class="form-control" placeholder="Select a Province" pattern="[A-Za-z ]{2,30}" title="Must Contain letters only" >
								   <div class="input-group-btn">
									<button id="get" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<span class="caret"></span></button>
										<ul class="dropdown-menu"  id='provv'>
											<?php
												require '../server/connectdb.php';

												$query = $conn->query("SELECT * FROM tbl_prov ORDER BY province");
												while($fetch = $query->fetch_array()){
											?>
											<li value="<?php echo $fetch['pid']?>"><a><?php echo $fetch['province']?></a></li>
											<?php
												}
											?>
											<li value="0"><a>Please Specify</a></li>
										</ul>
										</div>

							   </div> 
							   <span class="help-block" id="error"></span>
						  </div>
						  
						  <div class="form-group col-md-6" id="cityin">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
							   <input id="city" name="city" required type="text" class="form-control" disabled = "disabled" placeholder="Select a City" pattern="[A-Za-z ]{2,30}" title="Must Contain letters only">
								   <div class="input-group-btn">
									<button id="citydrop" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" disabled = "disabled">
									<span class="caret"></span></button>
									<ul class="dropdown-menu"  id='cityy'>
											<li value="" onclick="tryy()"><a></a></li>	
									</ul>
							   </div>
							   </div>
							   <span class="help-block" id="error"></span>
						  </div>
						  </div>
					  <div class="row" id="brgyrow">
						  <div class="form-group col-md-6">
						  <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
							   <input id="barangay" name="barangay" required type="text" disabled = "disabled" class="form-control" placeholder="Select a Barangay" pattern="[A-Za-z0-9 ]{2,30}" title="Must Contain letters and numbers only">
								   <div class="input-group-btn">
									<button id="brgydrop" type="button" class="btn btn-default dropdown-toggle" disabled = "disabled"  data-toggle="dropdown" aria-expanded="false">
									<span class="caret"></span></button>
										<ul class="dropdown-menu"  id='brgyy'>
											<li value=""><a></a></li>	
										</ul>
							   </div>
							   </div>
							   <span class="help-block" id="error"></span>
						  </div>
						   <div class="form-group col-md-6" id="other_addr_div">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
							   <input id="other_addr" name="other_addr" required type="text" class="form-control" disabled = "disabled" placeholder="Street/Housenumber/Other" pattern="[A-Za-z0-9 ]{2,30}" title="Must Contain letters and numbers only">
								   <div class="input-group-btn">
									<button id="otherdrop" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" disabled = "disabled">
									<span class="caret"></span></button>
									<ul class="dropdown-menu"  id='other_addr_ul'>
											<li value=""><a></a></li>	
									</ul>
							   </div>
							   </div>
							   <span class="help-block" id="error"></span>
						  </div>
					  </div>
						<br>
						<label>Account Information</label>
						<br>

					  <div class="row">
						   <div class="form-group col-md-6">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
							   <input id="username" name="username" type="text" class="form-control" onkeypress="checkUsername(this.value)" onfocusin="focus()"  placeholder="Username" required pattern="[a-zA-Z0-9_-]" title="Please input a valid username">
							   </div>
							   <span class="help-block" id="error"></span>
						   </div>
						   <div class="form-group col-md-6">
							   <div class="input-group">
							   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
							   
							   <select id = "position" name="position" class = "form-control" required>
										<option value = "">Select a Position</option>
											<?php
												require '../server/connectdb.php';

												$query = $conn->query("SELECT * FROM tbl_role ORDER BY description");
												while($fetch = $query->fetch_array()){	

											?>
											<option value="<?php echo $fetch['role-id']?>"><?php echo $fetch['description']?></option>
											<?php
												}
											?>
									</select>
							   </div>
							   <span class="help-block" id="error"></span>
						   </div>
					  </div>
					  <div class="row">

						   <div class="form-group col-md-6">
								<div class="input-group">
								<div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
								<input name="password" id="password" type="password" class="form-control" placeholder="Password" required  onfocusin="focus()" 
									pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
								</div>  
								<span class="help-block" id="error"></span>                    
						   </div>

						   <div class="form-group col-md-6">
								<div class="input-group">
								<div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
								<input name="cpassword" id="c_password" type="password" class="form-control" placeholder="Retype Password" required  onfocusin="focus()" 
								onkeypress="checkpass(this.value)" data-toggle="popover" data-content="Password did not match!" data-placement="bottom">
								</div>  
								<span class="help-block" id="error"></span>                    
						   </div>
					</div>

					</div>
						 
					<div class="row">
						<div class="form-group">
							<div class="col-md-5"></div>
							<div class="col-md-2">
								<div class="form-footer">
									<button type="submit" class="btn btn-primary" id="btn-register" value="1" name="btn-register">
									 <span class="glyphicon glyphicon-log-in"></span>&nbsp&nbsp Register
									</button>
								</div>
							</div>
							<div class="col-md-5"></div>
						</div>
					</div>


					</form>


          </div>
        </div>
      </div>
    </div>
  </div>
</section>

