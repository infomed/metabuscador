function selectBrowser(a)
{
      if(a)
      {        $.get('admin/fi/Ajax_BrowserParams.php',{'searchers': formDb.searchers.value}, function(data) {
      	$('#parameters').html(data);
      	});      }
      else
      {
        $.get('../../admin/fi/Ajax_BrowserParams.php',{'searchers': formDb.searchers.value}, function(data) {
      	$('#parameters').html(data);
      	});
      }
}
function compute(f)
{
  if (confirm("Esta seguro que desea registrar esos parámetros"))
    f.submit();

  else
  	return false;
}

$(document).ready(function() {
    var submitButton = $('#submit_button');
    if (submitButton) {
        submitButton.bind('click', function() {
            var engine = $('input[type=radio][@checked]');
            var button = this;
            button.disabled = true;
            if (!engine.length) {
                alert('You must select an Information Source Engine');
                this.disabled = false;
            }
            else {
                $.post('index_finfo.php', {'id': engine[0].value, 'fmt': 'js', 'opr': 'del'}, function(data) {
                    $('ul.li.input[@type=radio][@value=engine[0].value]').remove();
                    $('div.msg').html(data).fadeIn('slow');
                    button.disabled = false;
                });
            }
            return false;
        });
    }
});



