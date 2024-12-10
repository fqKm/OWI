<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS untuk tata letak dan styling -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style></style>
    <style>
        body {
            background-color: #a8f07a;
            font-family: sans-serif;
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 2rem;
        }

        .header {
            background-color: #A0CB44;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        .card {
            background-color: #fff;
            border-radius: 1rem;
            padding: 1rem;
            width: 300px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card img {
            width: 100%;
            border-radius: 1rem;
        }

        .card .info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .card .info h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card .info p {
            margin: 0;
            font-size: 0.8rem;
            color: #666;
        }

        .card .info .arrow {
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
        }

        .card.info .arrow:hover {
            color: #007bff;
        }

        .search-bar {
            width: 100%;
            max-width: 400px;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            margin-right: 1rem;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>OWI</h1>
        <input type="text" class="search-bar" placeholder="Cari Postingan">
        <div class="profile-icon">👤</div>
    </div>
    <div class="container">
        <div class="card">
            <img src="image.jpg" alt="Sample Image">
            <div class="info">
                <h3>Title</h3>
                <p>Description</p>
                <div class="arrow">➡️</div>
            </div>
        </div>
    </div>
</body>
</html>
