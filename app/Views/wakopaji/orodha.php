<?php

use App\Controllers\Functions;

$fun = new Functions;
?>
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
<div class="app-title">
    <div>
        <h1><i class="fa fa-users"></i> Orotha ya wakopaji wote</h1>
        <p>Wakopaji waliosajiliwa</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Wakopaji</li>
        <li class="breadcrumb-item"><a href="#">Orodha</a></li>
    </ul>
</div>
<div class="clearfix"></div>
<div class="col-md-12">
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
            <h3>Hakuna mkopaji yeyote aliyesajiliwa kwa sasa bonyeza hapa kusajili mpokaji mpya <a href="/ongezawakopaji" class="btn btn-primary"><i class="fa fa-user-plus"></i> Sajili</a></h3>

        <?php endif; ?>
    </div>
</div>
<script src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>
    <?php if(! empty($wakopaji) && is_array($wakopaji)) : ?>
    <script type="text/javascript">$('#wakopajitable').DataTable();</script>
    <?php endif ?>
      