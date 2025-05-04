<div class="modal fade" id="<?= esc($id ?? '') ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="<?= esc($id) ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered <?= esc($size ?? '') ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= esc($id) ?>Label"><?= esc($title ?? '') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $slot ?? '' ?>
            </div>
        </div>
    </div>
</div>
