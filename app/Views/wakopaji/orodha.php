<?php 
use App\Controllers\Functions;
$fun = new Functions;
?>
<div class="clearfix"></div>
<div class="col-md-12">
    <div class="tile">
        <h3 class="tile-title">Orodha ya wakopaji</h3>
        <?php if(! empty($wakopaji) && is_array($wakopaji)): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>kitambulisho</th>
                        <th>Jina la kwanza</th>
                        <th>Jina la kati</th>
                        <th>Jina la Mwisho</th>
                        <th>Mkazi wa</th>
                        <th>Kitendo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($wakopaji as $indexs=>$mkopaji): ?>
                    <tr>
                        <td>1</td>
                        <td>M/C/0<?php echo $mkopaji['id'] ?></td>
                        <td><?php echo strtoupper($mkopaji['full_name']) ?></td>
                        <td><?php echo strtoupper($mkopaji['middle_name']) ?></td>
                        <td><?php echo strtoupper($mkopaji['last_name']) ?></td>
                        <td><?php echo $mkopaji['region'] ?></td>
                        <td><a href="<?php echo "/tazamamkopaji"."/".urlencode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" class="btn btn-primary"><i class="fa fa-eye"></i> Tazama</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <h3>Hakuna mkopaji yeyote aliyesajiliwa kwa sasa bonyeza hapa kusajili mpokaji mpya <a href="/ongezawakopaji" class="btn btn-primary"><i class="fa fa-user-plus"></i> Sajili</a></h3>

            <?php endif; ?>
    </div>
</div>