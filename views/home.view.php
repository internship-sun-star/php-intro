<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/requester.js"></script>
    <title>Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            height: 100%;
        }

        body {
            background: linear-gradient(320deg, #eb92be, #ffef78, #63c9b4);
            font-family: "Raleway", sans-serif;
            height: inherit;
        }

        #header {
            height: 60px;
            background-color: black;
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            z-index: 1;
            text-align: center;
        }

        #header h2 {
            line-height: 60px;
            display: block;
            color: #fff;
        }

        #content {
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
            padding: 10px;
            background: #fff;
            width: 80%;
            border: none;
            border-radius: 10px;
            box-shadow: 2px 2px 5px 5px rgba(0, 0, 0, 0.2);
        }

        button {
            border: none;
            outline: none;
            padding: 10px;
            font-size: 15px;
            color: black;
            border-radius: 10px;
            cursor: pointer;
        }

        #logout-btn {
            background: #fff;
            position: absolute;
            right: 10px;
            top: 10px;
            color: black;
        }

        #logout-btn:hover {
            background: red;
            color: #fff;
        }

        #add-btn-section {
            margin-top: 100px;
            margin-bottom: 20px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            text-align: right;
        }

        #add-btn {
            background: black;
            color: #fff;
            box-shadow: 2px 2px 5px 5px rgba(0, 0, 0, 0.15);
        }

        #add-btn:hover {
            background: #555;
        }

        table {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            text-align: center;
            border: 2px solid black;
        }

        #add-modal,
        #edit-modal {
            position: fixed;
            align-items: center;
            justify-content: center;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.4);
            display: none;
        }

        form {
            background: #fff;
            width: 30%;
            padding: 15px;
            position: fixed;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .form-header {
            background: black;
            width: 30%;
            position: fixed;
            top: 22%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 25px;
            color: #fff;
            padding: 16px;
            text-align: center;
        }

        label {
            display: block;
            font-size: 15px;
            margin-bottom: 12px;
        }

        input {
            border-color: 1px solid #ccc;
            width: 100%;
            font-size: 15px;
            padding: 10px;
            margin-bottom: 5px;
        }

        #add-submit-btn,
        #edit-submit-btn {
            float: left;
            padding: 10px 40px;
            background: green;
            color: white;
        }
        
        #add-close-btn,
        #edit-close-btn {
            float: right;
            padding: 10px 40px;
            background: red;
            color: white;
        }
        
        #add-submit-btn:hover,
        #edit-submit-btn:hover {
            background: #006400;
        }

        #add-close-btn:hover,
        #edit-close-btn:hover {
            background: #8b0000;
        }

    </style>
</head>

<body>
    <div id="header">
        <h2>Book Management</h2>
        <button id="logout-btn" type="button">Logout</button>
    </div>
    <div id="add-btn-section">
        <button id="add-btn">Add</button>
    </div>
    <div id="content">
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
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody id="book-table-body"></tbody>
        </table>
    </div>

    <!--Add Popup form -->
    <div id="add-modal">
        <div id="add-popup-form">
            <header class="form-header">
                Add Book
            </header>
            <form id="add-book-form">
                <label for="title">Title:</label>
                <input type="text" id="add-title" name="title" required><br><br>
                <label for="author">Author:</label>
                <input type="text" id="add-author" name="author" required><br><br>
                <label for="published-year">Published Year:</label>
                <input type="number" id="add-published-year" name="published-year" required><br><br>
                <label for="price">Price:</label>
                <input type="number" id="add-price" name="price" step="any" required><br><br>
                <button type="add-submit" id="add-submit-btn">Add</button>
                <button type="button" id="add-close-btn">Close</button>
            </form>
        </div>
    </div>

    <!--Edit Popup form -->
    <div id="edit-modal">
        <div id="edit-popup-form">
            <header class="form-header">
                Edit Book
            </header>
            <form id="edit-book-form">
                <label for="edit-title">Title:</label>
                <input type="text" id="edit-title" name="title" required><br><br>
                <label for="edit-author">Author:</label>
                <input type="text" id="edit-author" name="author" required><br><br>
                <label for="edit-published-year">Published Year:</label>
                <input type="number" id="edit-published-year" name="published-year" required><br><br>
                <label for="edit-price">Price:</label>
                <input type="number" id="edit-price" name="price" step="any" required><br><br>
                <button type="edit-submit" id="edit-submit-btn">Save</button>
                <button type="button" id="edit-close-btn">Close</button>
            </form>
        </div>
    </div>

    <script src="./js/home.js"></script>
</body>

</html>