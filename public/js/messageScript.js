function addCardListeners() {
    $('.card').on('click', function(event) {
        if (!$(event.target).is('button') && !$(event.target).is('i')) {
            $(this).find('.message-details').slideToggle();
        }
    });
}

function addMarkAsImportantListeners() {
    $('.mark-as-important').on('click', function() {
        const messageId = $(this).closest('.card').data('id');
        axios.post('/admin/toggle-important', { messageId })
            .then(response => {
                if (response.data.isImportant) {
                    $(this).removeClass('btn-secondary').addClass('btn-warning');
                } else {
                    $(this).removeClass('btn-warning').addClass('btn-secondary');
                }
            })
            .catch(error => {
                // Handle error response here
                if (error.response && error.response.data && error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    alert('An error occurred while marking the message as important.');
                }
            });
    });
}

function addMarkAsReadListeners() {
    $('.mark-as-read').on('click', function() {
        const messageId = $(this).closest('.card').data('id');
        axios.post('/admin/toggle-read', { messageId })
            .then(response => {
                if (response.data.isRead) {
                    $(this).removeClass('btn-primary').addClass('btn-secondary');
                    //icon
                    const icon = $(this).find('i');
                    icon.removeClass('fa-envelope').addClass('fa-envelope-open');
                } else {
                    $(this).removeClass('btn-secondary').addClass('btn-primary');

                    const icon = $(this).find('i');
                    icon.removeClass('fa-envelope-open').addClass('fa-envelope');
                }
            })
            .catch(error => {
                // Handle error response here
                if (error.response && error.response.data && error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    alert('An error occurred while marking the message as read.');
                }
            });
    });
}

function addDeleteMessageListeners() {
    $('.delete-message').on('click', function() {
        // Toggle delete message
        const messageId = $(this).closest('.card').data('id');
        axios.post('/admin/toggle-delete', { messageId })
            .then(response => {
                // Update UI
                const icon = $(this).find('i');
                const textNode = this.lastChild;
                if (response.data.isDeleted) {
                    textNode.textContent = window.restoreText;
                    $(this).removeClass('btn-danger').addClass('btn-success');
                    icon.removeClass('fa-trash').addClass('fa-trash-restore');
                } else {
                    textNode.textContent = window.deleteText;
                    $(this).removeClass('btn-success').addClass('btn-danger');
                    icon.removeClass('fa-trash-restore').addClass('fa-trash');
                }
            })
            .catch(error => {
                // Handle error response here
                if (error.response && error.response.data && error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    alert('An error occurred while deleting the message.');
                }
            });
    });
}

function addButtonEventListener(buttonSelector, url) {
    const button = $(buttonSelector);
    if (button.length > 0) {
        button.on('click', function() {
            axios.get(url)
                .then(response => {
                    const view = response.data.view;
                    const messageContainer = $('.message-container');
                    messageContainer.html(view);

                    // Recall functions to set listeners again
                    addMarkAsImportantListeners();
                    addMarkAsReadListeners();
                    addDeleteMessageListeners();
                    addCardListeners();
                });
        });
    }
}

$(document).ready(function() {
	addCardListeners();
    addMarkAsImportantListeners();
    addMarkAsReadListeners();
    addDeleteMessageListeners();
	addButtonEventListener('.show-all', '/admin/show-all');
	addButtonEventListener('.filter-important', '/admin/show-important');
	addButtonEventListener('.show-deleted', '/admin/show-deleted');
	addButtonEventListener('.filter-read', '/admin/show-read');
});