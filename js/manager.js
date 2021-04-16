$(document).ready(function () {
            
/*  ------------------ JS To Know Which (Branch ID)'s Button Clicked ---------------- */
    
    $(document).on('click','.br',function(){
        brID = this.name;
    });

/*  ------------------ Function To Get The Value From Session PHP To Javascript ---------------- */
    
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                var ans=c.substring(name.length, c.length);
                var str = decodeURIComponent(ans);
                str = str.replace('+',' ');
                return str;
            }
        }
        return "";
    }
    
    var username = getCookie("username"); //Variable To Save The Username We Got From Cookies
    var orgname= getCookie("orgName"); //Variable To Save The OrgName We Got From Cookies

/*  ------------------ JS To Show Branches ---------------- */
    
    $.post('organizationCheck.php',{'show_branchesManager':username},function(data){
        $('.branch_list').html(data); 
    });

/*  ------------------ JS To Add Branch Into Organization ---------------- */
    
    $(document).on('click','#addBranch',function(){

        //Convert Array From JavasCript To PHP
        var i=0,j,k=0,z;
        var hours = document.getElementsByClassName("days");
        var days= new Array();
        for (z = 0; z < hours.length; z+=4) {
            days[i]=new Array(4);
            for(j=0;j<4;j++,k++)
                days[i][j] = hours[k].value;
            i++;
        }

        $.post('branchCheck.php',{'addsnif':'1','branchID':$('#branchID').val(),'branchName':$('#branchName').val(),'branchMail':$('#branchMail').val(),'branchTel':$('#branchTel').val(),'branchAddress':$('#branchAddress').val(),'daysArr':days},function(data){
            if(!data=="")
                alert(data);
            else
                {
                    alert("בוצע בהצלחה");
                    window.location.href = "manager.php";
                }
        });
    });

/*  ------------------ JS To Set The Current Branch Working Hours info into Fields ---------------- */
    
    $(document).on('click','#edHours',function(){
        $.post('branchCheck.php',{'updateHours':"1",'brID':brID},function(data){
            $('#ediHours').html(data);
        });
    });
    
/*  ------------------ JS To Edit Branch Work Hours ---------------- */
    
    $(document).on('click','#edithour',function(){

        //Convert Array From JavasCript To PHP
        var i=0,j,k=0,z;
        var hours = document.getElementsByClassName("editday");
        var days= new Array();
        for (z = 0; z < hours.length; z+=4) {
            days[i]=new Array(4);
            for(j=0;j<4;j++,k++)
                days[i][j] = hours[k].value;
            i++;
        }

        $.post('branchCheck.php',{'editbranchour':'1','brID':brID,'daysArr':days},function(data){
            if(!data=="")
                alert(data);
            else
                {
                    alert("העדכון בוצע בהצלחה");
                    window.location.href = "manager.php";
                }
        });
    });


/*  ------------------ JS To Set The Current Branch info into Fields ---------------- */
    
    $(document).on('click','#edBranch',function(){
        $.post('branchCheck.php',{'braID':brID},function(data){
            $('#edit-branche').html(data);
        });
    });

/*  ------------------ JS To Edit Branch ---------------- */
    
    $(document).on('click','#editBranch',function(){ 
        $.post('branchCheck.php',{'editsnif':'1','brID':brID,'editbranchName':$('#editbranchName').val(),'editbranchMail':$('#editbranchMail').val(),'editbranchTel':$('#editbranchTel').val(),'editbranchAddress':$('#editbranchAddress').val()},function(data){
            if(!data=="")
                alert(data);
            else
                {
                    alert("העדכון בוצע בהצלחה");
                    window.location.href = "manager.php";
                }
        });
    });
    
/*  ------------------ JS To Edit Organization ---------------- */
    
    $(document).on('click','#editorga',function(){ 
        $.post('branchCheck.php',{'editorganization':'1','usernameOrga':username,'editorgaName':$('#editorgaName').val(),'editorgaMail':$('#editorgaMail').val(),'orgPass':$('#orgPass').val()},function(data){
            if(!data=="")
                alert(data);
            else
                {
                    alert("העדכון בוצע בהצלחה");
                    window.location.href = "manager.php";
                }
        });
    });

