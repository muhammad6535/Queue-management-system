
$(document).ready(function () {

    var orgUser; //Variable To Save The Username Of The Organization That Choosed
    var orgName; //Variable To Save The Name Of The Organization That Choosed
    var selectedBranch; //Variable To Get The Selected Branch from Order Form
    var selectedService; //Variable To Get The Selected Service from Order Form
    var selectedDate; //Variable To Get The Selected Date from Order Form

/*  ------------------ JS To Show The List Of The Organization In The Page Organization.php ---------------- */
    
    $.post('organizationCheck.php', {
        'show_organization': ''
    }, function (data) {
        $('.org_list').html(data);
    });

/*  ------------------ JS To Know Which (Organization)'s Button Clicked ---------------- */
    
    $(document).on('click', '.orgUsername', function () {
        orgUser = this.name;
        orgName = this.value;
        document.getElementById("myModalLabel").innerHTML = orgName;

/*  ------------------ JS To Show Branches Name ---------------- */
        
        $.post('organizationCheck.php', {
            'show_bra': orgUser
        }, function (data) {

            $('.bra_list').html(data);
        });
    });

/*  ------------------ JS To Get The Selected Branch Value And Fill The Service List By His Branch ---------------- */

    $("#braSelect").change(function () {
        selectedBranch=$(this).val();
        var selectedBranchName =  this.options[this.selectedIndex].text;// To Get Selected Option
        document.getElementById("braName").innerHTML = selectedBranchName;
        //JS To Fill Branch Working Hours List
        if (selectedBranchName != "---") {
            $.post('organizationCheck.php', {
                'sbra': selectedBranch,
                'orgUser': orgUser
            }, function (data) {
                $('#workhours').html(data);
            });
        } else {
            document.getElementById("braName").innerHTML = "בחר סניף";
            $('#workhours').html("");
        }

/*  ------------------ JS To Fill Branches Service List ---------------- */
        
        $.post('organizationCheck.php', {
            'show_serv': selectedBranch,
            'orgUser': orgUser
        }, function (data) {
            $('.serv_list').html(data);
            selectedService = "---"; // After We Choose Another Branch We Reset The Service To Default Value
            $("#date").val("");
        });

    });

/*  ------------------ JS To Get The Selected Service Value ---------------- */

    $("#servSelect").change(function () {
        selectedService = $(this).val();
        $("#date").val("");
    });

/*  ------------------ JS To Insert Appointment ---------------- */
    
    $(document).on('click', '#sub', function () {
        $.post('appointmentCheck.php', {
            'ord': '1',
            'orgUser': orgUser,
            'client_name': $('#client_name').val(),
            'client_id': $('#client_id').val(),
            'client_email': $('#client_email').val(),
            'selectedBranch': selectedBranch,
            'selectedService': selectedService,
            'date': $("#date").val(),
            'time': $("#timeSelect").val()
        }, function (data) {

            if (data == "התור הוגדר בהצלחה , נשלחה הודעה למייל") {
                alert(data);
                window.location.href = "organizations.php";
            } else
                alert(data);
        });
    });

/*  ------------------ JS To Fill The Time List By Available Time From The DB ---------------- */
    
    $("#date").change(function () {
        selectedDate = $(this).val();
        $.post('organizationCheck.php', {
            'fillTime': '1',
            'selectDate': selectedDate,
            'brID': selectedBranch,
            'sServ': selectedService,
            'orgUser': orgUser
        }, function (data) {
            if (data == "נא לבחור סניף ושירות מתאים") {
                alert(data);
            } else {
                $('#timeSelect').html(data);
            }
        });
    });

/*  ------------------ To Refresh The Page After exit the modal ---------------- */
    
    $('#registerModal').on('hidden.bs.modal', function (e) {
        location.reload();
    });
    
/*  ------------------ JS To Search For A Specific Organization ---------------- */
    
    $('#searchVal').keyup(function(e){
        
        var input, filter , ul, a, i;
        input = document.getElementById("searchVal");
        filter = input.value.toUpperCase();
        ul = document.getElementsByClassName("organizations");
        for (i = 0; i < ul.length; i++) {
            a = ul[i].getElementsByClassName("card-title")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                ul[i].style.display = "";
            } else {
                ul[i].style.display = "none";
            }
        }
    });
    


});
