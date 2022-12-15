function showMassage(text) {
    color = 0;
    switch (color) {
        case 0:
            document.getElementById('alertDown').style.backgroundColor = 'rgba(220, 53, 69, 0.75)';
            break;
        case 1:
            document.getElementById('alertDown').style.backgroundColor = 'rgba(39, 151, 61, 0.75)';
            break;
        default:
    }

    document.getElementById("alertDown").innerHTML = text;

    parameters = {
        duration: 300,
        complete: function() {
            $('#progress')
                .css('width', '0%')
                .text('0%');
        }
    }
    $('#alertDown').slideDown(parameters);
    setTimeout(function() {
        parameters = {
            duration: 300,
            complete: function() {
                $('#progress')
                    .css('width', '0%')
                    .text('0%');
            }
        }
        $('#alertDown').slideUp(parameters);
    }, 4000);
}

function dropdown(){
    document.querySelector('.dropdown').classList.toggle('show');
    document.querySelector('.dropdown-menu').classList.toggle('show');
    
}