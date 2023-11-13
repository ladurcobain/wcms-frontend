<div class="modal animated bounceIn" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #D2322D">
                <h2 class="card-title text-white">Hapus Data</h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-wrapper">
                    <div class="modal-icon">
                        <i class="fas fa-times-circle" style="color: #D2322D"></i>
                    </div>
                    <div class="modal-text">
                        <h4 class="font-weight-bold text-dark">Konfirmasi</h4>
                        <p>Apa anda yakin akan menghapus data ini ?</p>
                        <textarea id="getIdDelete" class="id_delete" hidden></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tidak</button>
                <a href="{{ URL('about/doctrin/destroy') }}" onclick="location.href=this.href+'/'+document.getElementById('getIdDelete').value;return false;" class="btn btn-danger">Ya</a>
            </div>
        </div>
    </div>
</div>