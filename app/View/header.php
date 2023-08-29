<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $model["title"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-info">
    <div class="container-fluid ">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 mr">
                <li class="nav-item">
                    <a class="nav-link active text-light fw-bolder " aria-current="page" href="/">Home</a>
                </li>

                <li class="nav-item ms-lg-3">
                    <a class="nav-link active text-light fw-bolder" aria-current="page" href="/users/register">Register</a>
                </li>

                <li class="nav-item ms-lg-3">
                    <a class="nav-link active text-light fw-bolder" aria-current="page" href="/users/login">Login</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light fw-bolder" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
<div class="container mx-lg-5 mt-5">
    <h1 class="">Welcome To My Login Management</h1>
</div>
