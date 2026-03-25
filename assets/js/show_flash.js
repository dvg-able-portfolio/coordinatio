function showFlash(message, type = 'success', timeout = 3000) {
    const container = document.getElementById('flash-container');

    const div = document.createElement('div');
    div.className = `alert alert-${type} fade show`;
    div.setAttribute('role', 'alert');
    div.innerHTML  = message;

    container.appendChild(div);

    // remove after timeout
    setTimeout(() => div.remove(), timeout);
}

export {
    showFlash
}