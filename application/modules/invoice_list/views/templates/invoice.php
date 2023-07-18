<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title></title>
    <style type="text/css">

* {
    outline: none !important;
}
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

body {
    background: #fff;
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding-bottom: 35px;
    overflow-x: hidden;
    font-size: 14px;
}

hr {
    height: 0;
    border-top: 1px solid #eee;
    display: block;
    -webkit-margin-before: 0.5em;
    -webkit-margin-after: 0.5em;
    -webkit-margin-start: auto;
    -webkit-margin-end: auto;
    border-style: inset;
    border-width: 1px;
}
.row {
    margin-right: -10px;
    margin-left: -10px;
}



.table {
    margin-bottom: 10px;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}

.table-responsive {
    min-height: .01%;
    overflow-x: auto;
}

.m-t-40 {
    margin-top: 40px !important;
}
.font-600 {
    font-weight: 600;
}

.panel .panel-body p {
    margin: 0px;
}
p {
    line-height: 1.6;
}

.table>thead>tr>th {
    vertical-align: bottom;
    border-bottom: 2px solid #ddd;
}

th {
    text-align: left;
}
td, th {
    padding: 0;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
 
}


@media (min-width: 992px){
.col-md-6 {
    width: 50%;
    
}
}

.f-right{
    float: right;
}
.f-left{
    float: left;
}


.table-responsive>table {
   border-collapse: collapse;
}

.table-responsive>table>tbody>tr> {
    border-bottom: 1px solid #dddddd !important;

}

.table-responsive>table>thead>tr> {
    background-color: #eee !important;
}

div.table-responsive>table>tbody>tr.even> {
    background-color: #ddd;
}
div.table-responsive>table>tbody>tr.total> {
    background-color: #cecece;
}

</style>
</head>
<body>
    <div class="panel panel-default">
        <div class="panel-body">
            {{HEADER}} 
            <hr>
            {{CONTANT}}
            <!-- end row -->
            <div class="m-h-50"></div>
                <div class="table-responsive">
                
                    {PRODUCT_TABLE}
                    
                </div>
            {{FOOTER}}
            <hr>
            <div class="hidden-print">
                      
            </div>
        </div>
    </div>
</body>
</html>

