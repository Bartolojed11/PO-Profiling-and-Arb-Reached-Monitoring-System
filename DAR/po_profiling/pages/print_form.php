<?php
session_start();
require 'controller/connection.php';
require 'controller/user_functions.php';
$_COOKIE['username'] = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$_COOKIE['ssid'] = isset($_COOKIE['ssid']) ? $_COOKIE['ssid'] : '';
    if(authUser($_COOKIE['username'],$_COOKIE['ssid'], $conn)) {
        $user = $_COOKIE['username'] ;
?>

<!DOCTYPE html>
<html>

    <head>
        <style>
            body{
                font-family:sans-serif;
                font-size:12px;
            }
        .table th {
            border-bottom:1px solid gray;
            border-right:1px solid gray;
        }
        .table-bordered> tbody>tr>td,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>td,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>thead>tr>th {
            border: 1px solid #ddd;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 2px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }
        td, th {
            padding: 0;
        }
        .table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        .table {
            display: table;
            border-collapse: separate;
            border-spacing: 0px;
            border-color: grey;
        }
        .pagebreak { page-break-before: always; }
        input[type="text"] {
            border:0px;
            border-bottom:1px solid gray;
            outline:none;
        }
        input[type="text"]:disabled {
            background-color:white;
        }
        .cust_inline {
            display:inline;
        }
    .text-center {
        text-align:center;
    }
    .no-border {
        border-top:0px;
        border-bottom:0px;
    }
        </style>
    </head>

    <body>

        <div style="width:720px;border:1px double gray;border-width:5px;padding:10px;">
            <center><b>PO PROFILE<b></center>
            </div><br><br>
        <center><span>
        As of:<input disabled type='text' class='border-bottom' style='width:500px;'></center><br>

        <table>
        <tbody>
            <tr>
                <td style="width:160px;"><b>Name of PO:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Acronym:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Address:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Area of Operation:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Contact person:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Date organized:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Date registered:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Registration No.:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Agency/Entity registered:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Type of Organization:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Affiliation:</b></td>
                <td><input disabled type='text' class='border-bottom' style='width:500px;'></span></td>
            </tr>
        </tbody>
        
        </table>
        

        <br>
        <table class="" style="border:0px;width:700px;">
            <thead style="border:0px;">
                <tr style="border:0px;">
                    <th style="border:0px;">NAME OF NGO/ORGANIZATION ASSISTING</th>
                    <th style="border:0px;" class="text-center">YEAR</th>
                </tr>
            </thead>    

            <tbody id="add_row_1">
                <tr style='border:0px;'>
                    <td style='border:0px;'><input  disabled type='text' class='border-bottom' style='width:90%;'></td>
                    <td style='border:0px;'><input  disabled type='text' class='border-bottom' style='width:85%;'></td>
                </tr>
                <tr style='border:0px;'>
                    <td style='border:0px;'><input disabled  type='text' class='border-bottom' style='width:90%;'></td>
                    <td style='border:0px;'><input  disabled type='text' class='border-bottom' style='width:85%;'></td>
                </tr>
            </tbody>
        </table>
        <br>
        <b>CURRENT SERVICES PROVIDED:</b>

            <table class="table table-bordered">
                <tr>
                    <td style="width:200px;border-bottom:0px;border-top:0px;border-left:0px;"></td>
                    <td style="border-bottom:0px;">Units/</td>
                    <td colspan="2" class="text-center">Clients Served</td>
                    <td style="width:200px;border-top:0px;border-left:0px;"></td>
                    <td style="border-bottom:0px;">Units/</td>
                    <td colspan="2"  style="border-bottom:0px;" class="text-center" >Clients Served</td>
                </tr>
                <tr>
                    <td style="width:200px;border-bottom:0px;border-left:0px;border-top:0px;" ></td>
                    <td  style="border-top:0px;">Heads</td>
                    <td>Members</td>
                    <td>Non-Members</td>
                    <td style="width:200px;border-bottom:0px;border-top:0px;"></td>
                    <td  style="border-top:0px;">Heads</td>
                    <td>Members</td>
                    <td>Non-Members</td>
                </tr>
                <tr>
                    <td style="height:20px;width:200px;border-bottom:0px;border-left:0px;border-top:0px;">Pre Harvest Facilities</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-bottom:0px;border-top:0px;border-left:0px;">Post Harvest Facilities</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;width:200px;border-bottom:0px;border-top:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;Farm Tractor</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Rice Thresher</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;border-left:0px;width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Hand Tractor</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Corn Sheller</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Power Tiller</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Rice Mill</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;
                        <input type="text" disabled></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Mechanical Dryer
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;border-left:0px;width:200px;border-bottom:0px;border-top:0px;">Livestock</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Solar Dryer</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;border-left:0px;width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Carabao</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Hauling/utility vehicle</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;border-left:0px;width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Cattle</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Warehouse/MBP</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Goat</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-left:0px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;<input type="text" disabled>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td style="height:20px;border-left:0px;width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Swine</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-bottom:0px;border-top:0px;">Other Projects</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;border-left:0px;width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;
                        <input type="text" disabled></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Nursery(tree,fruit)
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;border-left:0px;width:200px;border-bottom:0px;border-top:0px;">Poultry</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Rice Production</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr><tr>
                    <td style="height:20px;border-left:0px;width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Ducks</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Sugar Production</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td style="height:20px;border-left:0px;width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Geese</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Micro Lending</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;width:200px;border-left:0px;border-bottom:0px;border-top:0px;">Chicken(native,caber,etc.)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-bottom:0px;border-top:0px;">&nbsp;&nbsp;&nbsp;Consumer store</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="height:20px;width:200px;border-left:0px;border-bottom:0px;border-top:0px;"><input type="text" disabled></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:200px;border-bottom:0px;border-top:0px;"><input type="text" disabled></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        <br><br>
        
        <table class="">
        
        <thead class="bg-success-custom">
            <tr>
                <td colspan="1" style="padding:0px;">MEMBERSHIP: </td>
            </tr>
        </thead>
            <thead>
                <tr>
                    <td style="width:120px;">ARB</td>
                    <td style="width:130px;"> <input disabled type="text" style="width:110px;"></td>
                    <td style="width:120px;">MALE</td>
                    <td style="width:130px;"><input disabled type="text" style="width:110px;"></td>
                    <td style="width:120px;">FEMALE</td>
                    <td style="width:130px;"><input disabled type="text" style="width:110px;"></td>
                </tr>
            </thead>

            <thead>
                <tr>
                    <td style="width:120px;">NON-ARB</td>
                    <td style="width:130px;"><input disabled type="text" style="width:110px;"></td>
                    <td style="width:120px;">MALE</td>
                    <td style="width:130px;"><input disabled type="text" style="width:110px;"></td>
                    <td style="width:120px;">FEMALE</td>
                    <td style="width:130px;"><input disabled type="text" style="width:110px;"></td>
                </tr>
            </thead>

            <thead>
                <tr>
                    <td style="width:120px;">HH-ARB</td>
                    <td style="width:130px;"><input disabled type="text" style="width:110px;"></td>
                    <td style="width:120px;">MALE</td>
                    <td style="width:130px;"><input disabled type="text" style="width:110px;"></td>
                    <td style="width:120px;">FEMALE</td>
                    <td style="width:130px;"><input disabled type="text" style="width:110px;"></td>
                </tr>
            </thead>

            <thead>
                <tr>
                    <td>TOTAL </td>
                    <td><input type="text" disabled style="width:110px;"> </td>
                    <td>MALE</td>
                    <td><input type="text" disabled style="width:110px;"> </td>
                    <td>FEMALE</td>
                    <td><input type="text"disabled  style="width:110px;"> </td>
                </tr>
            </thead>
        </table> <br>
        <table class="pagebreak" style="width:650px;">
                    <thead class="bg-success-custom">
                        <tr>
                            <td colspan="1" style="padding:0px;">
                            <b>FINANCIAL STATUS: </b></td>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <td></th>
                            <td rowspan="3" class="text-center" style="vertical-align: middle;text-center;">AMOUNT</td>
                            <th rowspan="3" class="text-center" style="vertical-align: middle;">NO. OF SAVERS</th>
                        </tr>
                    </thead>
        
                        <tbody>
                            <tr>
                                <td>Capital Build Up:</td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>
                            </tr>
                        </tbody>
        
                        <tbody>
                            <tr>
                                
                                <td>Savings:</td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>
                                    
                            </tr>
                        </tbody>	
        
                        <tbody>
                            <tr>
                                <td>Total Assets:</td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>    
                            </tr>
                        </tbody>
        
                        <tbody>
                            <tr>
                                <td>Total Liabilities:</td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>
                            </tr>
                        </tbody>
        
        
                        <tbody>
                            <tr>
                                <td>Networth:</td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled class='border-bottom' style='width:90%;'></td>
                            </tr>
                        </tbody>	
        
                    </table><br>
                    LOANS AVALIED IF ANY: 
                    <table class="table table-bordered" >
                        <thead>
                                <tr>
                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">NATURE / PURPOSE OF LOAN</th>
                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">AMOUNT</th>
                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">SOURCE</th>
                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">DATE RELEASED</th>
                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">DATE AVAILED</th>
                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">TERMS OF PAYMENT</th>
                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">AMOUNT PAID</th>
        
                                </tr>
                            </thead>
        
                            <tbody id="add_row_7">
                            <?php
                                $i = 0;
                                while($i < 5) {
                                    echo '<tr>
                                            <td style="height:20px;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>';
                                $i++;
                                }
                            ?>
                                    
                            </tbody>
                        </table><br>

                TRAININGS ATTENDED: 
                <table style="width:760px;">
                    </thead>
                        <thead>
                            <tr>
                                <th colspan="2"></th>
                                <th colspan="2"><center>No. of Pax</center></th>
                            </tr>
                            <tr>
                                <th class="text-center" style="vertical-align: middle;">Title of training: </th>
                                <th class="text-center" style="vertical-align: middle;">Date Conducted</th>
                                <th class="text-center" style="vertical-align: middle;">Officers</th>
                                <th class="text-center" style="vertical-align: middle;">Members</th>
                            </tr>

                        </thead>

                        <tbody>
                            <?php
                                $i = 0;
                                while($i < 10) {
                                    echo "<tr>
                                            <td><input type='text' class='border-bottom' style='width:180px;'></td>
                                            <td><input type='text' class='border-bottom' style='width:180px;'></td>
                                            <td><input type='text' class='border-bottom' style='width:80px;margin-left:50px;'></td>
                                            <td><input type='text' class='border-bottom' style='width:80px;margin-left:50px;'></td>
                                        </tr>";
                                        $i++;
                                }
                            
                            ?>
                        </tbody>
                    </table><br><br><br><br>
                    <b>(Please attached list of officers and members and note if acttve and inactive)</b>
                    <div class="pagebreak">
                    <b> LIST OF OFFICERS AND BOARD OF DIRECTORS</b>
                    <table class="table table-bordered" style="width:760px;">
                        <thead>
                            <tr>
                                <th>NAMES</th>
                                <th>POSITION</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                    $i = 0;
                                    while($i < 9) {
                                        echo "<tr>
                                                <td style='height:20px;'></td>
                                                <td style='height:20px;'></td>
                                            <tr>
                                        ";
                                        $i++;
                                    }
                                ?>
                        </tbody>
                    </table>
                    <br><br>
                    <h3><b>LIST OF BOARD OF MEMBERS AND COMMITTESSAND MEMBERS</b></h3>
                    <div class="row">
                    <?php
                        $i = 0;
                        while($i < 4) {
                            echo '
                                <div class="col-lg-3 col-sm-3">COMMITTEE:
                                <table class="table table-bordered" style="width:760px">
                                    <thead>
                                        <tr>
                                            <th rowspan="3" class="text-center" style="vertical-align: middle;">NAMES</th>
                                            <th rowspan="3" class="text-center" style="vertical-align: middle;">POSITION</th>
                                            <th style="border-top:0px;border-bottom:0px;"></th>
                                            <th rowspan="3" class="text-center" style="vertical-align: middle;">NAMES</th>
                                            <th rowspan="3" class="text-center" style="vertical-align: middle;">POSITION</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    for($j = 0 ; $j < 3; $j++) {
                                        echo '<tr>
                                                <td style="height:20px;"></td>
                                                <td></td>
                                                <td style="border-top:0px;border-bottom:0px;"></td>
                                                <td style="height:20px;"></td>
                                                <td></td>
                                            </tr>';
                                    }
                                echo '</tbody>	
                            </table></div>';
                            $i++;
                        }
                    ?>
                    </div></div>
                            
<br>
<script>
    (function() {
        window.print();
    })();
</script>
</body>
</html>
<?php } else {
    header('Location:../index.php');
}?>