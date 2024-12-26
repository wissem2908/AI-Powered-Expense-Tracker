$(document).ready(function() {

    // Function to format numbers with two decimals and commas
    function numberFormatWithCommas(number) {
        number = parseFloat(number); // Convert string to number
        return number.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Function to format numbers with two decimals
    function numberFormat(number) {
        number = parseFloat(number); // Convert string to number
        return number.toFixed(2);
    }

    $.ajax({
        url: 'php/dashboard.php',
        method: 'POST',
        success: function(response) {
            try {
                // Parse the JSON response
                var data = JSON.parse(response);
                console.log(data);

                // Update total expenses
                $('#total_expenses').html("$" + numberFormatWithCommas(data.total_expenses));

                // Get the list container
                var $list = $('#categorized-spending-list');

                // Loop through categorized spending data
                data.categorized_spending.forEach(function(category) {
                    var formattedAmount = numberFormat(category.category_total);
                    var listItem = '<li>' + category.category + ": $" + formattedAmount + '</li>';
                    $list.append(listItem);
                });

                // Monthly spending trends chart
                var ctx = document.getElementById('monthlyChart').getContext('2d');
                var monthlyChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.monthly_trends.map(function(item) {
                            return item.month; // Extract months from response data
                        }),
                        datasets: [{
                            label: 'Monthly Spending',
                            data: data.monthly_trends.map(function(item) {
                                return parseFloat(item.monthly_total); // Extract spending data
                            }),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

            } catch (error) {
                console.error("Error parsing response:", error);
                alert("There was an error processing the data.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("There was an error with the AJAX request.");
        }
    });







    /******************************************************************************************* */

    function getData() {
        $.ajax({
            url: 'php/expenses_list.php', // The PHP file that returns the expenses data
            method: "POST", // HTTP method (POST)
            success: function(response) {
                console.log(response); // Log the response for debugging
    
                // Parse the JSON response
                var data = JSON.parse(response);
    
                // Check if expenses list is available
                if (data.expenses_list && data.expenses_list.length > 0) {
                    // Clear any previous data in the table
                    $('table tbody').empty();
    
                    // Loop through the expenses and display them in the table
                    data.expenses_list.forEach(function(expense) {
                        // Ensure amount is a number
                        var amount = parseFloat(expense.amount); // Convert amount to a number
                        if (isNaN(amount)) {
                            amount = 0; // If it's not a valid number, set it to 0
                        }
    
                        // Create a table row for each expense
                        var row = '<tr>' +
                            '<td>$' + amount.toFixed(2) + '</td>' + // Amount
                            '<td>' + expense.category + '</td>' + // Category
                            '<td>' + expense.date + '</td>' + // Date
                            '<td>' + expense.description + '</td>' + // Description
                            '<td>' +
                                '<button class="btn btn-warning btn-sm">Edit</button> ' +
                                '<button class="btn btn-danger btn-sm">Delete</button>' +
                            '</td>' + // Actions (Edit/Delete buttons)
                        '</tr>';
    
                        // Append the row to the table body
                        $('table tbody').append(row);
                    });

                        // Initialize DataTables after data is loaded
                $('table').DataTable({
                    paging: true,  // Enable pagination
                    searching: true, // Enable search
                    ordering: true, // Enable sorting
                    info: true, // Show table information
                    lengthChange: true, // Enable changing page length
                    autoWidth: false, // Disable auto width
                });
                } else {
                    // Handle case when no expenses are found
                    $('table tbody').html('<tr><td colspan="5" class="text-center">No expenses found.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("There was an error with the AJAX request.");
            }
        });
    }
    
    // Call the function to get data
    getData();
    

    /********************************************* */

    $.ajax({
        type: "POST",
        url: "php/ai_insights.php",
        success:function(response){
            console.log(response);
            var data = JSON.parse(response);
            $('#ai_advice').html(data)
        }
    })
    
});
