$(document).ready(function () {

/*  ------------------ Appointment Cancel Check ---------------- */

        $(document).on('click', '#checkbtn', function () {
            $.post('appointmentCheck.php', {
                'cancel': '1',
                'customer_id': $('#customer_id').val(),
                'appointment_id': $('#appointment_id').val(),
                'email': $('#email').val()
            }, function (data) {
                if (data == "התור בוטל בהצלחה ,נשלחה הודעה למייל") {
                    alert(data);
                    location.reload();
                } else
                    alert(data);
            });
        });
    
/*  ------------------ Represent join check ---------------- */

        $(document).on('click', '#signbtn', function () {
            $.post('representCheck.php', {
                'sign': '1',
                'rep_name': $('#rep_name').val(),
                'rep_password': $('#rep_password').val()
            }, function (data) {
                if (data == "rep")
                    window.location.href = "branches.php";
                else {
                    if (data == "manager")
                        window.location.href = "manager.php";
                    else
                        alert(data);
                }
            });
        });

/*  ------------------ Organization Register Check ---------------- */

        $(document).on('click', '#org_btn', function () {
            $.post('organizationCheck.php', {
                'org': '1',
                'org_name': $('#org_name').val(),
                'org_username': $('#org_username').val(),
                'org_email': $('#org_email').val(),
                'org_password1': $('#org_password1').val(),
                'org_password2': $('#org_password2').val()
            }, function (data) {
                if (!data == "")
                    alert(data);
                else
                    window.location.href = "managersignup.php";
            });
        });

/*  ------------------ Move To Organizations Page ---------------- */
    
        $('.order').on('click', function () {
            $.post('organizations.php', {}, function (data) {
                window.location.href = "organizations.php";
            });
        });
});
