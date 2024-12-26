<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI-Powered Expense Tracker</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    
    <style>
        /* Dark mode styles */
        body {
            background-color: #121212;
            color: #f1f1f1;
        }

        .card {
            background-color: #1e1e1e;
            color: #f1f1f1;
        }

        .card-header {
            background-color: #333;
            color: #f1f1f1;
        }

        .form-control {
            background-color: #333;
            color: #f1f1f1;
            border-color: #444;
        }

        .btn-primary {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #5a6268;
        }

        /* Animation for image */
        @keyframes moveUpDown {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px); /* Move up */
            }
            100% {
                transform: translateY(0); /* Move back down */
            }
        }

        img {
            width: 250px;
            animation: moveUpDown 2s infinite; /* 2s duration, infinite loop */
        }

        .btn-warning {
    color: #212529;
    background-color: #71b3b8;
    border-color: #80d7f8;
}
    </style>
</head>
<body>
    <div class="container-fluid">
        <br/>
        <br/>

        <div class="row">
            <div class="col-3">
                <center><h3>Dashboard</h3></center>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Total Expenses
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" id="total_expenses"></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Categorized Spending
                            </div>
                            <div class="card-body">
                                <ul id="categorized-spending-list"></ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Trends (Last 6 Months)
                            </div>
                            <div class="card-body" id="monthly_trends">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <center><h3>Expense History</h3></center>
                <div class="row card">
                    <br/>
                    <div class="col-lg-12">
                        <a href="log_expense.html" class="btn btn-primary mb-3">Log New Expense</a>
                        <form>
                            <div class="mb-3">
                                <label for="category" class="form-label">Filter by Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">All Categories</option>
                                    <option value="Food">Food</option>
                                    <option value="Transport">Transport</option>
                                    <option value="Utilities">Utilities</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date-range" class="form-label">Filter by Date Range</label>
                                <input type="text" class="form-control" id="date-range" name="date-range" placeholder="YYYY-MM-DD to YYYY-MM-DD">
                            </div>
                            <button type="submit" class="btn btn-secondary">Apply Filters</button>
                        </form>
                    </div>

                    <div class="col-lg-12">
                        <br/>
                        <table class="table table-bordered text-white">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="expenses_list"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <center><h3>AI-Powered Financial Insights</h3></center>
                <div class="card p-3">
                    <center><img src="images/ai.png" width="250px" style="animation: moveUpDown 2s infinite;" /></center>
                    <p id="ai_advice"></p>
                </div>
            </div>
        </div>

        <br/>
        <hr />
    </div>

    <script src="vendor/jquery-3.3.1.min.js"></script>
    <script src="vendor/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="js/dashboard.js"></script>
</body>
</html>
