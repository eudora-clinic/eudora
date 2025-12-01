<div class="modal fade" id="<?= $modal_id ?>" tabindex="-1">
    <div class="modal-dialog <?= isset($modal_size) ? $modal_size : '' ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?= $content ?>
            </div>
            <?php if (isset($footer)): ?>
                <div class="modal-footer">
                    <?= $footer ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>