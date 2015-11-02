function initializePlugins()
{
    $('select').select2({
        tags: true
    }).on('change', function(e)
    {
        var lastValue = $(this).find(':selected').last();
        if (lastValue.attr('data-select2-tag') == 'true')
        {
            $.post('/automiam/web/app_dev.php/tags/new', {tagLabel: lastValue.val()})
            .done(function(data)
            {
                if (data['valid'])
                {
                    lastValue.val(data['tagId']);
                }
            });
        }
    });
    
    $("[datepicker='true']").datepicker({
        format: "dd/mm/yyyy",
        language: "fr",
        autoclose: true,
        todayHighlight: true
    });
}

$(document).ready(function()
{
    initializePlugins();
    $('[data-toggle="popover"]').popover();
});