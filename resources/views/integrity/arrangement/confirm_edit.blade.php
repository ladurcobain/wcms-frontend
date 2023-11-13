<div class="modal animated bounceIn" id="modalConfirmEdit" tabindex="-1" role="dialog" aria-labelledby="modalConfirmEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #EE9C28">
                <h2 class="card-title text-white">Ubah Data</h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-wrapper">
                    <div class="modal-icon">
                        <i class="fas fa-exclamation-triangle" style="color: #EE9C28"></i>
                    </div>
                    <div class="modal-text">
                        <h4 class="font-weight-bold text-dark">Konfirmasi</h4>
                        <p>Apa anda yakin akan mengubah data ini ?</p>
                        <textarea id="getIdEdit" class="id_edit" hidden></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tidak</button>
                <a href="{{ URL('integrity/arrangement') }}" onclick="location.href=this.href+'/'+document.getElementById('getIdEdit').value+'/edit';return false;" class="btn btn-warning">Ya</a>
            </div>
        </div>
    </div>
</div>