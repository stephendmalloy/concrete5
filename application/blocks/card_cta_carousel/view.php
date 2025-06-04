<?php defined('C5_EXECUTE') or die('Access Denied.');
$u = new User();
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
<div class="swiper card-cta-carousel" id="card-cta-carousel-<?=$bID?>">
    <div class="swiper-wrapper">
        <?php foreach ($rows as $row) { ?>
            <div class="swiper-slide">
                <div class="card-cta-item">
                    <?php if ($row['iconFID']) { $f = File::getByID($row['iconFID']); if ($f) { ?>
                        <img class="card-cta-icon" src="<?= $f->getRelativePath() ?>" alt="" />
                    <?php } } ?>
                    <?php if ($row['title']) { ?>
                        <h3 class="card-cta-title"><?= h($row['title']) ?></h3>
                    <?php } ?>
                    <div class="card-cta-description">
                        <?= $row['description'] ?>
                    </div>
                    <?php if (!empty($row['linkURL'])) { ?>
                        <div class="card-cta-button"><a href="<?= $row['linkURL'] ?>" class="btn btn-primary" target="_blank"><?= t('Learn More') ?></a></div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-pagination"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>
var swiper = new Swiper('#card-cta-carousel-<?=$bID?>', {
    loop: true,
    navigation: {
        nextEl: '#card-cta-carousel-<?=$bID?> .swiper-button-next',
        prevEl: '#card-cta-carousel-<?=$bID?> .swiper-button-prev'
    },
    pagination: {
        el: '#card-cta-carousel-<?=$bID?> .swiper-pagination',
        clickable: true
    }
});
</script>

