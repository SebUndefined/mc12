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
    $('.stepper').activateStepper();
    $('.modal').modal();
    $(".button-collapse").sideNav();
    $('.tooltipped').tooltip({delay: 4000});
    $('.select-dropdown').change(function() {
        alert('prout');
    });
    $('#mc12_subscriptionbundle_subscription_competitor_licence_type').change(
        function(){
            if (this.value == "OneDay") {
                $('#mc12_subscriptionbundle_subscription_competitor_licence_number').val('').hide().next().hide();
            }
            else {
                $('#mc12_subscriptionbundle_subscription_competitor_licence_number').show().next().show();
            }

        });

    //test step

/*    $(function(){
        $('.stepper').activateStepper();
        $('.select-dropdown').change(function() {
            alert('prout');
        });
        $('select.licenceType').change(function(){ console.log("got you"); });
    });*/

    //Step
});