/*  ------------------ JS To Edit Manager Information ---------------- */
    
    $(document).on('click','#editManager',function(){
        $.post('branchCheck.php',{'managerEdit':'1','cur_password':$('#cur_password').val(),'password1':$('#password1').val(),'password2':$('#password2').val(),'managerMail':$('#managerMail').val()},function(data){
            if(!data=="")
                alert(data);
            else
                window.location.href = "manager.php";
        });
    });

/*  ------------------ JS off adding Service Into Branch ---------------- */

    var arr = [];//Array To Save A Services List 
    var brID; //Variable To Save The Id Of The Branch That Choosed

    //Hide clear btn on page load
    $('#clear').hide();

    //Add text input to list on button press
    $('#add').click(function(){


        //var toAdd gets the value of the input field
        var toAdd = new Array(); 

        var apName = $("input[name=checkListItem]").val();
        var tAvg = $("input[name=apAvg]").val();

        if(apName != "")
            toAdd.push(apName);

        if(tAvg != "")
            toAdd.push(tAvg);


        var flag = 0;//Flag To Check If The Service Exists In The List
        var i;
        for(i=0;i<arr.length;i++)
        {
            if(arr[i] && arr[i][0] == apName)
                flag = 1;
        }


       if(flag == 0 && toAdd.length == 2 && toAdd[1]>=1 && toAdd[1] <=59)
        {
            arr.push(toAdd);
            //Append list item in its own div with a class of item into the list div
            //It also changes the cursor on hover of the appended item 
            if(toAdd[1])
                $('.list').append('<div  value='+toAdd[0]+' val='+toAdd[1]+' class="item">' + toAdd[0] + ": "+toAdd[1] +" דקות" + '</div>'  );
            //fade in clear button when the add button is clicked
            $('#clear').fadeIn('fast');
            //Clear input field when add button is pressed
            $('input').val('');
        }
        else
        {
            if(flag == 1)
                alert("סוג השירות שהכנסת קיים כבר ברשימה");
            else
                alert("נא להגדיר את כל השדות בצורה תקינה");
        }
    });

/*  ------------------ Checks off items as they are pressed ---------------- */
    
    $(document).on('click', '.item', function() {
        //Change list item to red
        $(this).css("color", "#cc0000");
        //Change cursor for checked item
        $(this).css("cursor","default");
        //Strike through clicked item while giving it a class of done so it will be affected by the clear
        $(this).wrapInner('<strike class="done"></strike>');
        //Add the X glyphicon
        $(this).append(" " + '<span class="glyphicon glyphicon-remove done" aria-hidden="true"></span>');
        //Stops checked off items from being clicked again
        $(this).prop('disabled', true);

        var x =$(this).find('.done').html().split(':')[0];

        //משחררים את הסוג שבוטל מהמערך
         for(i=0;i<arr.length;i++)
        {
            if(arr[i] && arr[i][0] == x)
            {   
                arr[i] = null;  
            }    
        }
    });

/*  ------------------ Removes list items with the class done ---------------- */
    
    $('#clear').click(function(){
        $('.done').remove('.done');
    });

/*  ------------------ Insert Services ---------------- */
    
    $(document).on('click','#serv',function(){
        $.post('branchCheck.php',{'serv':'1','brID':brID,'arr':arr},function(data){
            if(!data=="")
                alert(data);
            else
            {
                alert("בוצע בהצלחה");
                window.location.href = "manager.php";
            }
        });
    });

/*  ------------------ JS To Set Suitable Size ---------------- */

    $(document).on('click','#back',function(){
        $("#workhours").hide();
        $('#addb').show();
        $(".modal-content").css("margin-left",'0%');
        $(".modal-content").css("width",'100%');
    });

    $(document).on('click','#con',function(){
        $("#addb").hide();
        $('#workhours').show();
        $(".modal-content").css("margin-left",'-40%');
        $(".modal-content").css("width",'200%');
    });
    
    var selectedServ; //Variable To Save The Selected Service
    
