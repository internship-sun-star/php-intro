const btnLogin = document.querySelector('button')
btnLogin.addEventListener('click', async () => {
  try {
    await Requester.post("/login", {
      body: new FormData(document.querySelector('form'))
    });
    window.location.href = 'http://localhost/php-intro'
  } catch (error) {
    window.alert(error.message)
  }
})
