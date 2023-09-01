	jQuery(function ($) {
		"use strict";

        // Date picker range
        var pickrange = $("#dates");
		pickrange.daterangepicker({
            locale: {
                separator:' > ',
                direction: 'ltr',
                format: 'MM-DD-YY'
            },
            parentEl: "#inline-calendar",
            minDate:new Date(),
            autoUpdateInput: false,
            linkedCalendars:true,
            alwaysShowCalendars: true,
            singleDatePicker: false,
            autoApply :true,
            inline: true
        });
		 	pickrange.on('apply.daterangepicker', function(ev, picker) {
		  	$(this).val(picker.startDate.format('MM-DD-YY') + ' > ' + picker.endDate.format('MM-DD-YY'));
	  	});
	  		pickrange.on('cancel.daterangepicker', function(ev, picker) {
		  	$(this).val('');
	  	});

        // Date picker range disabled days of the week
        var pickrange_disabled_day = $("#dates.days-disabled");
        pickrange_disabled_day.daterangepicker({
            locale: {
                separator:' > ',
                direction: 'ltr',
                format: 'MM-DD-YY'
            },
            isInvalidDate: function (date) {
                return (date.day() == 0 || date.day() == 6); /*  Sundays(0) and Saturdays(6) disabled */
            },
            parentEl: "#inline-calendar",
            minDate:new Date(),
            autoUpdateInput: false,
            linkedCalendars:true,
            alwaysShowCalendars: true,
            singleDatePicker: false,
            autoApply :true,
            inline: true
        });
            pickrange_disabled_day.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM-DD-YY') + ' > ' + picker.endDate.format('MM-DD-YY'));
        });
            pickrange_disabled_day.on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        // Date picker range + translation French + european date format
        var pickrange_lang = $("#dates.lang");
        pickrange_lang.daterangepicker({
             locale: {
                separator:' > ',
                direction: 'ltr',
                format: 'DD-MM-YY',
                applyLabel: 'Valider',
                cancelLabel: 'Annuler',
                fromLabel: 'De',
                toLabel: 'à',
                daysOfWeek: [
                    'Dim',
                    'Lun',
                    'Mar',
                    'Mer',
                    'Jeu',
                    'Ven',
                    'Sam'
                ],
                monthNames: [
                    'Janvier',
                    'Février',
                    'Mars',
                    'Avril',
                    'Mai',
                    'Juin',
                    'Juillet',
                    'Août',
                    'Septembre',
                    'Octobre',
                    'Novembre',
                    'Décembre'
                ]
            },
            parentEl: "#inline-calendar",
            minDate:new Date(),
            autoUpdateInput: false,
            linkedCalendars:true,
            alwaysShowCalendars: true,
            singleDatePicker: false,
            autoApply :true,
            inline: true
        });
            pickrange_lang.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YY') + ' > ' + picker.endDate.format('DD-MM-YY'));
        });
            pickrange_lang.on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        // Date picker single
        var picksingle = $("#dates.single");
        $('#dates.single').daterangepicker({
            locale: {
                direction: 'ltr',
                format: 'MM-DD-YY'
            },
            parentEl: "#inline-calendar",
            minDate:new Date(),
            autoUpdateInput: false,
            linkedCalendars:false,
            alwaysShowCalendars: true,
            singleDatePicker: true,
            autoApply :true,
            inline: true
        });
            picksingle.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM-DD-YY'));
        });
            picksingle.on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        // Date picker single disabled specific dates
        var picksingle_dates_disabled = $("#dates.single-dates-disabled");
        picksingle_dates_disabled.daterangepicker({
            locale: {
                direction: 'ltr',
                format: 'MM-DD-YY'
            },
            isInvalidDate: function (date) {
                var formatted = date.format('MM-DD-YY');
                return ["10-28-21","10-29-21", "11-28-21","11-29-21", "12-28-21","12-29-21"].indexOf(formatted) > -1;
            },
            parentEl: "#inline-calendar",
            minDate:new Date(),
            autoUpdateInput: false,
            linkedCalendars:false,
            alwaysShowCalendars: true,
            singleDatePicker: true,
            autoApply :true,
            inline: true
        });
            picksingle_dates_disabled.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM-DD-YY'));
        });
            picksingle_dates_disabled.on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

});


