 $(document).ready(function() {

/*  ------------------ Function To Get The Value From Session PHP To Javascript ---------------- */
     
    function getCookie(cname) {
        var name = cname + "=";
        var a;
        var x;
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            
            var c = ca[i];
            
            
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            
   
            if (c.indexOf(name) == 0) {
                a = c.substring(name.length, c.length);
                return a;
            }
        }
        return "";
    }

    var curDate = getCookie("curDate"); //Variable To Get The Current Date Value From Cookies

/*  ------------------ JS To Set The Latest Choosed Date In The Input Date  ---------------- */
       
    $("#date").attr("value", curDate);

    /* ---- JS To Search Specific Queue From The List ---- */
    $('.filterable .btn-filter').click(function() {
        var $panel = $(this).parents('.filterable'),
            $filters = $panel.find('.filters input'),
            $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e) {
        // Ignore tab key
        var code = e.keyCode || e.which;
        if (code == '9') return;
        // Useful DOM data and selectors
        var $input = $(this),
            inputContent = $input.val().toLowerCase(),
            $panel = $input.parents('.filterable'),
            column = $panel.find('.filters th').index($input.parents('th')),
            $table = $panel.find('.table'),
            $rows = $table.find('tbody tr');
        // filter function
        var $filteredRows = $rows.filter(function() {
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        // Clean previous no-result if exist 
        $table.find('tbody .no-result').remove();
        // Show all rows, hide filtered ones
        $rows.show();
        $filteredRows.hide();
        // Prepend no-result row if all rows are filtered
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="' + $table.find('.filters th').length + '">לא נמצאו תוצאות</td></tr>'));
        }
    });
     
     
     
     var username = getCookie("username"); //Variable To Save The Username We Got From Cookies
     var nameID = getCookie("brID"); //Variable To Save The Branch ID We Got From Cookies
     var serv = getCookie("brServID"); //Variable To Save The Service ID We Got From Cookies
     var curDate = getCookie("curDate"); //Variable To Save The Date We Got From Cookies

/*  ------------------ JS To Fill Queues List Into Table  ---------------- */
    
    $.post('appointmentCheck.php',{'fill_Que':username,'braID':nameID,'brService':serv,'chDate':curDate},function(data){
        $('.que').html(data);

/*  ------------------ To Get Information About the Owner Of The Currently Queue  ---------------- */
    
    var fQueInfo = document.getElementsByTagName("td");
        if(fQueInfo[0])
            {
                var str='<h1>בטיפול</h1>\
                            <h5>\
                                <strong class="ltr">שם הלקוח: </strong>'+fQueInfo[1].innerHTML+'\
                            </h5>\
                            <h5>\
                                <strong class="ltr">מספר התור: </strong>'+fQueInfo[0].innerHTML+'\
                            </h5>\
                            <h5>\
                                <strong class="ltr">זמן סיום: </strong>'+fQueInfo[4].innerHTML+'\
                            </h5>\
                            <h5>\
                                <strong>סוג השירות: </strong>'+'<span class="ltr">'+fQueInfo[5].innerHTML+'</span>\
                            </h5>\
                            <h5>\
                                <button class="btn btn-success " id="nextque">הבא בתור</button>\
                            </h5>';
            }
        else
            {
               str="<h2>! לא קיים עוד תורים היום</h2>"; 
            }
        $('.well').html(str);
    });

/*  ------------------ JS To Update The Queue List By Finishing the Current Queue  ---------------- */
    
    $(document).on('click','#nextque',function(){
        var fQueInfo = document.getElementsByTagName("td");
        $.post('appointmentCheck.php',{'nextqueue':'1','queID':fQueInfo[0].innerHTML},function(data){
            if(!data=="")
                alert(data);
            else
                window.location.href = "queSystem.php";
        });
    });

/*  ------------------ JS To Show All The Queues of Specific Date That Choosed  ---------------- */
    
    $(document).on('click','#searchDate',function(){
            var curDate = $("#date").val();
            $.post('appointmentCheck.php',{'fill_Que':username,'braID':nameID,'brService':serv,'chDate':curDate},function(data){
            $('.que').html(data);

/*  ------------------ To Get Information About the Owner Of The Currently Queue  ---------------- */
    
    var fQueInfo = document.getElementsByTagName("td");
        if(fQueInfo[0])
            {
                var str='<h1>בטיפול</h1>\
                            <h5>\
                                <strong class="ltr">שם הלקוח: </strong>'+fQueInfo[1].innerHTML+'\
                            </h5>\
                            <h5>\
                                <strong class="ltr">מספר התור: </strong>'+fQueInfo[0].innerHTML+'\
                            </h5>\
                            <h5>\
                                <strong class="ltr">זמן סיום: </strong>'+fQueInfo[4].innerHTML+'\
                            </h5>\
                            <h5>\
                                <strong>סוג השירות: </strong>'+'<span class="ltr">'+fQueInfo[5].innerHTML+'</span>\
                            </h5>\
                            <h5>\
                                <button class="btn btn-success " id="nextque">הבא בתור</button>\
                            </h5>';
            }
        else
            {
               str="<h2>! לא קיים עוד תורים היום</h2>"; 
            }
        $('.well').html(str);
        });
    });


    var ApID; // Variable To Save The Appointment ID
     
/*  ------------------ JS To Know Which (Appointment ID)'s Button Clicked  ---------------- */
    
    $(document).on('click','.btn-edit',function(){ 
        ApID = this.name;
    });

/*  ------------------ JS To Edit Appointment  ---------------- */
    
    $(document).on('click','#ApEdit',function(){
        $.post('appointmentCheck.php',{'editAp':'1','ApID':ApID,'client_name':$('#client_name').val(),'client_id':$('#client_id').val(),'client_email':$('#client_email').val(),'date':$("#dateCh").val(),'time':$("#timeCh").val()},function(data){
            if(!data=="")
                alert(data);
            else
                window.location.href = "queSystem.php";
        });
    });

/*  ------------------ JS To Know Which (Appointment ID)'s Button Clicked  ---------------- */
    
    $(document).on('click','.btn-del',function(){ 
        ApID = this.name;
    });

/*  ------------------ JS To Delete Appointment  ---------------- */
    
     $(document).on('click','.btn-del',function(){ 
        var answer = confirm("האם אתה בטוח שברצונך למחוק התור מספר "+ApID);
        if(answer) {
            $.post('appointmentCheck.php',{'delAp':'1','ApID':ApID},function(data){
                alert("בוצע בהצלחה");
                window.location.href = "queSystem.php";
            });
        }
    });
     
/*  ------------------ JS To Update Appointment  ---------------- */
     
     $(document).on('click','.btn-edit',function(){
            $.post('appointmentCheck.php',{'EditAp':'1','ApID':ApID},function(data){
                $('#editApp').html(data);
            });
    });

/*  ------------------ JS To Fill The Time List By Available Time From The DB  ---------------- */
    
    $("#dateCh").change(function () {
        var selectedDate = $(this).val();
        $.post('appointmentCheck.php', {
            'fillTimeQue': '1',
            'selectDate': selectedDate,
            'nameID': nameID,
            'sServ': serv,
            'orgUser': username
        }, function (data) {
                $('#timeCh').html(data);
        });
    });
     
/*  ------------------ To Refresh The Page After exit the modal  ---------------- */

    $('#editModal').on('hidden.bs.modal', function (e) {
        location.reload();
    });


});