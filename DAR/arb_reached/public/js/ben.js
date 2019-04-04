"use strict";
let pageURL = $(location).attr("href");
let onchange = 0;
data_table();
function data_table(){
    $('#benarb').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : true,
    'ordering'    : false,
    'info'        : true,
    'autoWidth'   : false,
    });
    let let_non = pageURL.slice(-(7));
    let let_arbo = pageURL.slice(-(4));
    if(onchange % 2 != 0){
        nonarbo();
        console.log("aa" + let_non + " " + let_arbo );
    } else if (onchange == 0 || onchange % 2 == 0) {
        arbo();
    }
    $('#benarb_paginate').css('text-align','left');
    $('#ben_type').css('margin-left','20px');
    $('#ben_type').on("change",function(){
        let c_url = $('#ben_type').val();
        if(c_url == 'arbo'){
            fetchben(pageURL+'&org=arbo');
        } else if (c_url == 'nonarbo'){
            fetchben(pageURL+'&org=nonarbo');
        }
        onchange++;
    });
}

function arbo(){
    $('#benarb_filter').append('<label><select name="ben_type" class="form-control input-sm" id="ben_type">'+
                '<option value="arbo">With Organization</option>'+
                '<option value="nonarbo">Without Organization</option>'+
            '</select></label>');

}

function nonarbo(){
    $('#benarb_filter').append('<label><select name="ben_type" class="form-control input-sm" id="ben_type">'+
                '<option value="nonarbo">Without Organization</option>'+
                '<option value="arbo">With Organization</option>'+
            '</select></label>');
}

function fetchben(pageURL){
    let urllength = pageURL.length;
    let locateurl = urllength - 55;
    let newurl = pageURL.slice(-(locateurl));
    
    $.ajax({
        url : 'ben_content.php?'+newurl,
        type : 'post',
        data : newurl,
        success : function(data,status){
            $('#example1_wrapper').html(data);
            data_table();
            }
        });
}