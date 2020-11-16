// Custom JS file for FURI Symposium

jQuery(document).ready(function ($) {
    function resetAllControls() {
        $('.filter-group .filter').val('').trigger('chosen:updated');
    }

    if ($('body').hasClass('page-template-symposium')) {
        // Sort the participants names prior to initializing Chosen. Can't be done via WP Query.
        var participant_options = $('#filter-participant option');
        participant_options.sort(function (a, b) {
            if (a.text > b.text) return 1;
            else if (a.text < b.text) return -1;
            else return 0;
        });

        $('#filter-participant').empty().append(participant_options);

        var $singleOptions = {
            maxOptions: 10,
            style: '',
            styleBase: 'form-control',
            windowPadding: 180,
            selectedTextFormat: 'count > 1',
            width: '100%',
        };

        $('#filter-participant').selectpicker($singleOptions);
        $('#filter-titles').selectpicker($singleOptions);
        $('#filter-degree_program').selectpicker($singleOptions);
        $('#filter-faculty_mentor').selectpicker($singleOptions);
        $('#filter-symposium_group').selectpicker($singleOptions);

        $('#symposium-grid').isotope({
            // options
            itemSelector: '.grid-item',
            layoutMode: 'fitRows',
        });

        // Recalculate filter string on select box change.
        $('.filter-container select').on('change', function () {
            $filter = '';

            // grab value from the control that just changed.
            var $activeSelect = this.id;
            $value = $('#' + $activeSelect).val() || [];
            $filter = $value.join();

            // Did the control change result in a "clear selection?"
            if (!$filter) {
                // Enable all of the select boxes.
                $('.filter-container select')
                    .prop('disabled', false)
                    .selectpicker('refresh');
                // Enable the radio buttons, set to first option on each.
                $('input[name="researchThemeRadio"]')
                    .prop('disabled', false)
                    .filter('[value=""]')
                    .prop('checked', true);
                $('input[name="presentationTypeRadio"]')
                    .prop('disabled', false)
                    .filter('[value=""]')
                    .prop('checked', true);
            } else {
                // reset and disable all the selects except for the one that just changed.
                $('.filter-container select')
                    .not('#' + $activeSelect)
                    .val('')
                    .prop('disabled', true)
                    .selectpicker('refresh');
                // reset and disable the radio controls
                $('input[name="researchThemeRadio"]')
                    .prop('disabled', true)
                    .filter('[value=""]')
                    .prop('checked', true);
                $('input[name="presentationTypeRadio"]')
                    .prop('disabled', true)
                    .filter('[value=""]')
                    .prop('checked', true);
            }

            $('#symposium-grid').isotope({ filter: $filter });
        });

        // Bind filter on select change. Combine results of all select boxes within .filter-container.
        $('.filter-container input').on('change', function () {
            $research = $('input[name="researchThemeRadio"]:checked').val();
            $presentation = $(
                'input[name="presentationTypeRadio"]:checked'
            ).val();
            $filter = $research + $presentation;

            // Did the most recent change result in an empty filter?
            if (!$filter) {
                // Enable all of the select boxes.
                $('.filter-container select')
                    .prop('disabled', false)
                    .selectpicker('refresh');
            } else {
                // Disable and reset all of the select boxes.
                $('.filter-container select')
                    .val('')
                    .prop('disabled', true)
                    .selectpicker('refresh');
            }

            $('#symposium-grid').isotope({ filter: $filter });
        });

        // Shuffle. Resorts actively displayed collection of cards.
        $('#filter-shuffle').on('click', function () {
            $('#symposium-grid').isotope('shuffle');
        });

        // Reset all filters.
        $('#filter-reset').on('click', function () {
            // Enable and reset all of the select boxes.
            $('.filter-container select')
                .val('')
                .prop('disabled', false)
                .selectpicker('refresh');

            // Enable the radio buttons, set to first option on each.
            $('input[name="researchThemeRadio"]')
                .prop('disabled', false)
                .filter('[value=""]')
                .prop('checked', true);
            $('input[name="presentationTypeRadio"]')
                .prop('disabled', false)
                .filter('[value=""]')
                .prop('checked', true);

            $('#symposium-grid').isotope({ filter: '' });
        });
    }
});
