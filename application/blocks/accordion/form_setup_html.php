<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<style>
    .ccm-accordion-block-container {
        position: relative;
    }
    .ccm-accordion-block-container .btn-success {
        margin-bottom: 20px;
    }
    .ccm-accordion-entry {
        position: relative;
    }
    .ccm-accordion-entry.well {
        margin-bottom: 10px;
        padding: 28px 10px 10px;
    }
    .ccm-accordion-entry.well.entry-closed {
        height: 57px;
        padding: 0 0 0 15px;
    }
    .ccm-accordion-entry .entry-collapse-text {
        display: none;
    }
    .ccm-accordion-entry.entry-closed .entry-collapse-text {
        display: block;
        line-height: 57px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 335px;
    }
    .ccm-accordion-entry.entry-closed .form-group {
        display: none;
    }
    .ccm-accordion-entry .form-group:last-of-type {
        margin-bottom: 0;
    }
    .ccm-edit-entry {
        position: absolute;
        right: 127px;
        top: 10px;
    }
    .ccm-delete-accordion-entry {
        position: absolute;
        right: 41px;
        top: 10px;
    }
    .ccm-accordion-block-container i:hover {
        color: #428bca;
    }
    .ccm-accordion-block-container i.fa-arrows {
        cursor: move;
        font-size: 20px;
        padding: 5px;
        position: absolute;
        right: 5px;
        top: 6px;
    }
    .ccm-accordion-block-container .ui-state-highlight {
        height: 57px;
        margin-bottom: 10px;
    }
    .ccm-accordion-block-container .ui-sortable-helper {
        box-shadow: 0 10px 18px 2px rgba(54,55,66,0.27);
    }
</style>

<div class="ccm-accordion-block-container">
    <button type="button" class="btn btn-success ccm-add-accordion-entry"><?php echo t('Add Entry'); ?></button>
    <?php
    if ($rows) {
        foreach ($rows as $row) { ?>
            <div class="ccm-accordion-entry well entry-closed">
                <p class="entry-collapse-text"><?php echo $row['linkTitle'] ? $row['linkTitle'] : ''; ?></p>

                <div class="form-group">
                    <label class="control-label"><?php echo t('Section Title'); ?></label>
                    <input class="form-control ccm-input-text" type="text" name="linkTitle[]" value="<?php echo h($row['linkTitle']); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo t('Heading Text'); ?></label>
                    <input class="form-control ccm-input-text" type="text" name="title[]" value="<?php echo h($row['title']); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo t('Content'); ?></label>
                    <textarea class='editor-content' name="description[]"><?php echo $row['description']; ?></textarea>
                </div>
                <button type="button" class="btn btn-sm btn-default ccm-edit-entry" data-entry-close-text="<?php echo t('Collapse Entry'); ?>" data-entry-edit-text="<?php echo t('Edit Entry'); ?>"><?php echo t('Edit Entry'); ?></button>
                <button type="button" class="btn btn-sm btn-danger ccm-delete-accordion-entry"><?php echo t('Remove'); ?></button>
                <i class="fa fa-arrows"></i>

                <input class="ccm-accordion-entry-sort" type="hidden" name="sortOrder[]" value="<?php echo $row['sortOrder']; ?>">
            </div>
        <?php
        }
    } else {
    ?>
        <script>
        _.defer(function() {
            $('.ccm-add-accordion-entry').click();
        });
        </script>
    <?php
    }
    ?>

    <div class="ccm-accordion-entry well ccm-accordion-entry-template" style="display: none;">
        <p class="entry-collapse-text"></p>

        <div class="form-group">
            <label class="control-label"><?php echo t('Section Title'); ?></label>
            <input class="form-control ccm-input-text" type="text" name="linkTitle[]" value="">
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo t('Heading Text'); ?></label>
            <input class="form-control ccm-input-text" type="text" name="title[]" value="">
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo t('Content'); ?></label>
            <textarea class='editor-content' name="description[]"></textarea>
        </div>
        <button type="button" class="btn btn-sm btn-default ccm-edit-entry" data-entry-close-text="<?php echo t('Collapse Entry'); ?>" data-entry-edit-text="<?php echo t('Edit Entry'); ?>"><?php echo t('Edit Entry'); ?></button>
        <button type="button" class="btn btn-sm btn-danger ccm-delete-accordion-entry"><?php echo t('Remove'); ?></button>
        <i class="fa fa-arrows"></i>

        <input class="ccm-accordion-entry-sort" type="hidden" name="sortOrder[]" value="">
    </div>
