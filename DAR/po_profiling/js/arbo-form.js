$(function () {
    $('#datepicker').datepicker({
        autoclose: true
    })

    $('#q3 , #q5').datepicker({
        autoclose: true
    })

    // $('#benarb').DataTable({
    //     'paging': true,
    //     'lengthChange': false,
    //     'searching': false,
    //     'ordering': false,
    //     'info': false,
    //     'autoWidth': false
    // })
})

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
        $('#abc').append('<li id="part' + len + '" onclick="targetz(' + len + ', ' + len + ')"><i class="fa fa-folder-open"></i> PAGE ' + len + '</li>');
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

function targetz(l, m) {
    showDivs(slideIndex = l, m);
}


var row_id = 0;
let comm_count = 0;
var tbl_com = 0;
// show_org_count${row_id}
function add_association_mem() {
    row_id++;
    let tblr = `<tr id="assoc_${row_id}">
            <td style = "min-width:20px;pading-top:3em;" >
                <button class="btn btn-sm btn-default show_org_count" id="" type="button" data-toggle="modal" data-target="" >
                <span id="org_count_${row_id}">0</span>
            </button>
            </td>
            <td class="headcol1">
                <input type="text" class="custom_input assoc_lastname" name="assoc_lastname[]" onkeyup="checkArb($('.assoc_lastname').index(this))" id="">
            </td>
            <td class="headcol2">
                <input type="text" class="custom_input assoc_firstname" name="assoc_firstname[]"  onkeyup="checkArb($('.assoc_firstname').index(this))" id="assoc_firstname">
            </td>
            <td>
                <input type="text" class="custom_input assoc_mi" name="assoc_mi[]" onkeyup="checkArb($('.assoc_mi').index(this))" id="assoc_mi">
            </td>
            <td>
                <input type = "text" class = "custom_input" name = "assoc_position[]" id = "assoc_position" >
            </td>
            <td style = "min-width:150px;" >
                    <input type = "radio" class = "custom_radio_padd_sm"
                        name = "assoc_gender[${row_id}]" value="1" checked id="assoc_gender${row_id}" > M &nbsp;
                    <input type = "radio" class = "custom_radio_padd_sm"
                        name = "assoc_gender[${row_id}]" value="0" id = "assoc_gender${row_id}" > F
            </td>
            <td>
                <select class="select_brdr_btm vldt_arb assoc_arb_type" name="assoc_arb_type[]" id="" onchange="validate_arb()";>
                    <option value="1">ARB</option>
                    <option value="0">NON-ARB</option>
                    <option value="2">HH-ARB</option>
                </select>
            </td>
            <td>
                <input type = "checkbox" name = "assoc_status[]" id = "assoc_status" value = "1" >
            </td>
            <td>
                <input type = "text" class = "custom_input assoc_cloa_number fill_cloa" name = "assoc_cloa_number[]"
                onkeyup="validate_arb()" id = "assoc_cloa_number" >
            </td>
            <td>
                <input type="number" class="custom_input landsize assoc_landsize fill_land" name="assoc_landsize[]"
                onkeydown="validate_arb()" onkeyup="add_land()">
            </td>
            <td>
                <input type="text" class="custom_input_lg assoc_crop fill_crop" name="assoc_crop[]" onkeyup="validate_arb()">
            </td>
            <td>
                <input type = "checkbox" name = "assoc_cbu[]" id = "assoc_cbu" value = "1" >
            </td>
            <td>
                <input type="checkbox" class="custom_input" name="assoc_saving[]" value="1" id="assoc_saving">
            </td>
            <td>
                <input type = "checkbox" name = "assoc_production[]" id = "assoc_production" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_mrktng[]" id = "assoc_mrktng" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_credit[]" id = "assoc_credit" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_phf[]" id = "assoc_phf" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_micro[]" id = "assoc_micro" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_srvce[]" id = "assoc_srvce" value = "1" >
            </td>
            <td>
                <input type="text" class="custom_input_lg" name="assoc_others[]" id="assoc_others">
            </td>
            <td>
                <input type = "text" class = "custom_input_lg" placeholder="kindly put > after every new trainings" name = "assoc_train_attended[]" id = "assoc_train_attended" >
            </td>
            <td>
                <button class = "btn btn-sm btn-danger btn-sm" type = "button" onclick = "removez('assoc_${row_id}')" > X </button>
            </td>
            </tr>`;
    $("#assoc_tbl").append(tblr);
    validate_arb();
}

