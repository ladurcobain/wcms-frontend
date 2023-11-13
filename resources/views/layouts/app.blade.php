<!doctype html>
<html class="fixed">

<head>

    <!-- Basic -->
    <meta charset="UTF-8">
    <title>{{ str_replace("-", " ", config('app.name')) }} | @yield('title')</title>
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="keywords" content="{{ config('app.name') }}" />
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/kejaksaan-logo.jpg') }}" />

    <script>var base_url = "{{ URL::to('/') }}/"</script> 

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link id="googleFonts" href="{{ asset('assets/css/google_font.css') }}" rel="stylesheet" type="text/css">
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate/animate.compat.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/jstree/themes/default/style.css') }}" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/media/css/dataTables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/skins/default.css') }}" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    @stack('page-styles')

    @stack('css_page')
    <!-- Head Libs -->
    <script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
    <script>var is_nestable = 0;</script>
</head>

<body class="loading-overlay-showing" data-loading-overlay>
    <div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    @include('sweetalert::alert')

    <section class="body">

        <!-- start: header -->
        @include('layouts.partials.head')
        <!-- end: header -->

        <div class="inner-wrapper">
            <!-- start: sidebar -->
            <aside id="sidebar-left" class="sidebar-left">

                @include('layouts.partials.sidebar')

            </aside>
            <!-- end: sidebar -->

            <section role="main" class="content-body">
                <!-- start: page -->
                @yield('content')
                <!-- end: page -->
            </section>
        </div>
    </section>

    @stack('before-scripts')

    @include('layouts.partials.scripts')

    @stack('js_page')

    @stack('page-scripts')

</body>

<script>
var time_ajax = (3000 * 60) * 1; // sets timeout to 1 minutes
var time_show = 1000; // sets timeout to 1 seconds
var time_done = 500;

function notification() {
    setInterval(function() {
        load_notif_alert(<?php echo Session::get('user_id'); ?>);
        load_notif_chat(<?php echo Session::get('user_id'); ?>);
    }, time_ajax);
}

function load_notif_chat(id) {
    var uri = base_url + "ajax/notif-message/" + id;
    $.ajax({
        type: "get",
        dataType: "html",
        url: uri,
        timeout: time_show,
        beforeSend: function() {
            $("#notif-chat").html(
                '<div class="notification-icon"><i class="bx bx-loader"></i></div>');
        }
    }).done(function(data) {
        $("#notif-chat").html(data);
    }).fail(function(jqXHR, textStatus) {
        if (textStatus === 'timeout') {
            $("#notif-chat").html(
                '<div class="notification-icon"><i class="bx bx-error"></i></div>');
        }
    });
}

function load_notif_alert(id) {
    var uri = base_url + "ajax/notif-alert/" + id;
    $.ajax({
        type: "get",
        dataType: "html",
        url: uri,
        timeout: time_show,
        beforeSend: function() {
            $("#notif-alert").html(
                '<div class="notification-icon"><i class="bx bx-loader"></i></div>');
        }
    }).done(function(data) {
        $("#notif-alert").html(data);
    }).fail(function(jqXHR, textStatus) {
        if (textStatus === 'timeout') {
            $("#notif-alert").html(
                '<div class="notification-icon"><i class="bx bx-error"></i></div>');
        }
    });
}


$(document).ready(function() {
    $('.summernote').summernote({
        height: 250,
        placeholder: 'Input teks ...',
        toolbar: [
            ['fontsize', ['fontsize']],
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'help']],
        ]
    });
    
    $('.dropdown-toggle').dropdown(); 
    
    notification();
    load_notif_alert(<?php echo Session::get('user_id'); ?>);
    load_notif_chat(<?php echo Session::get('user_id'); ?>);

    <?php if($title == "Percakapan") { ?>
    load_chat_user();
    load_chat_message();
    <?php } ?>
});


function scrollIfNeeded(element, container) {
    if (element.offsetTop < container.scrollTop) {
        container.scrollTop = element.offsetTop;
    } else {
        const offsetBottom = element.offsetTop + element.offsetHeight;
        const scrollBottom = container.scrollTop + container.offsetHeight;
        if (offsetBottom > scrollBottom) {
        container.scrollTop = offsetBottom - container.offsetHeight;
        }
    }
}

