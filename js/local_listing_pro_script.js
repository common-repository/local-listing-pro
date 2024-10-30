var ls_a = jQuery(document);
var ls_ajax_url = llsp_ajax_custom.ajax_call;


(function($) {

		var start_year = new Date().getFullYear(),
		max_year = start_year + 9,
		select = document.getElementById('upgr_years');
		if(select!=null)
		{
		for (var i = start_year; i<=max_year; i++){
		var opt = document.createElement('option');
		opt.value = i;
		opt.innerHTML = i;
		select.appendChild(opt);
		}
		}
    $('[data-toggle="tooltip"]').tooltip();
    var $messages = $('#email-error-dialog');
    var upgrade_btn = '';


    ls_a.on('click', '.llsp_upgrade_btn', function() {

        var request_url = $('input[name="_llsp_request_url"]').val() + '?llsp9870_api';
        var email = $('input[name="_llsp_card_input_email"]').val();
        var number = $('input[name="_llsp_card_input_number"]').val();
        var cvc = $('input[name="_llsp_card_input_cvc"]').val();
        var exp_month = $('select[name="_llsp_card_input_month"]').val();
        var exp_year = $('select[name="_llsp_card_input_year"]').val();
        var name = $('input[name="_llsp_card_input_name"]').val();
        var address_line1 = $('input[name="_llsp_card_input_street"]').val();
        var address_city = $('input[name="_llsp_card_input_city"]').val();
        var address_zip = $('input[name="_llsp_card_input_zipcode"]').val();
        var address_state = $('select[name="_llsp_card_input_state"]').val();
        var address_country = $('select[name="_llsp_card_input_country"]').val();
        var response = [{
            'email': email,
            'number': number,
            'cvc': cvc,
            'exp_month': exp_month,
            'exp_year': exp_year,
            'name': name,
            'address_line1': address_line1,
            'address_city': address_city,
            'address_zip': address_zip,
            'address_state': address_state,
            'address_country': address_country,
            'request_url': request_url
        }];
        $valid_form = validate_form('form[name="llsp_submit_form"]');
        if (!$valid_form) {
            return true;

        }

        $('.pre_loader').show();

        jQuery.ajax({
            type: "post",
            url: ls_ajax_url,
            data: {
                action: "process_upgrade_business",
                'stripe_params': response,
                'email': email
            },
            success: function(response) {

                if (response == 'valid') {


                    window.location.href = "?page=business_visibility_report";


                } else {
                    $('.pre_loader').hide();
                    $('.result_message').html(response);;
                    $('.result_message').show(0).delay(5000).hide(0);
                }

            }
        })
    })

    ls_a.on('keyup', '.text_desc', function() {
        if (this.value != '') {
            var words = this.value.match(/\S+/g).length;
            if (words > 250) {
                var trimmed = $(this).val().split(/\s+/, 200).join(" ");
                $(this).val(trimmed + " ");
            } else {
                $('#word_left').show();
                $('#word_left').text(250 - words + " words left");
            }
        } else {

            $('#word_left').hide();

        }
    })

    ls_a.on('click', '#ls_search_btn', function() {

        var tempScrollTop = $(window).scrollTop();
        var search_name = $('input[name="llsp_search_name"]').val();
        var search_zipcode = $('input[name="llsp_search_zipcode"]').val();
        if (!validate_form('form[name="search_box_form"]')) {
            $(window).scrollTop(tempScrollTop);
            return true;
        }
        $('.pre_loader').css('display', 'block');
        $.ajax({
            type: "post",
            url: ls_ajax_url,
            datatype: 'json',
            data: {
                action: "search_business",
                search_name: search_name,
                search_zipcode: search_zipcode
            },
            success: function(response) {
                $('.pre_loader').css('display', 'none');
                $('.main_container').html(response);
                form_validate();
                phone_validation();
            }
        })

    })

    $('#tab a').click(function() {

        return false;

    });

    ls_a.on('click', '.ls_reset_btn', function() {


        form_reset($(this).closest('form'));

    })



    ls_a.on('click', '.business_li', function() {




        if ($(this).find('.checkbox7').prop('checked')) {

            $(this).find('.checkbox7').prop('checked', false);
            $(this).find('label').removeClass('checked');

            form_reset($('.main_container').find('form[name="llsp_submit_form"]'));
            return true;

        } else {
            $('.checkbox7').prop('checked', false);
            $('.checkbox7').next().removeClass('checked');
            $(this).find('.checkbox7').prop('checked', true);
            $(this).find('label').addClass('checked');

        }

        selected_business = $(this).find('.checkbox7').val();


        $.ajax({
            type: "post",
            url: ls_ajax_url,

            data: {
                action: "add_existing_business",
                selected_business: selected_business
            },
            success: function(response) {



                $('.main_container').find('form[name="llsp_submit_form"]').html(response);
                form_validate();
                phone_validation();

            }
        })
    })

    function form_reset(ele) {


        ele.find("input[type=text], textarea").val("");

        $('select').each(function() {
            var temp_select = $(this);
            $(this).find('option').each(function() {
                if (this.defaultSelected) {


                    this.selected = false;
                    return false;

                }
            });

            $(this).val($(this).find('option:first').val());
            $(this).find('option:first').selected = true;

        })
    }
    $(document).keyup(function(e) {
        var code = e.keyCode;
        if (code == 13) {
            if ($('#ls_search_box').val() != '') {
                $('#ls_search_btn').trigger("click");
            } else {
                $('#ls_search_box').focus();
            }
        }

    })
    ls_a.on('change', 'input[name="llsp_searched_item"]', function() {

    })

    ls_a.on('click', '.ls_submit_changes_btn', function() {
        var business_updated_data = $('form[name="business_form_update"]').serializeArray();;
        var business_id = $('input[name="_llsp_business_id"]').val();
        var business_client_id = $('input[name="_llsp_business_client_id"]').val();
        $valid_hour = validate_hours(true);
        if (!$valid_hour) {

            return true;
        }


        $('.pre_loader').css('display', 'block');

        $.ajax({
            type: "post",
            url: ls_ajax_url,

            data: {
                action: "update_business",
                business_client_id: business_client_id,
                business_updated_data: business_updated_data,
                type: 'hours',
                business_id: business_id
            },
            success: function(response) {


                $('.pre_loader').css('display', 'none');

                $('.result_message').html("Business Hours is Updated Successfully")
                $('.result_message').show(0).delay(5000).hide(0);

            }
        })
    })

    ls_a.on('click', '.create_ticket', function() {

        var formData = new FormData($('#create_ticket_form')[0]);
        var business_client_id = $('input[name="_llsp_business_client_id_footer"]').val();
        formData.append('action', 'create_ticket');
        formData.append('business_client_id', business_client_id);
        if (!validate_form('form[name="create_ticket_form"]')) {
            return true;
        }

      $('.pre_loader').show();;
        $.ajax({
            type: "POST",
            url: ls_ajax_url,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
			
				
				if(response == 1)
				{ 
				$('.pre_loader').hide();;
                $('.result_message1').html("Ticket is Created Successfully")
				$('.result_message1').show(0);
				}
				else
				{
				$('.pre_loader').hide();;
                $('.result_message1').html("Sorry! Ticket is not created. Please check email or duplicate ticket")
				$('.result_message1').show(0);
				}
	



            }
        })



    })

    ls_a.on('click', '.ls_submit_photo', function() {

        var business_updated_data = $('form[name="business_form_photo"]').serializeArray();;
        var business_id = $('input[name="_llsp_business_id"]').val();
        var business_client_id = $('input[name="_llsp_business_client_id"]').val();
        var business_logo_id = $('input[name="_thumbnail_id"]').val();
        var formData = new FormData($('#business_photo_form')[0]);
        formData.append('action', 'update_business');
        formData.append('type', 'photos');
        formData.append('business_id', business_id);
        formData.append('business_client_id', business_client_id);
        formData.append('business_logo_id', business_logo_id);
        formData.append('business_form_data', $('form[name="business_form_photo"]')[0]);
        $.ajax({
            type: "POST",
            url: ls_ajax_url,

            processData: false,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {




            }
        })



    })

    ls_a.on('change', '.hour_box select', function() {

        if ($(this).val() != 'select') {
            $(this).removeClass('error');
            $(this).next().remove();
        }
        if (($(this).is(':first-child'))) {
            if ($(this).val() == 'closed') {

                $(this).parent('div').next().children('select').find('option[value != "closed"]').attr('disabled', 'true');
                $(this).parent('div').next().children('select').find('option[value = "closed"]').attr('selected', 'true');
            } else {
                $(this).parent('div').next().children('select').find('option').removeAttr('disabled');
                if ($(this).parent('div').next().children('select').find('option:selected').val() == 'closed') {
                    $(this).parent('div').next().children('select').find('option:first').attr('selected', 'true');
                }
            }
        }
        if (($(this).is(':last-child'))) {
            if ($(this).val() == 'closed') {

                $(this).parent('div').prev().children('select').find('option[value != "closed"]').attr('disabled', 'true');
                $(this).parent('div').prev().children('select').find('option[value = "closed"]').attr('selected', 'true');
            } else {
                $(this).parent('div').prev().children('select').find('option').removeAttr('disabled');
                if ($(this).parent('div').prev().children('select').find('option:selected').val() == 'closed') {
                    $(this).parent('div').prev().children('select').find('option:first').attr('selected', 'true');
                }

            }
        }




    })




    ls_a.on('change', '.logo-file-selector', function() {
        $('.upload_box').next('.form-error').remove();



    })

    $('input[name="_llsp_business_phone"]').mask("(999) 999-9999");
    $('input[name="llsp_submit_field_phone"]').mask("(999) 999-9999");

    function phone_validation() {
        $('input[name="llsp_submit_field_phone"]').mask("(999) 999-9999");
    }

    ls_a.on('click', '.ls_submit_site_btn', function() {
        var business_form_data = $('form[name="llsp_submit_form"]').serializeArray();
        var business_id = $('input[name="_llsp_business_id"]').val();
        var $valid_form = true;
        var $valid_image = true;
        if (typeof business_id == "undefined") {
            var formData = new FormData();

            var files = $('.logo-file-selector')[0].files;
            for (k = 0; k < files.length; k++) {
                formData.append('logo', files[k]);
            }
            formData.append('action', 'upload_business_logo');
            if (files.length == 0) {
                $('.upload_box').next('.form-error').remove();
                $('.upload_box').after('<span class="help-block form-error">Please upload image</span>');
                $valid_image = false;
            }

        }
        $valid_form = validate_form('form[name="llsp_submit_form"]');
        $valid_hour = validate_hours(false);

        if (!$valid_form || !$valid_hour || !$valid_image) {

            return true;

        }

        $('.pre_loader').show();;

        $.ajax({
            type: "post",

            url: ls_ajax_url,

            data: {
                action: "submit_business",
                business_form_data: business_form_data,
                business_id: business_id
            },

            success: function(response) {
                
                console.log(response);


                 
                if (typeof business_id == "undefined") {



                    formData.append('action', 'upload_business_image');

                    $.ajax({
                        type: "post",
                        url: ls_ajax_url,
                        processData: false,
                        data: formData,
                        contentType: false,
                        cache: false,
                        success: function(response) {
                            

                            window.location.href = "?page=business_visibility_report";
                            $('.pre_loader').css('display', 'none');
                            ls_a.scrollTop(0);

                        }

                    })

                } else {

                    $('.pre_loader').css('display', 'none');
                    var result = $('<div />').append(response).find('.addres_user').html();
                    $('.addres_user').html(result);
                    $('.result_message').html("Business is Updated Successfully")
                    $('.result_message').show(0).delay(5000).hide(0);


                }
            }

        })

    })

    function validate_hours(validate_field) {
        var $valid_flag = true;
        var required_field = false;
        $('.submit_business_hours .hour_box').each(function() {
            open_time = $(this).find('select:first');
            close_time = $(this).find('select:last');
            open_time_selected = open_time.val();
            close_time_selected = close_time.val();
            open_time.removeClass('error');
            open_time.next().remove();
            close_time.removeClass('error');
            close_time.next().remove();
            var time_str_open = open_time_selected.split(' ');
            var time_str_close = close_time_selected.split(' ');
            var time_elapsed = toSeconds(time_str_open[0]) - toSeconds(time_str_close[0]);
            if (open_time_selected != 'select' && close_time_selected == 'select' && open_time_selected != 'closed') {
                close_time.addClass('error');
                close_time.after('<span class="help-block form-error">Please select closing time</span>');
                $valid_flag = false;
            } else
            if (open_time_selected == 'select' && close_time_selected != 'select' && close_time_selected != 'closed') {
                open_time.addClass('error');
                open_time.after('<span class="help-block form-error">Please select Open time</span>');
                $valid_flag = false;
            } else
            if (open_time_selected == 'closed' && close_time_selected != 'closed') {
                close_time.addClass('error');
                close_time.after('<span class="help-block form-error">Please select closed</span>');
                $valid_flag = false;
            } else
            if (open_time_selected != 'closed' && close_time_selected == 'closed') {
                open_time.addClass('error');
                open_time.after('<span class="help-block form-error">Please select closed</span>');
                $valid_flag = false;
            } else
            if ((time_elapsed > 0) && time_str_open[1].toString() === 'AM' && time_str_close[1].toString() === 'AM') {

                close_time.addClass('error');
                close_time.after('<span class="help-block form-error">Invalid Closed Time</span>');
                $valid_flag = false;

            } else
            if ((time_elapsed > 0) && time_str_open[1].toString() == 'PM' && time_str_close[1].toString() == 'PM') {

                close_time.addClass('error');
                close_time.after('<span class="help-block form-error">Invalid Closed Time</span>');
                $valid_flag = false;

            } else
            if ((time_elapsed < 0) && time_str_open[1].toString() == 'PM' && time_str_close[1].toString() == 'PM' && time_str_close[0].toString() == '12:00') {

                close_time.addClass('error');
                close_time.after('<span class="help-block form-error">Invalid Closed Time</span>');
                $valid_flag = false;

            } else
            if ((time_elapsed == 0) && ((time_str_open[1].toString() == 'PM' && time_str_close[1].toString() == 'PM') || (time_str_open[1].toString() == 'AM' && time_str_close[1].toString() == 'AM'))) {

                close_time.addClass('error');
                close_time.after('<span class="help-block form-error">Invalid Closed Time</span>');
                $valid_flag = false;

            } else
            if (open_time_selected != 'select' && close_time_selected != 'select') {

                required_field = true;
            }

        })
        if ($valid_flag) {
            if (!required_field && validate_field) {
                return required_field;
            }
        }

        return $valid_flag;
    }

    function validate_form(form) {
        var invalid = true;
        var errors = [],
            conf = {
                onElementValidate: function(valid, $el, $form, errorMess) {
                    if (!valid) {

                        errors.push({
                            el: $el,
                            error: errorMess
                        });

                    }
                }
            },
            lang = {};
        if (!$(form).isValid(lang, conf, true)) {
            invalid = false;
        }
        return invalid;
    }

    ls_a.on('change', 'select[name="llsp_submit_field_country"],select[name="_llsp_business_country"]', function() {
        country_id = $(this).val();
        get_state_list(country_id);
    })

    function get_state_list(country_id) {

        if (country_id == 'US') {
            $.ajax({
                type: "post",
                url: ls_ajax_url,
                data: {
                    action: "get_state",
                    country_id: country_id,
                    load_view: true
                },
                success: function(response) {
                    $('select[name="llsp_submit_field_state"]').html(response);

                }
            })
        }
    }

    $(document).on('click', '.delete-file-selector', function() {
        var business_id = $('input[name="_llsp_business_id"]').val();
        var business_client_id = $('input[name="_llsp_business_client_id"]').val();
        var attach_id = $(this).attr('attach_id');
        var image_type = $(this).attr('image_type');
        $('.pre_loader').show();
        $.ajax({
            type: "POST",
            url: ls_ajax_url,
            data: {
                'action': 'update_business',
                'business_id': business_id,
                'business_client_id': business_client_id,
                'type': 'delete_photo',
                'attach_id': attach_id,
                'image_type': image_type
            },
            success: function(response) {

                $(document).find('.uploaded_image_box').html(response);
                $('.pre_loader').hide();

            }
        })
    })

    $(document).on('change', '.logo-file-selector', function() {
        $('.upload_box').next('.form-error').remove();
        var files = $(this)[0].files;
        var image_type = $(this).attr('image_type');
        var ext = $(this).val().split('.').pop().toLowerCase();

        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg']) == -1) {
            $('.upload_box').after('<span class="help-block form-error">Invalid image</span>');
           $('#' + image_type).attr('src', llsp_ajax_custom.image_url+'images/no-image-icon.png');
            $(this).val('');
            return true;
        }



        if (files) {

            var reader = new FileReader();

            reader.onload = function(e) {
                $('#' + image_type).attr('src', e.target.result);
            };

            reader.readAsDataURL(files[0]);
        }


    })

    $(document).on('click', '.cancel_btn', function() {
        var btn = $(this);
        btn.hide();
        $('.pre_loader').show();
        $('#myModal').delay(1000).removeClass('in');
        $.ajax({
            type: "POST",
            url: ls_ajax_url,
            data: {
                'action': 'cancel_billing'
            },
            success: function(response) {


              window.location.href = "?page=upgrade_business";


            }
        })

    })

    $(document).on('change', '.upload-file-selector', function() {

        var formData = new FormData();
        var files = $(this)[0].files;
        var image_type = $(this).attr('image_type');
        var business_id = $('input[name="_llsp_business_id"]').val();
        var business_client_id = $('input[name="_llsp_business_client_id"]').val();
        var business_logo_id = $('input[name="_thumbnail_id"]').val();
        var img_no = $('input[name="img#"]').val();
        var ext = $(this).val().split('.').pop().toLowerCase();
        $('.form-error').remove();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg']) == -1) {

            $(this).parents('.upload_box').after('<span class="help-block form-error">Invalid image</span>');
            $(this).val('');
            return true;

        }
        $('.pre_loader').show();

        for (k = 0; k < files.length; k++) {
            formData.append(image_type, files[k]);
        }
        formData.append('action', 'update_business');
        formData.append('type', 'photos');
        formData.append('business_id', business_id);
        formData.append('business_client_id', business_client_id);
        formData.append('business_logo_id', business_logo_id);
        formData.append('img_#', img_no);
        $.ajax({
            type: "POST",
            url: ls_ajax_url,
            processData: false,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {

                $('.pre_loader').hide();


                if (image_type == 'logo') {

                    if (files) {

                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#' + image_type)
                                .attr('src', e.target.result);
                        };

                        reader.readAsDataURL(files[0]);
                    }


                } else {
                    $(document).find('.uploaded_image_box').html(response);
                }
            }
        })




    })



    $.formUtils.addValidator({
        name: 'phone_number',
        validatorFunction: function(value, $el, config, language, $form) {

            return value.match(/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/) != null;
        },
        errorMessage: 'Please Enter valid phone number',
        errorMessageKey: 'badEvenNumber'
    });

    var invalid, errormsg, inputname;

    form_validate()

    function form_validate() {
        $.validate({




            inputParentClassOnError: '',
            inputParentClassOnSuccess: '',


            onElementValidate: function(valid, $el, $form, errorMess) {

                invalid = valid;
                errormsg = errorMess;
                inputname = $el.attr('name');

            }




        });




    }

    function toSeconds(time_str) {

        var time_parts = time_str.split(':');
        return time_parts[0] * 3600 + time_parts[1] * 60;
    }




})(jQuery);