function add_association_mem_up(val) {
    row_id++;
    up_row = row_id + (val-1);
    let tblr = `<tr id="assoc_${up_row}">
            <td style = "min-width:20px;pading-top:3em;" >
                <button class="btn btn-sm btn-default show_org_count" id="show_org_count${up_row}" type="button" data-toggle="modal" data-target="" >
                <span id="org_count_${up_row}">0</span>
            </button>
            </td>
            <td class="headcol1">
                <input type="text" class="custom_input assoc_lastname" onkeyup="checkArb($('.assoc_lastname').index(this))" name="assoc_lastname[]" >
            </td>
            <td class="headcol2">
                <input type="text" class="custom_input assoc_firstname" onkeyup="checkArb($('.assoc_firstname').index(this))" name="assoc_firstname[]" >
            </td>
            <td>
                <input type="text" class="custom_input assoc_mi" onkeyup="checkArb($('.assoc_mi').index(this))" name="assoc_mi[]" >
            </td>
            <td>
                <input type = "text" class = "custom_input" name = "assoc_position[]" id = "assoc_position" >
            </td>
            <td style = "min-width:150px;" >
                    <input type = "radio" class = "custom_radio_padd_sm" name = "assoc_gender[${up_row}]" checked value="1" id = "assoc_gender${up_row}" > &nbsp; M

                    <input type = "radio" class = "custom_radio_padd_sm" name = "assoc_gender[${up_row}]" value="0" id = "assoc_gender${up_row}" > &nbsp; F
            </td>
            <td>
                <select class="select_brdr_btm vldt_arb assoc_arb_type" name="assoc_arb_type[]" id="" onchange="validate_arb()">
                    <option value="1">ARB</option>
                    <option value="0">NON-ARB</option>
                    <option value="2">HH-ARB</option>
                </select>  
            </td>
            <td>
                <input type = "checkbox" name = "assoc_status[]" id = "assoc_status" value = "1" >
            </td>
            <td>
                <input type = "text" class = "custom_input assoc_cloa_number fill_cloa" name = "assoc_cloa_number[]"
                onkeyup="validate_arb()" id = "assoc_cloa_number" >
            </td>
            <td>
                <input type="number" class="custom_input landsize assoc_landsize fill_land" name="assoc_landsize[]"
                onkeydown="validate_arb()" onkeyup="add_land()">
            </td>
            <td>
                <input type="text" class="custom_input_lg assoc_crop fill_crop" name="assoc_crop[]" onkeyup="validate_arb()">
            </td>
            <td>
                <input type = "checkbox" name = "assoc_cbu[]" id = "assoc_cbu" value = "1" >
            </td>
            <td>
                <input type="text" class="custom_input" name="assoc_saving[]" id="assoc_saving">
            </td>
            <td>
                <input type = "checkbox" name = "assoc_production[]" id = "assoc_production" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_mrktng[]" id = "assoc_mrktng" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_credit[]" id = "assoc_credit" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_phf[]" id = "assoc_phf" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_micro[]" id = "assoc_micro" value = "1" >
            </td>
            <td>
                <input type = "checkbox" name = "assoc_srvce[]" id = "assoc_srvce" value = "1" >
            </td>
            <td>
                <input type="text" class="custom_input_lg" name="assoc_others[]" id="assoc_others">
            </td>
            <td>
                <input type = "text" class = "custom_input_lg" placeholder="kindly put > after every new trainings" name = "assoc_train_attended[]" id = "assoc_train_attended" >
            </td>
            <td>
                <button class = "btn btn-sm btn-danger btn-sm" type = "button" onclick = "removez('assoc_${up_row}')" > X </button>
            </td>
            </tr>`;
    $("#assoc_tbl").append(tblr);
    validate_arb();
}

