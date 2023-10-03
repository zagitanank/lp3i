<?=$this->layout('index');?>

<!-- Start Breadcrumb 
   ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?=$this->e($page_title);?></h1>
                <ul class="breadcrumb">
                    <li><a href="<?=BASE_URL;?>"><i class="fas fa-home"></i> <?=$this->e($front_home);?></a></li>
                    <li class="active"><?=$this->e($page_title);?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Blog
   ============================================= -->
<div class="blog-area full-blog right-sidebar full-blog default-padding">
    <div class="container">
        <div class="row">
            <div class="blog-items">
                <div class="blog-content col-md-8">
                    <!-- Single Item -->
                    <?php
                            $search = $this->post()->getPostFromSearch('3', 'post.id_post DESC', $this->e($query), $this->e($page), WEB_LANG_ID);
                            foreach($search as $post){

                        ?>
                    <div class="single-item">
                        <div class="item">
                            <div class="thumb">
                                <a href="<?=BASE_URL;?>/detailpost/<?=$post['seotitle'];?>"><img
                                        src="<?=BASE_URL;?>/<?=DIR_CON;?>/uploads/medium/medium_<?=$post['picture'];?>"
                                        alt="Thumb"></a>
                                <div class="date">
                                    <h4><?=$this->pocore()->call->podatetime->tgl_indo($post['date']);?></h4>
                                </div>
                            </div>
                            <div class="info">
                                <h3>
                                    <a href="<?=BASE_URL;?>/detailpost/<?=$post['seotitle'];?>"><?=$post['title'];?></a>
                                </h3>
                                <p><?=$this->pocore()->call->postring->cuthighlight('post', $post['content'], '200');?>...
                                </p>
                                <a href="<?=BASE_URL;?>/detailpost/<?=$post['seotitle'];?>">Baca Sekarang <i
                                        class="fas fa-angle-double-right"></i></a>
                                <div class="meta">
                                    <ul>
                                        <li>
                                            <a href="#"><i class="fas fa-user"></i>
                                                <?=$this->post()->getAuthorName($post['editor']);?></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fas fa-comments"></i>
                                                <?=$this->post()->getCountComment($post['id_post']);?> Komentar</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Item -->
                    <?php } ?>
                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-md-12 pagi-area">
                            <nav aria-label="navigation">
                                <ul class="pagination">
                                    <?=$this->post()->getSearchPaging('3', $this->e($query), $this->e($page), WEB_LANG_ID, '1', $this->e($front_paging_prev), $this->e($front_paging_next));?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Item -->
                <?=$this->insert('sidebar');?>
                <!-- End Sidebar Item -->
            </div>
        </div>
    </div>
</div>