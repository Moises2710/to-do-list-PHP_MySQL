document.addEventListener('DOMContentLoaded', () => {
    const createTaskForm = document.getElementById('createTaskForm');
    const editTaskForm = document.getElementById('editTaskForm');
    const editTaskModalEl = document.getElementById('editTaskModal');
    const newTaskModalEl = document.getElementById('newTaskModal');
    const deleteTaskModalEl = document.getElementById('deleteTaskModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    let taskToDeleteId = null;
    let createDatePicker = null;
    let editDatePicker = null;

    // Flatpickr Modern Date Picker Initialization
    if (typeof flatpickr !== 'undefined') {
        const flatpickrConfig = {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'M j, Y',
            minDate: 'today',
            animate: true
        };

        const createInput = document.getElementById('create_due_date');
        if (createInput) {
            createDatePicker = flatpickr(createInput, flatpickrConfig);
        }

        const editInput = document.getElementById('edit_due_date');
        if (editInput) {
            editDatePicker = flatpickr(editInput, {
                ...flatpickrConfig,
                minDate: null
            });
        }
    }

    // Toast alert helper
    function showAlert(message, type = 'success') {
        const container = document.getElementById('alertContainer');
        if (!container) return;

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show rounded-3 shadow-sm`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        container.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 4000);
    }

    // Dynamic metrics update helper
    function updateMetrics(metrics) {
        if (!metrics) return;
        const totalEl = document.getElementById('metricTotal');
        const pendingEl = document.getElementById('metricPending');
        const inProgressEl = document.getElementById('metricInProgress');
        const completedEl = document.getElementById('metricCompleted');

        if (totalEl) totalEl.textContent = metrics.total;
        if (pendingEl) pendingEl.textContent = metrics.pending;
        if (inProgressEl) inProgressEl.textContent = metrics.in_progress;
        if (completedEl) completedEl.textContent = metrics.completed;
    }

    // Dynamic Priority Select Background Color Updater
    function updatePrioritySelectColor(selectEl) {
        if (!selectEl) return;
        selectEl.classList.add('priority-select-input');
        selectEl.classList.remove('priority-select-low', 'priority-select-medium', 'priority-select-high');
        
        const priority = selectEl.value;
        if (priority === 'low') {
            selectEl.classList.add('priority-select-low');
        } else if (priority === 'high') {
            selectEl.classList.add('priority-select-high');
        } else {
            selectEl.classList.add('priority-select-medium');
        }
    }

    // Initialize & listen for changes on priority select dropdowns
    const prioritySelects = document.querySelectorAll('.priority-select-input, #create_priority, #edit_priority');
    prioritySelects.forEach(selectEl => {
        updatePrioritySelectColor(selectEl);
        selectEl.addEventListener('change', () => updatePrioritySelectColor(selectEl));
    });

    // Handle Create Task Form Submission
    if (createTaskForm) {
        createTaskForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = createTaskForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            const formData = new FormData(createTaskForm);

            try {
                const response = await fetch('/tasks', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showAlert(result.message, 'success');
                    createTaskForm.reset();
                    if (createDatePicker) createDatePicker.clear();

                    const createPriority = document.getElementById('create_priority');
                    if (createPriority) updatePrioritySelectColor(createPriority);

                    const modal = bootstrap.Modal.getInstance(newTaskModalEl);
                    if (modal) modal.hide();

                    updateMetrics(result.data.metrics);
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showAlert(result.message || 'Error creating task', 'danger');
                }
            } catch (err) {
                showAlert('Network error occurred.', 'danger');
            } finally {
                submitBtn.disabled = false;
            }
        });
    }

    // Handle Status Change via dropdown select
    document.addEventListener('change', async (e) => {
        if (e.target && e.target.classList.contains('task-status-select')) {
            const selectEl = e.target;
            const taskId = selectEl.dataset.taskId;
            const newStatus = selectEl.value;

            const formData = new FormData();
            formData.append('task_id', taskId);
            formData.append('status', newStatus);

            try {
                const response = await fetch('/tasks/update-status', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showAlert(result.message, 'success');
                    updateMetrics(result.data.metrics);

                    const cardEl = document.getElementById(`task-card-${taskId}`);
                    if (cardEl) {
                        cardEl.classList.remove('status-pending', 'status-in_progress', 'status-completed');
                        cardEl.classList.add(`status-${newStatus}`);
                    }
                } else {
                    showAlert(result.message || 'Error updating status', 'danger');
                }
            } catch (err) {
                showAlert('Failed to update status.', 'danger');
            }
        }
    });

    // Populate Edit Task Modal & Update Priority Background
    if (editTaskModalEl) {
        editTaskModalEl.addEventListener('show.bs.modal', (e) => {
            const button = e.relatedTarget;
            if (!button) return;

            document.getElementById('edit_task_id').value = button.dataset.taskId || '';
            document.getElementById('edit_title').value = button.dataset.taskTitle || '';
            document.getElementById('edit_description').value = button.dataset.taskDescription || '';
            
            const editPriority = document.getElementById('edit_priority');
            if (editPriority) {
                editPriority.value = button.dataset.taskPriority || 'medium';
                updatePrioritySelectColor(editPriority);
            }

            document.getElementById('edit_status').value = button.dataset.taskStatus || 'pending';
            
            const dueDate = button.dataset.taskDueDate || '';
            if (editDatePicker) {
                editDatePicker.setDate(dueDate);
            } else {
                document.getElementById('edit_due_date').value = dueDate;
            }
        });
    }

    // Handle Edit Task Form Submission
    if (editTaskForm) {
        editTaskForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = editTaskForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            const formData = new FormData(editTaskForm);

            try {
                const response = await fetch('/tasks/edit', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showAlert(result.message, 'success');
                    const modal = bootstrap.Modal.getInstance(editTaskModalEl);
                    if (modal) modal.hide();

                    updateMetrics(result.data.metrics);
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showAlert(result.message || 'Error updating task', 'danger');
                }
            } catch (err) {
                showAlert('Network error occurred.', 'danger');
            } finally {
                submitBtn.disabled = false;
            }
        });
    }

    // Populate Delete Confirmation Modal
    if (deleteTaskModalEl) {
        deleteTaskModalEl.addEventListener('show.bs.modal', (e) => {
            const button = e.relatedTarget;
            if (button) {
                taskToDeleteId = button.dataset.taskId;
            }
        });
    }

    // Handle Delete Confirmation
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', async () => {
            if (!taskToDeleteId) return;

            confirmDeleteBtn.disabled = true;
            const formData = new FormData();
            formData.append('task_id', taskToDeleteId);

            try {
                const response = await fetch('/tasks/delete', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showAlert(result.message, 'success');
                    const modal = bootstrap.Modal.getInstance(deleteTaskModalEl);
                    if (modal) modal.hide();

                    const taskCard = document.getElementById(`task-card-${taskToDeleteId}`);
                    if (taskCard) taskCard.remove();

                    updateMetrics(result.data.metrics);
                } else {
                    showAlert(result.message || 'Error deleting task', 'danger');
                }
            } catch (err) {
                showAlert('Network error occurred.', 'danger');
            } finally {
                confirmDeleteBtn.disabled = false;
                taskToDeleteId = null;
            }
        });
    }

    // Client-side Task Filter Tabs
    const filterTabs = document.querySelectorAll('.task-filter-btn');
    filterTabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            filterTabs.forEach(t => t.classList.remove('active', 'btn-primary'));
            filterTabs.forEach(t => t.classList.add('btn-outline-secondary'));

            tab.classList.remove('btn-outline-secondary');
            tab.classList.add('active', 'btn-primary');

            const filter = tab.dataset.filter;
            const taskCards = document.querySelectorAll('.task-card-item');

            taskCards.forEach(card => {
                if (filter === 'all' || card.dataset.status === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
