document.getElementById('productForm').addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const responseMsg = document.getElementById('responseMsg');

    responseMsg.textContent = '';

    fetch('task06.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Request failed');
            }

            return response.json();
        })
        .then(data => {
            responseMsg.textContent = data.message;
            responseMsg.className =
                `mt-3 fw-bold ${data.success ? 'valid' : 'error'}`;
        })
        .catch(() => {
            responseMsg.textContent =
                'An error occurred while processing the request.';
            responseMsg.className = 'mt-3 fw-bold error';
        });
});