document.addEventListener('DOMContentLoaded', function() {
    const updateButton = document.getElementById('update-button');
    const form = updateButton.closest('form');
    const inputs = form.querySelectorAll('input[type="date"], select');

    updateButton.addEventListener('click', function() {
        // Toggle button text between 'Update' and 'See Rooms'
        if (updateButton.value === 'Update') {
            updateButton.value = 'See Rooms';

            // Enable all form fields
            inputs.forEach(input => input.disabled = false);
            form.setAttribute('method', 'GET'); // Use GET method to see dynamic updates
        } else {
            // If the button is 'See Rooms', submit the form
            form.submit();
        }
    });
});
