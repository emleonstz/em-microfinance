<style>
    .card-box {
        position: relative;
        color: #fff;
        padding: 20px 10px 40px;
        margin: 20px 0px;
    }

    .card-box:hover {
        text-decoration: none;
        color: #f1f1f1;
    }

    .card-box:hover .icon i {
        font-size: 100px;
        transition: 1s;
        -webkit-transition: 1s;
    }

    .card-box .inner {
        padding: 5px 10px 0 10px;
    }

    .card-box h3 {
        font-size: 27px;
        font-weight: bold;
        margin: 0 0 8px 0;
        white-space: nowrap;
        padding: 0;
        text-align: left;
    }

    .card-box p {
        font-size: 15px;
    }

    .card-box .icon {
        position: absolute;
        top: auto;
        bottom: 5px;
        right: 5px;
        z-index: 0;
        font-size: 72px;
        color: rgba(0, 0, 0, 0.15);
    }

    .card-box .card-box-footer {
        position: absolute;
        left: 0px;
        bottom: 0px;
        text-align: center;
        padding: 3px 0;
        color: rgba(255, 255, 255, 0.8);
        background: rgba(0, 0, 0, 0.1);
        width: 100%;
        text-decoration: none;
    }

    .card-box:hover .card-box-footer {
        background: rgba(0, 0, 0, 0.3);
    }

    .bg-blue {
        background-color: #00c0ef !important;
    }

    .bg-green {
        background-color: #00a65a !important;
    }

    .bg-orange {
        background-color: #f39c12 !important;
    }

    .bg-red {
        background-color: #d9534f !important;
    }
</style>
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
<div class="container">
    <p class="bs-component text-right">
        <a href="/ongezawakopaji" class="btn btn-primary" type="button"><i class="fa fa-user-plus" aria-hidden="true"></i> Sajili Mkopaji</a>
        <a href="#" class="btn btn-success" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Wasilisha Maombi ya mkopo</a>
        <a href="#" class="btn btn-success" type="button"><i class="fa fa-money" aria-hidden="true"></i> Wasilisha Malipo mkopo</a>
    </p>
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-primary">
                <div class="inner">
                    <h3> 0 </h3>
                    <p>Maombi yanayosubiri uthibitisho </p>
                </div>
                <div class="icon">
                    <i class="fa fa-money" aria-hidden="true"></i>
                </div>
                <a href="#" class="card-box-footer">Tazama zaidi <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-primary">
                <div class="inner">
                    <h3> 0 </h3>
                    <p>Maombi yanayosubiri uthibitisho </p>
                </div>
                <div class="icon">
                    <i class="fa fa-suitcase" aria-hidden="true"></i>
                </div>
                <a href="#" class="card-box-footer">Tazama zaidi <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-primary">
                <div class="inner">
                    <h3> 0 </h3>
                    <p>Wakopaji hawajawasilisha fomu ya kujiunga</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                </div>
                <a href="#" class="card-box-footer">Taarifa zaidi <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-green">
                <div class="inner">
                    <h3> 0 </h3>
                    <p>Jumla ya Wakopaji walio sajiliwa kikamlifu </p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- maombi ya mkopo-->
    <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Maombi ya mikopo yanayosubiri uthibitisho</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>