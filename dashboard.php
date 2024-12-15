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
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>OWI</h1>
        <input type="text" class="search-bar" placeholder="Cari Postingan">
        <div class="profile-icon" onclick="location.href='profile.php'">👤</div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="d-flex justify-content-between mb-4">
                    <button class="btn btn-primary" onclick="showSection('news')">News Feed</button>
                    <button class="btn btn-secondary" onclick="showSection('marketplace')">Marketplace</button>
                </div>

                <!-- News Feed Section -->
                <div id="news-section">
                    <h2 class="text-center">News Feed</h2>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">John Doe</h5>
                            <p class="card-text">This is my first post!</p>
                            <img src="image1.jpg" class="img-fluid" alt="Post image">
                            <p class="text-muted">Posted on 2024-12-11</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jane Smith</h5>
                            <p class="card-text">Loving this platform!</p>
                            <img src="image2.jpg" class="img-fluid" alt="Post image">
                            <p class="text-muted">Posted on 2024-12-10</p>
                        </div>
                    </div>
                </div>

                <!-- Marketplace Section -->
                <div id="marketplace-section" class="hidden">
                    <h2 class="text-center">Marketplace</h2>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Item 1</h5>
                            <p class="card-text">Description for item 1. Price: $100</p>
                            <img src="marketplace1.jpg" class="img-fluid" alt="Item image">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Item 2</h5>
                            <p class="card-text">Description for item 2. Price: $200</p>
                            <img src="marketplace2.jpg" class="img-fluid" alt="Item image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showSection(section) {
            document.getElementById('news-section').classList.add('hidden');
            document.getElementById('marketplace-section').classList.add('hidden');

            if (section === 'news') {
                document.getElementById('news-section').classList.remove('hidden');
            } else if (section === 'marketplace') {
                document.getElementById('marketplace-section').classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
