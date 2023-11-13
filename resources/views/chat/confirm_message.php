<div class="modal animated bounceIn" id="modalConfirmMessage" tabindex="-1" role="dialog" aria-labelledby="modalConfirmMessageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body" id="modal-content">
                <form id="form" class="form-horizontal form-bordered" action="<?php echo url('chat/process'); ?>" method="post">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />    
                    <input type="hidden" name="type" value="<?php echo $type; ?>" />
                    <div class="form-group row pb-3">
                        <label class="col-sm-3 control-label text-sm-end pt-2">Pengguna <span class="required">*</span></label>
                        <div class="col-sm-9">
                            <select data-plugin-selectTwo class="form-control populate placeholder" id="user" name="user"
                                data-plugin-options='{ "placeholder": "Pilih Pengguna ...", "allowClear": false }' required>
                                <option><option>
                                <?php foreach($users as $r) { ?>
                                <option value="<?php echo $r->user_id; ?>"><?php echo $r->satker_name; ?></option>           
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row pb-2">
                        <label class="col-sm-3 control-label text-sm-end pt-2">Pesan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="message" name="message" rows="2" style="resize: none;" placeholder="Pesan ..."></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <button type="reset" class="btn btn-default">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>