function adding_row() {
    row_id++;
    var tblr = '<tr id="rw_' + row_id + '">';
    tblr += '<td><input type="text" class="form-control" name="par1_name_org_assiting[]" placeholder=""></td>';
    tblr += '<td><input type="number" class="form-control"  min="1900" max="3000"  placeholder="1900"  name="part1_year[]"></td>';
    tblr += '<td><button class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw_' + row_id + '\')">X</button></td>';
    tblr += '</tr>';
    $("#add_row_1").append(tblr);
}

function addingup_row(num) {
    row_id++;
    up_row = row_id + (num-1);
    var tblr = '<tr id="rw_' + up_row + '">';
    tblr += '<td><input type="text" class="form-control" name="par1_name_org_assiting[]" placeholder=""></td>';
    tblr += '<td><input type="number" class="form-control"  min="1900" max="3000"  placeholder="1900"  name="part1_year[]"></td>';
    tblr += '<td><button class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw_' + up_row + '\')">X</button></td>';
    tblr += '</tr>';
    $("#add_row_1").append(tblr);
}

function adding_list() {
    row_id++;
    $(`#offcrs_and_bod_position${row_id}`).load('offc.php');
    var tblr = '<tr id="rw4_0' + row_id + '">' +
        '<td><input type="text" class="form-control" id="off_bod_fname" name="off_bod_fname[]"   ></td>' +
        '<td><input type="text" class="form-control" id="off_bod_lname" name="off_bod_lname[]"   ></td>' +
        '<td><input type="text" class="form-control" id="off_bod_mname" name="off_bod_mname[]"   ></td>' +
        '<td><input type="text" class="form-control" name="offcrs_and_bod_position[]"></td>' +
        '<td><button class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw4_0' + row_id + '\')">X</button></td>' +
        '</tr>';
    $("#add_row_9").append(tblr);
}

function adding_list_up(val) {
    row_id++;
    up_row = row_id + (val-1);
    $(`#offcrs_and_bod_position${row_id}`).load('offc.php');
    var tblr = '<tr id="rw4_0' + up_row + '">' +
        '<td><input type="text" class="form-control" id="off_bod_fname" name="off_bod_fname[]"   ></td>' +
        '<td><input type="text" class="form-control" id="off_bod_lname" name="off_bod_lname[]"   ></td>' +
        '<td><input type="text" class="form-control" id="off_bod_mname" name="off_bod_mname[]"   ></td>' +
        '<td><input type="text" class="form-control" name="offcrs_and_bod_position[]"></td>' +
        '<td><button class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw4_0' + up_row + '\')">X</button></td>' +
        '</tr>';
    $("#add_row_9").append(tblr);
}

var numb_of_tbl = 0;
function add_committee(val) {
    numb_of_tbl++;
    tbl_com = numb_of_tbl + Number(val);
    let committee = `
                <table class="table table-bordered" id="comm_${tbl_com}">
                    <thead style="background-color:#00a65a;padding:2px;color:white;">
                    <th colspan="2" class="text-center">COMMITTEE</th>
                    <th colspan="2"><input type="text" class="form-control custom-input-white" name="committee_type[]" placeholder="Input Committee..."></th>
                    <th style="width:40px;font-weight:bolder;"><button type="button" class="btn btn-danger btn-sm" onclick="removez('comm_${tbl_com}')"><b>--</b></th>
                    </thead>
                    <thead style="background-color:rgb(189, 255, 189);">
                    <tr>
                        <th>FIRSTNAME</th>
                        <th>LASTNAME</th>
                        <th>MIDDLENAME</th>
                        <th>POSITION</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody id="comm_tbl_${tbl_com}">
                        <tr id="comm_row_${tbl_com}">
                            <td>
                            <input type="hidden" name="committee_where[]" value="${tbl_com}_add">
                            <input type="text" class="form-control" name="com_mem_fname${tbl_com}[]"></td>
                            <td><input type="text" class="form-control" name="com_mem_lname${tbl_com}[]"></td>
                            <td><input type="text" class="form-control" name="com_mem_mname${tbl_com}[]"></td>
                            <td><select class="form-control select_brdr_btm" name="committee_pos${tbl_com}[]">
                                    <option value="1">CHAIRPERSON</option>
                                    <option value="2">MEMBER</option>
                                </select>
                                </td>
                                <td></td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="7">
                                <button type="button" class="btn btn-success btn-sm pull-right" onclick="adding_comm(${tbl_com})">
                                <i class="fa fa-plus"></i> ADD</button></th>
                        </tr>
                    </tfoot>
                </table>
                <br>
            `;
    $(`#committee_members`).append(committee);
}

