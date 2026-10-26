document.getElementById('searchBtn').addEventListener('click', () => {
    const type = document.getElementById('typeInput').value;
    const brand = document.getElementById('brandInput').value;
    const price = document.getElementById('priceInput').value;
    const number = document.getElementById('numberInput').value;

    const tbody = document.getElementById('resultTable');
    const errorMsg = document.getElementById('errorMsg');

    // Limpar
    tbody.innerHTML = '';
    errorMsg.textContent = '';

    const params = new URLSearchParams({
        type: type,
        brand: brand,
        price: price,
        number: number
    });

    fetch(`task05.php?${params.toString()}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Request failed');
            }

            return response.json();
        })
        .then(data => {
            if (data.error) {
                errorMsg.textContent = data.error;
                return;
            }

            data.forEach(item => {
                const tr = document.createElement('tr');

                [item.type, item.brand, item.price, item.number, item.stock]
                    .forEach(value => {
                        const td = document.createElement('td');
                        td.textContent = value;
                        tr.appendChild(td);
                    });

                tbody.appendChild(tr);
            });
        })
        .catch(() => {
            errorMsg.textContent = 'Error executing request.';
        });
});