$("#loginform").on("submit",function(event){
    
    let data = $('#loginform').serialize();
    event.preventDefault();
	
	var username_ = $('#username').val();
	
		$.ajax({
        url : 'validate/loginscript_.php',
        type : 'POST',
        data :  data,
        success : function(data,status){
            console.log(data,status);
            if(data == 1){
                window.location = 'pages/index.php';
            }
			else if(data == 2){
				//alert('You don\'t have enough permission!');
			} else {
                $('#iferror').html('<center><span class="loginerror">Invalid username or password!</span></center>');
                $('#divpass,#divuname').addClass('loginerrinput');
            }
        }
    });
});