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
        <h1><i class="fa fa-user-plus"></i> Sajili Mkopaji</h1>
        <p>Tafadahli Weka taarifa za mkopaji kwa usahihi</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Wakopaji</li>
        <li class="breadcrumb-item"><a href="#">Sajili</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="row">
                <div class="col-lg-6">
                    <?php helper('form') ?>
                    <form method="post" id="fomu" action="/sajilimtumiaji" enctype="multipart/form-data">
                        <?= session()->getFlashdata('error') ?>
                        <?= validation_list_errors() ?>
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="jina-lakwanza">Jina la kwanza</label>
                            <input class="form-control" required id="jina-lakwanza" name="jina-lakwanza" type="text" aria-describedby="emailHelp" placeholder="Weka jina la kwanza">
                        </div>
                        <div class="form-group">
                            <label for="jina-lakwanza">Jina la Kati</label>
                            <input class="form-control" required id="jina-lakwanza" name="jina-lakati" type="text" aria-describedby="emailHelp" placeholder="Weka jina la kati">
                        </div>
                        <div class="form-group">
                            <label for="jina-lakwanza">Jina la mwisho</label>
                            <input class="form-control" required id="jina-lakwanza" name="jinalamwisho" type="text" aria-describedby="emailHelp" placeholder="Weka jina la whisho">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Jinsia</label>
                            <select class="form-control" required name="jinsia" id="exampleSelect1">
                                <option value="Mwanaume">Mwanaume</option>
                                <option value="Mwanamke">Mwanamke</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Baruapepe</label>
                            <input class="form-control" required name="email" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Weka baruapepe">
                        </div>
                        <div class="form-group">
                            <label for="jina-lakwanza">Namba ya simu</label>
                            <input class="form-control" required id="jina-lakwanza" name="simu" type="tel" placeholder="Mfano: 06564100000">
                        </div>
                        <div class="form-group">
                            <label for="jina-lakwanza">Utaifa</label>
                            <input class="form-control" id="jina-lakwanza" value="Mtanzania" name="utaifa" type="text" placeholder="Andika utaifa">
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



                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox">Check me out
                            </label>
                        </div>

                </div>
                <div class="col-lg-4 offset-lg-1">

                    <div class="form-group">
                        <label for="jina-lakwanza">Mtaa Anaoishi</label>
                        <input class="form-control" required id="jina-lakwanza" name="mtaa" type="text" placeholder="Ingiza mtaa">
                    </div>
                    <div class="form-group">
                        <label for="jina-lakwanza">Kabila</label>
                        <input class="form-control" required id="jina-lakwanza" name="kabila" type="text" placeholder="Andika Kabila">
                    </div>
                    <div class="form-group">
                        <fieldset>
                            <label class="control-label" for="disabledInput">Namba ya nyumba</label>
                            <input class="form-control" required name="nambayumba" id="disabledInput" type="text" placeholder="weka namba ya nyumba">
                        </fieldset>
                    </div>
                    <div class="form-group">
                        <fieldset>
                            <label for="exampleSelect1">Aina ya majukumu</label>
                            <select class="form-control" required name="ainayakazi" id="exampleSelect1">
                                <option value="Mjasiriamali">Mjasiriamali</option>
                                <option value="Mwajiriwa">Mwajiriwa</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group">
                        <fieldset>
                            <label class="control-label" for="readOnlyInput">Kazi / Shughuli</label>
                            <input class="form-control" required name="kazi" id="readOnlyInput" type="text" placeholder="Kazi au shughuli">
                        </fieldset>
                    </div>
                    <div class="form-group">
                        <fieldset>
                            <label class="control-label" for="readOnlyInput">Semehu ya kazi</label>
                            <input class="form-control" required name="sehemukazi" id="readOnlyInput" type="text" placeholder="shirika, kampuni, taasisi, ofisi, fremu, ">
                        </fieldset>
                    </div>
                    <div class="form-group">
                        <fieldset>
                            <label for="exampleSelect1">Aina ya Kitambulisho</label>
                            <select class="form-control" required name="ainakitambulisho" id="exampleSelect1">
                                <option value="NIDA">NIDA</option>
                                <option value="Mpigakura">Mpigakura</option>
                                <option value="Leseni">Leseni</option>
                                <option value="pasport">Pasport ya kuasfiria</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group">
                        <fieldset>
                            <label class="control-label" for="readOnlyInput">Namba ya Kitambulisho</label>
                            <input class="form-control" required name="nambakitambulisho" id="readOnlyInput" type="text" placeholder="Namba ya kitabulisho">
                        </fieldset>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Picha ya Kitambulisho</label>
                        <input class="form-control-file" required name="pichakitambulisho" accept="image/*" id="exampleInputFile" type="file" aria-describedby="fileHelp"><small class="form-text text-muted" id="fileHelp">Pakia picha ya kitabulisho cha mkopaji ukubwa usiozidi 3mb</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Pasport size</label>
                        <input class="form-control-file" required name="pichapasport" accept="image/*" id="exampleInputFile" type="file" aria-describedby="fileHelp"><small class="form-text text-muted" id="fileHelp">Pakia pasipoti ya mkopaji ukubwa usiozidi 3mb</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea">Maelezo ya ziada</label>
                        <textarea class="form-control" required name="maelezo" id="exampleTextarea" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="tile-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>