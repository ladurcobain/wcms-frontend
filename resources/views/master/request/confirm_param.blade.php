<div class="modal animated bounceIn" id="modalConfirmDetail" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body" id="modal-content">
                <form id="form" class="form-horizontal form-bordered" action="{{ route('request.process') }}" method="post" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" id="parentId" name="parentId" />
                    <div class="form-group row pb-3">
                        <label class="col-sm-3 control-label text-sm-end pt-2">Tipe Data <span class="required">*</span></label>
                        <div class="col-sm-9">
                            <select data-plugin-selectTwo class="form-control populate placeholder" id="type" name="type"
                                data-plugin-options='{ "placeholder": "Pilih Tipe Data ...", "allowClear": false }' required>
                                <option><option>
                                <option value="Integer"; ?>Integer</option>
                                <option value="String"; ?>String</option>
                                <option value="File"; ?>File</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row pb-3">
                        <label class="col-sm-3 control-label text-sm-end pt-2">Nilai <span class="required">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="initial" name="initial" placeholder="Nilai" autocomplete="off" required />
                        </div>
                    </div>
                    <div class="form-group row pb-2">
                        <label class="col-sm-3 control-label text-sm-end pt-2">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="desc" name="desc" rows="2" style="resize: none;" placeholder="Keterangan ..."></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <button type="reset" class="btn btn-default">Batal</button>
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>