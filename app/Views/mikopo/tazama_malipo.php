<?php 
use App\Controllers\Functions;
$fun = new Functions;
?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-file-text-o"></i> Ankara ya malipo</h1>
          <p>Historia ya malipo ya mkopo</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Invoice</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <section class="invoice">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header"><i class="fa fa-building-o"></i> <?= $microfinance['name'] ?></h2>
                </div>
                <div class="col-6">
                  <h5 class="text-right">Ankara ya malipo</h5>
                </div>
              </div>
              <div class="row invoice-info">
                <div class="col-4">Tawi la:
                  <address><strong><?= $microfinance['branch'] ?>.</strong><br><?= (isset($microfinance['postal_box']))?$microfinance['postal_box']:$microfinance['office_no'] ?><br><?= $microfinance['district']?><br><?= $microfinance['region']?></address>
                </div>
                <div class="col-4">Mteja
                  <address><strong><?= $mkopaji['full_name']." ".$mkopaji['middle_name']." ".$mkopaji['last_name'] ?></strong><br>NIDA: <?= $mkopaji['id_no'] ?><br><?= $mkopaji['region'] ?>, <?= $mkopaji['district'] ?><br>simu: <?= $mkopaji['phone'] ?><br>Email: <?= $mkopaji['email'] ?></address>
                </div>
                <div class="col-4"><b>Kumbukumbu ya Mkopo: MKP-0<?= $taarifaZamkopo['id'] ?></b><br><br><b>Deni kuu:</b> <?= $fun->format_currency($taarifaZamkopo['payment_amount']) ?><br><b>Mwisho wa kulipa:</b> <?= date("d/F/Y",$taarifaZamkopo['duration']) ?><br><b>Riba iliyopatikana:</b> <?= $fun->format_currency($taarifaZamkopo['payment_amount']-$taarifaZamkopo['principal_amount']) ?></div>
              </div>
              <div class="row">
                <div class="col-12 table-responsive">
                <?php if(! empty($malipo_ya_kopo) && is_array($malipo_ya_kopo)): ?>
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Kumbukumbu no.</th>
                        <th>Tarehe ya kulipa</th>
                        <th>Kisai kilichokopwa</th>
                        <th>Deni lilosalia</th>
                        <th>Katika Deni kuu</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach($malipo_ya_kopo as $malipo): ?>
                      <tr>
                        <td>MLP-0<?= $malipo['id'] ?></td>
                        <td><?= date("d/F/Y H:i A",strtotime($malipo['payment_date'])) ?></td>
                        <td><?= $fun->format_currency($malipo['payment_amount']) ?></td>
                        <td><?= $fun->format_currency($malipo['remaining_amount']) ?></td>
                        <td><?= $fun->format_currency($taarifaZamkopo['payment_amount']) ?></td>
                      </tr>
                      <?php endforeach ?>
                      
                    </tbody>
                  </table>
                <?php else: ?>
                    <p>Hakuna rekodi ya malipo</p>
                    <?php endif ?>
                </div>
              </div>
            </section>
          </div>
        </div>
</div>