function addCardListeners() {
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', event => {
            let target = event.target;
            while (target !== card) {
                if (target.tagName === 'BUTTON' || target.tagName === 'I') {
                    return;
                }
                target = target.parentNode;
            }
            const messageDetails = card.querySelector('.message-details');
            messageDetails.style.display = 'block';
        });
    });
}

function addMarkAsImportantListeners() {
    document.querySelectorAll('.mark-as-important').forEach(button => {
        button.addEventListener('click', () => {
            const messageId = button.closest('.card').dataset.id;
            axios.post('/admin/toggle-important', { messageId })
                .then(response => {
                    if (response.data.isImportant) {
                        button.classList.remove('btn-secondary');
                        button.classList.add('btn-warning');
                    } else {
                        button.classList.remove('btn-warning');
                        button.classList.add('btn-secondary');
                    }
                });
        });
    });
}

function addMarkAsReadListeners() {
    document.querySelectorAll('.mark-as-read').forEach(button => {
        button.addEventListener('click', () => {
            const messageId = button.closest('.card').dataset.id;
            axios.post('/admin/toggle-read', { messageId })
                .then(response => {
                    if (response.data.isRead) {
                        button.classList.remove('btn-primary');
                        button.classList.add('btn-secondary');
                        //icon
                        const icon = button.querySelector('i');
                        icon.classList.remove('fa-envelope');
                        icon.classList.add('fa-envelope-open');
                    } else {
                        button.classList.remove('btn-secondary');
                        button.classList.add('btn-primary');

                        const icon = button.querySelector('i');
                        icon.classList.remove('fa-envelope-open');
                        icon.classList.add('fa-envelope');
                    }
                });
        });
    });
}

function addDeleteMessageListeners() {
    document.querySelectorAll('.delete-message').forEach(button => {
        button.addEventListener('click', () => {
            // Toggle delete message
            const messageId = button.closest('.card').dataset.id;
            axios.post('/admin/toggle-delete', { messageId })
                .then(response => {
                    // Update UI
                    const icon = button.querySelector('i');
                    const textNode = button.lastChild;
                    if (response.data.isDeleted) {
                        textNode.textContent = ' Restore';
                        button.classList.remove('btn-danger');
                        button.classList.add('btn-success');
                        icon.classList.remove('fa-trash');
                        icon.classList.add('fa-trash-restore');
                    } else {
                        textNode.textContent = ' Delete';
                        button.classList.remove('btn-success');
                        button.classList.add('btn-danger');
                        icon.classList.remove('fa-trash-restore');
                        icon.classList.add('fa-trash');
                    }
                });
        });
    });
}

function addButtonEventListener(buttonSelector, url) {
    const button = document.querySelector(buttonSelector);
    if (button) {
        button.addEventListener('click', () => {
            axios.get(url)
                .then(response => {
                    const view = response.data.view;
                    const messageContainer = document.querySelector('.message-container');
                    messageContainer.innerHTML = view;

                    // Recall functions to set listeners again
                    addMarkAsImportantListeners();
                    addMarkAsReadListeners();
                    addDeleteMessageListeners();
                    addCardListeners();
                });
        });
    }
}

window.addEventListener('load', () => {
	addCardListeners();
    addMarkAsImportantListeners();
    addMarkAsReadListeners();
    addDeleteMessageListeners();
	addButtonEventListener('.show-all', '/admin/show-all');
	addButtonEventListener('.filter-important', '/admin/show-important');
	addButtonEventListener('.show-deleted', '/admin/show-deleted');
	addButtonEventListener('.filter-read', '/admin/show-read');
});