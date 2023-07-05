const btnLogout = document.querySelector('button')
btnLogout.addEventListener('click', async () => {
  try {
    const response = await Requester.delete('/logout', {
      credentials: 'include',
    })
    if (!response.ok) {
      const result = await response.json()
      window.alert(result.message)
    } else {
      window.location.href = 'http://localhost/php-intro/login'
    }
  } catch (error) {
    if (error.code === 403) {
      window.location.href = 'http://localhost/php-intro/login'
    } else {
      window.alert(error.message);
    }
  }
})
