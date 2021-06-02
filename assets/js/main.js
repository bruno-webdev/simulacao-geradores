$(document).ready(function () {
    if($("#phone").length) {
        maskPhone();
        $('#phone').blur(function(event) {
            maskPhone();
        });
    }

    if($("#price").length) {
        $("#price").mask("#.##0,00", {reverse: true});
        $('#phone').blur(function(event) {
            if($(this).val().length === 15){
                $('#phone').mask('(00) 00000-0009');
            } else {
                $('#phone').mask('(00) 0000-00009');
            }
        });
    }
});

function maskPhone() {
    if($('#phone').val().length === 15){
        $('#phone').mask('(00) 00000-0009');
    } else {
        $('#phone').mask('(00) 0000-00009');
    }
}