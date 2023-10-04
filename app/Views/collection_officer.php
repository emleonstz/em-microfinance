<?php 
use App\Controllers\Functions;
$fun  = new Functions;
?>
<link rel="stylesheet" href="<?php echo base_url('assets/custom/css/collectiondash.css') ?>">
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
        <a href="/ongezawakopaji" class="btn btn-success" type="button"><i class="fa fa-user-plus" aria-hidden="true"></i> Sajili Mkopaji</a>
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
                <a href="/maombiyanayosubiri" class="card-box-footer">Tazama zaidi <i class="fa fa-arrow-circle-right"></i></a>
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
    <div class="">
        <div class="tile">
            <h3 class="tile-title">Orodha ya wakopaji</h3>
            <?php if (!empty($wakopaji) && is_array($wakopaji)) : ?>
                <div class="table-responsive">
                    <table class="table" id="wakopajitable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>kitambulisho</th>
                                <th>Jina la kwanza</th>
                                <th>Jina la kati</th>
                                <th>Jina la Mwisho</th>
                                <th>Hali ya usajili</th>
                                <th>Kitendo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($wakopaji as $indexs => $mkopaji) : ?>
                                <tr>
                                    <td><?php $index = $indexs + 1;
                                        echo $index++ ?></td>
                                    <td><?php echo $mkopaji['refercence_no'] . $mkopaji['id'] ?></td>
                                    <td><?php echo strtoupper($mkopaji['full_name']) ?></td>
                                    <td><?php echo strtoupper($mkopaji['middle_name']) ?></td>
                                    <td><?php echo strtoupper($mkopaji['last_name']) ?></td>
                                    <td><?php if ($mkopaji['account_status']  == "Pending") :  ?>
                                            <span class="badge badge-warning">Haujakamilika</span>
                                        <?php elseif ($mkopaji['account_status']  == "Active") : ?>
                                            <span class="badge badge-success">Umekamilika</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger">Amezuiliwa</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><a href="<?php echo "/tazamamkopaji" . "/" . urlencode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" class="btn btn-primary"><i class="fa fa-eye"></i> Tazama</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <hp>Hakuna mkopaji yeyote aliyesajiliwa kwa sasa bonyeza hapa kusajili mpokaji mpya <a href="/ongezawakopaji" class="btn btn-primary"><i class="fa fa-user-plus"></i> Sajili</a></hp>

            <?php endif; ?>
        </div>
    </div>

</div>
<script src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>
    <?php if(! empty($wakopaji) && is_array($wakopaji)) : ?>
    <script type="text/javascript">$('#wakopajitable').DataTable();</script>
    <?php endif ?>