/*  ------------------ JS To Set The Current Service List Of This Specific Branch ---------------- */
    
    $(document).on('click','#edServ',function(){
        $.post('branchCheck.php',{'editServ':"1",'selectedBranchID':brID},function(data){
            $('#servSelect').html(data);
        });
    });
    
/*  ------------------ JS To Set The Current Manager Information ---------------- */
    
    $(document).on('click','#manageinfoedit',function(){
        $.post('branchCheck.php',{'editmanager':"1",'usernameOrg':username},function(data){
            $('#edit-manager').html(data);
        });
    });
    
/*  ------------------ JS To Set The Current Organization Information ---------------- */
    
    $(document).on('click','#orgainfoedit',function(){
        $.post('branchCheck.php',{'editorga':"1",'usernameOrga':username},function(data){
            $('#edit-orga').html(data);
        });
    });
    
/*  ------------------ JS To Set The Value Of The Selected Service In The Inputs ---------------- */
    
    $("#servSelect").change(function () {
        selectedServ = $(this).val();
        $.post('branchCheck.php', {
            'setValues': '1',
            'selectedServ': selectedServ,
        }, function (data) {
            if (data == "נא לבחור סוג שירות שברצונך לעדכן") {
                alert(data);
                $('#setServInfo').html("");
            } else {
                $('#setServInfo').html(data);
            }
        });
    });
    
/*  ------------------ Update Service Info ---------------- */

    $(document).on('click','#editSr',function(){
        $.post('branchCheck.php',{'updateServ':"1",'selectedServID':selectedServ,'selectedServName':$('#updatedServ').val(),'selectedAvg':$('#updatedAvg').val()},function(data){
            if(data == "נא לבחור סוג שירות שברצונך לעדכן")
                alert(data);
            else
                {
                    alert("העדכון בוצע בהצלחה");
                    window.location.href = "manager.php";
                }
        });
    });
    
/*  ------------------ Delete Service Info ---------------- */
    
    $(document).on('click','#delSr',function(){
        $.post('branchCheck.php',{'deleteServ':"1",'selectedServID':selectedServ},function(data){
            if(data == "נא לבחור סוג שירות שברצונך לעדכן")
                alert(data);
            else
                {
                    alert("בוצע בהצלחה");
                    window.location.href = "manager.php";
                }
        });
    });
    
/*  ------------------ Delete Branch From Organization ---------------- */
    
    $(document).on('click','#delBranch',function(){
        var answer = confirm("האם אתה בטוח שברצונך למחוק סניף מס' "+brID);
        if(answer){
            $.post('branchCheck.php',{'deleteBranch':"1",'selectedBranch':brID},function(data){
                alert(data);
                location.reload();
            });
        }
    });
    
/*  ------------------ Delete Organization ---------------- */
    
    $(document).on('click','#delorg',function(){
        var answer = confirm("האם אתה בטוח שברצונך למחוק ארגון - "+orgname);
        if(answer){
            $.post('branchCheck.php',{'deleteOrg':"1",'selectedOrg':username},function(data){
                alert(data);
                if(data!="לא ניתן למחוק ארגון שעבורו נקבע תור")
                    window.location.href = "index.php";
            });
        }
    });
    
/*  ------------------ JS To Search For A Specific Branch ---------------- */
    
    $('#searchVal').keyup(function(e){
        
        var input, filter , ul, a, i;
        input = document.getElementById("searchVal");
        filter = input.value.toUpperCase();
        ul = document.getElementsByClassName("branches");
        for (i = 0; i < ul.length; i++) {
            a = ul[i].getElementsByClassName("card-title")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                ul[i].style.display = "";
            } else {
                ul[i].style.display = "none";
            }
        }
    });
    
/*  ------------------ To Refresh The Page After exit the modal ---------------- */
    
    $('.modal').on('hidden.bs.modal', function (e) {
      location.reload();
    });
});
