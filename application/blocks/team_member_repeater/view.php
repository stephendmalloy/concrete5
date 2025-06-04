<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div class="team-member-repeater-block">
    <?php if ($headerTitle) { ?>
        <h2 class="team-header-title"><?= h($headerTitle) ?></h2>
    <?php } ?>
    <?php if ($headerDescription) { ?>
        <div class="team-header-description"><?= LinkAbstractor::translateFrom($headerDescription) ?></div>
    <?php } ?>
    <div class="team-buttons">
        <?php if ($buttonOneText && $buttonOneLink) { ?>
            <a href="<?= $buttonOneLink ?>" class="btn btn-primary team-button-one"><?= h($buttonOneText) ?></a>
        <?php } ?>
        <?php if ($buttonTwoText && $buttonTwoLink) { ?>
            <a href="<?= $buttonTwoLink ?>" class="btn btn-secondary team-button-two"><?= h($buttonTwoText) ?></a>
        <?php } ?>
    </div>
    <div class="team-member-list">
        <?php foreach ($rows as $row) { ?>
            <div class="team-member-item">
                <?php if ($row['headshotFID']) { $f = File::getByID($row['headshotFID']); if ($f) { ?>
                    <img class="team-member-headshot" src="<?= $f->getRelativePath() ?>" alt="" />
                <?php } } ?>
                <h4 class="team-member-name"><?= h($row['firstName'] . ' ' . $row['lastName']) ?></h4>
                <div class="team-member-bio"><?= $row['bio'] ?></div>
            </div>
        <?php } ?>
    </div>
</div>