function adding_comm(row) {
row_id++;
var tblr = `<tr id="comm_row_${row_id}">
                <td><input type="text" class="form-control" name="com_mem_fname${row}[]" placeholder=""></td>
                <td><input type="text" class="form-control" name="com_mem_lname${row}[]" placeholder=""></td>
                <td><input type="text" class="form-control" name="com_mem_mname${row}[]" placeholder=""></td>
                <td><select class="form-control select_brdr_btm" name="committee_pos${row}[]">
                <option value="1">CHAIRPERSON</option><option value="2">MEMBER</option></select></td>
                <td><button type="button" class="btn btn-sm btn-danger btn-sm" onclick="removez('comm_row_${row_id}')">X</button></td>
            </tr>`;
$(`#comm_tbl_${row}`).append(tblr);
}
function adding_rows() {
    row_id++;
    var tblr = '<tr id="rw2_' + row_id + '">';
    tblr += '<td><input type="text" class="form-control" name="purpose_of_loan[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="loan_amount[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="loan_source[]"   ></td>';
    tblr += '<td><input type="date" class="form-control" name="loan_date_released[]"   ></td>';
    tblr += '<td><input type="date" class="form-control" name="loan_date_availed[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="loan_terms_payment[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="loan_amount_paid[]"   ></td>';
    tblr += '<td><button class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw2_' + row_id + '\')">X</button></td>';
    tblr += '</tr>';
    $("#add_row_7").append(tblr);
}

function adding_rows_up(val) {
    row_id++;
    up_row = row_id + (val-1);
    var tblr = '<tr id="rw2_' + up_row + '">';
    tblr += '<td><input type="text" class="form-control" name="purpose_of_loan[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="loan_amount[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="loan_source[]"   ></td>';
    tblr += '<td><input type="date" class="form-control" name="loan_date_released[]"   ></td>';
    tblr += '<td><input type="date" class="form-control" name="loan_date_availed[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="loan_terms_payment[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="loan_amount_paid[]"   ></td>';
    tblr += '<td><button class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw2_' + up_row + '\')">X</button></td>';
    tblr += '</tr>';
    $("#add_row_7").append(tblr);
}

function adding_rowsy() {
    row_id++;
    var tblr = '<tr id="rw3_' + row_id + '">';
    tblr += '<td><input type="text" class="form-control" name="part3_title[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_date_conducted[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_conducted_by[]" placeholder=""></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_officers[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_members[]"   ></td>';
    tblr += '<td><button class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw3_' + row_id + '\')">X</button></td>';
    tblr += '</tr>';
    $("#add_row_8").append(tblr);
}

function adding_rowsy_up(val) {
    row_id++;
    up_row = row_id + (val - 1);
    var tblr = '<tr id="rw3_' + up_row + '">';
    tblr += '<td><input type="text" class="form-control" name="part3_title[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_date_conducted[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_conducted_by[]" placeholder=""></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_officers[]"   ></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_members[]"   ></td>';
    tblr += '<td><button class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw3_' + up_row + '\')">X</button></td>';
    tblr += '</tr>';
    $("#add_row_8").append(tblr);
}

function removez(rw) {
    $('#' + rw).remove();
    validate_arb();
}

var prt3 = 0;

function adding_row_part3() {
    prt3++;
    var tblr = '<tr id="rw3_' + prt3 + '">';
    tblr += '<td><input type="text" class="form-control" name="part3_crop_name[]"></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_area[]"></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_no_crop[]"></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_ave_yield[]"></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_annual_prod[]"></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_unit_price[]"></td>';
    tblr += '<td><input type="text" class="form-control" name="part3_gross_income[]"></td>';
    tblr += '<td><button class="btn btn-danger btn-sm" onclick="removez(\'rw3_' + prt3 + '\')">X</button></td>';
    tblr += '</tr>';
    $("#part3_crop_row").append(tblr);
}
var prt4 = 0;

