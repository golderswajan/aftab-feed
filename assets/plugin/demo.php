<?php
/**
 * Created by PhpStorm.
 * User: swaja
 * Date: 12/27/2017
 * Time: 2:11 PM
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="jquery-3.2.1.min.js"></script>
        <script src="jquery.editable-grid_Swajan.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script>

            $(document).ready(function($){
                $('table').editableGrid({
                    primaryTable: "identity",
                    selectQuery : "select identity.id,name,st_id,institution from identity,student where identity.id=student.i_id",
                    columns : [
                        "NAME",
                        "Student Id",
                        "Institution"
                     ],
                    editMethods: {
                         institution : "update identity,student set student.institution='*' where student.i_id=identity.id && identity.id='*'" ,
                         st_id : "update identity,student set student.st_id='*' where student.i_id=identity.id && identity.id='*'"
                    }


                    }
                );

            });

            function reload(){
                $('table').editableGrid({
                    primaryTable: "identity"
                });
            }

        </script>

<!--        <style>-->
<!--            <style>-->
<!--            .myTable{-->
<!--                width: 95%;-->
<!--                margin: 2%;-->
<!--            }-->
<!--            .myTable table,th,td{-->
<!--                border:1px solid black;-->
<!--                border-collapse: collapse;-->
<!--            }-->
<!--            .myTable textarea,span{-->
<!--                padding: 6px;-->
<!--                text-align: left;-->
<!--            }-->
<!--            .myTable th{-->
<!--                background: black;-->
<!--                color:white;-->
<!--            }-->
<!--            table.myTable tr:nth-child(even){-->
<!--                background-color: #eeeeee;-->
<!--            }-->
<!--            table.myTable tr:nth-child(odd){-->
<!--                background-color: #ffffff;-->
<!--            }-->
<!--            .myTextArea-->
<!--            {-->
<!--                width: 100%;-->
<!--                height: 100%;-->
<!--            }-->
<!--        </style>-->
    </head>

    <body>
        <table width="50%" style="border: 1px solid black">
        </table>
    <div onclick="reload()">hello</div>
    </body>
</html>
