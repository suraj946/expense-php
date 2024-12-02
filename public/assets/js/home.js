document.addEventListener('DOMContentLoaded', () => {
  const expensesList = document.getElementById('expenses');
  const addExpenseForm = document.getElementById('addExpenseForm');
  const editModal = document.getElementById('editModal');
  const editExpenseForm = document.getElementById('editExpenseForm');
  const closeModalBtn = document.getElementById('closeModal');

  const amountInput = document.getElementById('amount');
  const categoryInput = document.getElementById('category');
  const descriptionInput = document.getElementById('description');
  const amountError = document.getElementById('amountError');
  const categoryError = document.getElementById('categoryError');
  const descriptionError = document.getElementById('descriptionError');

  const editAmountInput = document.getElementById('editAmount');
  const editCategoryInput = document.getElementById('editCategory');
  const editDescriptionInput = document.getElementById('editDescription');
  const editAmountError = document.getElementById('editAmountError');
  const editCategoryError = document.getElementById('editCategoryError');
  const editDescriptionError = document.getElementById('editDescriptionError');

  let expenses = []; // Store all fetched expenses here

  function showMessage(message, type="success") {
    const messageElement = document.createElement('div');
    messageElement.className = `${type === "error" ? "server-error" : "server-message"}`;
    messageElement.textContent = message;
    document.body.appendChild(messageElement);
    setTimeout(() => {
      messageElement.style.transition = 'opacity 0.5s ease';
      messageElement.style.opacity = '0';
      setTimeout(() => {
        messageElement.remove();
      }, 500);
    }, 3000);
  }

  function validateAmount(fieldValue, errorElement, fieldName = 'Amount') {
    const amountRegex = /^[0-9]+(\.[0-9]{1,2})?$/;
    if (fieldValue.trim() === '') {
      errorElement.textContent = `${fieldName} is required`;
      return false;
    } else if (!amountRegex.test(fieldValue)) {
      errorElement.textContent = `Please enter a valid ${fieldName} (e.g., 100, 100.50)`;
      return false;
    } else {
      errorElement.textContent = '';
      return true;
    }
  }
  
  function validateCategory(fieldValue, errorElement, fieldName = 'Category') {
    const categoryRegex = /^[a-zA-Z\s]+$/; 
    if (fieldValue.trim() === '') {
      errorElement.textContent = `${fieldName} is required`;
      return false;
    } else if (!categoryRegex.test(fieldValue)) {
      errorElement.textContent = `${fieldName} must contain only alphabets and spaces`;
      return false;
    } else if (fieldValue.length > 40) {
      errorElement.textContent = `${fieldName} cannot exceed 40 characters`;
      return false;
    } else {
      errorElement.textContent = '';
      return true;
    }
  }
  
  function validateDescription(fieldValue, errorElement, fieldName = 'Description') {
    if (fieldValue.trim() === '') {
      errorElement.textContent = `${fieldName} is required`;
      return false;
    } else {
      errorElement.textContent = '';
      return true;
    }
  }

  amountInput.addEventListener('input', () => validateAmount(amountInput.value, amountError));
  categoryInput.addEventListener('input', () => validateCategory(categoryInput.value, categoryError));
  descriptionInput.addEventListener('input', () => validateDescription(descriptionInput.value, descriptionError));

  editAmountInput.addEventListener('input', () => validateAmount(editAmountInput.value, editAmountError));
  editCategoryInput.addEventListener('input', () => validateCategory(editCategoryInput.value, editCategoryError));
  editDescriptionInput.addEventListener('input', () => validateDescription(editDescriptionInput.value, editDescriptionError));
  

  function createExpenseCard(expense) {
    const expenseCard = document.createElement('div');
    expenseCard.className = 'expense-card';
    expenseCard.dataset.expenseId = expense.id;

    expenseCard.innerHTML = `
      <div class="card-category">${expense.category}</div>
      <div class="card-content">
          <div class="expense-amount">${expense.amount}</div>
          <div class="expense-description">${expense.description}</div>
          <div class="expense-date">${new Date(expense.date).toLocaleDateString()}</div>
      </div>
      <div class="card-actions">
          <button class="edit-btn" data-id="${expense.id}">Edit</button>
          <button class="delete-btn" data-id="${expense.id}">Delete</button>
      </div>
    `;
    expenseCard.querySelector('.edit-btn').addEventListener('click', (e) => openEditModal(e.target.dataset.id));
    expenseCard.querySelector('.delete-btn').addEventListener('click', (e) => deleteExpense(e.target.dataset.id));
    return expenseCard;
  }
  function addOneExpenseOnUI(expense){
    const expenseCard = createExpenseCard(expense);
    expensesList.appendChild(expenseCard);
  };
  async function fetchExpenses() {
    try {
      const response = await fetch('/api/expenses/all', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      });
      const data = await response.json();
      if (data.success) {
        expenses = data.data;
        renderExpenses();
      } else {
        expensesList.innerHTML = '<p class="no-expenses">No expenses found.</p>';
      }
    } catch (error) {
      console.error('Error fetching expenses:', error);
      expensesList.innerHTML =
        '<p class="no-expenses">Failed to load expenses. Try again later.</p>';
    }
  }
  function renderExpenses() {
    expensesList.innerHTML = '';
    expenses.forEach((expense) => {
      const expenseCard = createExpenseCard(expense);
      expensesList.appendChild(expenseCard);
    });

  }

  function openEditModal(expenseId) {
    //reset errors of edit
    editAmountError.textContent = '';
    editCategoryError.textContent = '';
    editDescriptionError.textContent = '';
    const expense = expenses.find((exp) => exp.id == expenseId);
    if (!expense) return;

    editExpenseForm.dataset.expenseId = expenseId;
    document.getElementById('editAmount').value = expense.amount;
    document.getElementById('editDescription').value = expense.description;
    document.getElementById('editCategory').value = expense.category;

    editModal.classList.remove('hidden');
  }

  closeModalBtn.addEventListener('click', () => {
    editModal.classList.add('hidden');
  });

  async function deleteExpense(expenseId) {
    if (!confirm('Are you sure you want to delete this expense?')) return;
    try {
      const response = await fetch(`/api/expenses/delete`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ expenseId }),
      });
      const data = await response.json();

      if (data.success) {
        expenses = expenses.filter((exp) => exp.id != expenseId);
        renderExpenses();
        showMessage('Expense deleted successfully');
      } else {
        showMessage("Failed to delete expense.", 'error');
      }
    } catch (error) {
      console.error('Error deleting expense:', error);
      showMessage("Failed to delete expense.", 'error');
    }
  }

  addExpenseForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    const amountValid = validateAmount(amountInput.value, amountError);
    const categoryValid = validateCategory(categoryInput.value, categoryError);
    const descriptionValid = validateDescription(descriptionInput.value, descriptionError);

    if (!amountValid || !categoryValid || !descriptionValid) return;

    const formData = new FormData(addExpenseForm);
    const payload = Object.fromEntries(formData.entries());

    try {
      const response = await fetch('/api/expenses', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(payload),
      });
      const data = await response.json();
      console.log(response);
      if (data.success) {
        expenses.push(data.data);
        addOneExpenseOnUI(data.data);
        addExpenseForm.reset();
        showMessage('Expense added successfully');
      } else {
        showMessage("Failed to add expense.", 'error');
      }
    } catch (error) {
      console.error('Error adding expense:', error);
      showMessage("An error occurred while adding the expense.", "error");
    }
  });

  editExpenseForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    const amountValid = validateAmount(editAmountInput.value, editAmountError);
    const categoryValid = validateCategory(editCategoryInput.value, editCategoryError);
    const descriptionValid = validateDescription(editDescriptionInput.value, editDescriptionError);

    if (!amountValid || !categoryValid || !descriptionValid) return;

    const expenseId = editExpenseForm.dataset.expenseId;
    const formData = new FormData(editExpenseForm);
    const payload = Object.fromEntries(formData.entries());

    try {
      const response = await fetch(`/api/expenses`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({...payload, expenseId}),
      });

      const data = await response.json();      
      if (data.success) {
        const expenseIndex = expenses.findIndex((exp) => exp.id == expenseId);
        if (expenseIndex !== -1) expenses[expenseIndex] = {...expenses[expenseIndex], ...payload, id: expenseId};

        renderExpenses();
        editModal.classList.add('hidden');
        showMessage('Expense updated successfully');
      } else {
        showMessage("Failed to update expense.", 'error');
      }
    } catch (error) {
      console.error('Error updating expense:', error);
      showMessage("An error occurred while updating the expense.", "error");
    }
  });

  fetchExpenses();
});