function adding_row_part4() {
    pr4++;
    var tblr = '<tr id="rw4_' + prt4 + '">';
    tblr += '<td><input type="text" class="form-control" name="part4_name[]"></td>';
    tblr += '<td><input type="text" class="form-control" name="part4_positions[]"></td>';
    tblr += '<td><button class="btn btn-danger btn-sm" onclick="removez(\'rw4_' + prt4 + '\')">X</button></td>';
    tblr += '</tr>';
    $("#add_row_9").append(tblr);
}

var a_acc_row = 0;

function adding_access() {
    a_acc_row++;
    var d = '<div class="col-sm-12" id="ac_row_' + a_acc_row + '" style="margin-top: 7px;">';
    d += '<div class="col-xs-1">';
    d += '<button class="btn btn-sm btn-danger part5_no" onclick="removez(\'ac_row_' + a_acc_row + '\')">X</button>';
    d += '</div>';
    d += '<div class="col-sm-4">';
    d += '<input type="text" class="form-control part5_no" name="part5_owned[]">';
    d += '</div>';
    d += '<div class="col-sm-1">';
    d += '<label>';
    d += '<input type="radio" name="part5_owned_[' + a_acc_row + ']" class="flat-red part5_no" value="0" checked>';
    d += '</label>';
    d += '</div>';
    d += '<div class="col-sm-1">';
    d += '<label>';
    d += '<input type="radio" name="part5_owned_[' + a_acc_row + ']" class="flat-red part5_no" value="1">';
    d += '</label>';
    d += '</div>';
    d += '<div class="col-sm-5">';
    d += '<input type="text" class="form-control part5_no" name="part5_rented[]">';
    d += '</div>';
    d += '</div>';
    $('#add_access').append(d);
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
}

function type_() {
    var num1 = document.getElementById('part3_arb1_members').value;
    var num2 = document.getElementById('part3_arb2_members').value;
    var num3 = document.getElementById('total_hh_arb').value;
    document.getElementById('part3_total_members').value = (Number(num1) + Number(num2) + Number(num3));
}

function sumMale() {
    var num1 = document.getElementById('part3_arb1_male').value;
    var num2 = document.getElementById('part3_arb2_male').value;
    var num3 = document.getElementById('male_hh_arb').value;
    var num4 = document.getElementById('part3_arb1_female').value;
    var num5 = document.getElementById('part3_arb2_female').value;
    var num6 = document.getElementById('female_hh_arb').value;
    var num7 = document.getElementById('part3_arb1_members').value;
    var num8 = document.getElementById('part3_arb2_members').value;
    var num9 = document.getElementById('total_hh_arb').value;

    document.getElementById('part3_arb1_members').value = (Number(num1) + Number(num4));
    document.getElementById('part3_arb2_members').value = (Number(num2) + Number(num5));
    document.getElementById('total_hh_arb').value = (Number(num3) + Number(num6));
    document.getElementById('part3_total_male').value = (Number(num1) + Number(num2) + Number(num3));
    document.getElementById('part3_total_members').value = (Number(num7) + Number(num8) + Number(num9));
}


function sumFemale() {
    var num1 = document.getElementById('part3_arb1_male').value;
    var num2 = document.getElementById('part3_arb2_male').value;
    var num3 = document.getElementById('male_hh_arb').value;
    var num4 = document.getElementById('part3_arb1_female').value;
    var num5 = document.getElementById('part3_arb2_female').value;
    var num6 = document.getElementById('female_hh_arb').value;
    var num7 = document.getElementById('part3_arb1_members').value;
    var num8 = document.getElementById('part3_arb2_members').value;
    var num9 = document.getElementById('total_hh_arb').value;

    document.getElementById('part3_arb1_members').value = (Number(num1) + Number(num4));
    document.getElementById('part3_arb2_members').value = (Number(num2) + Number(num5));
    document.getElementById('total_hh_arb').value = (Number(num3) + Number(num6));
    
    document.getElementById('part3_total_female').value = (Number(num4) + Number(num5) + Number(num6));
    document.getElementById('part3_total_members').value = (Number(num7) + Number(num8) + Number(num9));

}