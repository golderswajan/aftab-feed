<?php
    include_once './templates/topper-customized.php';
?>
<script>

    function showCalculator() {
        $('#calc').show();
    }

</script>
<div style="position: relative">
    <input type="button" value="Calculator" onclick="showCalculator()">
    <input type="number" id="comission">

    <FORM NAME="Calc" id="calculator" style="display: block;z-index: 1;position: absolute;top: 80px;left: 50px;">
        <TABLE BORDER=4>
            <TR>
                <TD>
                    <INPUT TYPE="text"   NAME="Input" Size="16">
                    <br>
                </TD>
            </TR>
            <TR>
                <TD>
                    <INPUT TYPE="button" NAME="ac"   VALUE="AC" OnClick="Calc.Input.value = ''">
                    <INPUT TYPE="button" NAME="clear"   VALUE="c" OnCLick="Calc.Input.value = Calc.Input.value.slice(0,-1)">
                    <INPUT TYPE="button" NAME="close" VALUE="close" OnClick="$('#calculator').hide()">
                    <INPUT TYPE="button" NAME="save"  VALUE="save" OnClick="$('#comission').val(Calc.Input.value);$('#calculator').hide()">
                    <br>
                    <INPUT TYPE="button" NAME="one"   VALUE="  1  " OnClick="Calc.Input.value += '1'">
                    <INPUT TYPE="button" NAME="two"   VALUE="  2  " OnCLick="Calc.Input.value += '2'">
                    <INPUT TYPE="button" NAME="three" VALUE="  3  " OnClick="Calc.Input.value += '3'">
                    <INPUT TYPE="button" NAME="plus"  VALUE="  +  " OnClick="Calc.Input.value += ' + '">
                    <br>
                    <INPUT TYPE="button" NAME="four"  VALUE="  4  " OnClick="Calc.Input.value += '4'">
                    <INPUT TYPE="button" NAME="five"  VALUE="  5  " OnCLick="Calc.Input.value += '5'">
                    <INPUT TYPE="button" NAME="six"   VALUE="  6  " OnClick="Calc.Input.value += '6'">
                    <INPUT TYPE="button" NAME="minus" VALUE="  --  " OnClick="Calc.Input.value += ' - '">
                    <br>
                    <INPUT TYPE="button" NAME="seven" VALUE="  7  " OnClick="Calc.Input.value += '7'">
                    <INPUT TYPE="button" NAME="eight" VALUE="  8  " OnCLick="Calc.Input.value += '8'">
                    <INPUT TYPE="button" NAME="nine"  VALUE="  9  " OnClick="Calc.Input.value += '9'">
                    <INPUT TYPE="button" NAME="times" VALUE="  x  " OnClick="Calc.Input.value += ' * '">
                    <br>
                    <INPUT TYPE="button" NAME="point" VALUE="  .   " OnClick="Calc.Input.value += '.'">
                    <INPUT TYPE="button" NAME="zero"  VALUE="  0  " OnClick="Calc.Input.value += '0'">
                    <INPUT TYPE="button" NAME="DoIt"  VALUE="  =  " OnClick="Calc.Input.value = eval(Calc.Input.value)">
                    <INPUT TYPE="button" NAME="div"   VALUE="   /  " OnClick="Calc.Input.value += ' / '">
                    <br>
                </TD>
            </TR>
        </TABLE>
    </FORM>

</div>

<h2>Hello</h2>


<?php
    include_once './templates/footer-customized.php';
?>
