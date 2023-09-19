<?php 
use App\Controllers\Functions;
$fun = new Functions;
?>
<style>
    /*profile page*/

    .left-profile-card .user-profile {
        width: 100px;
        height: 100px;
        border-radius: 10%;
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
            <p>Kumbukumbu ya mkopo: </p>
        </div>
        <div>
            <?php if($taarifaZamkopo['application_status']=="Pending"): ?>
                <a href="/baruayamaombi/<?= urlencode(base64_encode($fun->encrypt($taarifaZamkopo['id']))) ?>" class="btn btn-danger "><i class="fa fa-trash"></i>Futa maombi haya</a>
            <a href="/baruayamaombi/<?= urlencode(base64_encode($fun->encrypt($taarifaZamkopo['id']))) ?>" class="btn btn-info "><i class="fa fa-print"></i>pakua barua ya mkopo</a>
            <a href="/baruayamaombi/<?= urlencode(base64_encode($fun->encrypt($taarifaZamkopo['id']))) ?>" class="btn btn-success "><i class="fa fa-check"></i>Thibitisha mkopo huu</a>
            <?php else: ?>
                <a href="/ratibamalipo/<?= urlencode(base64_encode($fun->encrypt($taarifaZamkopo['id']))) ?>" class="btn btn-info ">pakua ratiba ya malipo</a>
            <button class="btn btn-success ">Lipa mkopo</button>
            <?php endif ?>
        </div>

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
                        <img src="<?= $mkopaji['pasport'] ?>" alt="" class="user-profile">
                        <h3><?= $mkopaji['full_name']." ".$mkopaji['middle_name']." ".$mkopaji['last_name'] ?></h3>
                        <p>Mkopaji</p>
                    </div>
                    <div class="personal-info">
                        <h3>Taarifa za Mkopo huu</h3>
                        
                        <ul class="personal-list">
                            <li>Jumla Kiasi kilichokopwa: <br> <?= $fun->format_currency($taarifaZamkopo['principal_amount']) ?></li>
                            <hr>
                            <li>Jumla Kiasi cha kurejesha: <br><?= $fun->format_currency($taarifaZamkopo['payment_amount']) ?></li>
                            <hr>
                            <li>Tarehe ya kuchukua Mkopo: <br><?= date("F d/Y H:i A",strtotime($taarifaZamkopo['borrowing_date'])) ?></li>
                            <hr>
                            <li>Mwisho wa kurejesha: <br><?= date("F d/Y H:i A",$taarifaZamkopo['duration']) ?></li>
                            <hr>
                            <li>Mkopaji atalipa kiasi cha <?= $fun->format_currency($taarifaZamkopo['kiasi_kwa_awamu']) ?> <br> kila baada ya <?= $taarifaZamkopo['kulipa_kwa_kila']?>  mara <?= $taarifaZamkopo['idadi_malipo']?> ndani ya miezi <?= $taarifaZamkopo['ndani_miezi']?> kutoka katika tarehe ya kuchukua <?= date("F d/Y H:i A",strtotime($taarifaZamkopo['borrowing_date'])) ?> mpaka tarehe ya mwisho wa malipo tarehe <?= date("F d/Y H:i A",$taarifaZamkopo['duration']) ?>.</li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-9">

            <div class="d-flex justify-content-end">
                <h5>Mwisho wa kulipa <?= date("F d/Y H:i A",$taarifaZamkopo['duration']) ?></h5>
            </div>
            <div class="row my-4">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumla Deni</h5>
                            <p class="card-text"><?= $fun->format_currency($taarifaZamkopo['payment_amount']) ?></p>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kiasi kilicholipwa</h5>
                            <p class="card-text"><?php if(! empty($jumla_kalipa) && is_array($jumla_kalipa)){
                                echo (isset($jumla_kalipa['num']))?$fun->format_currency($jumla_kalipa['num']):$fun->format_currency(0);
                            }else{
                                echo $fun->format_currency(0);
                            } ?></p>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Deni lililosalia</h5>
                            <p class="card-text"><?= $fun->format_currency($taarifaZamkopo['unpaid_amount']) ?></p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="my-2">
                <ul class="list-group list-group-horizontal-md">
                    <li class="list-group-item">Hali ya Mkopo <span class="badge badge-<?php
                        $num = (isset($jumla_kalipa['num']))?$jumla_kalipa['num']:0;
                        if($num = 0){
                            echo 'warning';
                        }elseif($taarifaZamkopo['payment_amount']-$num != 0 && $taarifaZamkopo['payment_amount'] != $num && $taarifaZamkopo['unpaid_amount'] != 0){
                            echo 'warning';
                        }elseif($taarifaZamkopo['payment_amount']-$num == 0 && $taarifaZamkopo['payment_amount'] == $num && $taarifaZamkopo['unpaid_amount'] == 0){
                            echo 'success';
                        }elseif(time()>$taarifaZamkopo['duration'] && $taarifaZamkopo['payment_amount']-$num != 0 && $taarifaZamkopo['payment_amount'] != $num && $taarifaZamkopo['unpaid_amount'] != 0){
                            echo 'danger';
                        } 
                    ?>">
                    <?php
                        $num = (isset($jumla_kalipa['num']))?$jumla_kalipa['num']:0;
                        if($num == 0){
                            echo "Malipo hayajafanyika";
                        }elseif($taarifaZamkopo['payment_amount']-$num != 0 && $taarifaZamkopo['payment_amount'] != $num && $taarifaZamkopo['unpaid_amount'] != 0){
                            echo "Malipo hayajamalizika";
                        }elseif($taarifaZamkopo['payment_amount']-$num == 0 && $taarifaZamkopo['payment_amount'] == $num && $taarifaZamkopo['unpaid_amount'] == 0){
                            echo "Malipo yamekamilika";
                        }elseif(time()>$taarifaZamkopo['duration'] && $taarifaZamkopo['payment_amount']-$num != 0 && $taarifaZamkopo['payment_amount'] != $num && $taarifaZamkopo['unpaid_amount'] != 0){
                            echo "Mkopo umepitilza muda wa malipo";
                            
                        } 
                    ?>
                    </span></li>
                    <li class="list-group-item">Riba iliyoupatikana: <?= $fun->format_currency($taarifaZamkopo['payment_amount']-$taarifaZamkopo['principal_amount']) ?></li>
                    <li class="list-group-item"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#invoiceModal"><i class="fa fa-eye"></i>Mali ya dhamana</button></li>
                </ul>

            </div>
            <div class="card right-profile-card">
                <div class="card-header alert-primary">
                    <h3>Historia ya malipo</h3>
                </div>
                <div class="card-body">
                    <div class="tile">
                        <h3 class="tile-title">Malipo</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Siku ya malipo</th>
                                        <th>kiasi kilicholipwa</th>
                                        <th>kiasi kilichobaki</th>
                                        <th>malipo yajayo</th>
                                        <th>Kitendo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>1000000000</td>
                                        <td>1000000000</td>
                                        <td>@mdo</td>
                                        <td>Otto</td>
                                        <td><button type="button" class="btn btn-primary" >Tazama Ankara</button></td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>1000000000</td>
                                        <td>1000000000</td>
                                        <td>@mdo</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- modal dhamana -->
                            <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Mali ya dhamana</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Mali:</strong> <?= $taarifaZamkopo['assets_name'] ?></p>
                                            <p><strong>Maelezo:</strong> <?= $taarifaZamkopo['asset_descriptions'] ?></p>
                                            <hr>
                                            <p>Picha ya mali</p>
                                            <img src="<?= $taarifaZamkopo['asset_image']?>" alt="pichayamali" width="100%" height="300px" style="object-fit: contain;">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
