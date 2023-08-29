<div class="container mx-lg-5 mt-5">
    <div class="card mt-5" style="width: 30rem;">
        <div class="card-body">
            <h5 class="card-title">Register</h5>
            <form class="" method="post" action="/users/register">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input name="id" type="text" class="form-control" id="id" placeholder="Create New Id" value="<?= $_POST["id"] ?? " " ?>">
                </div>
                <div class="mb-3">
                    <label for="id" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="id" placeholder="Create New Name" value="<?= $_POST["name"] ?? " " ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Create New Password">
                </div>
                <button type="submit" class="btn btn-info text-light">Sign Up</button>
            </form>
        </div>
    </div>

    <?php if(isset($model["error"])){ ?>
        <div class="alert alert-danger mt-2" role="alert" style="width: 30rem;">
            <?= $model["error"] ?>
        </div>
    <?php }?>

</div>