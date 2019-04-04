$().ready(function(){
    redirect();
});

function redirect(){
    $(document).on("keydown", function( event ) {
        var key = event.which;
        console.log(key);
        if(key == 77){
            window.location = "arb_reached/index.php";
        } else if (key == 73){
            window.location = 'ARBIS/index.php';
        } else if (key == 80){
            window.location = 'po_profiling/index.php';
        } else if(key == 69){
            window.location = '../yob/login.php';
        }
      });
    $("#monitor").click(function(){
        window.location = "arb_reached/index.php";
    });
    $("#inventory").click(function(){
        window.location = "ARBIS/index.php";
    });
    $("#profiling").click(function(){
        window.location = "po_profiling/index.php";
    });
}