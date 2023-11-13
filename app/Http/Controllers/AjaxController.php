<?php
    
namespace App\Http\Controllers;
    
use App\Http\Controllers\Controller;
use App\Helpers\Curl;
use App\Helpers\Status;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
    
class AjaxController extends Controller
{
    public function notif_message($id)
    {
        $count = 0;
        if($id != "") {
            $uri = Curl::endpoint();
            $url = $uri .'/'.'active/get-messaging';
            $param = array(
                'type' => Session::get('user_type'),
                'user_id'   => Session::get('user_id'),
            );
            
            $res = Curl::requestPost($url, $param);
    
            $list  = "";
            if($res->status == true) {
                $arr  = $res->data;
                $list .= "<ul>";
                foreach($arr as $r) {
                    if(Session::get('user_type') == 2) { 
                        $chat_image = $r->chat_from->user_path;
                        $chat_name  = $r->chat_from->user_fullname;
                    } else { 
                        $chat_image = $r->chat_to->user_path;
                        $chat_name  = $r->chat_to->user_fullname;
                    } 
                    
                    $list .= '<li>';
                    $list .= '<a>';
                    $list .= '<span class="title">'. $chat_name .'</span>';
                    $list .= '<span class="message">'. $r->message_datetime .'</span>';
                    $list .= '</a>';
                    $list .= '</li>';
                }
    
                $list .= "</ul>";
                $link  = '<a href="'. route("chat.index") .'" class="view-more">Selengkapnya</a>';
                $count = count($arr);
            }
        }
        
        $str = "";
        if($count > 0) {
            $str .=         '<a href="javascript:void(0);" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">';
            $str .=         '   <i class="bx bx-comment"></i>';
            $str .=         '   <span class="badge">'. $count .'</span>';
            $str .=         '</a>';
            $str .=         '<div class="dropdown-menu notification-menu">';
            $str .=         '   <div class="notification-title">';
            $str .=         '       <span class="float-end badge badge-default">'. $count .'</span>';
            $str .=         '       Pesan';
            $str .=         '   </div>';
            $str .=         '   <div class="content">';
            $str .=         $list;
            $str .=         '       <hr />';
            $str .=         '       <div class="text-end">';
            $str .=         $link;
            $str .=         '       </div>';
            $str .=         '   </div>';
            $str .=         '</div>';
        }
        else {
            $str = '
            <a href="javascript:void(0);" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
                <i class="bx bx-comment"></i>
            </a>
            <div class="dropdown-menu notification-menu">
                <div class="notification-title">
                    Percakapan
                </div>

                <div class="content">
                    <center><span class="va-middle">Data tidak ditemukan.</span><center>
                </div>
            </div>
            ';
        }
        
        return $str;
    }

    public function notif_alert($id)
    {
        $count = 0;
        if($id != "") {
            $uri = Curl::endpoint();
            $url = $uri .'/'.'active/get-notification';
            $param = array('user_id' => $id);
            $res = Curl::requestPost($url, $param);
    
            $list  = "";
            if($res->status == true) {
                $arr  = $res->data;
                $list .= "<ul>";
                foreach($arr as $r) {
                    $list .= '<li>';
                    $list .= '<a>';
                    $list .= '<span class="title">'. $r->notification_description .'</span>';
                    $list .= '<span class="message">'. $r->notification_date .' '. $r->notification_time .'</span>';
                    $list .= '</a>';
                    $list .= '</li>';
                }
    
                $list .= "</ul>";
                $link  = '<a href="'. route("notification.index") .'" class="view-more">Selengkapnya</a>';
                $count = count($arr);
            }
        }
        
        $str = "";
        if($count > 0) {
            $str .=         '<a href="javascript:void(0);" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">';
            $str .=         '   <i class="bx bx-bell"></i>';
            $str .=         '   <span class="badge">'. $count .'</span>';
            $str .=         '</a>';
            $str .=         '<div class="dropdown-menu notification-menu">';
            $str .=         '   <div class="notification-title">';
            $str .=         '       <span class="float-end badge badge-default">'. $count .'</span>';
            $str .=         '       Notifikasi';
            $str .=         '   </div>';
            $str .=         '   <div class="content">';
            $str .=         $list;
            $str .=         '       <hr />';
            $str .=         '       <div class="text-end">';
            $str .=         $link;
            $str .=         '       </div>';
            $str .=         '   </div>';
            $str .=         '</div>';
        }
        else {
            $str = '
            <a href="javascript:void(0);" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
                <i class="bx bx-bell"></i>
            </a>
            <div class="dropdown-menu notification-menu">
                <div class="notification-title">
                    Notifikasi
                </div>

                <div class="content">
                    <center><span class="va-middle">Data tidak ditemukan.</span><center>
                </div>
            </div>
            ';
        }
        
        return $str;
    }


