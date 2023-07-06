const btnLogout = document.querySelector('button')
const btnAdd = document.getElementById('add-btn');
const btnClose = document.getElementById('close-btn');
const popupForm = document.getElementById('popup-form');
const addBookForm = document.getElementById('add-book-form');

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

btnAdd.addEventListener('click', () => {
  popupForm.style.display = 'block'; // Display the popup form
});

btnClose.addEventListener('click', () => {
  popupForm.style.display = 'none'; // Hide the popup form
});

addBookForm.addEventListener('submit', async (e) => {
  e.preventDefault(); // Prevent form submission

  const title = document.getElementById('title').value;
  const author = document.getElementById('author').value;
  const publishedYear = document.getElementById('published-year').value;
  const price = document.getElementById('price').value;

  try {
    const response = await Requester.post('/php-intro/books', {
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        title: title,
        author: author,
        published_year: publishedYear,
        price: price
      })
    });

    if (!response.ok) {
      const result = await response.json();
      window.alert(result.message);
    } else {
      // Refresh the book table
     window.location.reload();
    }
  } catch (error) {
    window.alert(error.message);
  }
});

document.addEventListener('DOMContentLoaded', () => {
  // Lấy danh sách sách từ API và hiển thị trên trang
  fetch('/php-intro/books')
      .then(response => response.json())
      .then(data => {
          // Lưu thông tin sách vào đối tượng booksObject
          const booksObject = {};
          data.forEach(book => {
              const bookInfo = {
                  id: book.id,
                  title: book.title,
                  author: book.author,
                  published_year: book.published_year,
                  price: book.price,
                  user_id: book.user_id,
                  created_at: new Date(book.created_at),
                  updated_at: new Date(book.updated_at)
              };
              booksObject[book.id] = bookInfo;
          });

          // Hiển thị thông tin sách từ đối tượng booksObject
          displayBooks(booksObject);
      })
      .catch(error => {
          console.error('Error:', error);
      });
});

function displayBooks(booksObject) {
  const tableBody = document.getElementById('book-table-body');
  tableBody.innerHTML = '';

  for (const bookId in booksObject) {
      if (booksObject.hasOwnProperty(bookId)) {
          const book = booksObject[bookId];

          const row = document.createElement('tr');

          const idCell = document.createElement('td');
          idCell.textContent = book.id;
          row.appendChild(idCell);

          const titleCell = document.createElement('td');
          titleCell.textContent = book.title;
          row.appendChild(titleCell);

          const authorCell = document.createElement('td');
          authorCell.textContent = book.author;
          row.appendChild(authorCell);

          const publishedYearCell = document.createElement('td');
          publishedYearCell.textContent = book.published_year;
          row.appendChild(publishedYearCell);

          const priceCell = document.createElement('td');
          priceCell.textContent = book.price;
          row.appendChild(priceCell);

          const createdCell = document.createElement('td');
          createdCell.textContent = book.created_at.toLocaleString();
          row.appendChild(createdCell);

          const updatedCell = document.createElement('td');
          updatedCell.textContent = book.updated_at.toLocaleString();
          row.appendChild(updatedCell);

          tableBody.appendChild(row);
      }
  }
}