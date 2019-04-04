// JavaScript Validation For Registration Page

$('document').ready(function()
{		 
		 // name validation
		 var nameregex = /^[a-zA-Z ]+$/;
		 
		 $.validator.addMethod("validname", function( value, element ) {
		     return this.optional( element ) || nameregex.test( value );
		 }); 
		 
		 // valid email pattern
		 var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		 $.validator.addMethod("validemail", function( value, element ) {
		     return this.optional( element ) || eregex.test( value );
		 });
	
		 // valid username
		 var uregex = /^[a-zA-Z0-9_\.\-\+]+$/;
		 
		 $.validator.addMethod("validusername", function( value, element ) {
		     return this.optional( element ) || uregex.test( value );
		 });
	
		 // valid phone number
		 var phoneregex = /^[0-9 ]+$/;
		 
		 $.validator.addMethod("validphone", function( value, element ) {
		     return this.optional( element ) || phoneregex.test( value );
		 });
		
		
		 $("#register-user").validate({
		  rules:
		  {
				first_name: {
					required: true,
					validname: true
				},
			  	middle_name: {
					required: true,
					validname: true
				},
			  	last_name: {
					required: true,
					validname: true
				},
				email : {
				required : true,
				validemail: true,
				remote: {
					url: "../server/checkEmail.php",
					type: "post",
					data: {
						email: function() {
							return $( "#email" ).val();
						}
					}
				}
				},
			  	phone : {
				required : true,
				minlength : 11,
				maxlength : 11,
				validphone: true,
				},
			  	username : {
				required : true,
				validusername: true,
				remote: {
					url: "../server/checkUser.php",
					type: "post",
					data: {
						username: function() {
							return $( "#username" ).val();
						}
					}
				}
				},
				password: {
					required: true,
					minlength: 8,
					maxlength: 15
				},
				cpassword: {
					required: true,
					equalTo: '#password'
				},
			  	province: {
					required : true
				},
			    city: {
					required : true
				},
			    barangay: {
					required : true
				},
			    position: {
					required : true
				}
		   },
		   messages:
		   {
				first_name: {
					required: "First Name is required",
					validname: "First Name must contain only alphabets and space",
					  },
			   	middle_name: {
					required: "Middle Name is required",
					validname: "Middle Name must contain only alphabets and space"
					  },
			   	last_name: {
					required: "Last Name is required",
					validname: "Last Name must contain only alphabets and space"
					  },
				email : {
				required : "Email is required",
				validemail : "Please enter valid email address",
				remote : "Email already exists"
						},
			   	phone : {
				required : "Phone number is required",
				minlength : "Please input 11 digits",
				maxlength : "Please input only 11 digits",
				validphone : "Please enter valid phone number"
						},
				username : {
				required : "Username is required",
				validusername : "Please enter valid username",
				remote : "Username already exists"
						},
				password:{
					required: "Password is required",
					minlength: "Password at least have 8 characters"
					},
				cpassword:{
					required: "Retype your password",
					equalTo: "Password did not match !"
					},
			    province:{
					required: "Please fill in your address"
				},
			    city:{
					required: "Please complete your address"
				},
			    barangay:{
					required: "Please complete your address"
				},
			    position:{
					required: "Please select user position"
				}
		   },
		   errorPlacement : function(error, element) {
			  $(element).closest('.form-group').find('.help-block').html(error.html());
		   },
		   highlight : function(element) {
			  $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		   },
		   unhighlight: function(element, errorClass, validClass) {
			  $(element).closest('.form-group').removeClass('has-error');
			  $(element).closest('.form-group').find('.help-block').html('');
		   },
		   debug : true,
		   submitHandler: submitForm
		   });

});
function submitForm(){
	console.log('submit form');
	$.ajax({
		   
		   type : 'POST',
		   async: false,
		   url  : '../server/register_user.php',
		   data : $('#register-user').serialize(),
		   dataType : 'json',
						
		   success : function(data){
			   
			   
				   console.log(data);
				   
				   
				   //$('#btn-register').html('<img src="../useraccess/ajax-loader.gif" /> &nbsp; loading...').attr('disabled', 'disabled');
					
					setTimeout(function(){
						
						if ( data.status =='success' ) {
							
							$('#errorDiv').slideDown(200, function(){
								 $('#errorDiv').html('<div class="alert alert-info">'+data.message+'</div>');
								 $('#errorDiv').delay(3000).slideUp(100);
								 $("#register-user")[0].reset();
								 $('#btn-register').html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Register');
								 $('#btn-register').removeAttr('disabled');
								 });
							
						} else {
							 $('#errorDiv').slideDown(200, function(){
								  $('#errorDiv').html('<div class="alert alert-danger">'+data.message+'</div>');
								  $('#errorDiv').delay(3000).slideUp(100);
								  $('#btn-register').html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Register');
								  $('#btn-register').removeAttr('disabled');
							  });
						}
					
					},100);
							
		   },
		   error: function(){console.log('Error')}

	});
	
	return false;
}