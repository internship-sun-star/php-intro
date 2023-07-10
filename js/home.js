const btnLogout = document.querySelector('button')
const btnAdd = document.getElementById('add-btn');
const addModal = document.getElementById('add-modal');
const addBookForm = document.getElementById('add-book-form');
const addPopupForm = document.getElementById('add-popup-form');
const btnCloseAdd = document.getElementById('add-close-btn');
const editPopupForm = document.getElementById('edit-popup-form');
const btnCloseEdit = document.getElementById('edit-close-btn');
const editModal = document.getElementById('edit-modal');

document.addEventListener('DOMContentLoaded', fetchDataAndDisplayBooks);

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
  addModal.style.display = 'block';
});

btnCloseAdd.addEventListener('click', () => {
  addModal.style.display = 'none';
});

btnCloseEdit.addEventListener('click', () => {
  editModal.style.display = 'none';
})

addBookForm.addEventListener('submit', async (e) => {
  e.preventDefault(); // Prevent form submission

  const title = document.getElementById('add-title').value;
  const author = document.getElementById('add-author').value;
  const publishedYear = parseInt(document.getElementById('add-published-year').value);
  const price = parseFloat(document.getElementById('add-price').value);

  try {
    await Requester.post('/php-intro/books', {
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

    refreshBookTable();
    btnCloseAdd.click();
  } catch (error) {
    window.alert(error.body.message);
  }
});

function fetchDataAndDisplayBooks() {
  fetch('/php-intro/books')
    .then(response => response.json())
    .then(data => {
      const booksObject = transformDataToBooksObject(data);
      const booksArray = sortBooksArrayDescending(booksObject);
      displayBooks(booksArray);
    })
    .catch(error => {
      window.alert(error.body.message);
    });
}

function transformDataToBooksObject(data) {
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
  return booksObject;
}

function sortBooksArrayDescending(booksObject) {
  const booksArray = Object.values(booksObject);
  booksArray.sort((a, b) => b.id - a.id);
  return booksArray;
}

function displayBooks(booksArray) {
  const tableBody = document.getElementById('book-table-body');
  tableBody.innerHTML = '';

  booksArray.forEach(book => {
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

    const editCell = document.createElement('td');
    const editButton = document.createElement('button');
    editButton.textContent = 'Edit';
    editButton.style.background = 'black';
    editButton.style.color = 'white';
    editButton.dataset.bookId = book.id;
    editButton.addEventListener('click', editBook);
    editCell.appendChild(editButton);
    row.appendChild(editCell);

    const deleteCell = document.createElement('td');
    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.style.background = 'black';
    deleteButton.style.color = 'white';
    deleteButton.dataset.bookId = book.id;
    deleteButton.addEventListener('click', deleteBook);
    deleteCell.appendChild(deleteButton);
    row.appendChild(deleteCell);

    tableBody.appendChild(row);
  });
}

async function deleteBook(event) {
  const bookId = event.target.dataset.bookId;
  try {
    await Requester.delete(`/php-intro/books/${bookId}`, {
      credentials: 'include',
    });

    refreshBookTable();
  } catch (error) {
    window.alert(error.body.message);
  }
}

function editBook(event) {
  const bookId = event.target.dataset.bookId;

  // Lấy thông tin sách từ API bằng bookId
  fetch(`/php-intro/books/${bookId}`)
    .then(response => response.json())
    .then(book => {
      showEditPopupForm(book);
    })
    .catch(error => {
      window.alert(error.body.message);
    });
}

function showEditPopupForm(book) {
  const editBookForm = document.getElementById('edit-book-form');
  const editModal = document.getElementById('edit-modal');

  // Điền thông tin sách vào các trường trong form
  document.getElementById('edit-title').value = book.title;
  document.getElementById('edit-author').value = book.author;
  document.getElementById('edit-published-year').value = book.published_year;
  document.getElementById('edit-price').value = book.price;

  // Hiển thị popup form
  editModal.style.display = 'block';

  // Xử lý khi submit form chỉnh sửa sách
  editBookForm.addEventListener('submit', async (e) => {
    e.preventDefault(); // Prevent form submission

    // Lấy thông tin chỉnh sửa từ các trường trong form
    const editedTitle = document.getElementById('edit-title').value;
    const editedAuthor = document.getElementById('edit-author').value;
    const editedPublishedYear = parseInt(document.getElementById('edit-published-year').value);
    const editedPrice = parseFloat(document.getElementById('edit-price').value);

    try {
      await Requester.put(`/php-intro/books/${book.id}`, {
        credentials: 'include',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          title: editedTitle,
          author: editedAuthor,
          published_year: editedPublishedYear,
          price: editedPrice
        })
      });

      refreshBookTable();
      editModal.style.display = 'none';
    } catch (error) {
      window.alert(error.body.message);
    }
  });
}

function refreshBookTable() {
  const bookTable = document.getElementById('book-table-body');
  bookTable.innerHTML = '';

  // Gọi lại hàm để lấy danh sách sách từ API và hiển thị
  fetchDataAndDisplayBooks();
}