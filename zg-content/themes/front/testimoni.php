<?= $this->layout('index'); ?>

<!-- Start Breadcrumb 
    ============================================= -->
<section class="s-top py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <small><a href="<?= BASE_URL; ?>"><?= $this->e($front_home); ?></a> / <?= $this->e($page_title); ?></small>
        <div class="post-meta mt-4">
            <span class="post-date"></span>
        </div>
        <h2 class="text-black mb-0 mt-2"><?= $this->e($page_title); ?></h2>
    </div>
</section>
<!-- End Breadcrumb -->

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">

                <div role="form" class="eight columns wpcf7" style="float: left; margin: 0; padding: 0;">
                    <div class="screen-reader-response"></div>
                    <?= htmlspecialchars_decode($this->e($alertmsg)); ?>
                    <form action="<?= BASE_URL; ?>/contact" method="post" class="wpcf7-form" novalidate="novalidate">
                        <p>
                            <?= $this->e($contact_name); ?> <span>*</span><br />
                            <span class="wpcf7-form-control-wrap your-name"><input type="text" name="contact_name" value="<?= (isset($_POST['contact_name']) ? $_POST['contact_name'] : ''); ?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" /></span>
                        </p>
                        <p>
                            <?= $this->e($contact_email); ?> <span>*</span><br />
                            <span class="wpcf7-form-control-wrap your-email"><input type="email" name="contact_email" value="<?= (isset($_POST['contact_email']) ? $_POST['contact_email'] : ''); ?>" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false" /></span>
                        </p>
                        <p>
                            No. Whatsapp <span>*</span><br />
                            <span class="wpcf7-form-control-wrap your-subject"><input type="text" name="contact_subject" value="<?= (isset($_POST['contact_subject']) ? $_POST['contact_subject'] : ''); ?>" size="40" class="wpcf7-form-control wpcf7-text" aria-required="true" aria-invalid="false" /></span>
                        </p>
                        <p>
                            Aspirasi <span>*</span><br />
                            <span class="wpcf7-form-control-wrap your-message"><textarea name="contact_message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-required="true" aria-invalid="false"><?= (isset($_POST['contact_message']) ? $_POST['contact_message'] : ''); ?></textarea></span>
                        </p>
                        <p>
                        <div class="g-recaptcha" data-sitekey="<?= $this->pocore()->call->posetting[21]['value']; ?>">
                        </div>
                        </p>

                        <p>
                            <input type="submit" value="Send Message" class="wpcf7-form-control wpcf7-submit" style='margin-top:70px;' />
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>