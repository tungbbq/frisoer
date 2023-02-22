const login = document.querySelector('.login');
login.addEventListener('click', () => {
    const button = document.querySelector('.login');
    button.disabled = true;

    const formData = new FormData(document.querySelector('form'));
    let status = '';
    fetch('../index.php', {
        'method': 'POST',
        'body': formData,
    })
        .then(res => {
            status = res.status
            return res.text();
        })
        .then(data => {
            alert(data)
            if (status === 200)
                location.href = `?action=role`;
        })
        .catch(err => {
            console.log(err)
        })
})