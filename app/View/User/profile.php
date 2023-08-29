<div class="container mx-lg-5 mt-5">
    <div class="card mt-5" style="width: 30rem;">
        <div class="card-body">
            <h5 class="card-title">Update Profile</h5>
            <form class="" method="post" action="/users/profile">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input type="text" class="form-control" id="id"
                           placeholder="Your Id" disabled value="<?= $model["user"]["id"] ?? " " ?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="name"
                           placeholder="New Name" value="<?= $model["user"]["name"] ?? " " ?>">
                </div>
                <button type="submit" class="btn btn-info text-light">Update</button>
            </form>
        </div>
    </div>
    <?php if(isset($model["error"])){ ?>
        <div class="alert alert-danger mt-2" role="alert" style="width: 30rem;">
            <?= $model["error"] ?>
        </div>
    <?php }?>
</div>

