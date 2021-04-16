 $(document).ready(function(){

    var selectedService; //Variable To Get The Selected Service from Branch Form

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
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    var username = getCookie("username"); //Variable To Save The Username We Got From Cookies
     
/*  ------------------ Manager Sign in check ---------------- */
     
    $(document).on('click','#managerSign',function(){
        $.post('representCheck.php',{'managerSign':'1','rep_name':$('#rep_name').val(),'rep_password':$('#rep_password').val()},function(data){
            if(!data=="")
                alert(data);
            else
                window.location.href = "manager.php";
            });
    });
     
/*  ------------------ JS To Delete All The Expired Date's Appointments ---------------- */
     
    $.post('representCheck.php',{'delExpApp':'1','username':username},function(data){
        if(!data=="")
            alert(data);
        });

/*  ------------------ Enter Queue System Page And Move The Branch Name That Choosed ---------------- */
     
    $(document).on('click','.queSys',function(){

        var yourSelect = document.getElementById(this.value); // Pointer To A Selection Box
        var selectedService = yourSelect.options[ yourSelect.selectedIndex ].value;// To Get Selected Option

        $.post('appointmentCheck.php',{'brID':this.value,'brServiceID':selectedService},function(data){
            if(!data=="")
                alert(data);
            else
                window.location.href = "queSystem.php";
            });
    });
     
/*  ------------------ JS To Show Branches in the Page ---------------- */
     
    $.post('organizationCheck.php',{'show_branches':username},function(data){

        $('.branch_list').html(data); 
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