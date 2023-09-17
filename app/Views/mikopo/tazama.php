<style>
    /*profile page*/

    .left-profile-card .user-profile {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: auto;
        margin-bottom: 20px;
    }

    .left-profile-card h3 {
        font-size: 18px;
        margin-bottom: 0;
        font-weight: 700;
    }

    .left-profile-card p {
        margin-bottom: 5px;
    }

    .left-profile-card .progress-bar {
        background-color: var(--main-color);
    }

    .personal-info {
        margin-bottom: 30px;
    }

    .personal-info .personal-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .personal-list li {
        margin-bottom: 5px;
    }

    .personal-info h3 {
        margin-bottom: 10px;
    }

    .personal-info p {
        margin-bottom: 5px;
        font-size: 14px;
    }

    .personal-info i {
        font-size: 15px;
        color: var(--main-color);
        ;
        margin-right: 15px;
        width: 18px;
    }
</style>
<div class="">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-user-plus"></i> Tazama Mkopo</h1>
            <p>Tafadahli Weka taarifa za mkopaji kwa usahihi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Mikopo</li>
            <li class="breadcrumb-item"><a href="#">Tazama</a></li>
        </ul>
    </div>
    <?php if (!empty(session()->get('ujumbe'))) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fa fa-exclamation-triangle"></i></strong> <?= session()->get('ujumbe') ?>.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
    <?php if (!empty(session()->get('error'))) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fa fa-exclamation-triangle"></i></strong> <?= session()->get('error') ?>.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
    <div class="row">
        <div class="col-lg-3 ">
            <div class="card left-profile-card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="" class="user-profile">
                        <h3>John Doe</h3>
                        <p>World of Internet</p>
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <i class="fas fa-star text-info"></i>
                            <i class="fas fa-star text-info"></i>
                            <i class="fas fa-star text-info"></i>
                            <i class="fas fa-star text-info"></i>
                            <i class="fas fa-star text-info"></i>
                        </div>
                    </div>
                    <div class="personal-info">
                        <h3>Personal Information</h3>
                        <ul class="personal-list">
                            <li><i class="fas fa-briefcase "></i><span>Web Designer</span></li>
                            <li><i class="fas fa-map-marker-alt "></i><span> New York</span></li>
                            <li><i class="far fa-envelope "></i><span>like @example.com</span></li>
                            <li><i class="fas fa-mobile "></i><span>1234564343</span></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-9">
            
            <div class="d-flex justify-content-end">
                <button class="btn btn-info mx-2">pakua ratiba ya malipo</button>
                <button class="btn btn-success mx-2">Lipa mkopo</button>
            </div>
            <div class="row my-4">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumla Deni</h5>
                            <p class="card-text">10000</p>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kiasi kilicholipwa</h5>
                            <p class="card-text">10000</p>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kiasi kilichosalia</h5>
                            <p class="card-text">10000</p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="my-2">
                <ul class="list-group list-group-horizontal-md">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                </ul>
            </div>
            <div class="card right-profile-card">
                <div class="card-header alert-primary">
                    <h3>Historia ya malipo</h3>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>