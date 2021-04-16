$(document).ready(function() {
            
    alert("נא להגדיר פרטי המנהל של הארגון על פי הטופס הנתון להלן ");
            
/*  ------------------ JS To Set Manager Informations Into Organization ---------------- */    

    $(document).on('click','#updatemanager',function(){
        $.post('representCheck.php',{'updatemanager':'1','managermail':$('#managermail').val(),'pass1':$('#pass1').val(),'pass2':$('#pass2').val()},function(data){
            if(!data=="")
                alert(data);
            else
                window.location.href = "manager.php";
        });
    });
});