    public function modal_userrole($id)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'role-user/get-authority';
        $param = array('role_id' => $id);
        $res = Curl::requestPost($url, $param);

        $list = "<tr><td>Data tidak ditemukan</td></tr>";
        if($res->status == true) {
            $list = "";
            $authoritys = $res->data; 
            for($i=0; $i<count($authoritys); $i++) {
                $list .= '<tr><td>'. $authoritys[$i] .'</td></tr>';
            }
        }
        
        $str = "";
        $str .= '<table class="table table-bordered table-striped mb-0">';
        $str .= '<thead>';
        $str .= '<tr>';
        $str .= '<th>Akses Modul</th>';
        $str .= '</tr>';
        $str .= '</thead>';
        $str .= '<tbody>';
        $str .= $list;
        $str .= '</tbody>';
        $str .= '</table>';
        
        return $str;
    }

    public function modal_satkermenu($id)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'satker/get-navigation';
        $param = array('satker_id' => $id);
        $res = Curl::requestPost($url, $param);

        $list = "<tr><td>Data tidak ditemukan</td></tr>";
        if($res->status == true) {
            $list = "";
            $authoritys = $res->data; 
            for($i=0; $i<count($authoritys); $i++) {
                $list .= '<tr><td>'. $authoritys[$i] .'</td></tr>';
            }
        }
        
        $str = "";
        $str .= '<table class="table table-bordered table-striped mb-0">';
        $str .= '<thead>';
        $str .= '<tr>';
        $str .= '<th>Menu Navigasi</th>';
        $str .= '</tr>';
        $str .= '</thead>';
        $str .= '<tbody>';
        $str .= $list;
        $str .= '</tbody>';
        $str .= '</table>';
        
        return $str;
    }

    public function modal_visitor($id)
    {
        
        $now = Carbon::now();
        $year  = Carbon::createFromFormat('Y-m-d H:i:s', $now)->format('Y');
        $month = Carbon::createFromFormat('Y-m-d H:i:s', $now)->format('m');
        $day   = Carbon::createFromFormat('Y-m-d H:i:s', $now)->format('d');
        
        $uri = Curl::endpoint();
        $url = "";
        switch($id) {
            case 1 :
                $Keterangan = "Nama Satker";
                $param = array(
                    'user_id' => Session::get('user_id'),
                );
                
                $url = $uri .'/'.'activity/get-visitor-by-satker';
            break;
            case 2 :
                $Keterangan = "Nama Bulan";
                $param = array(
                    'user_id' => Session::get('user_id'),
                    'day'     => $year,
                );
                
                $url = $uri .'/'.'activity/get-visitor-by-year';
            break;
            case 3 :
                $Keterangan = "Tanggal";
                $param = array(
                    'user_id' => Session::get('user_id'),
                    'day'     => $year .'-'. $month,
                );
                
                $url = $uri .'/'.'activity/get-visitor-by-month';
            break;
            case 4 :
                $Keterangan = "Jam";
                $param = array(
                    'user_id' => Session::get('user_id'),
                    'day'     => $year .'-'. $month .'-'. $day,
                );
                
                $url = $uri .'/'.'activity/get-visitor-by-day';
            break;
        }

        $str = "";
        if($url != "") {
            $res = Curl::requestPost($url, $param);

            if($id != 1) {
                $list = "<tr><td colspan='2'>Data tidak ditemukan</td></tr>";
                if($res->status == true) {
                    $list = "";
                    $arr = $res->data; 
                    
                    foreach($arr as $row) {
                        $list .= '<tr><td style="display:none;">'. $row->sort .'</td><td>'. $row->title .'</td><td align="center">'. $row->count .'</td></tr>';
                    }
                }
                

                $str .= '<script>$("#dtTable").DataTable({responsive: true,pageLength: 100,info: false,"oLanguage": {"sZeroRecords": "Data tidak ditemukan","sLengthMenu": "Tampilkan &nbsp; _MENU_ data","oPaginate": {"sFirst": "<<","sPrevious": "<","sNext": ">","sLast": ">>"}},});</script>';
                $option = '{"searchPlaceholder": "Kata Kunci ..."}';
                $plugin = "data-plugin-options = '". $option ."'";
                $str .= '<div style="height: 300px;overflow-y: scroll;overflow-x: hidden;">';
                $str .= '<table style="width:90%;" class="table table-responsive-lg table-bordered table-striped mb-0" id="dtTable" '. $plugin .'>';
                $str .= '<thead>';
                $str .= '<tr>';
                $str .= '<th style="display:none;" width="1%">Sort</th>';
                $str .= '<th>'. $Keterangan .'</th>';
                $str .= '<th class="text-center" width="20%">Jumlah</th>';
                $str .= '</tr>';
                $str .= '</thead>';
                $str .= '<tbody>';
                $str .= $list;
                $str .= '</tbody>';
                $str .= '</table>';
                $str .= '</div>';
            }
            else {
                if($res->status == true) {
                    $str .= "<script>$('#treeSatker').jstree({'core' : {'themes' : {'responsive': true}},'types' : {'default' : {'icon' : 'fas fa-tags'},},'plugins': ['types']});</script>";
                    $str .= '<div id="treeSatker" style="height: 300px;overflow: scroll;">';
                    $arr = $res->data; 
                    
                    $level0 = $arr->level0;
                    if(count($level0) > 0) {
                        $str .= '<ul class="list-styled">';
                        foreach($level0 as $r0) {
                            $str .= '<li>';
                            $str .= $r0->name;
                            $str .= ' <small><span class="badge badge-primary">'. $r0->count .'</span></small>';
                            
                            $level1 = $r0->level1;
                            if(count($level1) > 0) {
                                $str .= '<ul>';
                                foreach($level1 as $r1) {
                                    $str .= '<li>';
                                    $str .= $r1->name;
                                    $str .= ' <small><span class="badge badge-primary">'. $r1->count .'</span></small>';
                                    
                                    $level2 = $r1->level2;
                                    if(count($level2) > 0) {
                                        $str .= '<ul>';
                                        foreach($level2 as $r2) {
                                            $str .= '<li>';
                                            $str .= $r2->name;
                                            $str .= ' <small><span class="badge badge-primary">'. $r2->count .'</span></small>';
                                            
                                            $level3 = $r2->level3;
                                            if(count($level3) > 0) {
                                                $str .= '<ul>';
                                                foreach($level3 as $r3) {
                                                    $str .= '<li>';
                                                    $str .= $r3->name;
                                                    $str .= ' <small><span class="badge badge-primary">'. $r3->count .'</span></small>';
                                                    $str .= '</li>';
                                                }

                                                $str .= '</ul>';
                                            }

                                            $str .= '</li>';
                                        }    

                                        $str .= '</ul>';
                                    }   

                                    $str .= '</li>';                                    
                                }

                                $str .= '</ul>';
                            }

                            $str .= '</li>';
                        }

                        $str .= '</ul>';
                    }

                    $str .= '</div>';
                }
                else {
                    $str .= '
                        <div class="content">
                            <center><span class="va-middle">Data tidak ditemukan.</span><center>
                        </div>
                    ';
                }
            }
            
        }
        
        return $str;
    }

    
    public function load_chat_user()
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'chat/get-by-type';
        $param = array(
            'type' => Session::get('user_type'),
            'user_id'   => Session::get('user_id'),
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $list = "";
            $user = $res->data;

            for($i=0; $i<count($user); $i++) {
                if(Session::get('user_type') == 1) { 
                    $chat_image = $user[$i]->user_to->user_path;
                    $chat_name  = $user[$i]->user_to->user_fullname;
                } else { 
                    $chat_image = $user[$i]->user_from->user_path;
                    $chat_name  = $user[$i]->user_from->user_fullname;
                } 

                $unread = '';
                if($user[$i]->unread > 0) {
                    $unread = '<span class="badge badge-primary">'. $user[$i]->unread .'</span>';
                }

                $list .= '
                    <li>
                        <a href="javascript:void(0);" OnClick="load_chat_header('. $user[$i]->chat_id .');">
                            <div>
                                <ul class="simple-user-list">
                                    <li>
                                        <figure class="image">    
                                            <img src="'. $chat_image .'" alt="'. $chat_name .'"
                                                class="rounded-circle" style="height: 36px;width: 36px;" />
                                        </figure>
                                        <span class="title mb-1">'. $chat_name .'</span>
                                        <span class="message">'. $user[$i]->last_edited .'</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="todo-actions">'. $unread .'</div>
                        </a>
                    </li>
                ';
            }
            
            $str = $list;
        }
        else {
            $str = '<li><center><div class="notification-icon"><i class="bx bx-error"></i> Belum ada data</div></center></li>';
        }
        
        return $str;
    }

    public function load_chat_profile($id)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'chat/get-by-single';
        $param = array(
            'chat_id' => $id,
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $btn = "";
            if(Session::get('user_type') == 1) {
                $user_path      = $res->data->chat_to->user_path;
                $user_fullname  = $res->data->chat_to->user_fullname;

                $btn = 
                '
                    <div class="pull-right">
                        <a class="btn btn-sm btn-default" style="margin-top: 20px;" href="javascript:void(0);" OnClick="removeMessage('. $res->data->chat_id .');">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                ';
            }
            else {
                $user_path      = $res->data->chat_from->user_path;
                $user_fullname  = $res->data->chat_from->user_fullname;
            }

            $str = '
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="'. $user_path .'" style="width: 50px;height: 50px;" />
                                </div>
                                <div class="profile-info">
                                    <h4 class="name font-weight-semibold mb-0">'. $user_fullname .'</h4>
                                    <h5 class="role mt-0">'. $res->data->last_edited .'</h5>
                                </div>
                            </div>
                        </div>
                        '. $btn .'
                    </div>
                </div>
            ';
        }
        else {
            $str = '
                <center>...</center>
            ';
        }

        return $str;
    }

    public function load_chat_message($id)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'chat/get-message';
        $param = array(
            'chat_id'   => $id,
            'type'      => Session::get('user_type'),
            'user_id'   => Session::get('user_id'),
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $list = "";
            $text = $res->data;

            foreach($text as $row) {
                if($row->message_type == 1) { 
                    $style  = 'style="margin: 5px;padding: 5px 5px 2px 30px;"';
                    $styles = 'style="width: 100%;line-height: 24px;text-align:right;background: #f9f9f9;"';
                } else { 
                    $style  = 'style="margin: 5px;padding: 5px 30px 2px 5px;"';
                    $styles = 'style="width: 100%;line-height: 24px;text-align:left;background: #ffffff;"';
                } 

                $list .= '
                    <div class="tm-body" '. $style .'>
                        <div class="tm-title" '. $styles .'>
                            <h5 class="m-0 pt-2 pb-2">'. $row->message_text .'</h5>
                            <small>'. $row->message_datetime .'</small>
                        </div>
                    </div>
                ';
            }
            
            $str = $list;
        }
        else {
            $str = '
                <div class="row">
                    <div class="widget-profile-info">
                        <div class="profile-picture">
                            <img src="'. asset("assets/img/webphada.png") .'" style="width: 50px;height: 50px;" />
                        </div>
                        <div class="profile-info">
                            <h2 class="name font-weight-semibold mb-0"> ...</h2>
                        </div>
                    </div>
                </div>
            ';
        }

        return $str;
    }

    public function load_chat_append($id)
    {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'chat/check-message';
        $param = array(
            'chat_id'   => $id,
            'type'      => Session::get('user_type'),
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $list = "";
            $text = $res->data;

            foreach($text as $row) {
                if($row->message_type == 1) { 
                    $style  = 'style="margin: 5px;padding: 5px 5px 2px 30px;"';
                    $styles = 'style="width: 100%;line-height: 24px;text-align:right;background: #f9f9f9;"';
                } else { 
                    $style  = 'style="margin: 5px;padding: 5px 30px 2px 5px;"';
                    $styles = 'style="width: 100%;line-height: 24px;text-align:left;background: #ffffff;"';
                } 

                $list .= '
                    <div class="tm-body" '. $style .'>
                        <div class="tm-title" '. $styles .'>
                            <h5 class="m-0 pt-2 pb-2">'. $row->message_text .'</h5>
                            <small>'. $row->message_datetime .'</small>
                        </div>
                    </div>
                ';
            }
            
            $str = $list;
        }
        else {
            $str = '';
        }

        return $str;
    }

    public function process_chat(Request $request)
    {
        $chat_id = $request->chat_id;
        $message = $request->message;

        $uri = Curl::endpoint();
        $url = $uri .'/'.'chat/process-message';
        $param = array(
            'chat_id'   => $chat_id,
            'type'      => Session::get('user_type'),
            'message'   => $message
        );

        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $str = 1;
        }
        else {
            $str = 0;
        }

        return $str;
    }


    public function load_chart_line($month) {
        $uri = Curl::endpoint();
        $url = $uri .'/'.'activity/get-chart-line';
        $param = array(
            'month'   => $month,
            'user_id' => Session::get('user_id'),
        );

        $str = "";
        $res = Curl::requestPost($url, $param);
        if($res->status == true) {
            $str .= '
            
            <script type="text/javascript">
            plot = $.plot("#flotBasic", flotBasicData, {
				series: {
					lines: {
						show: true,
						fill: true,
						lineWidth: 1,
						fillColor: {
							colors: [{
								opacity: 0.45
							}, {
								opacity: 0.45
							}]
						}
					},
					points: {
						show: true
					},
					shadowSize: 0
				},
				grid: {
					hoverable: true,
					clickable: true,
					borderColor: "rgba(0,0,0,0.1)",
					borderWidth: 1,
					labelMargin: 15,
					backgroundColor: "transparent"
				},
				yaxis: {
					min: 0,
					color: "rgba(0,0,0,0.1)"
				},
				xaxis: {
					color: "rgba(0,0,0,0.1)"
				},
				tooltip: true,
				tooltipOpts: {
					content: "Tanggal %x = %y",
					shifts: {
						x: -60,
						y: 25
					},
					defaultTheme: false
				}
			});
            flotBasicData = [{
                data: [
        ';

           foreach ($res->data as $row) {
            $str .= '['. $row->day .', '. $row->count .'],';
           }   

           $str .= '
                ],
                label: "'. Status::monthName($month) .'",
                color: "#00AC69"
            }];
            </script>
            <div class="chart chart-md" id="flotBasic"></div>
        ';
        }

        return $str;
    }
}