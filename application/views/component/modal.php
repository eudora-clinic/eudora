<div class="modal fade" id="<?= $modal_id ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $modal_id ?>Label"
    aria-hidden="true">
    <div class="modal-dialog <?= isset($modal_size) ? $modal_size : '' ?>" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= $modal_id ?>Label"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $content ?>
            </div>
            <div class="modal-footer">
                <?= $footer ?>
            </div>
        </div>
    </div>
</div>