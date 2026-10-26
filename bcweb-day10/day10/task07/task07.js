
const chatBox = document.getElementById('chatBox');
const chatForm = document.getElementById('chatForm');

async function readJson(response) {
    const text = await response.text();

    try {
        return JSON.parse(text);
    } catch {
        throw new Error(
            'The server did not return JSON. Check task07.php and the PHP server.'
        );
    }
}

async function fetchMessages() {
    try {
        const response = await fetch('task07.php');

        const messages = await readJson(response);

        if (!response.ok) {
            throw new Error(
                messages.error || 'Could not load messages.'
            );
        }

        if (!Array.isArray(messages)) {
            throw new Error('The server returned an invalid message list.');
        }

        chatBox.innerHTML = '';

        messages.forEach((msg) => {
            const paragraph = document.createElement('p');
            const sender = document.createElement('strong');

            sender.textContent = msg.sender + ': ';

            paragraph.appendChild(sender);
            paragraph.appendChild(
                document.createTextNode(msg.message)
            );

            chatBox.appendChild(paragraph);
        });

        chatBox.scrollTop = chatBox.scrollHeight;
        statusMsg.textContent = '';

    } catch (error) {
        statusMsg.textContent = error.message;
    }
}

chatForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(chatForm);

    try {
        const response = await fetch('task07.php', {
            method: 'POST',
            body: formData
        });

        const data = await readJson(response);

        if (!response.ok || !data.success) {
            throw new Error(
                data.error || 'Could not send message.'
            );
        }

        document.getElementById('message').value = '';

        statusMsg.textContent = '';

        await fetchMessages();

    } catch (error) {
        statusMsg.textContent = error.message;
    }
});

fetchMessages();

setInterval(fetchMessages, 4000);
