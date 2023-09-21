<?php

use App\Controllers\Functions;

$fun = new Functions;
helper('form')
?>
<style>
    .thumb-lg {
        height: 88px;
        width: 88px;
    }

    .profile-user-box {
        position: relative;
        border-radius: 5px
    }

    .bg-custom {
        background-color: #02c0ce !important;
    }

    .profile-user-box {
        position: relative;
        border-radius: 5px;
    }

    .card-box {
        padding: 20px;
        border-radius: 3px;
        margin-bottom: 30px;
        background-color: #fff;
    }

    .inbox-widget .inbox-item img {
        width: 40px;
    }

    .inbox-widget .inbox-item {
        border-bottom: 1px solid #f3f6f8;
        overflow: hidden;
        padding: 10px 0;
        position: relative
    }

    .inbox-widget .inbox-item .inbox-item-img {
        display: block;
        float: left;
        margin-right: 15px;
        width: 40px
    }

    .inbox-widget .inbox-item img {
        width: 40px
    }

    .inbox-widget .inbox-item .inbox-item-author {
        color: #313a46;
        display: block;
        margin: 0
    }

    .inbox-widget .inbox-item .inbox-item-text {
        color: #98a6ad;
        display: block;
        font-size: 14px;
        margin: 0
    }

    .inbox-widget .inbox-item .inbox-item-date {
        color: #98a6ad;
        font-size: 11px;
        position: absolute;
        right: 7px;
        top: 12px
    }

    .comment-list .comment-box-item {
        position: relative
    }

    .comment-list .comment-box-item .commnet-item-date {
        color: #98a6ad;
        font-size: 11px;
        position: absolute;
        right: 7px;
        top: 2px
    }

    .comment-list .comment-box-item .commnet-item-msg {
        color: #313a46;
        display: block;
        margin: 10px 0;
        font-weight: 400;
        font-size: 15px;
        line-height: 24px
    }

    .comment-list .comment-box-item .commnet-item-user {
        color: #98a6ad;
        display: block;
        font-size: 14px;
        margin: 0
    }

    .comment-list a+a {
        margin-top: 15px;
        display: block
    }

    .ribbon-box .ribbon-primary {
        background: #2d7bf4;
    }

    .ribbon-box .ribbon {
        position: relative;
        float: left;
        clear: both;
        padding: 5px 12px 5px 12px;
        margin-left: -30px;
        margin-bottom: 15px;
        font-family: Rubik, sans-serif;
        -webkit-box-shadow: 2px 5px 10px rgba(49, 58, 70, .15);
        -o-box-shadow: 2px 5px 10px rgba(49, 58, 70, .15);
        box-shadow: 2px 5px 10px rgba(49, 58, 70, .15);
        color: #fff;
        font-size: 13px;
    }

    .text-custom {
        color: #02c0ce !important;
    }

    .badge-custom {
        background: #02c0ce;
        color: #fff;
    }

    .badge {
        font-family: Rubik, sans-serif;
        -webkit-box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
        box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
        padding: .35em .5em;
        font-weight: 500;
    }

    .text-muted {
        color: #98a6ad !important;
    }

    .font-13 {
        font-size: 13px !important;
    }
