<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-6 m-auto mt-5 bg-white shadow font-monospace border border-info">
            <p class="text-warning text-center fs-3 fw-bold my-3">User Registration</p>
            <form action="insert.php" method="POST">
                <div class="mb-3">
                    <label for="name">UserName:</label>
                    <input type="text" name="name" id="name" placeholder="Enter User Name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email">UserEmail:</label>
                    <input type="email" name="email" id="email" placeholder="Enter User Email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="number">UserNumber:</label>
                    <input type="number" name="number" id="number" placeholder="Enter User Number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password">UserPassword:</label>
                    <input type="password" name="password" id="password" placeholder="Enter User Password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <button type="submit" name="submit" class="w-100 bg-warning fs-4 text-white">REGISTER</button>
                </div>
                <div class="mb-3">
                    <button type="button" class="w-100 bg-danger fs-4 text-white"><a href="login.php" class="text-decoration-none text-white">ALREADY HAVE AN ACCOUNT?</a></button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