</div>

<script>
<?php
$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
$editorJavascript = $app->make('editor')->outputStandardEditorInitJSFunction();
?>
var launchEditor = <?=$editorJavascript?>;

$(document).ready(function() {
    var container = $('.ccm-accordion-block-container');

    var doSortCount = function() {
        $('.ccm-accordion-entry', container).each(function(index) {
            $(this).find('.ccm-accordion-entry-sort').val(index);
        });
    };
    doSortCount();

    var uniqueEntryID = function() {
        $('.ccm-accordion-entry', container).each(function() {
            $(this).find('.editor-content').not('.ccm-accordion-entry-template').attr('id', _.uniqueId());
        });
    };
    uniqueEntryID();

    var cloneTemplate = $('.ccm-accordion-entry-template', container).clone(true);
    cloneTemplate.removeClass('.ccm-accordion-entry-template');
    $('.ccm-accordion-entry-template').remove();

    $(cloneTemplate).add($('.ccm-accordion-entry', container)).find('.ccm-delete-accordion-entry').click(function() {
        var deleteIt = confirm('<?php echo t('Are you sure?'); ?>');
        if (deleteIt === true) {
            entryID = $(this).closest('.ccm-accordion-entry').find('.editor-content').attr('id');
            if (typeof CKEDITOR === 'object') {
                CKEDITOR.instances[entryID].destroy();
            }

            $(this).closest('.ccm-accordion-entry').remove();
            doSortCount();
        }
    });

    if (container.find('.editor-content').length) {
        launchEditor(container.find('.editor-content'));
    }

    $('.ccm-add-accordion-entry', container).click(function() {
        var newClone = cloneTemplate.clone(true);
        newClone.find('.editor-content').attr('id', _.uniqueId());
        launchEditor(newClone.show().find('.editor-content'));
        container.append(newClone);

        $('.ccm-accordion-entry').not('.entry-closed').each(function() {
            $(this).addClass('entry-closed');
            var thisEditButton = $(this).find('.ccm-edit-entry');
            thisEditButton.text(thisEditButton.data('entryEditText'));

            var linkTitleText = $(this).find('input[name="linkTitle[]"]').val();
            if (linkTitleText) {
                $(this).find('.entry-collapse-text').text(linkTitleText);
            }
        });

        var newEntry = $('.ccm-accordion-entry').last();
        var closeText = newEntry.find('.ccm-edit-entry').data('entryCloseText');
        newEntry.removeClass('entry-closed').find('.ccm-edit-entry').text(closeText);

        var thisModal = $(this).closest('.ui-dialog-content');
        thisModal.scrollTop(newEntry.offset().top);
        doSortCount();
    });

    $(container).on('click','.ccm-edit-entry', function() {
        var closestEntry = $(this).closest('.ccm-accordion-entry');
        closestEntry.toggleClass('entry-closed');

        var thisEditButton = $(this);
        if (thisEditButton.data('entryEditText') === thisEditButton.text()) {
            thisEditButton.text(thisEditButton.data('entryCloseText'));
        } else if (thisEditButton.data('entryCloseText') === thisEditButton.text()) {
            thisEditButton.text(thisEditButton.data('entryEditText'));

            var linkTitleText = closestEntry.find('input[name="linkTitle[]"]').val();
            if (linkTitleText) {
                closestEntry.find('.entry-collapse-text').text(linkTitleText);
            }
        }
    });

    $(container).sortable({
        placeholder: 'ui-state-highlight',
        axis: 'y',
        items: '.ccm-accordion-entry',
        handle: 'i.fa-arrows',
        cursor: 'move',
        update: function() {
            doSortCount();
        }
    });
});
</script>
