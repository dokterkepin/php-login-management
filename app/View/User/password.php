<div class="container mx-lg-5 mt-5">
    <div class="card mt-5" style="width: 30rem;">
        <div class="card-body">
            <h5 class="card-title">Change Password</h5>
            <form class="" method="post" action="/users/password">
                <div class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input name="id" type="text" class="form-control" id="id" placeholder="" value="<?= $model["user"]["id"] ?>">
                </div>
                <div class="mb-3">
                    <label for="old" class="form-label">Old Password</label>
                    <input name="old" type="text" class="form-control" id="old" placeholder="Your Old Password">
                </div>
                <div class="mb-3">
                    <label for="new" class="form-label">New Password</label>
                    <input name="new" type="text" class="form-control" id="new" placeholder="Your New Password">
                </div>
                <button type="submit" class="btn btn-info text-light">Change</button>
            </form>
        </div>
    </div>
    <?php if(isset($model["error"])){ ?>
        <div class="alert alert-danger mt-2" role="alert" style="width: 30rem;">
            <?= $model["error"] ?>
        </div>
    <?php } ?>

</div>
<?php
