<?php
//    include_once './templates/topper-customized.php';
//?>

<!doctype html>
<html>
    <head>

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <script src="/assets/plugin/jquery-3.2.1.min.js"></script>
        <style>
            td{
                /*background: #4091e2;*/
                background: #9d9d9d;
                width: 34px;
                height: 34px;
                border: 2px solid black;
                font-size: x-small;
            }
        </style>
        <script>

            var points='';
            function  showResult() {
                var x1 = $('#x1').val();
                x1=parseInt(x1);
                var x2 = $('#x2').val();
                x2=parseInt(x2);
                var y1 = $('#y1').val();
                y1=parseInt(y1);
                var y2 = $('#y2').val();
                y2=parseInt(y2);
                var dx = x2-x1;
                var dy = y2-y1;
                var p = 2*dy-dx;
                if(dy>dx){
                    alert("This input is not supported by this algorithm as tangent is greater than 1");
                    return;
                }
                drawPoint(x1,y1);

                var y=y1;
                for(var i=x1 ;i<x2;i++){
                    if(p<0){
                        drawPoint(i+1,y);
                        p += 2*dy;
                    }else{
                        drawPoint(i+1,++y);
                        p += 2*dy-2*dx;
                    }
                }

    //            $('#points').html(points.slice(0,-1));

            }

            function drawPoint(m,n){
                points += "( "+m+","+n+" ),";
                var x = 19 - n +1;
                var y = m+1;
                console.log(x+" "+y);

                $('#cell'+x+''+y).css('background-color','red');
                $('#cell'+x+''+y).html("("+m+","+n+")");
            }

        </script>
    </head>

    <body>
        <div style="margin-left: 20px">

            <p id="points"></p>

            <div>
                <table>
                    <?php
                    $html='';
                        for($i=1;$i<21;$i++){
                            $html .= "<tr>";
                            for($j=1;$j<21;$j++){
                                $html .= "<td id=\"cell".$i.$j."\"></td>";
                            }
                            $html .= "</tr>";
                        }
                        echo $html;
                    ?>
                </table>
            </div>

            <div style="margin-top: 10px">
                <input type="number" id="x1" placeholder=" input X1">
                <input type="number" id="y1" placeholder=" input Y1">
                <input type="number" id="x2" placeholder=" input X2">
                <input type="number" id="y2" placeholder=" input Y2">
                <input type="button" value="Result" id="result" onclick="showResult()">
            </div>
        </div>
    </body>

</html>

<?php
//    include_once './templates/footer-customized.php';
?>
