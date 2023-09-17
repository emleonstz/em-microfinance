<?php

use App\Controllers\Functions;

$fun = new Functions;

?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-user-plus"></i> Maombi ya Mkopo</h1>
        <p>Tafadahli Weka taarifa za mkopaji kwa usahihi</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Mikopo</li>
        <li class="breadcrumb-item"><a href="#">Maombi</a></li>
    </ul>
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
    <div class="col-md-12">
        <div class="tile">
            <div class="row">
                <div class="col-lg-6">
                    <?php helper('form') ?>
                    <form method="post" id="fomu" action="/ombamkopo" enctype="multipart/form-data">
                        <?= session()->getFlashdata('error') ?>
                        <?= validation_list_errors() ?>
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="jina-lakwanza">Jina la kwanza</label>
                            <input disabled class="form-control" required id="jina-lakwanza" value="<?= esc($mkopaji['full_name']) ?>" name="jina-lakwanza" type="text" placeholder="Weka jina la kwanza">
                        </div>
                        <input type="text" hidden name="mkopajiid" value="<?= base64_encode($fun->encrypt($mkopaji['id'])) ?>">
                        <div class="form-group">
                            <label for="jina-lakwanza">Jina la Kati</label>
                            <input disabled class="form-control" required id="jina-lakwanza" value="<?= esc($mkopaji['middle_name']) ?>" name="jina-lakati" type="text" placeholder="Weka jina la kati">
                        </div>
                        <div class="form-group">
                            <label for="jina-lakwanza">Jina la mwisho</label>
                            <input disabled class="form-control" required id="jina-lakwanza" value="<?= esc($mkopaji['last_name']) ?>" name="jinalamwisho" type="text" placeholder="Weka jina la whisho">
                        </div>
                        <div class="form-group">
                            <label for="kiasi-kukopa">Kiasi Anachokopa</label>
                            <input class="form-control" required id="kiasi-kukopa" name="kiasi_chakukopa" type="number" placeholder="Weka kiasi cha kukopa">
                        </div>
                        <div class="form-group">
                            <label for="jina-lakwanza">Jumla kiasi kinachotakiwa kurejeshwa</label>
                            <input class="form-control" required id="kulipa-jumla" name="kiasi_kulipa_jumla" type="number" placeholder="Jumla kiasi cha kurejesha">
                        </div>
                        <div class="form-group">
                            <label id="idadimuda" for="idadi-ya-muda"></label>
                            <input class="form-control" required id="idadi-muda" name="idadi_ya_muda" type="number" placeholder="Mkopo ulipwe ndani ya miezi">
                        </div>
                        <div class="form-group">
                            <label for="ainaYaMuda">Malipo yafanyike kwa kila: </label>
                            <select class="form-control" id="ainaYaMuda" name="ainaYaMuda">
                                <option value="Wiki">Wiki</option>
                                <option value="Mwezi">Mwezi</option>
                            </select>
                        </div>
                        <div id="wikii" class="form-group">
                            <label for="lipa-wiki">Kiasi Cha kulipa kila wiki</label>
                            <input class="form-control" id="lipa-wiki" name="kiasi_kulipa_wiki" type="number" placeholder="Weka kiasi cha kulipa kwa wiki">
                        </div>
                        <div id="mwezii" class="form-group">
                            <label for="lipa-mwezi">Kiasi Cha kulipa kila mwezi</label>
                            <input class="form-control" id="lipa-mwezi" name="kiasi_kulipa_mwezi" type="number" placeholder="Weka kiasi cha kulipa kwa mwezi">
                        </div>
                        <div class="form-group">
                            <label for="jina-lakwanza">Riba (%)</label>
                            <input class="form-control" required id="jina-riba" name="riba" type="number" placeholder="kiasi cha riba kwa aslimia">
                        </div>
                        <div class="form-group">
                            <label for="tareheYaKuanza">Tarehe ya Kuchukua mkopo</label>
                            <input type="date" min="<?= date("Y-m-d") ?>" value="<?= date("Y-m-d") ?>" class="form-control" id="tareheYaKuanza" name="tareheYaKuanza" required>
                        </div>
                        <div class="form-group">
                            <label for="tareheYaKuanzakulipa">Tarehe ya kuanza kurejesha mkopo</label>
                            <input type="date" min="<?= date("Y-m-d") ?>" class="form-control" id="tareheYaKuanzakulipa" name="tareheYaKuanzakulipa" required>
                        </div>
                        <div class="form-group">
                            <label for="jina-lakwanza">Mali ya dhamana</label>
                            <input class="form-control" required id="jina-mali-dhamana" name="mali_yadhamna" type="text" placeholder="Weka jina / Aina ya mali ya dhamana">
                        </div>
                        <div class="form-group">
                            <label for="jina-lakwanza">Malezo ya mali ya dhamana</label>
                            <textarea name="maelezo_ya_mali" cols="10" rows="8" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                  <label class="control-label">Pakia picha ya mali ya dhamana</label>
                  <input class="form-control" required accept="image/*" name="picha_ya_mali" type="file">
                </div>

                </div>

            </div>
            <div class="tile-footer">
                <button class="btn btn-primary" type="submit">Hifadhi</button>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="position-fixed" style="bottom: 10px; right: 10px;">
    <div class="card" style="width: 18rem;">
        <div class="card-header d-flex justify-content-between">
            <a href="javascript.void(0)" data-toggle="collapse" style="text-decoration: none;" data-target="#loanCardBody" aria-expanded="true">
                <h5 class="card-title mb-0">Kikokotoo cha Mkopo <i id="toggleIcon" class="fa fa-chevron-down"></i></h5>

        </div>
        </a>
        <div id="loanCardBody" class="card-body collapse show">
            <form id="loanCalculatorForm">
                <?= csrf_field() ?>
                <div class="form-group">

                    <input type="number" placeholder="kiasi cha kukopa" class="form-control" id="kiasiz" name="kiasi" required>
                </div>
                <div class="form-group">
                    <label for="ribaYaMwakaz">Riba (%)</label>
                    <input type="number" placeholder="Riba" class="form-control" id="ribaYaMwakaz" name="ribaYaMwaka" required>
                </div>
                <div class="form-group">
                    <label for="ainaYaMuda">Aina ya Muda</label>
                    <select class="form-control" id="ainaYaMuda" name="ainaYaMuda">
                        <option value="mwezi">Miezi</option>
                        <option value="mwaka">Mwaka</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" placeholder="Muda" class="form-control" id="mudaz" name="muda" required>
                </div>

                <div class="form-group">
                    <label for="tareheYaKuanza">Tarehe ya Kuanza</label>
                    <input type="date" min="<?= date("Y-m-d") ?>" value="<?= date("Y-m-d") ?>" class="form-control" id="tareheYaKuanza" name="tareheYaKuanza" required>
                </div>
                <button type="submit" class="btn btn-primary">Hesabu</button>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="kalkuletorModal" tabindex="-1" role="dialog" aria-labelledby="kalkuletorModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Kikokotoo cha mkopo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Malipo kwa kila wiki: </strong> <span id="lipawiki">0</span></p>
                <p><strong>Malipo kwa kila mwezi: </strong> <span id="lipamwezi">0</span></p>
                <p><strong>Malipo kwa ujumla: </strong> <span id="lipakwaujumla">0</span></p>
                <p><strong>Riba: </strong> <span id="riba">0</span></p>
                <p><strong>Tarehe ya kuanza kurejesha kwa kila wiki: </strong> <span id="terehelipawiki">0</span></p>
                <p><strong>Tarehe ya kuanza kurejesha kwa kila mwezi: </strong> <span id="terehelipamwezi">0</span></p>
                <p><strong>Mwisho wa kulipa: </strong> <span id="terehemisho">0</span></p>
            </div>
            <div class="modal-footer">
                <button id="pakia" type="submit" class="btn btn-primary">Pakia katika fomu</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>

            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('ajax_loading/ajax-loading.js') ?>"></script>


