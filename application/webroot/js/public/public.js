(function (jQuery) {

    /*!
     * REPAYMENT CALCULATOR VERSION 1.0 (AUGUST 2017)
     */
    (function ($) {
        var formatNumber = function (value) {
            var numberString = Math.ceil(value * 100).toString();
            var match = numberString.match(/^(.*)(\d{2})$/);

            if (match) {
                match[1] = match[1].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                return match[1] + '.' + match[2];
            }

            return '0';
        };

        $('#financed-amount').on('change', function () {
            var value = parseFloat(this.value.replace(/[\$,]/g, ''));

            if (isNaN(value)) {
                value = 0;
            }

            this.value = '$' + formatNumber(value);
        });
        $('#calculator-form').on('submit', function () {
            var value = this.financed_amount.value;
            value = parseFloat(value.replace(/[\$,]/g, ''));

            if (isNaN(value)) {
                value = 0;
            }

            var establishmentFee = 0, weeklyFee = 1.00;
            var repaymentTotal = value + establishmentFee;

            $('.repayment').each(function (idx, elem) {
                var months = $(elem).data('term');
                var fortnightCount = Math.floor(months / 12 * 26);
                var total = repaymentTotal + fortnightCount * weeklyFee * 2;
                var repayment = formatNumber(total / fortnightCount);
                $('.repayment-dollars', elem).text(repayment.substr(0, repayment.length - 3));
                $('.repayment-cents', elem).text(repayment.substr(-2));
                $('.repayment-total', elem).text(formatNumber(total));
                $(elem).removeClass('mask');
            });

            return false;
        });
    }(jQuery));

    /*!
     * PUBLIC WEBSITE
     */
    (function ($) {
        var handler = function () {
            $('.section-splash.hero.full-height .section-splash-inner')
                .css('height', window.innerHeight - 120);
        };
        handler();
        $(window).on('resize', handler);

        $('.navbar-nav > li > a').each(function (idx, elem) {
            if ($(elem).prop('href') === window.location.origin + window.location.pathname) {
                $(elem).parent().addClass('active');

                return false;
            }
        });

        $.validator.addMethod('postcode', function (value, element) {
            return this.optional(element) || /^(08\d\d|[2-7]\d\d\d)$/.test(value);
        }, 'Please enter a valid postcode.');
        $.validator.addMethod('phone', function (value, element) {
            return this.optional(element) || /^0[234578]\d{8}$/.test(value);
        }, 'Please enter a 10-digit phone number with area code.');

        $('.ajax-form').on('change', function () {
            $('.ajax-form-success-message', this).hide();
        });
        $('#retailers-form').validate({
            errorPlacement: function (error, element) {
                if (element.parent().is('label')) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                var button = $('button[type="submit"]', form);
                button.button('loading');

                var $form = $(form);
                var postData = {};
                $.each($form.serializeArray(), function (i, field) {
                    postData[field.name] = field.value || ''; });
                $
                    .ajax({
                        method: 'post',
                        url: $form.attr('action'),
                        data: JSON.stringify(postData),
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8'
                    })
                    .done(
                        function () {
                            $('#retailers-form').hide();
                            $('#retailers-form-success').show();
                            $('#retailers-form-success #pre-approvals-btn').attr('href', function () {
                                return $(this).attr('href') + '?' + $.param([
                                    {name: 'name', value: $form.context.name.value},
                                    {name: 'mobile', value: $form.context.phone.value},
                                    {name: 'email', value: $form.context.email.value}
                                ]);
                            });
                            form.reset();
                        }
                    )
                    .success(
                        function (response) {
                            var lead_id = 0;
                            if (response && response.lead_id) {
                                lead_id = response.lead_id;
                            }
                            //if the form gets submitted successfully, we send this event to GA
                            gtag(
                                'event',
                                'Success Customer Lead Submit',
                                {
                                    'event_category' : 'Form Submit',
                                    'event_action' : 'Submit',
                                    'event_label' : 'Customer Lead Form Submit (Success)',
                                    'portalCustomerLeadId' : lead_id
                                }
                            );
                        }
                    )
                    .fail(
                        function (jqXHR, textStatus, errorThrown) {
                            var message = errorThrown;

                            if (jqXHR && jqXHR.responseJSON) {
                                message = jqXHR.responseJSON.message;
                            }

                            $('#retailers-form .ajax-form-success-message').text(message).show();
                        }
                    )
                    .always(function () {
                        form.reset();
                        button.button('reset');
                    });

                return false;
            }
        });

        $('#carousel-testimonial').on('touchstart', function (eStart) {
            var startX = eStart.originalEvent.touches[0].clientX;
            var startY = eStart.originalEvent.touches[0].clientY;
            var endX, endY;

            var handler = function (eMove) {
                endX = eMove.originalEvent.touches[0].clientX;
                endY = eMove.originalEvent.touches[0].clientY;
            };

            $(this).on('touchmove', handler);
            $('.carousel').one('touchend', function (eEnd) {
                $(this).off('touchmove', handler);
                $(this).carousel('pause');

                var moveX = endX - startX,
                    moveY = endY - startY;

                if (Math.abs(moveX) > Math.abs(moveY) * 2 && Math.abs(moveX) > 20) {
                    $(this).carousel(moveX < 0 ? 'next' : 'prev');
                }
            });
        });

        $('#careers-form #cv').on('change', function () {
            $('#careers-form #cv-filename').val(this.files[0] ? this.files[0].name : '');
        });
        $('#careers-form').validate({
            ignore: null,
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            submitHandler: function (form) {
                var button = $('button[type="submit"]', form);
                button.button('loading');

                $
                    .ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: new FormData(form),
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                    .done(function () {
                        $('#careers-form .ajax-form-success-message').show();
                        form.reset();
                    })
                    .always(function () {
                        button.button('reset');
                    });

                return false;
            }
        });
        $('#contact-form').validate({
            submitHandler: function (form) {
                var button = $('button[type="submit"]', form);
                button.button('loading');

                $
                    .post($(form).attr('action'), $(form).serialize())
                    .done(function () {
                        $('#contact-form .ajax-form-success-message').show();
                        form.reset();
                    })
                    .always(function () {
                        button.button('reset');
                    });

                return false;
            }
        });
        $('#callback-form').validate({
            submitHandler: function (form) {
                var button = $('button[type="submit"]', form);
                button.button('loading');

                $
                    .post($(form).attr('action'), $(form).serialize())
                    .done(function () {
                        $('#callback-form .ajax-form-success-message').show();
                        form.reset();
                    })
                    .always(function () {
                        button.button('reset');
                    });

                return false;
            }
        });
    }(jQuery));

}(window.jQuery));