function scrollBottom() {
    scrollIfNeeded(document.getElementById('myDiv'), document.getElementById('chat-body'));
}


function load_chat_user() {
    var uri = base_url + "ajax/load-chat-user/";
    $.ajax({
        type: "get",
        dataType: "html",
        url: uri,
        timeout: time_show,
        beforeSend: function() {
            $("#div-chat-user").html(
                '<li><center><div class="notification-icon"><i class="bx bx-loader"></i></div></center></li>');
        }
    }).done(function(data) {
        $("#div-chat-user").html(data);
    }).fail(function(jqXHR, textStatus) {
        if (textStatus === 'timeout') {
            $("#div-chat-user").html(
                '<li><center><div class="notification-icon"><i class="bx bx-error"></i></div></center></li>');
        }
    });
}

function append_chat(id) {
    var param = 0;
    if(id != "") {
        param = id;
    }

    var uri = base_url + "ajax/load-chat-append/" + param;
    $.ajax({
        type: "get",
        dataType: "html",
        url: uri,
        timeout: time_show,
        beforeSend: function() {
            $("#div-chat-message").append('');
        }
    }).done(function(data) {
        $("#div-chat-message").append(data);
    }).fail(function(jqXHR, textStatus) {
        if (textStatus === 'timeout') {
            $("#div-chat-message").append('');
        }
    });

    scrollBottom();
}

function load_chat_message() {
    var initHeader = 0;
    setInterval(function() {
        var chat_id = $('#chat_id').val();
        if(chat_id != "") {
            if(initHeader == 0) {
                load_chat_header(chat_id);
                initHeader = 1;
            }

            append_chat(chat_id);
        }
    }, 1000);
}

function load_chat_header(id) {
    var param = 0;
    if(id != "") {
        param = id;
    }

    var uri = base_url + "ajax/load-chat-profile/" + param;
    $.ajax({
        type: "get",
        dataType: "html",
        url: uri,
        timeout: time_show,
        beforeSend: function() {
            $("#div-chat-header").html(
                '<center><div class="notification-icon"><i class="bx bx-loader"></i></div></center>');
        }
    }).done(function(data) {
        $("#div-chat-header").html(data);
    }).fail(function(jqXHR, textStatus) {
        if (textStatus === 'timeout') {
            $("#div-chat-header").html(
                '<center><div class="notification-icon"><i class="bx bx-error"></i></div></center>');
        }
    });

    $('#chat_id').val(param);
    load_chat_content(param);
}

function load_chat_content(id) {
    var param = 0;
    if(id != "") {
        param = id;
    }

    $('#chat-text').removeAttr("disabled");
    $('#chat-btn').removeAttr("disabled");

    var uri = base_url + "ajax/load-chat-message/" + param;
    $.ajax({
        type: "get",
        dataType: "html",
        url: uri,
        timeout: time_show,
        beforeSend: function() {
            $("#div-chat-message").html(
                '<center><div class="notification-icon"><i class="bx bx-loader"></i></div></center>');
        }
    }).done(function(data) {
        $("#div-chat-message").html(data);
    }).fail(function(jqXHR, textStatus) {
        if (textStatus === 'timeout') {
            $("#div-chat-message").html(
                '<center><div class="notification-icon"><i class="bx bx-error"></i></div></center>');
        }
    });

    load_chat_user();
}

function showTypeUser(val) {
    if(val == 1) {
        document.getElementById('cmb-user-role').style.display = "block";
        document.getElementById('cmb-user-satker').style.display = "none";
    }
    else {
        document.getElementById('cmb-user-role').style.display = "none";
        document.getElementById('cmb-user-satker').style.display = "block";
    }
}

function showTypeVideo(val) {
    if(val == 1) {
        document.getElementById('form-embed').style.display = "block";
        document.getElementById('form-upload').style.display = "none";
    }
    else {
        document.getElementById('form-embed').style.display = "none";
        document.getElementById('form-upload').style.display = "block";
    }
}

function showCategoryNews(val) {
    if(val == 1) {
        document.getElementById('upload-img-news').style.display = "block";
    }
    else if(val == 2) {
        document.getElementById('upload-img-news').style.display = "block";
    }
    else if(val == 3) {
        document.getElementById('upload-img-news').style.display = "block";
    }
    else {
        document.getElementById('upload-img-news').style.display = "none";
    }
}
</script>

</html>
