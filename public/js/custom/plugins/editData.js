function editData(url, modalId , custom) {
    // Check if has url
    if (url != '' && url != 'undefined' && modalId != '' && modalId != 'undefined') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            // Get Remote data
            url: url,
            type: 'GET',
            success: function (data) {

                var response = data;
                // Check if HTTP Status code is 200
                if (response.code == 200) {
                    $('#' + modalId).modal('show');
                    var formelement = document.getElementById(modalId + '_form');
                    formelement.removeAttribute('action');
                    formelement.removeAttribute('data-id');
                    formelement.setAttribute('data-id', response.id);
                    formelement.setAttribute('action', response.url);

                    $("#"+modalId + '_form').append('<input name="_method" id="_put" type="hidden" value="PUT">');
                    var keys = Object.keys(response.fields);
                    if(typeof custom != 'undefined'){
                        eval(custom)(data , modalId);
                    }

                    for (var index in keys) {

                        if (response.fields[keys[index]] instanceof Array) {

                            var select = $('#'+modalId).find('select[name="' + keys[index] + '[]"]');
                            var form   = $('#'+modalId).find('form');

                            response.fields[keys[index]].forEach(function (item) {

                                var option = '<option value="' + item.id + '" selected>' + item.text + '</option>';
                                var hidden = '<input type="hidden" name="relId[' + item.id + ']" value="' + item.relId +'">';
                                form.append(hidden);

                                select.append(option);

                                select.trigger('change');

                            });

                        }

                        if (response.fields[keys[index]] != null) {
                            if(typeof response.fields[keys[index]].id == 'undefined' && response.fields[keys[index]].id == null) {

                                $('#' + modalId).find('[name="'+keys[index]+'"]').val(response.fields[keys[index]]);
                                $('#' + modalId).find('input[type="radio"]').each(function() {
                                    if($(this).val() == response.fields[keys[index]]) {
                                        $(this).prop('checked' , true);
                                    }
                                });
                                $('#' + modalId).find('input[type="checkbox"]').each(function(){
                                    if($(this).prop('name') == keys[index] && response.fields[keys[index]]==true) {
                                        $(this).prop('checked' , true);
                                    }
                                });

                            }
                            else {


                                if(keys[index]=='listPositionNameId'){


                                    POSNAMEID='listPositionNameId';
                                    $('#hiddenposname').val(response.fields[keys[index]].id)

                                }
                                var selectParent = $('#' + modalId).find('select[name="' + keys[index] + '"]');
                                var optionselectParentID = $('<option></option>').attr('selected', true).text(response.fields[keys[index]].text).val(response.fields[keys[index]].id);
                                /* insert the option (which is already 'selected'!) into the select */

                                optionselectParentID.appendTo(selectParent);

                                /* Let select2 do whatever it likes with this */
                                selectParent.trigger('change');
                            }
                        }
                    }
                }
            },
            error: function () {
                swal("", "Məlumat əldə etmək mümkün olmadı xahiş olunur bir daha cəhd edin", "error");
            }
        });
    } else {
        throw new Error('URL is required , Modal Id is required')
        swal("", "Məlumat əldə etmək mümkün olmadı xahiş olunur bir daha cəhd edin", "error");
    }




}