<script>
    var malipoKwakilaWik = 0;
    var malipokwakilaMwezi = 0;
    var malipokwaUjumla = 0;
    var riba = 0;
    var mwishoWaKulipa = 0;
    $(document).ready(function() {
        // Function to toggle visibility
        function toggleVisibility() {
            let selection = $('#ainaYaMuda').val();

            if (selection == 'Wiki') {

                $("#idadimuda").text("Ndani ya miezi");
                $('#lipa-wiki').closest('.form-group').show();
                $('#lipa-mwezi').closest('.form-group').hide();

            } else if (selection == 'Mwezi') {
                $("#idadimuda").text("Ndani ya miezi");
                $('#lipa-wiki').closest('.form-group').hide();
                $('#lipa-mwezi').closest('.form-group').show();
            }
        }

        // Initial toggle
        toggleVisibility();

        // Listen for changes on the select element
        $('#ainaYaMuda').on('change', toggleVisibility);
        // Toggles the minus and plus icons
        $('[data-toggle="collapse"]').on('click', function() {
            let icon = $("#toggleIcon");
            if (icon.hasClass("fa fa-chevron-down")) {
                icon.removeClass("fa fa-chevron-down").addClass("fa fa-chevron-up");
            } else {
                icon.removeClass("fa fa-chevron-up").addClass("fa fa-chevron-down");
            }
        });
        // AJAX request
        $("#loanCalculatorForm").submit(function(event) {
            event.preventDefault();


            $.ajax({
                url: '/calc',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                type: 'GET',
                data: $(this).serialize(),
                success: function(response) {
                    // Handle success
                    var modal = $('#kalkuletorModal');
                    modal.modal('show');
                    var data = JSON.parse(response);
                    $('#lipawiki').text(data.weekly);
                    malipoKwakilaWik = data.malipoKwaWiki;
                    $('#lipamwezi').text(data.monthly);
                    malipokwakilaMwezi = data.malipoKwaMwezi;
                    $('#lipakwaujumla').text(data.totlapayment);
                    malipokwaUjumla = data.jumlaYaMalipo;
                    $('#riba').text(data.totlrate);
                    $('#terehemisho').text(data.tareheYaMwisho);
                    $('#terehelipawiki').text(data.tareheKuanzaKulipaWiki);
                    $('#terehelipamwezi').text(data.tareheKuanzaKulipamwezi);
                    

                },
                error: function(error) {
                    // Handle error
                    alert("An error occurred: " + error.responseText);
                }
            });

        });
        $('#pakia').click(function() {
            var miezi = document.getElementById("mudaz").value;
            var kiasiz = document.getElementById("kiasiz").value;
            var ribaz = document.getElementById("ribaYaMwakaz").value;
            $('#lipa-wiki').val(malipoKwakilaWik);
            $('#lipa-mwezi').val(malipokwakilaMwezi);
            $('#kulipa-jumla').val(malipokwaUjumla);
            $('#idadi-muda').val(miezi);
            $('#kiasi-kukopa').val(kiasiz);
            $('#jina-riba').val(ribaz);
            var modal = $('#kalkuletorModal');
            modal.modal('hide');


        });
    });
</script>