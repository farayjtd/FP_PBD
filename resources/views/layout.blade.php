<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            padding: 30px;
        }

        h2 {
            color: #1e88e5;
            text-align: center;
            margin-bottom: 20px;
        }

        nav {
            background-color: #1e88e5;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: #ffffff;
            margin: 0 10px;
            text-decoration: none;
            font-weight: 600;
        }

        nav a:hover {
            text-decoration: underline;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 0;
        }

        .content {
            padding: 20px 0;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <nav>
            <a href="{{ route('dashboard') }}">Home</a>
            <a href="{{ route('publisher.index') }}">Publisher</a>
            <a href="{{ route('member.index') }}">Member</a>
            <a href="{{ route('category.index') }}">Category</a>
            <a href="{{ route('book.index') }}">Book</a>
            <a href="{{ route('borrowing.index') }}">Borrowing</a>
        </nav>
        <hr>
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>
