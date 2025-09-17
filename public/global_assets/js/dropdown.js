
// Function to get dynamic dropdown data
function getDynamicDropdownData(url, target, callback) {
    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        success: function(response) {
            if (!response.success) {
                console.error('Failed to fetch data:', response.message);
                return;
            }
            $(target).empty();
            $(target).append($('<option></option>').attr('value', '').text('Select...').prop('disabled', true).prop('selected', true));
            $.each(response.data, function(index, item) {
                $(target).append($('<option></option>').attr('value', item.id).text(item.name));
            });

            // Initialize Select2 after populating options
            if ($(target).hasClass('select2-hidden-accessible')) {
                $(target).select2('destroy');
            }
            $(target).select2({
                placeholder: 'Select...',
                allowClear: true,
                width: '100%',
                dropdownParent: $(target).parent()  // Append to the select's immediate parent for correct positioning
            });

            // Execute callback if provided
            if (typeof callback === 'function') {
                callback();
            }
        },
        error: function(xhr) {
            console.error('Error fetching dynamic dropdown data:', xhr);
        }
    });
}