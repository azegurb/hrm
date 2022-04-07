$(document).on('change','#ListPositionClassification', function(){
    var url = '/personal-cards/qualifications/list-qualification-types/'+$(this).val();

    $(document).find('#ListQualificationType').data('url',url);

    $(document).find('#ListQualificationType').selectObj('ListQualificationType');
    $(document).find('#ListQualificationType').val('').trigger('change');
});

$(document).on('change','#ListSpecialRankType', function(){
    var url = '/personal-cardsranks/list-special-ranks/'+$(this).val();

    $(document).find('#ListSpecialRank').data('url',url);

    $(document).find('#ListSpecialRank').selectObj('ListSpecialRank');
    $(document).find('#ListSpecialRank').val('').trigger('change');

});