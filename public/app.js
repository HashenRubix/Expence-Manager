const API_BASE = '/api/expenses';

const form = document.getElementById('expense-form');
const listBody = document.getElementById('expense-list');
const formError = document.getElementById('form-error');
const detailSection = document.getElementById('detail-section');
const detailList = document.getElementById('expense-detail');
const closeDetailBtn = document.getElementById('close-detail');

// Load and render all expenses
async function loadExpenses() {
  const response = await fetch(API_BASE);
  const expenses = await response.json();

  listBody.innerHTML = '';

  expenses.forEach((expense) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${expense.date}</td>
      <td>${escapeHtml(expense.description)}</td>
      <td>${expense.expense_type}</td>
      <td>${Number(expense.cost).toFixed(2)}</td>
      <td>
        <button class="action-btn" data-action="view" data-id="${expense.id}">View</button>
        <button class="action-btn" data-action="delete" data-id="${expense.id}">Delete</button>
      </td>
    `;
    listBody.appendChild(row);
  });
}

// Basic escaping to avoid rendering raw HTML from user input
function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}

// Handle form submission (create)
form.addEventListener('submit', async (event) => {
  event.preventDefault();
  formError.textContent = '';

  const payload = {
    date: form.date.value,
    cost: form.cost.value,
    description: form.description.value,
    expense_type: form.expense_type.value,
  };

  const response = await fetch(API_BASE, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
    body: JSON.stringify(payload),
  });

  if (response.status === 201) {
    form.reset();
    loadExpenses();
  } else if (response.status === 422) {
    const data = await response.json();
    formError.textContent = Object.values(data.errors).flat().join(' ');
  } else {
    formError.textContent = 'Something went wrong. Please try again.';
  }
});

// Handle view/delete clicks (event delegation)
listBody.addEventListener('click', async (event) => {
  const btn = event.target.closest('button[data-action]');
  if (!btn) return;

  const id = btn.dataset.id;

  if (btn.dataset.action === 'delete') {
    if (!confirm('Delete this expense?')) return;
    await fetch(`${API_BASE}/${id}`, { method: 'DELETE' });
    loadExpenses();
  }

  if (btn.dataset.action === 'view') {
    const response = await fetch(`${API_BASE}/${id}`);
    const expense = await response.json();
    showDetail(expense);
  }
});

function showDetail(expense) {
  detailList.innerHTML = `
    <dt>Date</dt><dd>${expense.date}</dd>
    <dt>Description</dt><dd>${escapeHtml(expense.description)}</dd>
    <dt>Type</dt><dd>${expense.expense_type}</dd>
    <dt>Cost</dt><dd>Rs. ${Number(expense.cost).toFixed(2)}</dd>
  `;
  detailSection.hidden = false;
  detailSection.scrollIntoView({ behavior: 'smooth' });
}

closeDetailBtn.addEventListener('click', () => {
  detailSection.hidden = true;
});

// Initial load
loadExpenses();