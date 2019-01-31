$(document).ready(function() {
    $("#submitForm").unbind('submit').bind('submit', function() {
        var form = $(this);
 
        var url = form.attr('action');
        var type = form.attr('method');
 
        // sending the request to server
        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'text',
            success:function(response) {
                $("#submitForm")[0].reset();
                alert(response);
            }
        });
 
        return false;
    });
});