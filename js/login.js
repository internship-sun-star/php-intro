const btnLogin = document.getElementById('login-btn')
const eleRememberMe = document.getElementById('remember')
const eleUsername = document.getElementById('username')
const elePassword = document.getElementById('password')

let isLoading = false;

btnLogin.addEventListener('click', async () => {
  if (isLoading) return;
  isLoading = true;
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
    window.alert(error.body.message)
  } finally {
    isLoading = false;
  }
})
