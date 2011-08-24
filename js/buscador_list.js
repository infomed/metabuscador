$(document).ready(function() {
    var submitButton = $('#submit_button');
    if (submitButton) {
        submitButton.bind('click', function() {
            var engine = $('input[type=radio][@checked]');
            var button = this;
            button.disabled = true;
            if (!engine.length) {
                alert('You must select an engine');
                this.disabled = false;
            }
            else {
                $.post('index.php', {'id': engine[0].value, 'fmt': 'js', 'opr': 'del'}, function(data) {
                    $('ul.li.input[@type=radio][@value=engine[0].value]).remove();
                    $('div.msg').html(data).fadeIn('slow');
                    button.disabled = false;
                });
            }
            return false;
        });
    }
});
