<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Input & Table Data</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    /* Reset CSS */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
    }
    /* Background & Layout */
    body, html {
      min-height: 100%;
      background: repeating-linear-gradient(#393939, #1e1e1e);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    /* Wrapper untuk kedua container agar berdampingan */
    .container-wrapper {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      width: 100%;
      max-width: 1200px;
    }
    /* Styling Container */
    .container {
      background: rgba(30, 30, 30, 0.95);
      padding: 60px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
      text-align: center;
      backdrop-filter: blur(10px);
      flex: 1;
      max-width: 45%;
    }
    /* Judul Container */
    .container h2 {
      font-size: 26px;
      font-weight: bold;
      color: #ffffff;
      margin-bottom: 15px;
    }
    /* Form Input */
    .form-group {
      text-align: left;
      margin-bottom: 15px;
    }
    .form-group label {
      font-size: 14px;
      color: #b0b0b0;
      margin-bottom: 5px;
      display: block;
    }
    .form-control {
      width: 100%;
      padding: 12px;
      font-size: 14px;
      border: none;
      border-radius: 5px;
      background: #393939;
      color: #fff;
      outline: none;
      transition: 0.3s;
    }
    .form-control:focus {
      background: #393939;
      box-shadow: 0 0 8px rgba(255, 126, 95, 0.5);
    }
    /* Tombol */
    .btn {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      background: linear-gradient(135deg, #ff7e5f, #e76b4a);
      color: white;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 10px;
    }
    .btn:hover {
      background: linear-gradient(135deg, #e76b4a, #ff7e5f);
    }
    /* Tabel */
    #table-container {
      display: flex;
      flex-direction: column;
      align-items: center; /* Center horizontally */
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      max-width: 800px; /* Set a max width for better appearance */
    }
    table th, table td {
      border: 1px solid #393939;
      padding: 12px;
      text-align: left;
      color: #fff;
    }
    table th {
      background: #393939;
      font-weight: bold;
    }
    table tr:nth-child(even) {
      background: rgba(255, 255, 255, 0.05);
    }
    table tr:hover {
      background: rgba(255, 126, 95, 0.2);
    }
    /* Responsive */
    @media(max-width: 768px) {
      .container {
        max-width: 100%;
      }
      .container-wrapper {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="container-wrapper">
    <!-- Container untuk Form Input Data -->
    <div class="container" id="input-container">
      <h2>Input Data</h2>
      <form id="data-form">
        <div class="form-group">
          <label for="data-title">Title</label>
          <input type="text" id="data-title" class="form-control" placeholder="Title" required>
        </div>
        <div class="form-group">
          <label for="data-description">Description</label>
          <textarea id="data-description" class="form-control" placeholder="Description" required></textarea>
        </div>
        <button type="submit" class="btn">Save Data</button>
      </form>
      <button id="logout-btn" class="btn">Logout</button>
    </div>

    <div class="container" id="table-container">
      <h2>Data Table</h2>
      <table id="data-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <button id="reload-btn" class="btn">Reload Data</button>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      function loadData() {
        $.ajax({
          url: '/api/home-data',
          method: 'GET',
          success: function(response) {
            $('#data-table tbody').empty();
            response.forEach(function(item) {
              let row = '<tr>' +
                          '<td>' + item.title + '</td>' +
                          '<td>' + item.description + '</td>' +
                          '<td>' + 
                            '<button class="btn delete-btn" data-id="' + item.id + '">Delete</button>' + 
                          '</td>' +
                        '</tr>';
              $('#data-table tbody').append(row);
            });
          },
          error: function(xhr) {
            alert("Failed to load data: " + xhr.responseText); 
          }
        });
      }
      
      loadData();
      
      $('#data-form').submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: '/data/store', 
          method: 'POST',
          data: {
            title: $('#data-title').val(),
            description: $('#data-description').val(),
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            alert(response.message); 
            $('#data-title').val('');
            $('#data-description').val('');
            loadData();
          },
          error: function(xhr) {
            alert("Failed to save data: " + xhr.responseText);
          }
        });
      });
      
      $('#reload-btn').click(function() {
        loadData();
      });
      
      $('#logout-btn').click(function() {
        $.post('/logout', { _token: '{{ csrf_token() }}' }, function() {
          window.location.href = '/login'; 
        });
      });

      // Handle delete button click
      $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: '/data/delete/' + id,
                method: 'DELETE',
                success: function(response) {
                    alert(response.message);
                    loadData();
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert("Failed to delete data: " + xhr.responseText);
                }
            });
        }
      });
    });
  </script>
</body>
</html>