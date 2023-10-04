<?php

use App\Controllers\Functions;

$fun = new Functions;
$microfinance  = $fun->getMicrofinance();
helper('form');
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/custom/css/mikopotazama.css') ?>">
<script src="<?php echo base_url('assets/custom/js/mkopotazama.js') ?>"></script>
<div class="">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-user-plus"></i> Tazama Mkopo</h1>
            <p>Kumbukumbu ya mkopo: MKP-0<?= $taarifaZamkopo['id'] ?> </p>
        </div>
        <div>
            <?php if ($taarifaZamkopo['application_status'] == "Pending") : ?>
                <a href="/futamaombi/<?= urlencode(base64_encode($fun->encrypt($taarifaZamkopo['id']))) ?>" class="btn btn-danger "><i class="fa fa-trash"></i>Futa maombi haya</a>
                <a href="/baruayamaombi/<?= urlencode(base64_encode($fun->encrypt($taarifaZamkopo['id']))) ?>" class="btn btn-info "><i class="fa fa-print"></i>pakua barua ya mkopo</a>
                <?php if ($fun->getUserRole() == "mhasibu" || $fun->getUserRole() == "afisa_mkopo") : ?>
                    <a href="/baruayamaombi/<?= urlencode(base64_encode($fun->encrypt($taarifaZamkopo['id']))) ?>" class="btn btn-success "><i class="fa fa-check"></i>Thibitisha mkopo huu</a>
                <?php endif; ?>
            <?php else : ?>
                <?php if($taarifaZamkopo['payment_amount']-$taarifaZamkopo['unpaid_amount'] == $taarifaZamkopo['payment_amount']): ?>
                    <a href="/ongezamkopo/<?php echo urldecode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" class="btn btn-success"><i class="fa fa-plus"></i>Wasilisha maombi ya mkopo</a>
                    <?php  else: ?>
                <a href="/ratibamalipo/<?= urlencode(base64_encode($fun->encrypt($taarifaZamkopo['id']))) ?>" class="btn btn-info ">pakua ratiba ya malipo</a>
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#paymentModal">Lipa mkopo</button>
                <?php endif ?>
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
    <?php if ($taarifaZamkopo['application_status'] == "Pending") : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fa fa-exclamation-triangle"></i></strong> <?= "Mkopo huu umesubirishwa tafadhali pakua na wasilisha barua ya maobmi ya mkopo iliyosainiwa na mteja kwa afisa mikopo" ?>.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
    <?= validation_list_errors() ?>
    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Lipa Mkopo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if ($taarifaZamkopo['unpaid_amount'] != 0) : ?>
                        <form id="malipoform" method="post" action="/lipamkopo">
                            <?= validation_list_errors() ?>
                            <?= csrf_field() ?>
                            <!-- Visible Input: Kiasi cha malipo -->
                            <p class="text-info">* kulipa kwa awamu katika mkopo huu ni <?= $fun->format_currency($taarifaZamkopo['kiasi_kwa_awamu']) ?> kwa kila <?= $taarifaZamkopo['kulipa_kwa_kila']?></p>
                            
                            <div class="form-group my-3">
                                <label for="paymentAmount">Ingiza Kiasi anacholipa</label>
                                <input type="number" class="form-control" required id="paymentAmount" name="paymentAmount" placeholder="Ingiza kiasi chakulipa">
                            </div>
                            
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" name="nakubali" required type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">
                                        Mimi <?= session()->get('USER_FIRSTNAME') . " " . session()->get('USER_LASTNAME')  ?> Nime pokea Kiasi cha fedha tajwa hapo juu kama malipo ya deni la mkopo wa ndugu <?= $mkopaji['full_name'] . " " . $mkopaji['middle_name'] . " " . $mkopaji['last_name'] ?> mkopo namba MKP-0<?= $taarifaZamkopo['id'] ?>
                                    </label>
                                </div>
                            </div>
                            <div id="captcha-container" class="form-control">
                                <span id="captcha-text"></span>
                                <button type="button" class="btn btn-info btn-sm" onclick="generateCaptcha()"><i class="fa fa-refresh"></i></button>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control my-3" required id="captcha-input" placeholder="Ingiza CAPTCHA" />
                                <div class="invalid-feedback">CAPTCHA sio sahihi!</div>
                            </div>
                            <div class="form-group">
                                <label for="msimbo-input">Ingiza wa msimbo malipo</label>
                                <input type="text" class="form-control"  id="msimbo-input" name="msimbo" placeholder="Ingiza msimbo wa siri" autocomplete="off" />
                                <div class="invalid-feedback">msimbo siyo sahihi!</div>
                            </div>


                            <!-- Hidden Inputs -->
                            <input type="hidden" name="loanId" id="loanId" value="<?= base64_encode($fun->encrypt($taarifaZamkopo['id'])) ?>">
                            <input type="hidden" name="userId" id="userId" value="<?= base64_encode($fun->encrypt($mkopaji['id']) )?>">
                            <input type="hidden" name="remainingAmount" id="remainingAmount" value="<?= base64_encode($fun->encrypt($taarifaZamkopo['unpaid_amount'])) ?>">
                            <input type="hidden" name="microfinanceId" id="microfinanceId" value="<?= base64_encode($fun->encrypt($microfinance['id'])) ?>">

                            <button type="submit" class="btn btn-primary">Hifadhi</button>
                        </form>
                    <?php else : ?>
                        <h3 class="text-success"><i class="fa fa-check"></i> Malipo yamekamilika</h3>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 ">
            <div class="card left-profile-card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="<?= $mkopaji['pasport'] ?>" alt="" class="user-profile">
                        <h3><?= $mkopaji['full_name'] . " " . $mkopaji['middle_name'] . " " . $mkopaji['last_name'] ?></h3>
                        <p>Mkopaji</p>
                    </div>
                    <div class="personal-info">
                        <h3>Taarifa za Mkopo huu</h3>

                        <ul class="personal-list">
                            <li>Jumla Kiasi kilichokopwa: <br> <?= $fun->format_currency($taarifaZamkopo['principal_amount']) ?></li>
                            <hr>
                            <li>Jumla Kiasi cha kurejesha: <br><?= $fun->format_currency($taarifaZamkopo['payment_amount']) ?></li>
                            <hr>
                            <li>Tarehe ya kuchukua Mkopo: <br><?= date("F d/Y H:i A", strtotime($taarifaZamkopo['borrowing_date'])) ?></li>
                            <hr>
                            <li>Mwisho wa kurejesha: <br><?= date("F d/Y H:i A", $taarifaZamkopo['duration']) ?></li>
                            <hr>
                            <li>Mkopaji atalipa kiasi cha <?= $fun->format_currency($taarifaZamkopo['kiasi_kwa_awamu']) ?> <br> kila baada ya <?= $taarifaZamkopo['kulipa_kwa_kila'] ?> mara <?= $taarifaZamkopo['idadi_malipo'] ?> ndani ya miezi <?= $taarifaZamkopo['ndani_miezi'] ?> kutoka katika tarehe ya kuchukua <?= date("F d/Y H:i A", strtotime($taarifaZamkopo['borrowing_date'])) ?> mpaka tarehe ya mwisho wa malipo tarehe <?= date("F d/Y H:i A", $taarifaZamkopo['duration']) ?>.</li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-9">

            <div class="d-flex justify-content-end">
                <h5>Mwisho wa kulipa <?= date("F d/Y H:i A", $taarifaZamkopo['duration']) ?></h5>
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
                            <p class="card-text"><?php if (!empty($jumla_kalipa) && is_array($jumla_kalipa)) {
                                                        echo (isset($jumla_kalipa['num'])) ? $fun->format_currency($jumla_kalipa['num']) : $fun->format_currency(0);
                                                    } else {
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
                    <li class="list-group-item">Hali ya Mkopo
                        <span class="badge badge-<?php
                                                    $num = (isset($jumla_kalipa['num'])) ? $jumla_kalipa['num'] : 0;
                                                    if ($num == 0) {
                                                        echo "warning";
                                                    } elseif ($taarifaZamkopo['payment_amount'] - $num != 0 && $taarifaZamkopo['payment_amount'] != $num && $taarifaZamkopo['unpaid_amount'] != 0) {
                                                        echo "warning";
                                                    } elseif ($taarifaZamkopo['payment_amount'] - $num == 0 && $taarifaZamkopo['payment_amount'] == $num && $taarifaZamkopo['unpaid_amount'] == 0) {
                                                        echo "success";
                                                    } elseif (time() > $taarifaZamkopo['duration'] && $taarifaZamkopo['payment_amount'] - $num != 0 && $taarifaZamkopo['payment_amount'] != $num && $taarifaZamkopo['unpaid_amount'] != 0) {
                                                        echo "danger";
                                                    }
                                                    ?>">
                            <?php
                            $num = (isset($jumla_kalipa['num'])) ? $jumla_kalipa['num'] : 0;
                            if ($num == 0) {
                                echo "Malipo hayajafanyika";
                            } elseif ($taarifaZamkopo['payment_amount'] - $num != 0 && $taarifaZamkopo['payment_amount'] != $num && $taarifaZamkopo['unpaid_amount'] != 0) {
                                echo "Malipo hayajamalizika";
                            } elseif ($taarifaZamkopo['payment_amount'] - $num == 0 && $taarifaZamkopo['payment_amount'] == $num && $taarifaZamkopo['unpaid_amount'] == 0) {
                                echo "Malipo yamekamilika";
                            } elseif (time() > $taarifaZamkopo['duration'] && $taarifaZamkopo['payment_amount'] - $num != 0 && $taarifaZamkopo['payment_amount'] != $num && $taarifaZamkopo['unpaid_amount'] != 0) {
                                echo "Mkopo umepitilza muda wa malipo";
                            }
                            ?>
                        </span>
                    </li>
                    <li class="list-group-item">Riba iliyoupatikana: <?= $fun->format_currency($taarifaZamkopo['payment_amount'] - $taarifaZamkopo['principal_amount']) ?></li>
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
                            <?php if (!empty($malipo_ya_kopo) && is_array($malipo_ya_kopo)) :  ?>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Siku ya malipo</th>
                                            <th>kiasi kilicholipwa</th>
                                            <th>kiasi kilichobaki</th>
                                            <th>Kitendo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($malipo_ya_kopo as $index => $malipo) : ?>
                                            <tr>
                                                <td><?= $index += 1  ?></td>
                                                <td><?= date("d/F/Y", strtotime($malipo['payment_date'])) ?></td>
                                                <td><?= $fun->format_currency($malipo['payment_amount']) ?></td>
                                                <td><?= $fun->format_currency($malipo['remaining_amount']) ?></td>
                                                <td><a href="/tazamamalipo/<?= urlencode(base64_encode($fun->encrypt($taarifaZamkopo['id']))) ?>" type="button" class="btn btn-primary"><i class="fa fa-eye"></i>Tazama Ankara</a></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <p>hakuna rekodi ya malipo ya mkopo huu</p>
                            <?php endif ?>
                            <!-- modal dhamana -->

                        </div>
                    </div>
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
                                    <img src="<?= $taarifaZamkopo['asset_image'] ?>" alt="pichayamali" width="100%" height="300px" style="object-fit: contain;">
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