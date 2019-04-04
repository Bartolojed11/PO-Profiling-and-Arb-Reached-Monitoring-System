var len = 0;
var exz = [];
var slideIndex = 1;
showDivs(slideIndex, 1);
var o = 1;
var prev = 1;
var up_row = 0;
function plusDivs(n, prt) {
    showDivs(slideIndex += n, prt);
}

function showDivs(n, prt) {

var notz = false;
for (var iz = 0; iz < exz.length; iz++) {
    if (exz[iz] == n) {
        notz = true;
    }
}
if (notz == false) {
    len = n;
    exz[n] = n;
    $('#arb_page').append('<li id="part' + len + '" onclick="targetz(' + len + ', ' + len + ')"><i class="fa fa-folder-open"></i> PAGE ' + len + '</li>');
}
var i;
var x = document.getElementsByClassName("form-next");
for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
}
x[slideIndex - 1].style.display = "block";
$('#part' + prev).removeAttr('class', 'active_cust');
$('#part' + prt).attr('class', 'active_cust');
prev = prt;
}

function enable(id){
    $('#' + id).removeAttr('disabled', ' ');
    $('.' + id).toggleClass('addbgcolor');
}
function addbg(val, val2) {
    if(val2 == 0) {
        $('.'+val).toggleClass('addbgcolor');
    } else {
        $('.'+val+''+val2).toggleClass('addbgcolor');
    }
}
show_barangay();
function show_barangay() {
    let city = $('#arb_municipal').val();
    let upd_bid = $('#upd_bid').val();
    $.post('controller/disp_brgy.php' , {
        cid : city,
        upd_bid : upd_bid
    }, function(data,status) {
        $('#arb_barangay').html(data);
    });
}

$('.removethis').click(function(){
    $(this).parents('tr').first().remove();
});

set_age();
function set_age() {
    let age = $('#arb_bdate').val();
    let year = age.split("-");
    let d = new Date();
    $('#age').val(Number(d.getFullYear()) - Number(year[0]));
    if(age == '') {
        $('#age').val('');    
    }
    console.log('age' + age);
}

$('#arb_lname, #arb_fname , #arb_mi').keyup(function() {
    $('#attestedby').val($('#arb_lname').val() + ' ' + $('#arb_fname').val() + ' ' + $('#arb_mi').val());
});
$('select').focusin(function() {
    $(this).css({'border':'0px' ,'border-bottom':'1.5px solid green'});
});
$('select').focusout(function() {
    $(this).css({'border':'1px' ,'border-bottom':'1px solid gray'});
});