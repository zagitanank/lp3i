<?=$this->layout('index');?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div style="margin-top:25px;" class="col-md-12">
                <h1>DOKUMEN</h1>
                <ul class="breadcrumb">
                    <li><a href="<?=BASE_URL;?>"><i class="fas fa-home"></i> <?=$this->e($front_home);?></a></li>
                    <li><a href="#">Dokumen</a></li>
                    <li class="active">MBKM UNIFA</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->



<section class="contact-info-area default-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>
                        <tr style="background: #003679;">
                            <th style="width: 10%; text-align: center;">
                                <font color="white">No.</font>
                            </th>
                            <th style="width: 30%; text-align: center;">
                                <font color="white"><?=$this->e($document_category);?></font>
                            </th>
                            <th style="width: 30%; text-align: center;">
                                <font color="white"><?=$this->e($document_title);?></font>
                            </th>
                            <th style="width:20%; text-align: center;">
                                <font color="white"><?=$this->e($document_date);?></font>
                            </th>
                            <th style="width: 10%; text-align: center;">
                                <font color="white"><?=$this->e($document_file);?></font>
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr style="background: #003679;">
                            <th style="width: 10%; text-align: center;">
                                <font color="white">No.</font>
                            </th>
                            <th style="width: 30%; text-align: center;">
                                <font color="white"><?=$this->e($document_category);?></font>
                            </th>
                            <th style="width: 30%; text-align: center;">
                                <font color="white"><?=$this->e($document_title);?></font>
                            </th>
                            <th style="width:20%; text-align: center;">
                                <font color="white"><?=$this->e($document_date);?></font>
                            </th>
                            <th style="width: 10%; text-align: center;">
                                <font color="white"><?=$this->e($document_file);?></font>
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                                $no=1;
                                $documents = $this->document()->getDocument('DESC',WEB_LANG_ID);
                                foreach($documents as $docs){
                                    $documents_category = $this->document()->getDocCategory($docs['id_document'], WEB_LANG_ID);
                            ?>

                        <tr style="background: white;">
                            <td style="width: 10%; text-align: center;"><?=$no;?></td>
                            <td style="width: 30%"><?=$documents_category;?></td>
                            <td style="width: 30%"><?=$docs['title'];?></td>
                            <td style="width:20%; text-align: center;">
                                <?=$this->pocore()->call->podatetime->tgl_indo($docs['publishdate']);?></td>
                            <td style="width: 10%">
                                <?php if(!empty($docs['picture'])){ ?>
                                <center><a href="<?=BASE_URL;?>/<?=DIR_CON;?>/uploads/<?=$docs['picture'];?>"
                                        target="_blank"><img
                                            src="<?=$this->asset('/assets/img/imgsmalldownloadpdf.png');?>"></a>
                                </center>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>




            </div><!-- /.col-md-12 -->


        </div>
    </div>
</section>