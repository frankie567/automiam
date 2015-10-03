function initializePlugins()
{
    $('select').select2();
    
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
});