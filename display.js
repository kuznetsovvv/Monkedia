//default action is to define a global variable containing our result
var clientList;
var editing = -1; 
function fetchList(){
    $.ajax({
        url: "./interface.php", 
        data: {fn:"list"},
        type: 'GET',
        success: function(result){                                                                      //I will assume that this works, no error handling has been implemented
            window.clientList = JSON.parse(result);
            showList();
        }
    });
}
function showList(){
    var table = ("<table id='clientTable' class='table table-hover table-bordered'><thead><tr>");      // I will assume result is not empty
    for(var colName in window.clientList[1]){
        table += ("<th>"+colName+"</th>");
    }
    table += ("</tr></thead>");
    for(var row in window.clientList){
        table += makeRow(row);
        
    }
    table += ("</table>");
    jQuery("#outputArea").html(table);
}
function makeRow(row){
    var tablerow = ""
    var rowdata = window.clientList[row];
        tablerow += ("<tr class='clientRow' id='"+row+"' onclick='javascript:selectRow(this);'>");
            for(var data in rowdata){
                tablerow += ("<td>"+rowdata[data]+"</td>");            
            }
    tablerow += ("</tr>");
    return tablerow;
}
function selectRow(rowTag){
    row = jQuery(rowTag).attr('id');
    if(window.editing == -1 ){
    jQuery(rowTag).removeAttr('onclick');
        window.editing = row;
        var rowdata = window.clientList[row];
        var table = "";
            for(var data in rowdata){
                if(data == "ID"){
                    table += ('<td><span id="savecancel"><span onclick="javascript:save();" class="green">&#10004;</span>&nbsp;<span onclick="javascript:cancel('+"'"+row+"'"+');" class="red">&#10006;</span></span>&nbsp;'+rowdata[data]+"</td>");   
                }else{
                    table += ("<td><input type='text' id='"+data+"' id='"+data+"' value='"+rowdata[data].replace("'","&#39;").replace('"','&quot;').replace('`','&quot;').replace('"','&#39;')+"'/></td>");
                }
            }
        jQuery(rowTag).html(table);
    }else{
        alert("Please save or cancel edits to the other client first.");
    }
}
function cancel(row){
    window.editing = -1; 
    jQuery("#"+row).replaceWith(makeRow(row));
    
}
function cancelNew(){
    window.editing = -1; 
    jQuery("#new").remove(); 
}
function save(){
    var toSend = {fn:"update", ID:window.editing};
    var err = 0;
    $('#'+window.editing+' *').filter(':input').each(function(){
        toSend[jQuery(this).attr('id')] = jQuery(this).val();
        if(jQuery(this).val() == "" || jQuery(this).val() == null){
            if(err == 0){
                alert("Please enter "+jQuery(this).attr('id'));
            }
            err++;
        }
    });
    if(err == 0){
        $.ajax({
            url: "./interface.php", 
            data: toSend,
            type: 'GET',
            success: function(result){ 
                window.editing = -1;
                fetchList();
            }
        });
    }
}
function saveNew(){
    var toSend = {fn:"new"};
    var err = 0;
    $('#new *').filter(':input').each(function(){
        toSend[jQuery(this).attr('id')] = jQuery(this).val();
        if(jQuery(this).val() == "" || jQuery(this).val() == null){
            if(err == 0){
                alert("Please enter "+jQuery(this).attr('id'));
            }
            err++;
        }
    });
    if(err == 0){
        $.ajax({
            url: "./interface.php", 
            data: toSend,
            type: 'GET',
            success: function(result){ 
                window.editing = -1;
                fetchList();
            }
        });
    }
}
function newRow(){
    if(window.editing == -1){
        window.editing = -2;
        var tablerow = "";
        tablerow += ("<tr class='clientRow' id='new'>");
            $('thead th').each(function(){
                headText = jQuery(this).html();
                if(headText != "ID"){
                    tablerow += ("<td><input id='"+headText+"' name='"+headText+"' placeholder='"+headText+"'/></td>");  
                }else{
                    tablerow += ('<td><span id="savecancel"><span onclick="javascript:saveNew();" class="green">&#10004;</span>&nbsp;<span onclick="javascript:cancelNew();" class="red">&#10006;</span></span></td>');
                }
            });
        tablerow += ("</tr>");
        jQuery("#clientTable").append(tablerow);
    }else{
        alert("Please save or cancel edits to the other client first.");
    }
}