/**
 * Created by sebby on 08/09/17.
 */
$(document).ready(function() {
    $('select').material_select();
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 150, // Creates a dropdown of 150 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false,
        format: 'dd/mm/yyyy'
    });



    //test step

    $(function(){
        $('.stepper').activateStepper();
        $('.select-dropdown').change(function() {
            alert('prout');
        });
        $('select.licenceType').change(function(){ console.log("got you"); });
    });

    //Step
});