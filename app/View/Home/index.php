<div class="container mx-lg-5 mt-5">
    <div class="card mt-5" style="width: 30rem;">
        <div class="card-body">
            <h5 class="card-title">Welcome, Login New User</h5>
            <form class="" method="post" action="/users/login">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input name="id" type="text" class="form-control" id="id" placeholder="Your Id" value="<?= $_POST["id"] ?? "" ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Your Password">
                </div>
                <button type="submit" class="btn btn-info text-light">Sign In</button>
            </form>
        </div>
    </div>

    <?php if(isset($model["error"])){ ?>
        <div class="alert alert-danger mt-2" role="alert" style="width: 30rem;">
            <?= $model["error"] ?>
        </div>
    <?php } ?>
</div>