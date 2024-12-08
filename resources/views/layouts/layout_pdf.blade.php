<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        body {
            color: #0a0a0a;
            font-size: 13px;
            font-family: DejaVu Sans, sans-serif;
        }

    </style>

</head>
<style type="text/css">

    div.filter_exp {
        background-color: #EEEEEE;
    }

    td.titre_g{
        font-size: 12px;
        font-weight: bold;
        text-align: left;

    }
    td.titre_ar_g{
        font-size: 14px;
        font-weight: bold;
        text-align: right;

    }
    td.titre2_g{
        font-size: 10px;
        text-align: left;
    }
    td.titre2_ar_g{
        font-size: 11px;
        text-align: right;
    }

    td.titre3_g{
        font-size: 9px;
        text-align: left;
        font-weight: bold;

    }
    td.titre3_ar_g{
        font-size: 10px;
        text-align: right;
        font-weight: bold;

    }

    td.titre{
        font-size: 10px;
        font-weight: bold;
        text-align: left;

    }
    td.titre_ar{
        font-size: 11px;
        font-weight: bold;
        text-align: right;

    }
    td.titre2{
        font-size: 9px;
        text-align: left;
    }
    td.titre2_ar{
        font-size: 8px;
        text-align: right;
    }

    td.titre3{
        font-size: 8px;
        text-align: left;
        font-weight: bold;

    }
    td.titre3_ar{
        font-size: 9px;
        text-align: right;
        font-weight: bold;

    }
    img {
        width: 40px;
        height: 40px;
    }
    td.t_left{
        /*border: 1px solid red;*/
        width: 45%;
    }
    td.t_center{
        /*border: 1px solid blue;*/
        width: 10%;
    }
    td.t_right{
        /* border: 1px solid green;*/
        width: 45%;
    }

    td.t_left_g{
        /*border: 1px solid red;*/
        width: 32%;
    }
    td.t_center_g{
        /*border: 1px solid blue;*/
        width: 40%;
    }
    td.t_right_g{
        /* border: 1px solid green;*/
        width: 28%;
    }


    .pdf-table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .pdf-table td, .pdf-table th {
        border: 1px solid #ddd;
        padding: 8px;
        color: #444
    }

    .pdf-table th {
        background-color: #f1f1f1;
    }

    .pdf-filter {
        background-color: #eef;
        padding: .8rem;
        margin-bottom: 1rem;
    }

    .filter-table tr td {
        padding: .2rem;
        width: 33.33%;
        vertical-align: top;
    }

    .filter-table tr td:nth-child(2) {
        padding: 0 1rem;
    }

    /*pdf activite and marches */


    .removeBorder tr, td {
        border: 0px solid black;
    }

    .table_space tr td {
        padding: 2px;
    }

    table.removeBorder_td td {
        border: none !important;
    }

    table.table_space {
        padding: 0px;
        margin-bottom: 0px;
    }

    .table_space td {
        padding: 2px;
    }

    .decompte tr, th {
        border: 1px solid black;
    }

    .removeBorder tr, td {
        border: 0px solid black;
    }

    .table_montants {
        margin-left: 50%;
        margin-top: 5px;
    }

    .decompte td, th {
        border: 1px solid black;
    }
</style>
<body>
<div id="wrapper">
    
    <div class="ct_certificat ">

        @yield("page-content")
        
    </div>


</div>
</body>
</html>
