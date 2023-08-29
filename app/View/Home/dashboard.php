<div class="container mx-lg-5 mt-5 d-flex">
      <div class="container row align-items-center">
        <h1 class="text-center text-uppercase fw-bold" style="font-size: 5rem;">Welcome Home <?= $model["user"]["name"] ?></h1>
      </div>
      <div class="card mt-5 p-lg-5 " style="width: 40rem;">
          <div class="card-body">
            <div>
              <div class="form-floating mb-3">
                  <a href="/users/profile" class="w-100 btn btn-lg btn-info text-light">Profile</a>
              </div>
              <div class="form-floating mb-3">
                  <a href="/users/password" class="w-100 btn btn-lg btn-info text-light">Password</a>
              </div>
              <div class="form-floating mb-3">
                <a href="/users/logout" class="w-100 btn btn-lg btn-danger text-light">Logout</a>
              </div>
            </div>
          </div>
        </div>
    </div>