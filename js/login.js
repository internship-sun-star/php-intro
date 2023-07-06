const btnLogin = document.querySelector('button')
const eleRememberMe = document.getElementById('remember')
const eleUsername = document.getElementById('username')
const elePassword = document.getElementById('password')

btnLogin.addEventListener('click', async () => {
  try {
    await Requester.post('/login', {
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        username: eleUsername.value,
        password: elePassword.value,
        remember: eleRememberMe.checked,
      }),
    })
    window.location.href = 'http://localhost/php-intro'
  } catch (error) {
    window.alert(error.message)
  }
})
