function logout() {
    const logout = document.querySelector('.logout');

    if (logout) {
        logout.addEventListener('click', () => {
            let status = '';
            fetch('../index.php?action=logout')
                .then(res => {
                    status = res.status
                    return res.text();
                })
                .then(data => {
                    alert(data)
                    if (status === 200)
                        location.href = `?view=startPage`;
                })
                .catch(err => {
                    console.log(err)
                })
        })
    }
}
logout()