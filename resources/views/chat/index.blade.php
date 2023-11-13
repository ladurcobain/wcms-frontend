@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col-lg-4">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left mt-2">
                                <h2 class="card-title">Kontak Pengguna</h2>
                            </div>
                            <div class="pull-right">
                                <?php if(Session::get('user_type') == 1) { ?>
                                <a class="btn btn-sm btn-primary" href="javascript:void(0);" OnClick="dialogMessage();"> <i class="fas fa-plus"></i></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <div id="body-chat" class="scrollable" data-plugin-scrollable style="min-height: 300px;max-height: 500px;">
                        <div class="scrollable-content">
                            <ul id="div-chat-user" class="widget-todo-list">
                                <?php if(!empty($list_user)) { ?>
                                <?php foreach($list_user as $r) : ?>
                                    <?php 
                                        if(Session::get('user_type') == 1) { 
                                            $chat_image = $r->user_to->user_path;
                                            $chat_name  = $r->user_to->user_fullname;
                                        } else { 
                                            $chat_image = $r->user_from->user_path;
                                            $chat_name  = $r->user_from->user_fullname;
                                        } 
                                    ?>
                                    <li>
                                        <a href="javascript:void(0);" OnClick="load_chat_header(<?php echo $r->chat_id; ?>);">
                                            <div>
                                                <ul class="simple-user-list">
                                                    <li>
                                                        <figure class="image">    
                                                            <img src="<?php echo $chat_image; ?>" alt="<?php echo $chat_name; ?>"
                                                            class="rounded-circle" style="height: 36px;width: 36px;" />
                                                        </figure>
                                                        <span class="title mb-1"><?php echo $chat_name; ?></span>
                                                        <span class="message"><?php echo $r->last_edited; ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="todo-actions">
                                                <?php if($r->unread > 0) { ?>
                                                <span class="badge badge-primary"><?php echo $r->unread; ?></span>
                                                <?php } ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <?php } else { ?>
                                    <li><center><div class="notification-icon"><i class="bx bx-error"></i> Belum ada data</div></center></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-8">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header bg-primary">
                    <div id="div-chat-header" class="row">
                        <div class="widget-profile-info">
                            <div class="profile-picture">
                                <img src="{{ asset('assets/img/webphada.png') }}" style="width: 50px;height: 50px;" />
                            </div>
                            <div class="profile-info">
                                <h2 class="name font-weight-semibold mb-0"> ....</h2>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <div id="chat-body" style="padding-right: 15px;height: 380px;overflow-x: hidden;overflow-y: scroll;">
                        <div id="div-chat-message" class="timeline timeline-simple">
                            <center>...</center>
                        </div>
                        <div id="myDiv"></div>
                    </div>
                    <div style="margin-top: 10px;">
                        <form id="form-chat" class="form-horizontal form-bordered" action="<?php echo url('chat/process'); ?>" method="post">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />    
                            <input type="hidden" id="chat_id" name="chat_id" value="<?php echo Session::get('chat_id'); ?>" readonly />
                            <input type="hidden" id="type" name="type" value="<?php echo $type; ?>" readonly />
                            <div class="form-row">
                                <div class="form-group col mb-1"></div>
                                <div class="form-group col">
                                    <textarea id="chat-text" disabled class="form-control form-control-modern mb-2" name="message" rows="2"
                                        style="resize:none;line-height: 18px;" placeholder="Masukkan pesan ..."></textarea>
                                    <button id="chat-btn" disabled OnClick="sendMessage();" type="button" class="mb-1 mt-1 me-1 btn btn-primary btn-block"
                                        style="float: right">Kirim Pesan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    function removeMessage(id) {
        document.getElementById('parentId').value = id;
        $('#modalRemoveMessage').modal('show');
    }   

    function dialogMessage() {
        $('#modalConfirmMessage').modal('show');
    }    

    function sendMessage() { 
        var id = $('#chat_id').val();
        var types = $('#type').val();
        var message_text = $('#chat-text').val();

        var uri = base_url + "ajax/process-chat";
        var form = $('#form-chat');
        $.ajax({
            url: uri,
            data: form.serialize(),
            type: "POST",
            dataType: "JSON",
            timeout: time_show,
            beforeSend: function() {
                //
            }
        }).done(function(data) {
            var currentdate = new Date();
            var day   = currentdate.getDate();
            var month = (currentdate.getMonth()+1);
            if(day < 10) {
                var currentDay = "0"+ day;
            } 

            if(month < 10) {
                var currentMonth = "0"+ month;
            } 

            var message_datetime = currentDay +"-"+ currentMonth +"-"+ currentdate.getFullYear() +" "+ currentdate.getHours() + ":"  
                            + currentdate.getMinutes() + ":" 
                            + currentdate.getSeconds();

            if(types == 1) {
                var style = 'style="margin: 5px;padding: 5px 5px 2px 30px;"';
                var styles = 'style="width: 100%;line-height: 24px;text-align:right;background: #f9f9f9;"';
            }
            else {
                var style  = 'style="margin: 5px;padding: 5px 30px 2px 5px;"';
                var styles = 'style="width: 100%;line-height: 24px;text-align:left;background: #ffffff;"';
            }
            
            if(id != "") {
                $("#div-chat-message").append('<div class="tm-body" '+ style +'><div class="tm-title" '+ styles +'><h5 class="m-0 pt-2 pb-2">'+ message_text +'</h5><small>'+ message_datetime +'</small></div></div>');
            }

            scrollBottom();
            load_chat_user();

            $('#chat-text').val('');
        }).fail(function(jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                //
            }
        });
    } 
</script>

@include('chat.confirm_remove')
@include('chat.confirm_message')
@endsection