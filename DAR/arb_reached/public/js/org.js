"use strict";
            
            let pageURL = $(location).attr("href");
            let onchange = 0;
            
            data_table();

            function data_table(){
                $('#org').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : false,
                'info'        : true,
                'autoWidth'   : false,
                });
                //let let_arbo_non = pageURL.slice(-(10));
                //let let_arbo = pageURL.slice(-(7));
                if(onchange % 2 != 0) {
                    notreached();
                    console.log("not?"+onchange);
                } else if (onchange == 0 || onchange % 2 == 0) {
                    reached();
                    console.log("reached"+onchange);
                }
                $('#org_paginate').css('text-align','left');
                $('#org_type').css('margin-left','20px');
                $('#org_type').on("change",function(){
                    let c_url = $('#org_type').val();
                    if(c_url == 'reached'){
                        fetch_arbr(pageURL+'&organization=reached');
                    } else if (c_url == 'notreached'){
                        fetch_arbr(pageURL+'&organization=notreached');
                        
                    }
                    
                    onchange++;
                });
               
            }

            function reached() {
                $('#org_filter').append('<label><select name="org_type" class="form-control input-sm" id="org_type">'+
                            '<option value="reached">Reached</option>'+
                            '<option value="notreached">Not Reached</option>'+
                        '</select></label>');

            }
            
            function notreached() {
                $('#org_filter').append('<label><select name="org_type" class="form-control input-sm" id="org_type">'+
                        '<option value="notreached">Not Reached</option>'+
                        '<option value="reached">Reached</option>'+
                        '</select></label>');
            }

            function fetch_arbr(pageURL) {
                let urllength = pageURL.length;
                let locateurl = urllength - 64;
                let newrurl = pageURL.slice(-(locateurl));
                console.log('amuni' + newrurl);
                $.ajax({
                    url : 'org_content.php?'+newrurl,
                    type : 'post',
                    data : newrurl,
                    success : function(data,status){
                        $('#arbr').html(data);
                        data_table();
                        }
                    });
            }    