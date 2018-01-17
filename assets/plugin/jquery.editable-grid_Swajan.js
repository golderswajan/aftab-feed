(function ($) {

    $.fn.editableGrid = function (options) {
        this.on('click','td a span',doDeleteFunction);
        this.on('dblclick','td',editCell);

        var settings =  $.extend({
            primaryTable:'',
            identity:'',
            selectQuery:'select * from ',
            columns:'',
            editMethods:'',
            format:'',
            editAble:''

        },options);
        if(settings.selectQuery=="select * from ")settings.selectQuery += settings.primaryTable;

        var columns,ddlColumns=[],myTable=this;
        var clickControl=false;
        var primaryKey='';
        var primaryColumn;
        var primaryValue;
        var updateColumn;
        var updateValue;
        var identity = settings.identity;
        var ddlData = '';
        var info='';

        showData();

        function showData(){
            columns = [];
            $.post('/assets/plugin/j-process.php',{generalSelect:settings.selectQuery},function(data){
                info = JSON.parse(data);
                for(var key in info[0]) {
                    columns.push(key);
                }


                var ddlCheck = false;
                if(settings.format!=''){
                    for(var i=0;i<columns.length;i++){
                        if(settings.format[columns[i]]!=null){
                            if(settings.format[columns[i]].type=="ddl"){
                                ddlCheck = true;
                                var query = settings.format[columns[i]].selectQuery;
                                $.post('/assets/plugin/j-process.php',{generalSelect:query},function (data) {
                                    ddlData = JSON.parse(data);
                                    for(var key in ddlData[0]) {
                                        ddlColumns.push(key);
                                    }
                                    formTable();
                                });
                            }
                        }
                    }
                    if(!ddlCheck) formTable();
                }else{
                    formTable();
                }



            })


        }


        function formTable(){
            var rowHtml = "<thead>";
            var tempColumns;
            if(settings.columns.length!=0){
                tempColumns = settings.columns;
            }else{
                tempColumns = columns.slice();
                tempColumns.splice(0,1);
                $.each(tempColumns,function (index,value) {
                    tempColumns[index] = jsUcFirst(value);
                });
                console.log(tempColumns);
            }


            var tempColumnsLength = tempColumns.length,columnsLength=columns.length,infoLength=info.length;
            var colWidth= Math.round(93/(tempColumnsLength));
            rowHtml +="<th> SL.</th>"
            for(var i=0;i<tempColumnsLength;i++){
                rowHtml += "<th width='"+colWidth+"%'>"+tempColumns[i]+"</th>";
            }
            rowHtml +="<th>"+"Delete"+"</th>";
            rowHtml +="</thead>";

            rowHtml +="<tbody>";
            for(var i=0;i<infoLength;i++){
                rowHtml += "<tr>";
                rowHtml += "<td>"+(i+1)+"</td>"
                for(var j=1;j<columnsLength;j++){
                    if(settings.format!=''){
                        if(settings.format[columns[j]]!=null){
                            if(settings.format[columns[j]].type=="ddl"){
                                rowHtml += "<td id='"+identity+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+identity+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span>" +
                                    "<select id=\""+identity+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"form-control\" style='display: none'>" ;
                                for(var k=0;k<ddlData.length;k++){
                                    if(info[i][columns[j]]==ddlData[k].name)rowHtml += "<option selected>"+ddlData[k].name+"</option>";
                                    else rowHtml += "<option value='"+ddlData[k][ddlColumns[0]]+"'>"+ddlData[k][ddlColumns[1]]+"</option>";
                                }

                                rowHtml += "</select></td>";
                            }else if(settings.format[columns[j]].type=="date"){
                                rowHtml += "<td id='"+identity+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+identity+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span><input type='date' id=\""+identity+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"form-control\" style='display: none' value='"+info[i][columns[j]]+"'></td>";
                            }else if(settings.format[columns[j]].type=="number"){
                                rowHtml += "<td id='"+identity+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+identity+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span><input type='number' id=\""+identity+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"form-control\" style='display: none' value='"+info[i][columns[j]]+"' min='0'></td>";
                            }

                        }else{
                            //before adding editAble//rowHtml += "<td id='"+identity+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+identity+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span><textarea id=\""+identity+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"form-control\" rows='1' style='display: none;overflow: hidden'>"+info[i][columns[j]]+"</textarea></td>";
                            if(settings.editAble!=''){
                                if(settings.editAble[columns[j]]==null){
                                    rowHtml += "<td id='"+identity+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+identity+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span><textarea id=\""+identity+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"form-control\" rows='1' style='display: none;overflow: hidden'>"+info[i][columns[j]]+"</textarea></td>";
                                }else{
                                    rowHtml += "<td><span>"+info[i][columns[j]]+"</span></td>";
                                }
                            }else{
                                rowHtml += "<td id='"+identity+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+identity+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span><textarea id=\""+identity+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"form-control\" rows='1' style='display: none;overflow: hidden'>"+info[i][columns[j]]+"</textarea></td>";
                            }
                        }

                    }else {
                        //before adding editable//rowHtml += "<td id='"+identity+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+identity+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span><textarea id=\""+identity+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"form-control\" rows='1' style='display: none;overflow: hidden'>"+info[i][columns[j]]+"</textarea></td>";
                        if(settings.editAble!=''){
                            if(settings.editAble[columns[j]]==null){
                                rowHtml += "<td id='"+identity+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+identity+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span><textarea id=\""+identity+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"form-control\" rows='1' style='display: none;overflow: hidden'>"+info[i][columns[j]]+"</textarea></td>";
                            }else{
                                rowHtml += "<td><span>"+info[i][columns[j]]+"</span></td>";
                            }
                        }else{
                            rowHtml += "<td id='"+identity+columns[j]+"Td"+info[i][columns[0]]+"'><span id=\""+identity+columns[j]+"Label"+info[i][columns[0]]+"\">"+info[i][columns[j]]+"</span><textarea id=\""+identity+columns[j]+"Input"+info[i][columns[0]]+"\"  class=\"form-control\" rows='1' style='display: none;overflow: hidden'>"+info[i][columns[j]]+"</textarea></td>";
                        }
                    }


                }
                rowHtml += "<td><a href=\"#\"><span id='"+identity+info[i][columns[0]]+"' class=\"glyphicon glyphicon-remove\"></span></a></td>";
                rowHtml += "</tr>";
            }
            rowHtml +="</tbody>";


            myTable.html(rowHtml);

        }


        function jsUcFirst(string)
        {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }


        function editCell(e){
            var temp = e.target.id.split(/Label|Td/);
            if(settings.identity!="")temp[0] = temp[0].split(settings.identity)[1];
           if(temp.length==2){
               primaryKey = {
                   row:temp[1],
                   col:temp[0]
               };

               var label = $('#'+identity+primaryKey.col+"Label"+primaryKey.row);
               var input = $('#'+identity+primaryKey.col+"Input"+primaryKey.row);
               label.css({"display":"none"});
               input.css({"display":"block"});
               input.focus();
               var tempValue = input.val();
               input.val('');
               input.val(tempValue);
               clickControl = true;
           }
        }


        function doDeleteFunction(primaryIdEvent){
            if(settings.identity!="")primaryValue = primaryIdEvent.target.id.split(settings.identity)[1];
            else primaryValue = primaryIdEvent.target.id;
            if(confirm('Are you sure to delete ?')){
                var query = "delete from "+settings.primaryTable+" where "+columns[0]+"="+primaryValue;
                $.post('/assets/plugin/j-process.php',{
                    generalDelete:query
                },function(data){
                    showData();
                })
            }

        }

        $(window).click(function (event) {

            if (clickControl) {
                if (event.target.id != (identity+primaryKey.col+"Input"+primaryKey.row)) {
                    console.log("you touched");
                    doEditFunction();
                }
            }
        });

        $(document).keypress(function (e) {
            if (clickControl) {
                if (e.which == 13) {
                    console.log("you pressed enter");
                    doEditFunction();
                }

            }
        });

        function doEditFunction(){
            var label = $('#'+identity+primaryKey.col+"Label"+primaryKey.row);
            var input = $('#'+identity+primaryKey.col+"Input"+primaryKey.row);

            label.css({"display": "block"});
            input.css({"display": "none"});

            primaryColumn = columns[0];
            primaryValue = primaryKey.row;
            updateColumn = primaryKey.col;
            updateValue = input.val();


            var query='';
            if(settings.editMethods[updateColumn]!=null){
                var splittedQuery = settings.editMethods[updateColumn].split('*');
                query = splittedQuery[0]+updateValue+splittedQuery[1]+primaryValue+splittedQuery[2];

            }else{
                query = "UPDATE "+settings.primaryTable+" SET "+ updateColumn +" = '"+ updateValue +"' WHERE "+ primaryColumn +" = '"+ primaryValue +"'";
            }



            $.post('/assets/plugin/j-process.php', {
                generalUpdate : query
            }, function (data) {
                //label.html(input.val());
                showData();
            });

            clickControl = false;

        }


    }

}(jQuery));