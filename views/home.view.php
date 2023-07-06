<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/requester.js"></script>
    <title>Home</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <button id="logout-btn" type="button">Logout</button>
    <button id="add-btn">Add</button>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Published Year</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody id="book-table-body"></tbody>
    </table>

    <!-- Popup form -->
    <div id="popup-form" style="display: none;">
        <h2>Add Book</h2>
        <form id="add-book-form">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br><br>
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required><br><br>
            <label for="published-year">Published Year:</label>
            <input type="number" id="published-year" name="published-year" required><br><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required><br><br>
            <button type="submit">Add</button>
            <button type="button" id="close-btn">Close</button>
        </form>
    </div>

    <script src="./js/home.js"></script>
</body>

</html>