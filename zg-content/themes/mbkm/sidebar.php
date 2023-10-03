            <!-- Start Sidebar -->
            <div class="sidebar col-md-4">
                <aside>

                    <!-- Start Sidebar Item -->
                    <div class="sidebar-item search">
                        <div class="title">
                            <h4>Search</h4>
                        </div>
                        <div class="sidebar-info">
                            <form action="<?=BASE_URL;?>/search" method="post">
                                <input type="text" class="form-control">
                                <input type="submit" value="search" placeholder="<?=$this->e($front_search);?>...">
                            </form>
                        </div>
                    </div>
                    <!-- End Sidebar Item -->

                    <!-- Start Sidebar Item -->
                    <div class="sidebar-item category">
                        <div class="title">
                            <h4><?=$this->e($front_categories);?></h4>
                        </div>
                        <div class="sidebar-info">
                            <ul>
                                <?php
                                $categorys_side = $this->category()->getAllCategory(WEB_LANG_ID);
                                foreach($categorys_side as $category_side){
                                ?>
                                     <li><a href="<?=BASE_URL;?>/category/<?=$category_side['seotitle'];?>"><?=$category_side['title'];?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- End Sidebar Item -->

                    <!-- Start Sidebar Item -->
                    <div class="sidebar-item recent-post">
                        <div class="title">
                            <h4><?=$this->e($front_recent);?></h4>
                        </div>
                        <?php
						$recents_side = $this->post()->getRecent('5', 'DESC', WEB_LANG_ID);
						foreach($recents_side as $recent_side){
				    	?>
                        <div class="item">
                            <div class="content">
                                <div class="thumb">
                                    <a href="<?=$this->pocore()->call->postring->permalink(rtrim(BASE_URL, '/'), $recent_side);?>">
                                        <img src="<?=BASE_URL;?>/<?=DIR_CON;?>/thumbs/<?=$recent_side['picture'];?>" alt="Thumb">
                                    </a>
                                </div>
                                <div class="info">
                                    <h4>
                                        <a href="<?=$this->pocore()->call->postring->permalink(rtrim(BASE_URL, '/'), $recent_side);?>"><?=$recent_side['title'];?></a>
                                    </h4>
                                    <div class="meta">
                                        <i class="fas fa-calendar-alt"></i> <?=$this->pocore()->call->podatetime->tgl_indo($recent_side['date']);?></a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- End Sidebar Item -->

                    
                    
                    <!-- Start Sidebar Item -->
                    <div class="sidebar-item social-sidebar">
                        <div class="title">
                            <h4>follow us</h4>
                        </div>
                        <div class="sidebar-info">
                            <ul>
                                <li class="facebook">
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li class="twitter">
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li class="instagram">
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li class="youtube">
                                    <a href="#">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                                <li class="website">
                                    <a href="#">
                                        <i class="fab fa-dribbble"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Sidebar Item -->

                    <!-- Start Sidebar Item -->
                    <div class="sidebar-item tags">
                        <div class="title">
                            <h4><?=$this->e($front_tag);?></h4>
                        </div>
                        <div class="sidebar-info">
                            <ul>
                                <li><?=$this->post()->getAllTag('RAND()', '30', '');?>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    <!-- End Sidebar Item -->

                </aside>
            </div>
            <!-- End Start Sidebar -->