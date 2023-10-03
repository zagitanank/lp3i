<?=$this->layout('index');?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div style="margin-top:25px;" class="col-md-12">
                <h1>BERITA</h1>
                <ul class="breadcrumb">
                    <li><a href="<?=BASE_URL;?>"><i class="fas fa-home"></i> <?=$this->e($front_home);?></a></li>
                    <li><a href="#">Berita</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Blog
    ============================================= -->
<div class="blog-area full-blog right-sidebar single-blog full-blog default-padding">
    <div class="container">
        <div class="row">
            <div class="blog-items">
                <div class="blog-content col-md-8">
                    <div class="item-box">
                        <div class="item">
                            <div class="thumb">
                                <img src="<?=BASE_URL;?>/<?=DIR_CON;?>/uploads/<?=$post['picture'];?>" alt="">
                                <div class="date">
                                    <h4><?=$this->pocore()->call->podatetime->tgl_indo($post['date']);?></h4>
                                </div>
                            </div>
                            <div class="info">
                                <h3>
                                    <?=$post['title'];?>
                                </h3>
                                <div class="meta">
                                    <ul>
                                        <li><i class="fas fa-user"></i>
                                            <?=$this->post()->getAuthorName($post['editor']);?></li>
                                        <li><i class="fas fa-clock"></i>
                                            <?=$this->pocore()->call->podatetime->tgl_indo($post['publishdate']);?>
                                        </li>
                                        <li><i class="fas fa-eye"></i> <?=$post['hits'];?> View</li>
                                    </ul>

                                </div>
                                <p><?=htmlspecialchars_decode(html_entity_decode($post['content']));?></p>
                            </div>

                            <div class="post-tags">
                                <span><?=$this->e($front_tag);?>: </span>
                                <?=$this->post()->getAllTag('RAND()', '30', '');?>
                            </div>
                            <!--comment
                                <?php if ($post['comment'] == 'Y') { ?>
                                <div class="comments-area">
                                        
                                    <div class="comments-title">
                                        <h4><span><?=$this->post()->getCountComment($post['id_post']);?></span> <?=$this->e($front_comment);?> </h4>
                                        
                                        <?php
                                            $com_parent = $this->post()->getCommentByPost($post['id_post'], '6', 'DESC', $this->e($page));
                                            ?>
                                                <div class="comments-list">
                                                    <div class="commen-item">
                                                        <div class="avatar">
                                                            <img src="{$comment_avatar}" alt="Author">
                                                        </div>
                                                        <div class="content">
                                                            <h5>Jonathom Doe</h5>
                                                            <div class="comments-info">
                                                                July 15, 2018 <a href="#"><i class="fa fa-reply"></i>Reply</a>
                                                            </div>
                                                            <p>
                                                                Delivered ye sportsmen zealously arranging frankness estimable as. Nay any article enabled musical shyness yet sixteen yet blushes. Entire its the did figure wonder off. 
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="commen-item reply">
                                                        <div class="avatar">
                                                            <img src="assets/img/team/4.jpg" alt="Author">
                                                        </div>
                                                        <div class="content">
                                                            <h5>Spark Lee</h5>
                                                            <div class="comments-info">
                                                                July 15, 2018 <a href="#"><i class="fa fa-reply"></i>Reply</a>
                                                            </div>
                                                            <p>
                                                                Delivered ye sportsmen zealously arranging frankness estimable as. Nay any article enabled musical shyness yet sixteen yet blushes. Entire its the did figure wonder off. 
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                       
                                    </div>
                                    <?php } ?>
                                     end comment-->
                            <!---comment
                                    <div class="comments-form">
                                        <div class="title">
                                            <h4>Leave a comments</h4>
                                        </div>
                                        <form action="#" class="contact-comments">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      
                                                        <input name="name" class="form-control" placeholder="Name *" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        
                                                        <input name="email" class="form-control" placeholder="Email *" type="email">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group comments">
                                                        
                                                        <textarea class="form-control" placeholder="Comment"></textarea>
                                                    </div>
                                                    <div class="form-group full-width submit">
                                                        <button type="submit">
                                                            Post Comments
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                                --->





                        </div>
                    </div>
                </div>
                <!-- Start Sidebar -->
                <?=$this->insert('sidebar');?>
                <!-- End Sidebar -->
            </div>
        </div>
    </div>
</div>
<!-- End Blog -->