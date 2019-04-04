show_municipal();
show_barangay();
function show_municipal() {
    let prov = $('#arbo_province').val();
    $.post('controller/show_list_city.php' , {
        prov : prov
    } , function(data , status) {
        $('#arbo_municipal').html(data);
    });
}

function show_barangay() {
    let city = $('#arbo_municipal').val();
    $.post('controller/show_list_brgy.php' , {
        city : city
    }, function(data,status) {
        $('#arbo_barangay').html(data);
    });
}
show_ope_municipal();
show_ope_barangay();
function show_ope_municipal(){
    let prov = $('#ope_prov').val();
    $.post('controller/show_list_city.php' , {
        prov : prov
    } , function(data , status) {
        $('#ope_city').html(data);
    });
}

function show_ope_barangay(){
    let city = $('#ope_city').val();
    $.post('controller/show_list_brgy.php' , {
        city : city
    }, function(data,status) {
        $('#ope_brgy').html(data);
    });
}
function getMemberDetails(lname,fname,mi) {
    $.post("getMemberDetails.php" , {
        fname : fname,
        lname : lname,
        mi : mi
    } , function(data,status){
        $('#cityin > div > input').val(data);
    });
}