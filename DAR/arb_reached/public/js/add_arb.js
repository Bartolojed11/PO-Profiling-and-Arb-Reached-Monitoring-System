// JavaScript Validation For Registration Page

$('document').ready(function()
{	 		
		 // name validation
		 var nameregex = /^[a-zA-Z ]+$/;
		 
		 $.validator.addMethod("validbistring", function( value, element ) {
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
		
		 $("#register-arb").validate({
				
		  rules:
		  {
			arb_lname: {
					required: true,
					validbistring: true,
					remote: {
						url: "controller/checkArb.php",
						type: "post",
						data: {
							arb_lname: function() {
								return $( "#arb_lname" ).val();
							}
						}
					}
				},
				arb_fname: {
					required: true,
					validbistring: true,
					remote: {
						url: "controller/checkArb.php",
						type: "post",
						data: {
							arb_fname: function() {
								return $( "#arb_fname" ).val();
							}
						}
					}
				},
				arb_mi: {
					required: true,
					validbistring: true,
					remote: {
						url: "controller/checkArb.php",
						type: "post",
						data: {
							arb_mi: function() {
								return $( "#arb_mi" ).val();
							}
						}
					}
				},
				spouse_lname: {
					required: true,
					validbistring: true
				},
				spouse_fname: {
					required: true,
					validbistring: true
				},
				spouse_mi: {
					required: true,
					validbistring: true
				},
				arb_cloa: {
					required: true,
					validbistring: true
				},
				arb_landsize: {
					required: true,
					validbistring: true
				},
				spouse_mi: {
					required: true,
					validbistring: true
				},
				email : {
				required : true,
				validemail: true,
				remote: {
					url: "controller/checkEmail.php",
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
				minlength : 1,
				maxlength : 11,
				validphone: true,
				},
			  	username : {
				required : true,
				validusername: true,
				remote: {
					url: "controller/checkUser.php",
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
					minlength: 1,
					maxlength: 15
				},
				cpassword: {
					required: true,
					equalTo: '#password'
				},
			    city: {
					required : true
				},
			    brgy: {
					required : true
				},
				profile_picture : {
					required : true,
					extension: "png|jpeg|gif"
				}, 
				position : {
					required : true
				}
		   },
		   messages:
		   {
			first_name: {
				required: "First Name is required",
				validbistring: "First Name must contain only alphabets and space",
				  },
			   middle_name: {
				required: "Middle Name is required",
				validbistring: "Middle Name must contain only alphabets and space"
				  },
			   last_name: {
				required: "Last Name is required",
				validbistring: "Last Name must contain only alphabets and space"
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
		   submitHandler : function(form) {
				// alert("Registered!");
				// form.submit();
				if ($(form).valid()) {
					form.submit(); 
				} else {
					return false;
				}           
		  	}
		   });
	
	// $('#user_type').on('change', function(){
	// 	if($('#user_type').val() == ""){
	// 		$('#for_officer').empty();
	// 		$('<option value = "">For officer---</option>').appendTo('#for_officer');
	// 		$('#for_officer').attr('disabled', 'disabled');
	// 		$('#for_assistant').empty();
	// 		$('<option value = "">For assistant---</option>').appendTo('#for_assistant');
	// 		$('#for_assistant').attr('disabled', 'disabled');
	// 	}else{
	// 		if($('#user_type').val() == "1"){
	// 			$('#for_assistant').attr('disabled', 'disabled');
	// 			$('#for_officer').removeAttr('disabled', 'disabled');
	// 			//$('#for_officer').load('controller/officer.php');
	// 		}
	// 		if($('#user_type').val() == "2"){
	// 			$('#for_officer').attr('disabled', 'disabled');
	// 			$('#for_assistant').removeAttr('disabled', 'disabled');
	// 		}
	// 	}
	// });
	
});