<?php 
use App\Controllers\Functions;
use Mpdf\Tag\Em;

$fun = new Functions;
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
                                
                                <p class="font-13 text-light"><?php echo $mkopaji['refercence_no'].$mkopaji['id'] ?></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-right">
                                <button type="button" class="btn btn-light waves-effect"><i class="mdi mdi-account-settings-variant mr-1"></i> Hariri taarifa</button>
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
                        <p class=" ">Ndugu <?php echo strtoupper($mkopaji['full_name'])." ".strtoupper($mkopaji['middle_name'])." ".strtoupper($mkopaji['last_name'])." "." mkazi wa Mkoa wa".$mkopaji['region']." "." Wilaya ya ".$mkopaji['district']." Kata ya ".$mkopaji['ward']." Kijiji cha ".$mkopaji['village']." Mtaa wa ".$mkopaji['street']." Nyumba namba ".$mkopaji['house_no']  ?>  </p>
                        <hr>
                        <div class="text-left">
                            <p class=""><strong>Jina kamili : </strong> <span class="m-l-15"><?php echo strtoupper($mkopaji['full_name'])." ".strtoupper($mkopaji['middle_name'])." ".strtoupper($mkopaji['last_name'])?></span></p>
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
                        </div>
                        
                    </div>
                </div>
                <!-- Personal-Information -->
                <div class="card-box ribbon-box">
                    <div class="ribbon ribbon-primary">Wadhamini</div>
                    <div class="clearfix"></div>
                    <div class="inbox-widget">
                        <?php if(! empty($wadhmaini) && is_array($wadhmaini)): ?>
                            <?php foreach($wadhmaini as $mdhmaini): ?>                                                                            
                        <a href="#" style="text-decoration: none;">
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author"><?php echo $mdhmaini['full_name']." ".$mdhmaini['last_name'] ?></p>
                                <p class="inbox-item-text">Mkazi wa <?php echo $mdhmaini['region']?></p>
                                <p class="inbox-item-date">
                                    <button type="button" class="btn btn-icon btn-sm waves-effect waves-light btn-success">Tazama</button>
                                </p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <h3>Mtumiaji huyu hana mdhamini yeyote Bofya hapa kusajili mdhamini</h3>
                        <a href="#" class="btn btn-info"><i class="fa fa-user-plus"></i>Sajili mdhamini</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one"><i class="icon-layers float-right text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Mikopo ambayo haijalipwa</h6>
                            <h2 class="" data-plugin="counterup"><?php echo count($haijamalizka) ?></h2><span class="badge badge-custom">Deni </span><span class="text-muted"><?php 
                            
                            if(! empty($madeniyote) && is_array($madeniyote)){
                                $sum = 0;
                                foreach($madeniyote as $jumla){
                                    $sum = $sum + $jumla['unpaid_amount'];
                                }
                                echo $fun->format_currency($sum);
                            }else{

                                echo $fun->format_currency($sum= 0);
                            }
                            ?></span>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one"><i class="icon-paypal float-right text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Mikopo iliyopitiziza muda</h6>
                            <h2 class=""><span data-plugin="counterup"><?php echo count($mikopo_iliyopitilza) ?></span></h2><span class="badge badge-danger">Deni </span><span class="text-muted"><?php 
                            
                            if(! empty($mikopo_iliyopitilza) && is_array($mikopo_iliyopitilza)){
                                $sum = 0;
                                foreach($mikopo_iliyopitilza as $jumla){
                                    $sum = $sum + $jumla['unpaid_amount'];
                                }
                                echo $fun->format_currency($sum);
                            }else{
                                echo $fun->format_currency($sum);
                            }
                            ?></span>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one"><i class="icon-rocket float-right text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Mikopo iliyokamilishwa malipo</h6>
                            <h2 class="" data-plugin="counterup"><?php echo count($iliyomalizika) ?></h2><span class="badge badge-success">Faida </span><span class="text-muted"><?php 
                            
                            if(! empty($iliyomalizika) && is_array($iliyomalizika)){
                                $sumtake = 0;
                                $sumpay = 0;
                                foreach($iliyomalizika as $jumla){
                                    $sumtake = $sumtake + $jumla['principal_amount'];
                                   $sumpay = $sumpay + $jumla['payment_amount'];
                                }
                                $summ = $sumpay-$sumtake;
                                echo $fun->format_currency($summ);
                            }else{
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
                    <?php if(!empty($madeniyote) && is_array($madeniyote)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mkopaji</th>
                                    <th>Tarehe ya kuchukua</th>
                                    <th>Tarehe ya kurejesha</th>
                                    <th>Kiasi kilchochukuliwa</th>
                                    <th>Kiasi cha kulipwa</th>
                                    <th>Hali ya mkopo</th>
                                    <th>Kitendo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($madeniyote as $indexes=>$mikopoyote): ?>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $mkopaji['refercence_no'].$mikopoyote['client_id'] ?></td>
                                    <td><?php echo date("F d/Y",strtotime($mikopoyote['borrowing_date'])) ?></td>
                                    <td><?php echo date("F d/Y",$mikopoyote['duration']) ?></td>
                                    <td><?php echo $fun->format_currency($mikopoyote['principal_amount']) ?></td>
                                    <td><?php echo $fun->format_currency($mikopoyote['payment_amount']) ?></td>
                                    <td><span class="badge badge-<?php 
                                    if($mikopoyote['payment_amount']==$mikopoyote['unpaid_amount']){
                                        echo 'info';
                                    }elseif($mikopoyote['payment_amount'] - $mikopoyote['unpaid_amount'] != 0){
                                        echo 'warning';
                                    }elseif($mikopoyote['payment_amount'] - $mikopoyote['unpaid_amount'] == 0){
                                        echo 'success';
                                    }
                                    ?>">
                                    <?php 
                                    if($mikopoyote['payment_amount']==$mikopoyote['unpaid_amount']){
                                        echo "Haujalipwa";
                                    }elseif($mikopoyote['payment_amount'] - $mikopoyote['unpaid_amount'] != 0){
                                        echo "Haujamalizika";
                                    }elseif($mikopoyote['payment_amount'] - $mikopoyote['unpaid_amount'] == 0){
                                        echo "Umelipwa";
                                    }
                                    ?>
                                    </span></td>
                                    
                                    <td><div class="d-flex"><a href="/tazamamkopo/<?php echo urldecode(base64_encode($fun->encrypt($mikopoyote['id']))) ?>" class="btn btn-info"><i class="fa fa-eye"></i>Tazama</a></div></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <h4>Mtumiaji hanamkopo wowote kwa sasa <a href="/ongezamkopo/<?php echo urldecode(base64_encode($fun->encrypt($mkopaji['id']))) ?>" class="btn btn-success"><i class="fa fa-plus"></i>Wasilisha maombi ya mkopo</a> </h4>
                    <?php endif; ?>
                </div>
                
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- container -->
</div>