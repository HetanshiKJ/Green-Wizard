<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="category.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Home and Work</title>

    <style>
        .title-div{
            background-image: url(Images/home-work.png);
            width: 90vw;
            height: 40vh;
            background-size: cover;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 30px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="title-div">
    <h1>Home and Work</h1>
</div>

<ul id="action_list" class="action-list">
    <!-- Actions will be loaded here dynamically -->
</ul>
<script src="fetchActions.js"></script>
</body>
</html>

