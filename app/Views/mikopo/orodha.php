<?php 
use App\Controllers\Functions;
$fun = new Functions;
?>
</div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
                <?php if(! empty($mikopo) && is_array($mikopo)) : ?>
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>Jina la mteja</th>
                    <th>Kiasi alichokopa</th>
                    <th>Kiasi cha kurejesha</th>
                    <th>Tarehe ya kukopa</th>
                    <th>Hali ya malipo</th>
                    <th>Hali ya mkopo</th>
                    <th>Kitendo</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach($mikopo as $mikopo): ?>
                  <tr>
                    <td><?= $mikopo['full_name']." ".$fun->first_char($mikopo['middle_name']).". ".$mikopo['last_name'] ?></td>
                    <td><?= $fun->format_currency($mikopo['principal_amount']) ?></td>
                    <td><?= $fun->format_currency($mikopo['payment_amount']) ?></td>
                    <td><?= date("d/F/Y",strtotime($mikopo['borrowing_date'])) ?></td>
                    <td>
                    <span class="badge badge-<?php
                            if($mikopo['payment_amount'] == $mikopo['unpaid_amount']){
                                echo 'info';
                            }elseif($mikopo['payment_amount']-$mikopo['unpaid_amount']!= $mikopo['payment_amount']){
                                echo 'warning';
                            }elseif($mikopo['payment_amount']-$mikopo['unpaid_amount'] == $mikopo['payment_amount']){
                                echo 'success';
                            }
                        ?>">
                        <?php
                            if($mikopo['payment_amount'] == $mikopo['unpaid_amount']){
                                echo ($mikopo['application_status']=="Pending")?"umesubirishwa":"Haujalipwa";
                            }elseif($mikopo['payment_amount']-$mikopo['unpaid_amount']!= $mikopo['payment_amount']){
                                echo ($mikopo['application_status']=="Pending")?"umesubirishwa":"Malipo hayajamalizika";
                            }elseif($mikopo['payment_amount']-$mikopo['unpaid_amount'] == $mikopo['payment_amount']){
                                echo ($mikopo['application_status']=="Pending")?"umesubirishwa":"Umelipwa kikamilifu";
                            }
                        ?>
                    </span> 
                    </td>
                    <td><span class="badge badge-<?= ($mikopo['application_status']=="Pending")?'warning':'success' ?>"><?= ($mikopo['application_status']=="Pending")?"Umesubirishwa":"Umeidhinishwa" ?></span></td>
                    <td><a href="/tazamamkopo/<?php echo urldecode(base64_encode($fun->encrypt($mikopo['id']))) ?>" class="btn btn-info"><i class="fa fa-eye"></i>Tazama</a></td>
                  </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <?php else: ?>
                <p>Hakuna rekodi ya mkopo wowote kwa sasa</p>
                <?php endif ?>
            </div>
          </div>
        </div>
      </div>
      <script src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>
    <?php if(! empty($mikopo) && is_array($mikopo)) : ?>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <?php endif ?>
      