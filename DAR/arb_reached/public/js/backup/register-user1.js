function checkpass(val){
    console.log('this : ' + val);
    let pass = $('#password').val();
    console.log('pass : ' + pass);
    $('#c_password').on("blur" , function(){
        if (pass != val) {
            document.getElementById('c_password').setCustomValidity('Password did not match!');
        } else {
            document.getElementById('c_password').setCustomValidity('');
        }
    });
}

function checkEmail(email){
    console.log('email : ' + email);
    $.post("../server/checkEmail.php" , {
        email : email
    } , function(data){
        console.log(data);
            if(data === 0){
                document.getElementById('email').setCustomValidity('');
            } else {
                document.getElementById('email').setCustomValidity('Email already existed!');
            }
    });
}
function checkUsername(username){
    $.post("../server/checkUser.php" , {
        username : username
    } , function(data){
        console.log(data);
            if(data == 0){
                document.getElementById('username').setCustomValidity('');
            } else {
                document.getElementById('username').setCustomValidity('username already existed!');
            }
    });
}
function focus(){
    document.getElementById(this).setCustomValidity('');
}