<div class="modal animated bounceIn" id="modalRemoveMessage" tabindex="-1" role="dialog" aria-labelledby="modalRemoveMessage" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form id="form" class="form-horizontal form-bordered" action="<?php echo url('chat/remove'); ?>" method="post" novalidate>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" id="parentId" name="parentId" />
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi hapus data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apa Anda yakin akan menghapus data ini ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>