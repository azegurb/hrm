/**
 * Created by Asan on 5/6/2017.
 */
$('#country').selectObj('country');
$('#country').on('change' , function(){
    $('#city-container').remove();
    $('#village-container').remove();
    $('#placeselection').append(''+
        '<div id="city-container" class="col-md-4 float-left mt-20">'+
            '<h4 class="example-title">Şəhər</h4>'+
            '<select name="city" id="city" data-url="/orders/list-cities/'+$(this).val()+'"></select>'+
        '</div>');
    $('#city').selectObj('city');
    $('#city').on('change' , function(){
        $('#village-container').remove();
        $('#placeselection').append(''+
            '<div id="village-container" class="col-md-4 float-left mt-20">'+
            '<h4 class="example-title">Kənd</h4>'+
            '<select name="village" id="village" data-url="/orders/list-villages/'+$(this).val()+'"></select>'+
            '</div>');
        $('#village').selectObj('village');
    });
});