<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Expense Tracker</title>
    <link rel="stylesheet" href="/assets/css/home.css">
    <link rel="stylesheet" href="/assets/css/global.css">
</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: /login");
        exit();
    }

    if(isset($error)){
        echo '<div class="server-error" id="serverError">' . $error . '</div>';
        unset($error);
    }
    if(isset($_SESSION['message'])){
        echo '<div class="server-message" id="serverMessage">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }

    $user = $_SESSION['user'];
    ?>
    <div class="container">
        <header class="header">
            <h1>Welcome,
                <?php echo htmlspecialchars($user['name']); ?>!
            </h1>
            <a href="/logout" class="logout-btn">Logout</a>
        </header>
        <main>
            <div class="content">
                <!-- Left section: Expenses -->
                <section class="left-section">
                    <h2>Your Expenses</h2>
                    <div id="expenses" class="expenses-list">Loading...</div>
                </section>

                <!-- Right section: Form -->
                <section class="right-section">
                    <form id="addExpenseForm" class="expense-form">
                        <h2>Add Expense</h2>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" step="0.01" >
                            <div class="error-message" id="amountError"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description" >
                            <div class="error-message" id="descriptionError"></div>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" >
                            <div class="error-message" id="categoryError"></div>
                        </div>
                        <button type="submit" class="btn add-expense-btn">Add Expense</button>
                    </form>
                </section>
            </div>
        </main>

        <!-- Modal for Editing -->
        <div id="editModal" class="modal hidden">
            <div class="modal-content">
                <h2>Edit Expense</h2>
                <form id="editExpenseForm" class="expense-form edit-form">
                    <div class="form-group">
                        <label for="editAmount">Amount</label>
                        <input type="number" id="editAmount" name="amount" step="0.01" >
                        <div class="error-message" id="editAmountError"></div>
                    </div>
                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <input type="text" id="editDescription" name="description" >
                        <div class="error-message" id="editDescriptionError"></div>
                    </div>
                    <div class="form-group">
                        <label for="editCategory">Category</label>
                        <input type="text" id="editCategory" name="category" >
                        <div class="error-message" id="editCategoryError"></div>
                    </div>
                    <div class="modal-form-action">
                        <button type="submit" class="btn edit-btn-form">Update Expense</button>
                    </div>
                </form>
                <buttonx id="closeModal" class="close-modal-btn">x</buttonx
            </div>
        </div>
    </div>
    <script src="/assets/js/home.js"></script>
    <script src="/assets/js/global.js"></script>
</body>

</html>