</style>
<div class="content">
    <div class="container">
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
        <?= validation_list_errors() ?>
        <?php if (isset($mkopaji['account_status']) && $mkopaji['account_status'] == "Pending") : ?>
            <?php if (!count($wadhmaini) < 1) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-exclamation-triangle"></i></strong> <?= "Mkopaji " . strtoupper($mkopaji['full_name']) . " " . strtoupper($mkopaji['middle_name']) . " " . strtoupper($mkopaji['last_name']) . " hajaidhinishwa. Hawezi kupewa mkopo kwa sababu mkataba wake haujawasilishwa. Tafadhali wasilisha mkataba uliosainiwa  kwa Afisa mikopo " ?>.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php else : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-exclamation-triangle"></i></strong> <?= "Mkopaji huyu hanamdhani. Tafadhali sajili mdhami iilikuendelea " ?>.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif ?>
        <?php elseif (isset($mkopaji['account_status']) && $mkopaji['account_status'] == "Blocked") : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fa fa-exclamation-triangle"></i></strong> <?= "Mkopaji huyu Amezuiliwa kutumia hudumazetu " ?>.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php elseif (isset($mkopaji['account_status']) && $mkopaji['account_status'] == "Blocked") : ?>
        <?php else : ?>
        <?php endif ?>
        <div class="row">
            <div class="col-sm-12">
                <!-- meta -->

                <div class="profile-user-box card-box bg-custom">
                    <div class="row">
                        <div class="col-sm-6"><span class="float-left mr-3"><img src="<?php echo $mkopaji['pasport'] ?>" alt="" class="thumb-lg rounded"></span>
                            <div class="media-body text-white">
                                <h4 class="mt-1 mb-1 font-18"><?php echo $mkopaji['full_name'] ?> <?php function first_char(string $str)
                                                                                                    {
                                                                                                        return $str[0];
                                                                                                    }
                                                                                                    echo ucfirst(first_char($mkopaji['middle_name'])) . ". " . $mkopaji['last_name'] ?></h4>

                                <p class="font-13 text-light"><?php echo $mkopaji['refercence_no'] . $mkopaji['id'] ?></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-right">
                                <?php if (!count($wadhmaini) < 1) : ?>
                                    <?php if ($mkopaji['account_status'] == "Pending") : ?>
                                        <a href="/pakuamkataba/<?php echo urldecode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" class="btn btn-success waves-effect"><i class="fa fa-download"></i> Pakua Mkataba</a>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#mdhaminEditiModal">Hariri Mdhamini</button>
                                        <a href="/haririwakopaji/<?= urlencode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" type="button" class="btn btn-light waves-effect"><i class="fa fa-pencil"></i> Hariri taarifa</a>
                                    <?php elseif ($mkopaji['account_status'] == "Active") : ?>
                                        <?php if (count($madeniyote) < 1) : ?>
                                            <!--hadaiwi button ya kuomba-->
                                            <a href="/ongezamkopo/<?php echo urldecode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" class="btn btn-success"><i class="fa fa-plus"></i>Wasilisha maombi ya mkopo</a>
                                        <?php else : ?>
                                            <!--anadaiwa button ya kulipa-->
                                            <a href="/lipamkopo/<?php echo urldecode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" class="btn btn-success"><i class="fa fa-plus"></i>Lipa mkopo</a>
                                        <?php endif ?>
                                    <?php else : ?>
                                        <button class="btn btn-danger" disabled="disabled"><i class="fa fa-ban"></i> Mtumiaji amezuiliwa kutumia huduma zetu.</button>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdhaminOngezaModal">Sajili Mdhamini</button>
                                    <a href="/haririwakopaji/<?= urlencode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" type="button" class="btn btn-light waves-effect"><i class="fa fa-pencil"></i> Hariri taarifa</a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!--/ meta -->
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-4">
                <!-- Personal-Information -->
                <div class="card-box">
                    <h4 class="header-title mt-0">Taarifa binafi</h4>
                    <div class="panel-body">
                        <p class=" ">Ndugu <?php echo strtoupper($mkopaji['full_name']) . " " . strtoupper($mkopaji['middle_name']) . " " . strtoupper($mkopaji['last_name']) . " " . " mkazi wa Mkoa wa" . $mkopaji['region'] . " " . " Wilaya ya " . $mkopaji['district'] . " Kata ya " . $mkopaji['ward'] . " Kijiji cha " . $mkopaji['village'] . " Mtaa wa " . $mkopaji['street'] . " Nyumba namba " . $mkopaji['house_no']  ?> </p>
                        <hr>
                        <div class="text-left">
                            <p class=""><strong>Jina kamili : </strong> <span class="m-l-15"><?php echo strtoupper($mkopaji['full_name']) . " " . strtoupper($mkopaji['middle_name']) . " " . strtoupper($mkopaji['last_name']) ?></span></p>
                            <p class=""><strong>Jinsia : </strong><span class="m-l-15"><?php echo $mkopaji['gender'] ?></span></p>
                            <p class=""><strong>Utaifa : </strong><span class="m-l-15"><?php echo $mkopaji['nationality'] ?></span></p>
                            <p class=""><strong>Kabila : </strong><span class="m-l-15"><?php echo $mkopaji['tribe'] ?></span></p>
                            <p class=""><strong>Namba ya simu : </strong><span class="m-l-15"><?php echo $mkopaji['phone'] ?></span></p>
                            <p class=""><strong>Barudapepe : </strong> <span class="m-l-15"><?php echo $mkopaji['email'] ?></span></p>
                            <p class=""><strong>Ania ya kazi : </strong> <span class="m-l-15"><?php echo $mkopaji['type_ofwork'] ?></span></p>
                            <p class=""><strong>Kazi : </strong> <span class="m-l-15"><?php echo $mkopaji['occupation'] ?></span></p>
                            <p class=""><strong>Sehemu ya kazi : </strong> <span class="m-l-15"><?php echo $mkopaji['sehemu_yakazi'] ?></span></p>
                            <p class=""><strong>Aina ya kitambulisho : </strong> <span class="m-l-15"><?php echo $mkopaji['idcard_type'] ?></span></p>
                            <p class=""><strong>Namba ya kitambulisho : </strong> <span class="m-l-15"><?php echo $mkopaji['id_no'] ?></span></p>
                            <p class="font-13"><strong>Maelezo binafsi : </strong> <span class="m-l-5"><?php echo $mkopaji['maelezobinafsi'] ?></span></span>
                            </p>

                            <!-- ongeza mdhamini-->
                            <div class="modal fade" id="mdhaminOngezaModal" tabindex="-1" role="dialog" aria-labelledby="mdhaminOngezaModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Sajili mdhamni wa <?= ucfirst($mkopaji['full_name']) . " " . ucfirst($mkopaji['middle_name']) . " " . ucfirst($mkopaji['last_name']) ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="/hifadhimdhamin" method="post">
                                                <?= session()->getFlashdata('error') ?>
                                                <?= validation_list_errors() ?>
                                                <?= csrf_field() ?>

                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Jina la kwanza</label>
                                                    <input class="form-control" required id="jina-lakwanza" name="jina_lakwanza" type="text" placeholder="Ingiza jina la kwana">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Jina la kati na la mwisho</label>
                                                    <input class="form-control" required id="jina-lakwanza" name="jina_kati_miwsha" type="text" placeholder="Andika jina la kati na la mwisha">
                                                </div>
                                                <div class="form-group">
                                                    <fieldset>
                                                        <label for="exampleSelect1">Jinsia</label>
                                                        <select class="form-control" required name="jinsia" id="exampleSelect1">
                                                            <option value="Mwanaume">Mwanaume</option>
                                                            <option value="Mwanamke">Mwanamke</option>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group">
                                                    <fieldset>
                                                        <label class="control-label" for="disabledInput">Utaifa</label>
                                                        <input class="form-control" required name="utaifa" id="disabledInput" type="text" value="Mtanzania" placeholder="Andika utaifa">
                                                    </fieldset>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Mkoa Anaoishi</label>
                                                    <input class="form-control" required id="jina-lakwanza" name="mkoa" type="text" placeholder="Andika Mkoa">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Wilaya Anayoishi</label>
                                                    <input class="form-control" required id="jina-lakwanza" name="wilaya" type="text" placeholder="Andika Wilaya">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Kata Anayoishi</label>
                                                    <input class="form-control" required id="jina-lakwanza" name="kata" type="text" placeholder="Ingiza kata">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Kijiji Anachoishi</label>
                                                    <input class="form-control" required id="jina-lakwanza" name="kijiji" type="text" placeholder="Ingiza kijiji">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Simu</label>
                                                    <input class="form-control" required name="simu" id="exampleInputTell" type="tel" aria-describedby="emailHelp" placeholder="Weka namba ya simu">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Baruapepe</label>
                                                    <input class="form-control" required name="email" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Weka baruapepe">
                                                </div>
                                                <input type="text" hidden name="mkopajiid" required value="<?php echo base64_encode($fun->encrypt($mkopaji['id'])) ?>" id="clientid">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
                                            <button type="submit" class="btn btn-primary">Hifadhi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- Personal-Information -->
                <div class="card-box ribbon-box">
                    <div class="ribbon ribbon-primary">Wadhamini</div>
                    <div class="clearfix"></div>
                    <div class="inbox-widget">
                        <?php if (!empty($wadhmaini) && is_array($wadhmaini)) : ?>
                            <?php foreach ($wadhmaini as $mdhmaini) : ?>
                                <a href="#" style="text-decoration: none;">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"><img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="rounded-circle" alt=""></div>
                                        <p class="inbox-item-author"><?php echo $mdhmaini['full_name'] . " " . $mdhmaini['last_name'] ?></p>
                                        <p class="inbox-item-text">Mkazi wa <?php echo $mdhmaini['region'] ?></p>
                                        <p class="inbox-item-date">
                                            <button type="button" class="btn btn-icon btn-sm waves-effect waves-light btn-success" data-toggle="modal" data-target="#mdhaminTazamaModal">Tazama</button>
                                        </p>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                            <!--tazama Mdhamini-->
                            <div class="modal fade" id="mdhaminTazamaModal" tabindex="-1" role="dialog" aria-labelledby="mdhaminTazamaModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Mdhamni wa <?= ucfirst($mkopaji['full_name']) . " " . ucfirst($mkopaji['middle_name']) . " " . ucfirst($mkopaji['last_name']) ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <p><strong>Jina kamili: </strong> <?= $wadhmaini[0]['full_name'] . " " . $wadhmaini[0]['last_name']  ?></p>
                                            <p><strong>Jinsia: </strong> <?= $wadhmaini[0]['gender']  ?></p>
                                            <p><strong>Utaifa: </strong> <?= $wadhmaini[0]['nationality']  ?></p>
                                            <p><u>Taarifa ya makazi</u></p>
                                            <table class="table  table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Mkoa</th>
                                                        <th>Wilaya</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?= $wadhmaini[0]['region']  ?></td>
                                                        <td><?= $wadhmaini[0]['ward']  ?></td>
                                                    </tr>

                                                </tbody>
                                                <thead>
                                                    <tr>
                                                        <th>Kata</th>
                                                        <th>Kijiji</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?= $wadhmaini[0]['ward']  ?></td>
                                                        <td><?= $wadhmaini[0]['village']  ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <p><u>Mawasiliano</u></p>
                                            <p><strong>Simu: </strong> <?= $wadhmaini[0]['phone']  ?></p>
                                            <p><strong>Baruapepe: </strong> <?= $wadhmaini[0]['email']  ?></p>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="submit" class="btn btn-primary">Tuma SMS</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit Mdhamini-->
                            <div class="modal fade" id="mdhaminEditiModal" tabindex="-1" role="dialog" aria-labelledby="mdhaminEditiModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Hariri mdhamni wa <?= ucfirst($mkopaji['full_name']) . " " . ucfirst($mkopaji['middle_name']) . " " . ucfirst($mkopaji['last_name']) ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="/haririmdhamin" method="post">
                                                <?= session()->getFlashdata('error') ?>
                                                <?= validation_list_errors() ?>
                                                <?= csrf_field() ?>

                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Jina la kwanza</label>
                                                    <input class="form-control" required id="jina-lakwanza" value="<?= esc($wadhmaini[0]['full_name']) ?>" name="jina_lakwanza" type="text" placeholder="Ingiza jina la kwana">
                                                </div>
                                                <input type="text" hidden name="mdhaminiid" value="<?php echo base64_encode($fun->encrypt($wadhmaini[0]['id'])) ?>" id="mdhaminiid">
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Jina la kati na la mwisho</label>
                                                    <input class="form-control" required id="jina-lakwanza" value="<?= esc($wadhmaini[0]['last_name']) ?>" name="jina_kati_miwsha" type="text" placeholder="Andika jina la kati na la mwisha">
                                                </div>
                                                <div class="form-group">
                                                    <fieldset>
                                                        <label for="exampleSelect1">Jinsia</label>
                                                        <select class="form-control" required name="jinsia" id="exampleSelect1">
                                                            <option value="Mwanaume" <?php echo ($wadhmaini[0]['gender'] == "Mwanaume") ? 'selected' : '' ?>>Mwanaume</option>
                                                            <option value="Mwanamke" <?php echo ($wadhmaini[0]['gender'] == "Mwanamke") ? 'selected' : '' ?>>Mwanamke</option>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group">
                                                    <fieldset>
                                                        <label class="control-label" for="disabledInput">Utaifa</label>
                                                        <input class="form-control" required value="<?= esc($wadhmaini[0]['nationality']) ?>" name="utaifa" id="disabledInput" type="text" value="Mtanzania" placeholder="Andika utaifa">
                                                    </fieldset>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Mkoa Anaoishi</label>
                                                    <input class="form-control" required id="jina-lakwanza" value="<?= esc($wadhmaini[0]['region']) ?>" name="mkoa" type="text" placeholder="Andika Mkoa">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Wilaya Anayoishi</label>
                                                    <input class="form-control" required id="jina-lakwanza" value="<?= esc($wadhmaini[0]['district']) ?>" name="wilaya" type="text" placeholder="Andika Wilaya">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Kata Anayoishi</label>
                                                    <input class="form-control" required id="jina-lakwanza" value="<?= esc($wadhmaini[0]['ward']) ?>" name="kata" type="text" placeholder="Ingiza kata">
                                                </div>
                                                <div class="form-group">
                                                    <label for="jina-lakwanza">Kijiji Anachoishi</label>
                                                    <input class="form-control" required id="jina-lakwanza" value="<?= esc($wadhmaini[0]['village']) ?>" name="kijiji" type="text" placeholder="Ingiza kijiji">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Simu</label>
                                                    <input class="form-control" required name="simu" id="exampleInputTell" value="<?= esc($wadhmaini[0]['phone']) ?>" type="tel" aria-describedby="emailHelp" placeholder="Weka namba ya simu">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Baruapepe</label>
                                                    <input class="form-control" required name="email" value="<?= esc($wadhmaini[0]['email']) ?>" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Weka baruapepe">
                                                </div>
                                                <input type="text" hidden name="mkopajiid" required value="<?php echo base64_encode($fun->encrypt($mkopaji['id'])) ?>" id="clientid">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
                                            <button type="submit" class="btn btn-primary">Hifadhi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <h3>Mtumiaji huyu hana mdhamini yeyote Bofya hapa kusajili mdhamini</h3>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdhaminOngezaModal">Sajili Mdhamini</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one"><i class="icon-layers float-right text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Idadi ya Mikopo ambayo haijalipwa</h6>
                            <h2 class="" data-plugin="counterup"><?php echo count($haijamalizka) ?></h2><span class="badge badge-custom">Deni </span><span class="text-muted"><?php

                                                                                                                                                                                if (!empty($madeniyote) && is_array($madeniyote)) {
                                                                                                                                                                                    $sum = 0;
                                                                                                                                                                                    foreach ($madeniyote as $jumla) {
                                                                                                                                                                                        $sum = $sum + $jumla['unpaid_amount'];
                                                                                                                                                                                    }
                                                                                                                                                                                    echo $fun->format_currency($sum);
                                                                                                                                                                                } else {

                                                                                                                                                                                    echo $fun->format_currency($sum = 0);
                                                                                                                                                                                }
                                                                                                                                                                                ?></span>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one"><i class="icon-paypal float-right text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Idadi ya Mikopo iliyopitiziza muda</h6>
                            <h2 class=""><span data-plugin="counterup"><?php echo count($mikopo_iliyopitilza) ?></span></h2><span class="badge badge-danger">Deni </span><span class="text-muted"><?php

                                                                                                                                                                                                    if (!empty($mikopo_iliyopitilza) && is_array($mikopo_iliyopitilza)) {
                                                                                                                                                                                                        $sum = 0;
                                                                                                                                                                                                        foreach ($mikopo_iliyopitilza as $jumla) {
                                                                                                                                                                                                            $sum = $sum + $jumla['unpaid_amount'];
                                                                                                                                                                                                        }
                                                                                                                                                                                                        echo $fun->format_currency($sum);
                                                                                                                                                                                                    } else {
                                                                                                                                                                                                        echo $fun->format_currency($sum);
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?></span>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one"><i class="icon-rocket float-right text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Idadi ya mikopo iliyolipwa</h6>
                            <h2 class="" data-plugin="counterup"><?php echo count($iliyomalizika) ?></h2><span class="badge badge-success">Faida </span><span class="text-muted"><?php

                                                                                                                                                                                    if (!empty($iliyomalizika) && is_array($iliyomalizika)) {
                                                                                                                                                                                        $sumtake = 0;
                                                                                                                                                                                        $sumpay = 0;
                                                                                                                                                                                        foreach ($iliyomalizika as $jumla) {
                                                                                                                                                                                            $sumtake = $sumtake + $jumla['principal_amount'];
                                                                                                                                                                                            $sumpay = $sumpay + $jumla['payment_amount'];
                                                                                                                                                                                        }
                                                                                                                                                                                        $summ = $sumpay - $sumtake;
                                                                                                                                                                                        echo $fun->format_currency($summ);
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo $fun->format_currency($sum);
                                                                                                                                                                                    }
                                                                                                                                                                                    ?></span>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
                <div class="card-box">
                    <h4 class="header-title mb-3">Mikopo</h4>
                    <?php if (!empty($madeniyote) && is_array($madeniyote)) : ?>
                        <div class="table-responsive">
                            <table class="table" id="mikopotable">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        <th>Tarehe ya kuchukua</th>
                                        <th>Tarehe ya kurejesha</th>
                                        <th>Kiasi kilchochukuliwa</th>
                                        <th>Kiasi cha kulipwa</th>
                                        <th>Hali ya mkopo</th>
                                        <th>Kitendo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($madeniyote as $indexes => $mikopoyote) : ?>
                                        <tr>
                                            <td><?php $index = $indexes + 1;
                                                echo $index++ ?></td>

                                            <td><?php echo date("F d/Y", strtotime($mikopoyote['borrowing_date'])) ?></td>
                                            <td><?php echo date("F d/Y", $mikopoyote['duration']) ?></td>
                                            <td><?php echo $fun->format_currency($mikopoyote['principal_amount']) ?></td>
                                            <td><?php echo $fun->format_currency($mikopoyote['payment_amount']) ?></td>
                                            <td><span class="badge badge-<?php
                                                                            if ($mikopoyote['payment_amount'] == $mikopoyote['unpaid_amount']) {
                                                                                echo 'info';
                                                                            } elseif ($mikopoyote['payment_amount'] - $mikopoyote['unpaid_amount'] != 0) {
                                                                                echo 'warning';
                                                                            } elseif ($mikopoyote['payment_amount'] - $mikopoyote['unpaid_amount'] == 0) {
                                                                                echo 'success';
                                                                            }
                                                                            ?>">
                                                    <?php
                                                    if ($mikopoyote['payment_amount'] == $mikopoyote['unpaid_amount']) {
                                                        echo "Haujalipwa";
                                                    } elseif ($mikopoyote['payment_amount'] - $mikopoyote['unpaid_amount'] != 0) {
                                                        echo "Haujamalizika";
                                                    } elseif ($mikopoyote['payment_amount'] - $mikopoyote['unpaid_amount'] == 0) {
                                                        echo "Umelipwa";
                                                    }
                                                    ?>
                                                </span></td>

                                            <td>
                                                <a href="/tazamamkopo/<?php echo urldecode(base64_encode($fun->encrypt($mikopoyote['id']))) ?>" class="btn btn-info"><i class="fa fa-eye"></i>Tazama</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <h4>Mtumiaji hanamkopo wowote kwa sasa <a href="/ongezamkopo/<?= urldecode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" class="btn btn-success"><i class="fa fa-plus"></i>Wasilisha maombi ya mkopo</a> </h4>
                    <?php endif; ?>
                </div>

            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- container -->
</div>
<script src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>
    <?php if(! empty($madeniyote) && is_array($madeniyote)) : ?>
    <script type="text/javascript">$('#mikopotable').DataTable();</script>
    <?php endif ?>
