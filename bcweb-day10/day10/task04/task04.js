const typeInput = document.getElementById('typeInput');
const brandInput = document.getElementById('brandInput');
const typeMsg = document.getElementById('typeMsg');
const brandMsg = document.getElementById('brandMsg');

function validate() {
    const type = typeInput.value;
    const brand = brandInput.value;

    fetch(`task04.php?type=${encodeURIComponent(type)}&brand=${encodeURIComponent(brand)}`)
        .then(response => response.json())
        .then(data => {
            typeMsg.textContent = data.typeMessage;
            typeMsg.className = `form-text ${data.typeValid ? 'valid' : 'error'}`;

            brandMsg.textContent = data.brandMessage;
            brandMsg.className = `form-text ${data.brandValid ? 'valid' : 'error'}`;
        })
        .catch(err => console.error(err));
}


typeInput.addEventListener('input', validate);
brandInput.addEventListener('input', validate);