$(document).ready(function() {
    // Handle form submission
    $('#log_expense_process').on('click', function(e) {
        e.preventDefault(); // Prevent the form from submitting the traditional way

        // Get form data
        var amount = $('#amount').val();
        var category = $('#category').val();
        var customCategory = $('#custom-category').val();
        var date = $('#date').val();
        var description = $('#description').val();

        // Check if custom category is provided, if not, use the selected category
        if (customCategory) {
            category = customCategory;
        }

        // Validate form fields
        if (amount === '' || date === '') {
            alert('Please fill in all required fields.');
            return;
        }

        // Prepare data to be sent in the AJAX request
        var formData = {
            amount: amount,
            category: category,
            date: date,
            description: description
        };

        // Send data to the server using AJAX
        $.ajax({
            url: 'php/log_expense.php', // The PHP script to handle the expense logging
            method: 'POST',
            data: formData,
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                // Check if the response contains 'success'
                if (data.status === 'success') {
                    alert('Expense logged successfully!');
                    // Optionally, clear the form fields after successful submission
                    $('form')[0].reset();
                } else {
                    alert('There was an error logging the expense: ' + (data.message || 'Unknown error.'));
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("There was an error with the AJAX request.");
            }
        });
    });
});
