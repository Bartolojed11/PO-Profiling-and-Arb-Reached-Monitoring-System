
<?php require 'controller/connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
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
    </style>
</head>
<body>

<div class="association_members" style="">
<h4>COOPERATIVE MEMBERS</h4>

<table class='table table-bordered  associate_tbl' id='assoc_members_list'>
    <thead>
    <tr class='text-align:bottom;'>
        <td><small><span><center>NAMES</center></span></small></td>
        <td><small ></small></td>
        <td style='width:15px;'><small ><span>M/<br>F</span></small></td>
        <td><small ><span>ARB/<br>N-ARB</span></small></td>
        <td><small ><span>Active/</span></small></td>
        <td colspan='2'><small ><span>Contributions</span></small></td>
        <td colspan='7'><span><small ><center>Coop Programs/Services Availed</center></small></span></td>
        <td colspan='4'><small ><span><center>Trainings Attended</center></span></small></td>
    </tr>
    </thead>
    <thead style='white-space: nowrap'>
    <tr>
        <td><small ><span></i> (Last name, First Name, MI)</span></small></td>
        <td><small ><span>POSITION</span></small></td>
        <td style='width:15px;'><small><span>F</span></small></td>
        <td><small ><span>H-ARB</span></small></td>
        <td><small ><span>Inactive</span></small></td>
        <td><small ><span>CBU</span></small></td>
        <td><small ><span>M.DUE</span></small></td>

        <td><small ><span>Production</span></small></td>
        <td><small ><span>Marketing</span></small></td>
        <td><small ><span>Credit</span></small></td>
        <td><small ><span>PHF</span></small></td>
        <td><small ><span>MicroEnt.</span></small></td>
        <td><small ><span>Service</span></small></td>
        <td><small ><span>Others</span></small></td>
        <td colspan='4'></td>
        
    </tr>
    </thead>
    <tbody id="assoc_tbl"><tr>
            <?php
                $i = 0;
                while($i < 23) {

                    echo '<tr><td style="height:15px;"></td>';
                    for($j = 0 ; $j < 13; $j++) {
                        echo '<td style="min-width:30px;"></td>';
                    }
    
                    for($j = 0 ; $j < 3; $j++) {
                        echo '<td style="min-width:50px;"></td>';
                    }
                    echo '</tr>';
                    $i++;
                }
                
                
                
            ?>
</tbody>
                </table>

    <div>
    <script>
    (function() {
        window.print();
    })();
</script>
</body>
</html>