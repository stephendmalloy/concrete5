<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div id="accordion-<?php echo $bID; ?>" class="ccm-accordion-container">
    <?php foreach ($rows as $row) { ?>
        <h3><?php echo h($row['linkTitle']); ?></h3>
        <div>
            <?php echo $row['description']; ?>
        </div>
    <?php } ?>
</div>
<script>
$(function () {
    $('#accordion-<?php echo $bID; ?>').accordion({
        heightStyle: 'content',
        collapsible: true
    });
});
</script>
