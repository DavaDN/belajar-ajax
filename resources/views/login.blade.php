<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body, html {
            height: 100%;
            background: repeating-linear-gradient(#393939, #1e1e1e);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: rgba(30, 30, 30, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .container h2 {
            font-size: 26px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 15px;
        }

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
        }

        .btn:hover {
            background: linear-gradient(135deg, #e76b4a, #ff7e5f);
        }

        .text-center {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #b0b0b0;
        }

        .text-center a {
            color: #ff7e5f;
            text-decoration: none;
            font-weight: bold;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="login-form">
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="login-email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="login-password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="text-center">
            Belum punya akun? <a href="/register">Daftar</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#login-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/login',
                    method: 'POST',
                    data: {
                        email: $('#login-email').val(),
                        password: $('#login-password').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        window.location.href = '/home';
                    },
                    error: function() {
                        alert("Email atau password salah!");
                    }
                });
            });
        });
    </script>
</body>
</html>
