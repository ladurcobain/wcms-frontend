<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\GuidanceController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\ApkController;
use App\Http\Controllers\ConfigPreferenceController;
use App\Http\Controllers\ConfigPositionController;
use App\Http\Controllers\ConfigTransmitController;
use App\Http\Controllers\MasterModuleController;
use App\Http\Controllers\MasterMenuController;
use App\Http\Controllers\MasterTutorialController;
use App\Http\Controllers\MasterRequestController;
use App\Http\Controllers\MasterSatkerController;
use App\Http\Controllers\MasterPatternController;
use App\Http\Controllers\MasterCoverController;
use App\Http\Controllers\FilemanagerPdfController;
use App\Http\Controllers\FilemanagerImageController;
use App\Http\Controllers\FilemanagerVideoController;
use App\Http\Controllers\BackupManagerController;
use App\Http\Controllers\ProfileController;
//use App\Http\Controllers\SatkerController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserExportController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\ReportViewerController;
use App\Http\Controllers\ReportPollingController;
use App\Http\Controllers\ReportContactUsController;
use App\Http\Controllers\ReportNewsletterController;
use App\Http\Controllers\ReportArticleController;
use App\Http\Controllers\ReportSummaryController;
use App\Http\Controllers\ReportAnnuallyController;
use App\Http\Controllers\ReportMonthlyController;
use App\Http\Controllers\ReportDailyController;

use App\Http\Controllers\HomeBannerController;
use App\Http\Controllers\HomeInfografisController;
use App\Http\Controllers\HomeRelatedController;
use App\Http\Controllers\AboutInfoController;
use App\Http\Controllers\AboutStoryController;
use App\Http\Controllers\AboutDoctrinController;
use App\Http\Controllers\AboutLogoController;
use App\Http\Controllers\AboutIadController;
use App\Http\Controllers\AboutIntroController;
use App\Http\Controllers\AboutVisionController;
use App\Http\Controllers\AboutMisionController;
use App\Http\Controllers\AboutProgramController;
use App\Http\Controllers\AboutCommandController;
use App\Http\Controllers\IntegrityLegalController;
use App\Http\Controllers\IntegrityAccountabilityController;
use App\Http\Controllers\IntegrityArrangementController;
use App\Http\Controllers\IntegrityMechanismController;
use App\Http\Controllers\IntegrityInnovationController;
use App\Http\Controllers\IntegritySupervisionController;
use App\Http\Controllers\IntegrityProfessionalismController;
use App\Http\Controllers\ContactMedsosController;
use App\Http\Controllers\ConferenceNewsController;
use App\Http\Controllers\InformationDpoController;
use App\Http\Controllers\InformationUnitController;
use App\Http\Controllers\InformationStructuralController;
use App\Http\Controllers\InformationServiceController;
use App\Http\Controllers\InformationInfrastructureController;
use App\Http\Controllers\ArchivePhotoController;
use App\Http\Controllers\ArchiveRegulationController;
use App\Http\Controllers\ArchiveMovieController;
use App\Http\Controllers\ConfigureController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/',  [AuthController::class, 'index'])->name('login');
Route::post('/post-login',  [AuthController::class, 'loginPost'])->name('login.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('error', [ErrorController::class, 'index'])->name('error.index');
Route::get('/refresh-captcha',  [AuthController::class, 'refreshCaptcha'])->name('refresh-captcha');
Route::get('/schedule-backup',  [AuthController::class, 'scheduleBackup'])->name('schedule-backup');

Route::get('ajax/notif-alert/{id}', [AjaxController::class, 'notif_alert']);
Route::get('ajax/notif-message/{id}', [AjaxController::class, 'notif_message']);
Route::get('ajax/modal-userrole/{id}', [AjaxController::class, 'modal_userrole']);
Route::get('ajax/modal-satkermenu/{id}', [AjaxController::class, 'modal_satkermenu']);
Route::get('ajax/modal-visitor/{id}', [AjaxController::class, 'modal_visitor']);
Route::get('ajax/load-chart-line/{id}', [AjaxController::class, 'load_chart_line']);

Route::get('ajax/load-chat-user', [AjaxController::class, 'load_chat_user']);
Route::get('ajax/load-chat-profile/{id}', [AjaxController::class, 'load_chat_profile']);
Route::get('ajax/load-chat-message/{id}', [AjaxController::class, 'load_chat_message']);
Route::get('ajax/load-chat-append/{id}', [AjaxController::class, 'load_chat_append']);
Route::post('ajax/process-chat', [AjaxController::class, 'process_chat']);

Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
Route::post('chat/process', [ChatController::class, 'process']);
Route::post('chat/remove', [ChatController::class, 'remove']);
Route::get('integration/download', [IntegrationController::class, 'download'])->name('integration.download');

Route::group(['middleware' => ['checkLogin']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('guidance', [GuidanceController::class, 'index'])->name('guidance.index');
    Route::get('integration', [IntegrationController::class, 'index'])->name('integration.index');
    Route::get('apk', [ApkController::class, 'index'])->name('apk.index');
    
    // CONFIG PREFERENCE
    Route::resource('config/preference', ConfigPreferenceController::class);
    Route::post('config/preference/update', [ConfigPreferenceController::class, 'update'])->name('preference.update');

    // CONFIG TRANSMIT
    Route::resource('config/transmit', ConfigTransmitController::class);
    Route::post('config/transmit/store', [ConfigTransmitController::class, 'store'])->name('transmit.store');
    
    // PENGATURAN MENU
    Route::get('config/position', [ConfigPositionController::class, 'index'])->name('position.index');
    Route::post('config/position/sorting', [ConfigPositionController::class, 'sorting'])->name('position.sorting');
    Route::post('config/position/edit', [ConfigPositionController::class, 'edit'])->name('position.edit');
    Route::post('config/position/update', [ConfigPositionController::class, 'update'])->name('position.update');

    // MASTER MODULE
    Route::post('master/module/update', [MasterModuleController::class, 'update'])->name('module.update');
    Route::post('master/module/search', [MasterModuleController::class, 'search'])->name('module.search');
    Route::post('master/module/filter', [MasterModuleController::class, 'filter'])->name('module.filter');
    Route::get('master/module/search', [MasterModuleController::class, 'search'])->name('module.search');
    Route::get('master/module', [MasterModuleController::class, 'index'])->name('module.index');
    Route::get('master/module/{id}/edit', [MasterModuleController::class, 'edit'])->name('module.edit');

    // MASTER MENU
    Route::post('master/menu/update', [MasterMenuController::class, 'update'])->name('menu.update');
    Route::post('master/menu/search', [MasterMenuController::class, 'search'])->name('menu.search');
    Route::post('master/menu/filter', [MasterMenuController::class, 'filter'])->name('menu.filter');
    Route::get('master/menu/search', [MasterMenuController::class, 'search'])->name('menu.search');
    Route::get('master/menu', [MasterMenuController::class, 'index'])->name('menu.index');
    Route::get('master/menu/{id}/edit', [MasterMenuController::class, 'edit'])->name('menu.edit');

    // MASTER TUTORIAL
    Route::post('master/tutorial/update', [MasterTutorialController::class, 'update'])->name('tutorial.update');
    Route::post('master/tutorial/search', [MasterTutorialController::class, 'search'])->name('tutorial.search');
    Route::get('master/tutorial/destroy/{id}', [MasterTutorialController::class, 'destroy']);
    Route::post('master/tutorial/filter', [MasterTutorialController::class, 'filter'])->name('tutorial.filter');
    Route::get('master/tutorial/search', [MasterTutorialController::class, 'search'])->name('tutorial.search');
    Route::get('master/tutorial', [MasterTutorialController::class, 'index'])->name('tutorial.index');
    Route::get('master/tutorial/{id}/edit', [MasterTutorialController::class, 'edit'])->name('tutorial.edit');
    Route::get('master/tutorial/create', [MasterTutorialController::class, 'create'])->name('tutorial.create');
    Route::post('master/tutorial/store', [MasterTutorialController::class, 'store'])->name('tutorial.store');

    // MASTER REQUEST
    Route::post('master/request/update', [MasterRequestController::class, 'update'])->name('request.update');
    Route::post('master/request/search', [MasterRequestController::class, 'search'])->name('request.search');
    Route::get('master/request/destroy/{id}', [MasterRequestController::class, 'destroy']);
    Route::post('master/request/process', [MasterRequestController::class, 'process'])->name('request.process');
    Route::get('master/request/remove/{i}/{p}', [MasterRequestController::class, 'remove']);
    Route::post('master/request/filter', [MasterRequestController::class, 'filter'])->name('request.filter');
    Route::get('master/request/search', [MasterRequestController::class, 'search'])->name('request.search');
    Route::get('master/request', [MasterRequestController::class, 'index'])->name('request.index');
    Route::get('master/request/{id}/edit', [MasterRequestController::class, 'edit'])->name('request.edit');
    Route::get('master/request/create', [MasterRequestController::class, 'create'])->name('request.create');
    Route::post('master/request/store', [MasterRequestController::class, 'store'])->name('request.store');

    // MASTER SATKER
    Route::post('master/satker/update-info', [MasterSatkerController::class, 'updateinfo'])->name('satker.updateinfo');
    Route::post('master/satker/update-medsos', [MasterSatkerController::class, 'updatemedsos'])->name('satker.updatemedsos');
    Route::post('master/satker/update-support', [MasterSatkerController::class, 'updatesupport'])->name('satker.updatesupport');
    Route::post('master/satker/update-videos', [MasterSatkerController::class, 'updatevideos'])->name('satker.updatevideos');
    Route::post('master/satker/update-patterns', [MasterSatkerController::class, 'updatepatterns'])->name('satker.updatepatterns');
    Route::post('master/satker/update-backgrounds', [MasterSatkerController::class, 'updatebackgrounds'])->name('satker.updatebackgrounds');
    Route::post('master/satker/search', [MasterSatkerController::class, 'search'])->name('satker.search');
    Route::get('master/satker/destroy/{id}', [MasterSatkerController::class, 'destroy'])->name('satker.destroy');
    Route::post('master/satker/process', [MasterSatkerController::class, 'process'])->name('satker.process');
    Route::get('master/satker/detail/{id}', [MasterSatkerController::class, 'detail'])->name('satker.detail');
    Route::post('master/satker/filter', [MasterSatkerController::class, 'filter'])->name('satker.filter');
    Route::get('master/satker/search', [MasterSatkerController::class, 'search'])->name('satker.search');
    Route::get('master/satker', [MasterSatkerController::class, 'index'])->name('satker.index');
    Route::get('master/satker/{id}/edit', [MasterSatkerController::class, 'edit'])->name('satker.edit');
    Route::get('master/satker/create', [MasterSatkerController::class, 'create'])->name('satker.create');
    Route::post('master/satker/store', [MasterSatkerController::class, 'store'])->name('satker.store');

    // MASTER pattern
    Route::post('master/pattern/update', [MasterPatternController::class, 'update'])->name('pattern.update');
    Route::post('master/pattern/search', [MasterPatternController::class, 'search'])->name('pattern.search');
    Route::get('master/pattern/destroy/{id}', [MasterPatternController::class, 'destroy']);
    Route::post('master/pattern/filter', [MasterPatternController::class, 'filter'])->name('pattern.filter');
    Route::get('master/pattern/search', [MasterPatternController::class, 'search'])->name('pattern.search');
    Route::get('master/pattern', [MasterPatternController::class, 'index'])->name('pattern.index');
    Route::get('master/pattern/{id}/edit', [MasterPatternController::class, 'edit'])->name('pattern.edit');
    Route::get('master/pattern/create', [MasterPatternController::class, 'create'])->name('pattern.create');
    Route::post('master/pattern/store', [MasterPatternController::class, 'store'])->name('pattern.store');

    // MASTER cover
    Route::post('master/cover/update', [MasterCoverController::class, 'update'])->name('cover.update');
    Route::post('master/cover/search', [MasterCoverController::class, 'search'])->name('cover.search');
    Route::get('master/cover/destroy/{id}', [MasterCoverController::class, 'destroy']);
    Route::post('master/cover/filter', [MasterCoverController::class, 'filter'])->name('cover.filter');
    Route::get('master/cover/search', [MasterCoverController::class, 'search'])->name('cover.search');
    Route::get('master/cover', [MasterCoverController::class, 'index'])->name('cover.index');
    Route::get('master/cover/{id}/edit', [MasterCoverController::class, 'edit'])->name('cover.edit');
    Route::get('master/cover/create', [MasterCoverController::class, 'create'])->name('cover.create');
    Route::post('master/cover/store', [MasterCoverController::class, 'store'])->name('cover.store');


    //PROFILE
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile-update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile-password', [ProfileController::class, 'password'])->name('profile.password');
    
    Route::get('contents', [ContentsController::class, 'index'])->name('contents.index');
    Route::post('contents/filter', [ContentsController::class, 'filter'])->name('contents.filter');
    Route::post('contents/search', [ContentsController::class, 'search'])->name('contents.search');
    Route::get('contents/search', [ContentsController::class, 'search'])->name('contents.search');

    // SATKER
    // Route::post('satker/update-info', [SatkerController::class, 'updateinfo'])->name('satker.updateinfo');
    // Route::post('satker/update-medsos', [SatkerController::class, 'updatemedsos'])->name('satker.updatemedsos');
    // Route::post('satker/update-support', [SatkerController::class, 'updatesupport'])->name('satker.updatesupport');
    // Route::post('satker/update-videos', [SatkerController::class, 'updatevideos'])->name('satker.updatevideos');
    // Route::post('satker/search', [SatkerController::class, 'search'])->name('satker.search');
    // Route::get('satker/destroy/{id}', [SatkerController::class, 'destroy'])->name('satker.destroy');
    // Route::post('satker/process', [SatkerController::class, 'process'])->name('satker.process');
    // Route::get('satker/detail/{id}', [SatkerController::class, 'detail'])->name('satker.detail');
    // Route::post('satker/filter', [SatkerController::class, 'filter'])->name('satker.filter');
    // Route::get('satker/search', [SatkerController::class, 'search'])->name('satker.search');
    // Route::get('satker', [SatkerController::class, 'index'])->name('satker.index');
    // Route::get('satker/{id}/edit', [SatkerController::class, 'edit'])->name('satker.edit');
    // Route::get('satker/create', [SatkerController::class, 'create'])->name('satker.create');
    // Route::post('satker/store', [SatkerController::class, 'store'])->name('satker.store');


    // USER MANAGEMENT
    Route::post('user/management/update', [UserManagementController::class, 'update'])->name('management.update');
    Route::post('user/management/password', [UserManagementController::class, 'password'])->name('management.password');
    Route::post('user/management/search', [UserManagementController::class, 'search']);
    Route::get('user/management/destroy/{id}', [UserManagementController::class, 'destroy']);
    Route::post('user/management/filter', [UserManagementController::class, 'filter'])->name('management.filter');
    Route::get('user/management/search', [UserManagementController::class, 'search'])->name('management.search');
    Route::get('user/management', [UserManagementController::class, 'index'])->name('management.index');
    Route::get('user/management/{id}/edit', [UserManagementController::class, 'edit'])->name('management.edit');
    Route::get('user/management/create', [UserManagementController::class, 'create'])->name('management.create');
    Route::post('user/management/store', [UserManagementController::class, 'store'])->name('management.store');

    // USER ROLE
    Route::post('user/role/update', [UserRoleController::class, 'update'])->name('role.update');
    Route::post('user/role/search', [UserRoleController::class, 'search']);
    Route::get('user/role/destroy/{id}', [UserRoleController::class, 'destroy']);
    Route::post('user/role/process', [UserRoleController::class, 'process'])->name('role.process');
    Route::get('user/role/detail/{id}', [UserRoleController::class, 'detail'])->name('role.detail');
    Route::post('user/role/filter', [UserRoleController::class, 'filter'])->name('role.filter');
    Route::get('user/role/search', [UserRoleController::class, 'search'])->name('role.search');
    Route::get('user/role', [UserRoleController::class, 'index'])->name('role.index');
    Route::get('user/role/{id}/edit', [UserRoleController::class, 'edit'])->name('role.edit');
    Route::get('user/role/create', [UserRoleController::class, 'create'])->name('role.create');
    Route::post('user/role/store', [UserRoleController::class, 'store'])->name('role.store');

    // USER EXPORT
    Route::post('user/export/download', [UserExportController::class, 'download'])->name('export.download');
    Route::post('user/export/search', [UserExportController::class, 'search'])->name('export.search');
    Route::get('user/export/detail/{id}', [UserExportController::class, 'detail'])->name('export.detail');
    Route::post('user/export/excell', [UserExportController::class, 'excell'])->name('export.excell');
    Route::post('user/export/filter', [UserExportController::class, 'filter'])->name('export.filter');
    Route::get('user/export/search', [UserExportController::class, 'search'])->name('export.search');
    Route::get('user/export', [UserExportController::class, 'index'])->name('export.index');
    

    // LOG ACTIVITY
    Route::get('log-activity', [LogActivityController::class, 'index'])->name('log-activity.index');
    Route::post('log-activity/search', [LogActivityController::class, 'search'])->name('log-activity.search');
    Route::get('log-activity/search', [LogActivityController::class, 'search'])->name('log-activity.search');
    Route::post('log-activity/filter', [LogActivityController::class, 'filter'])->name('log-activity.filter');
    
    // NOTIFICATION
    Route::get('notification', [NotificationController::class, 'index'])->name('notification.index');
    Route::post('notification/search', [NotificationController::class, 'search'])->name('notification.search');
    Route::get('notification/destroy/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');
    Route::get('notification/detail/{id}', [NotificationController::class, 'detail'])->name('notification.detail');
    Route::get('notification/edit/{id}', [NotificationController::class, 'edit'])->name('notification.edit');
    Route::post('notification/update', [NotificationController::class, 'update'])->name('notification.update');
    Route::post('notification/filter', [NotificationController::class, 'filter'])->name('notification.filter');
    Route::get('notification/search', [NotificationController::class, 'search'])->name('notification.search');
    
    // SURVEY
    Route::get('survey', [SurveyController::class, 'index'])->name('survey.index');
    Route::post('survey/search', [SurveyController::class, 'search'])->name('survey.search');
    Route::get('survey/destroy/{id}', [SurveyController::class, 'destroy'])->name('survey.destroy');
    Route::get('survey/detail/{id}', [SurveyController::class, 'detail'])->name('survey.detail');
    Route::post('survey/filter', [SurveyController::class, 'filter'])->name('survey.filter');
    Route::get('survey/search', [SurveyController::class, 'search'])->name('survey.search');


    // BACKUP MANAGER
    Route::get('backupmanager', [BackupManagerController::class, 'index'])->name('backupmanager.index');
    Route::post('create', [BackupManagerController::class, 'createBackup'])->name('backupmanager_create');
    Route::post('restore_delete', [BackupManagerController::class, 'restoreOrDeleteBackups'])->name('backupmanager_restore_delete');
    Route::get('download/{file}', [BackupManagerController::class, 'download'])->name('backupmanager_download');

    // FILE MANAGER
    Route::get('filemanager/filepdf', [FilemanagerPdfController::class, 'index'])->name('filepdf.index');
    Route::post('filemanager/filepdf-filter', [FilemanagerPdfController::class, 'filter'])->name('filepdf.filter');
    Route::post('filemanager/filepdf/search', [FilemanagerPdfController::class, 'search'])->name('filepdf.search');
    Route::get('filemanager/filepdf/search', [FilemanagerPdfController::class, 'search'])->name('filepdf.search');
    Route::get('filemanager/filepdf/page/{id}', [FilemanagerPdfController::class, 'page']);

    Route::get('filemanager/fileimage', [FilemanagerImageController::class, 'index'])->name('fileimage.index');
    Route::post('filemanager/fileimage-filter', [FilemanagerImageController::class, 'filter'])->name('fileimage.filter');
    Route::post('filemanager/fileimage/search', [FilemanagerImageController::class, 'search'])->name('fileimage.search');
    Route::get('filemanager/fileimage/search', [FilemanagerImageController::class, 'search'])->name('fileimage.search');

    Route::get('filemanager/filevideo', [FilemanagerVideoController::class, 'index'])->name('filevideo.index');
    Route::post('filemanager/filevideo-filter', [FilemanagerVideoController::class, 'filter'])->name('filevideo.filter');
    Route::post('filemanager/filevideo/search', [FilemanagerVideoController::class, 'search'])->name('filevideo.search');
    Route::get('filemanager/filevideo/search', [FilemanagerVideoController::class, 'search'])->name('filevideo.search');

    // VIEWER
    Route::get('report/viewer', [ReportViewerController::class, 'index'])->name('viewer.index');
    Route::post('report/viewer/search', [ReportViewerController::class, 'search'])->name('viewer.search');
    Route::get('report/viewer/search', [ReportViewerController::class, 'search'])->name('viewer.search');
    Route::post('report/viewer/filter', [ReportViewerController::class, 'filter'])->name('viewer.filter');
    Route::post('report/viewer/download', [ReportViewerController::class, 'download'])->name('viewer.download');
    Route::post('report/viewer/excell', [ReportViewerController::class, 'excell'])->name('viewer.excell');

    // POLLING
    Route::get('report/polling', [ReportPollingController::class, 'index'])->name('polling.index');
    Route::post('report/polling/search', [ReportPollingController::class, 'search'])->name('polling.search');
    Route::get('report/polling/search', [ReportPollingController::class, 'search'])->name('polling.search');
    Route::get('report/polling/destroy/{id}', [ReportPollingController::class, 'destroy'])->name('polling.destroy');
    Route::get('report/polling/detail/{id}', [ReportPollingController::class, 'detail'])->name('polling.detail');
    Route::post('report/polling/filter', [ReportPollingController::class, 'filter'])->name('polling.filter');
    Route::post('report/polling/download', [ReportPollingController::class, 'download'])->name('polling.download');
    Route::post('report/polling/excell', [ReportPollingController::class, 'excell'])->name('polling.excell');

    // CONTACT-US
    Route::get('report/contact-us', [ReportContactUsController::class, 'index'])->name('contact-us.index');
    Route::post('report/contact-us/search', [ReportContactUsController::class, 'search'])->name('contact-us.search');
    Route::get('report/contact-us/search', [ReportContactUsController::class, 'search'])->name('contact-us.search');
    Route::get('report/contact-us/destroy/{id}', [ReportContactUsController::class, 'destroy'])->name('contact-us.destroy');
    Route::get('report/contact-us/detail/{id}', [ReportContactUsController::class, 'detail'])->name('contact-us.detail');
    Route::post('report/contact-us/filter', [ReportContactUsController::class, 'filter'])->name('contact-us.filter');
    Route::post('report/contact-us/download', [ReportContactUsController::class, 'download'])->name('contact-us.download');
    Route::post('report/contact-us/excell', [ReportContactUsController::class, 'excell'])->name('contact-us.excell');

    // NEWSLETTER
    Route::get('report/newsletter', [ReportNewsletterController::class, 'index'])->name('newsletter.index');
    Route::post('report/newsletter/search', [ReportNewsletterController::class, 'search'])->name('newsletter.search');
    Route::get('report/newsletter/search', [ReportNewsletterController::class, 'search'])->name('newsletter.search'); 
    Route::get('report/newsletter/destroy/{id}', [ReportNewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::get('report/newsletter/detail/{id}', [ReportNewsletterController::class, 'detail'])->name('newsletter.detail');
    Route::post('report/newsletter/filter', [ReportNewsletterController::class, 'filter'])->name('newsletter.filter');
    Route::post('report/newsletter/download', [ReportNewsletterController::class, 'download'])->name('newsletter.download');
    Route::post('report/newsletter/excell', [ReportNewsletterController::class, 'excell'])->name('newsletter.excell');

    // NEWSLETTER
    Route::get('report/article', [ReportArticleController::class, 'index'])->name('article.index');
    Route::post('report/article/search', [ReportArticleController::class, 'search'])->name('article.search');
    Route::get('report/article/search', [ReportArticleController::class, 'search'])->name('article.search'); 
    Route::get('report/article/destroy/{id}', [ReportArticleController::class, 'destroy'])->name('article.destroy');
    Route::get('report/article/detail/{id}', [ReportArticleController::class, 'detail'])->name('article.detail');
    Route::post('report/article/filter', [ReportArticleController::class, 'filter'])->name('article.filter');
    Route::post('report/article/download', [ReportArticleController::class, 'download'])->name('article.download');
    Route::post('report/article/excell', [ReportArticleController::class, 'excell'])->name('article.excell');
    Route::get('report/article/status/{id}', [ReportArticleController::class, 'status'])->name('article.status');

    // SUMMARY
    Route::get('report/summary', [ReportSummaryController::class, 'index'])->name('summary.index');
    Route::post('report/summary/search', [ReportSummaryController::class, 'search'])->name('summary.search');
    Route::get('report/summary/search', [ReportSummaryController::class, 'search'])->name('summary.search');
    Route::post('report/summary/filter', [ReportSummaryController::class, 'filter'])->name('summary.filter');
    Route::post('report/summary/download', [ReportSummaryController::class, 'download'])->name('summary.download');
    Route::post('report/summary/excell', [ReportSummaryController::class, 'excell'])->name('summary.excell');

    // ANNUALLY
    Route::get('report/annually', [ReportAnnuallyController::class, 'index'])->name('annually.index');
    Route::post('report/annually/search', [ReportAnnuallyController::class, 'search'])->name('annually.search');
    Route::get('report/annually/search', [ReportAnnuallyController::class, 'search'])->name('annually.search');
    Route::post('report/annually/filter', [ReportAnnuallyController::class, 'filter'])->name('annually.filter');
    Route::post('report/annually/download', [ReportAnnuallyController::class, 'download'])->name('annually.download');
    Route::post('report/annually/excell', [ReportAnnuallyController::class, 'excell'])->name('annually.excell');

    // MONTHLY
    Route::get('report/monthly', [ReportMonthlyController::class, 'index'])->name('monthly.index');
    Route::post('report/monthly/search', [ReportMonthlyController::class, 'search'])->name('monthly.search');
    Route::get('report/monthly/search', [ReportMonthlyController::class, 'search'])->name('monthly.search');
    Route::post('report/monthly/filter', [ReportMonthlyController::class, 'filter'])->name('monthly.filter');
    Route::post('report/monthly/download', [ReportMonthlyController::class, 'download'])->name('monthly.download');
    Route::post('report/monthly/excell', [ReportMonthlyController::class, 'excell'])->name('monthly.excell');

    // DAILY
    Route::get('report/daily', [ReportDailyController::class, 'index'])->name('daily.index');
    Route::post('report/daily/search', [ReportDailyController::class, 'search'])->name('daily.search');
    Route::get('report/daily/search', [ReportDailyController::class, 'search'])->name('daily.search');
    Route::post('report/daily/filter', [ReportDailyController::class, 'filter'])->name('daily.filter');
    Route::post('report/daily/download', [ReportDailyController::class, 'download'])->name('daily.download');
    Route::post('report/daily/excell', [ReportDailyController::class, 'excell'])->name('daily.excell');
    
    
    // HOME BANNER
    Route::post('home/banner/search', [HomeBannerController::class, 'search'])->name('banner.search');
    Route::post('home/banner/update', [HomeBannerController::class, 'update'])->name('banner.update');
    Route::get('home/banner/destroy/{id}', [HomeBannerController::class, 'destroy']);
    Route::post('home/banner/filter', [HomeBannerController::class, 'filter'])->name('banner.filter');
    Route::get('home/banner/search', [HomeBannerController::class, 'search'])->name('banner.search');
    Route::get('home/banner', [HomeBannerController::class, 'index'])->name('banner.index');
    Route::get('home/banner/{id}/edit', [HomeBannerController::class, 'edit'])->name('banner.edit');
    Route::get('home/banner/create', [HomeBannerController::class, 'create'])->name('banner.create');
    Route::post('home/banner/store', [HomeBannerController::class, 'store'])->name('banner.store');

    // HOME INFOGRAFIS
    Route::post('home/infografis/search', [HomeInfografisController::class, 'search'])->name('infografis.search');
    Route::post('home/infografis/update', [HomeInfografisController::class, 'update'])->name('infografis.update');
    Route::get('home/infografis/destroy/{id}', [HomeInfografisController::class, 'destroy']);
    Route::post('home/infografis/filter', [HomeInfografisController::class, 'filter'])->name('infografis.filter');
    Route::get('home/infografis/search', [HomeInfografisController::class, 'search'])->name('infografis.search');
    Route::get('home/infografis', [HomeInfografisController::class, 'index'])->name('infografis.index');
    Route::get('home/infografis/{id}/edit', [HomeInfografisController::class, 'edit'])->name('infografis.edit');
    Route::get('home/infografis/create', [HomeInfografisController::class, 'create'])->name('infografis.create');
    Route::post('home/infografis/store', [HomeInfografisController::class, 'store'])->name('infografis.store');

    // HOME RELATED
    Route::post('home/related/search', [HomeRelatedController::class, 'search'])->name('related.search');
    Route::post('home/related/update', [HomeRelatedController::class, 'update'])->name('related.update');
    Route::get('home/related/destroy/{id}', [HomeRelatedController::class, 'destroy']);
    Route::post('home/related/filter', [HomeRelatedController::class, 'filter'])->name('related.filter');
    Route::get('home/related/search', [HomeRelatedController::class, 'search'])->name('related.search');
    Route::get('home/related', [HomeRelatedController::class, 'index'])->name('related.index');
    Route::get('home/related/{id}/edit', [HomeRelatedController::class, 'edit'])->name('related.edit');
    Route::get('home/related/create', [HomeRelatedController::class, 'create'])->name('related.create');
    Route::post('home/related/store', [HomeRelatedController::class, 'store'])->name('related.store');

    // ABOUT INFO
    Route::post('about/info/search', [AboutInfoController::class, 'search'])->name('info.search');
    Route::post('about/info/update', [AboutInfoController::class, 'update'])->name('info.update');
    Route::get('about/info/destroy/{id}', [AboutInfoController::class, 'destroy']);
    Route::post('about/info/filter', [AboutInfoController::class, 'filter'])->name('info.filter');
    Route::get('about/info/search', [AboutInfoController::class, 'search'])->name('info.search');
    Route::get('about/info', [AboutInfoController::class, 'index'])->name('info.index');
    Route::get('about/info/{id}/edit', [AboutInfoController::class, 'edit'])->name('info.edit');
    Route::get('about/info/create', [AboutInfoController::class, 'create'])->name('info.create');
    Route::post('about/info/store', [AboutInfoController::class, 'store'])->name('info.store');

    // ABOUT STORY
    Route::post('about/story/search', [AboutStoryController::class, 'search'])->name('story.search');
    Route::post('about/story/update', [AboutStoryController::class, 'update'])->name('story.update');
    Route::get('about/story/destroy/{id}', [AboutStoryController::class, 'destroy']);
    Route::post('about/story/filter', [AboutStoryController::class, 'filter'])->name('story.filter');
    Route::get('about/story/search', [AboutStoryController::class, 'search'])->name('story.search');
    Route::get('about/story', [AboutStoryController::class, 'index'])->name('story.index');
    Route::get('about/story/{id}/edit', [AboutStoryController::class, 'edit'])->name('story.edit');
    Route::get('about/story/create', [AboutStoryController::class, 'create'])->name('story.create');
    Route::post('about/story/store', [AboutStoryController::class, 'store'])->name('story.store');

    // ABOUT DOCTRIN
    Route::post('about/doctrin/search', [AboutDoctrinController::class, 'search'])->name('doctrin.search');
    Route::post('about/doctrin/update', [AboutDoctrinController::class, 'update'])->name('doctrin.update');
    Route::get('about/doctrin/destroy/{id}', [AboutDoctrinController::class, 'destroy']);
    Route::post('about/doctrin/filter', [AboutDoctrinController::class, 'filter'])->name('doctrin.filter');
    Route::get('about/doctrin/search', [AboutDoctrinController::class, 'search'])->name('doctrin.search');
    Route::get('about/doctrin', [AboutDoctrinController::class, 'index'])->name('doctrin.index');
    Route::get('about/doctrin/{id}/edit', [AboutDoctrinController::class, 'edit'])->name('doctrin.edit');
    Route::get('about/doctrin/create', [AboutDoctrinController::class, 'create'])->name('doctrin.create');
    Route::post('about/doctrin/store', [AboutDoctrinController::class, 'store'])->name('doctrin.store');
    
    // ABOUT LOGO
    Route::post('about/logo/search', [AboutLogoController::class, 'search'])->name('logo.search');
    Route::post('about/logo/update', [AboutLogoController::class, 'update'])->name('logo.update');
    Route::get('about/logo/destroy/{id}', [AboutLogoController::class, 'destroy']);
    Route::post('about/logo/filter', [AboutLogoController::class, 'filter'])->name('logo.filter');
    Route::get('about/logo/search', [AboutLogoController::class, 'search'])->name('logo.search');
    Route::get('about/logo', [AboutLogoController::class, 'index'])->name('logo.index');
    Route::get('about/logo/{id}/edit', [AboutLogoController::class, 'edit'])->name('logo.edit');
    Route::get('about/logo/create', [AboutLogoController::class, 'create'])->name('logo.create');
    Route::post('about/logo/store', [AboutLogoController::class, 'store'])->name('logo.store');

    // ABOUT IAD
    Route::post('about/iad/search', [AboutIadController::class, 'search'])->name('iad.search');
    Route::post('about/iad/update', [AboutIadController::class, 'update'])->name('iad.update');
    Route::get('about/iad/destroy/{id}', [AboutIadController::class, 'destroy']);
    Route::post('about/iad/filter', [AboutIadController::class, 'filter'])->name('iad.filter');
    Route::get('about/iad/search', [AboutIadController::class, 'search'])->name('iad.search');
    Route::get('about/iad', [AboutIadController::class, 'index'])->name('iad.index');
    Route::get('about/iad/{id}/edit', [AboutIadController::class, 'edit'])->name('iad.edit');
    Route::get('about/iad/create', [AboutIadController::class, 'create'])->name('iad.create');
    Route::post('about/iad/store', [AboutIadController::class, 'store'])->name('iad.store');

    // ABOUT INTRO
    Route::post('about/intro/search', [AboutIntroController::class, 'search'])->name('intro.search');
    Route::post('about/intro/update', [AboutIntroController::class, 'update'])->name('intro.update');
    Route::get('about/intro/destroy/{id}', [AboutIntroController::class, 'destroy']);
    Route::post('about/intro/filter', [AboutIntroController::class, 'filter'])->name('intro.filter');
    Route::get('about/intro/search', [AboutIntroController::class, 'search'])->name('intro.search');
    Route::get('about/intro', [AboutIntroController::class, 'index'])->name('intro.index');
    Route::get('about/intro/{id}/edit', [AboutIntroController::class, 'edit'])->name('intro.edit');
    Route::get('about/intro/create', [AboutIntroController::class, 'create'])->name('intro.create');
    Route::post('about/intro/store', [AboutIntroController::class, 'store'])->name('intro.store');

    // ABOUT VISION
    Route::post('about/vision/search', [AboutVisionController::class, 'search'])->name('vision.search');
    Route::post('about/vision/update', [AboutVisionController::class, 'update'])->name('vision.update');
    Route::get('about/vision/destroy/{id}', [AboutVisionController::class, 'destroy']);
    Route::post('about/vision/filter', [AboutVisionController::class, 'filter'])->name('vision.filter');
    Route::get('about/vision/search', [AboutVisionController::class, 'search'])->name('vision.search');
    Route::get('about/vision', [AboutVisionController::class, 'index'])->name('vision.index');
    Route::get('about/vision/{id}/edit', [AboutVisionController::class, 'edit'])->name('vision.edit');
    Route::get('about/vision/create', [AboutVisionController::class, 'create'])->name('vision.create');
    Route::post('about/vision/store', [AboutVisionController::class, 'store'])->name('vision.store');

    // ABOUT MISION
    Route::post('about/mision/search', [AboutMisionController::class, 'search'])->name('mision.search');
    Route::post('about/mision/update', [AboutMisionController::class, 'update'])->name('mision.update');
    Route::get('about/mision/destroy/{id}', [AboutMisionController::class, 'destroy']);
    Route::post('about/mision/filter', [AboutMisionController::class, 'filter'])->name('mision.filter');
    Route::get('about/mision/search', [AboutMisionController::class, 'search'])->name('mision.search');
    Route::get('about/mision', [AboutMisionController::class, 'index'])->name('mision.index');
    Route::get('about/mision/{id}/edit', [AboutMisionController::class, 'edit'])->name('mision.edit');
    Route::get('about/mision/create', [AboutMisionController::class, 'create'])->name('mision.create');
    Route::post('about/mision/store', [AboutMisionController::class, 'store'])->name('mision.store');

    // ABOUT PROGRAM
    Route::post('about/program/search', [AboutProgramController::class, 'search'])->name('program.search');
    Route::post('about/program/update', [AboutProgramController::class, 'update'])->name('program.update');
    Route::get('about/program/destroy/{id}', [AboutProgramController::class, 'destroy']);
    Route::post('about/program/filter', [AboutProgramController::class, 'filter'])->name('program.filter');
    Route::get('about/program/search', [AboutProgramController::class, 'search'])->name('program.search');
    Route::get('about/program', [AboutProgramController::class, 'index'])->name('program.index');
    Route::get('about/program/{id}/edit', [AboutProgramController::class, 'edit'])->name('program.edit');
    Route::get('about/program/create', [AboutProgramController::class, 'create'])->name('program.create');
    Route::post('about/program/store', [AboutProgramController::class, 'store'])->name('program.store');

    // ABOUT COMMAND
    Route::post('about/command/search', [AboutCommandController::class, 'search'])->name('command.search');
    Route::post('about/command/update', [AboutCommandController::class, 'update'])->name('command.update');
    Route::get('about/command/destroy/{id}', [AboutCommandController::class, 'destroy']);
    Route::post('about/command/filter', [AboutCommandController::class, 'filter'])->name('command.filter');
    Route::get('about/command/search', [AboutCommandController::class, 'search'])->name('command.search');
    Route::get('about/command', [AboutCommandController::class, 'index'])->name('command.index');
    Route::get('about/command/{id}/edit', [AboutCommandController::class, 'edit'])->name('command.edit');
    Route::get('about/command/create', [AboutCommandController::class, 'create'])->name('command.create');
    Route::post('about/command/store', [AboutCommandController::class, 'store'])->name('command.store');

    // INTEGRITY LEGAL
    Route::post('integrity/legal/search', [IntegrityLegalController::class, 'search'])->name('legal.search');
    Route::post('integrity/legal/update', [IntegrityLegalController::class, 'update'])->name('legal.update');
    Route::get('integrity/legal/destroy/{id}', [IntegrityLegalController::class, 'destroy']);
    Route::post('integrity/legal/filter', [IntegrityLegalController::class, 'filter'])->name('legal.filter');
    Route::get('integrity/legal/search', [IntegrityLegalController::class, 'search'])->name('legal.search');
    Route::get('integrity/legal', [IntegrityLegalController::class, 'index'])->name('legal.index');
    Route::get('integrity/legal/{id}/edit', [IntegrityLegalController::class, 'edit'])->name('legal.edit');
    Route::get('integrity/legal/create', [IntegrityLegalController::class, 'create'])->name('legal.create');
    Route::post('integrity/legal/store', [IntegrityLegalController::class, 'store'])->name('legal.store');

    // INTEGRITY ACCOUNTABILITY
    Route::post('integrity/accountability/search', [IntegrityAccountabilityController::class, 'search'])->name('accountability.search');
    Route::post('integrity/accountability/update', [IntegrityAccountabilityController::class, 'update'])->name('accountability.update');
    Route::get('integrity/accountability/destroy/{id}', [IntegrityAccountabilityController::class, 'destroy']);
    Route::post('integrity/accountability/filter', [IntegrityAccountabilityController::class, 'filter'])->name('accountability.filter');
    Route::get('integrity/accountability/search', [IntegrityAccountabilityController::class, 'search'])->name('accountability.search');
    Route::get('integrity/accountability', [IntegrityAccountabilityController::class, 'index'])->name('accountability.index');
    Route::get('integrity/accountability/{id}/edit', [IntegrityAccountabilityController::class, 'edit'])->name('accountability.edit');
    Route::get('integrity/accountability/create', [IntegrityAccountabilityController::class, 'create'])->name('accountability.create');
    Route::post('integrity/accountability/store', [IntegrityAccountabilityController::class, 'store'])->name('accountability.store');

    // INTEGRITY ARRANGEMENT
    Route::post('integrity/arrangement/search', [IntegrityArrangementController::class, 'search'])->name('arrangement.search');
    Route::post('integrity/arrangement/update', [IntegrityArrangementController::class, 'update'])->name('arrangement.update');
    Route::get('integrity/arrangement/destroy/{id}', [IntegrityArrangementController::class, 'destroy']);
    Route::post('integrity/arrangement/filter', [IntegrityArrangementController::class, 'filter'])->name('arrangement.filter');
    Route::get('integrity/arrangement/search', [IntegrityArrangementController::class, 'search'])->name('arrangement.search');
    Route::get('integrity/arrangement', [IntegrityArrangementController::class, 'index'])->name('arrangement.index');
    Route::get('integrity/arrangement/{id}/edit', [IntegrityArrangementController::class, 'edit'])->name('arrangement.edit');
    Route::get('integrity/arrangement/create', [IntegrityArrangementController::class, 'create'])->name('arrangement.create');
    Route::post('integrity/arrangement/store', [IntegrityArrangementController::class, 'store'])->name('arrangement.store');

    // INTEGRITY INNOVATION
    Route::post('integrity/innovation/search', [IntegrityInnovationController::class, 'search'])->name('innovation.search');
    Route::post('integrity/innovation/update', [IntegrityInnovationController::class, 'update'])->name('innovation.update');
    Route::get('integrity/innovation/destroy/{id}', [IntegrityInnovationController::class, 'destroy']);
    Route::post('integrity/innovation/filter', [IntegrityInnovationController::class, 'filter'])->name('innovation.filter');
    Route::get('integrity/innovation/search', [IntegrityInnovationController::class, 'search'])->name('innovation.search');
    Route::get('integrity/innovation', [IntegrityInnovationController::class, 'index'])->name('innovation.index');
    Route::get('integrity/innovation/{id}/edit', [IntegrityInnovationController::class, 'edit'])->name('innovation.edit');
    Route::get('integrity/innovation/create', [IntegrityInnovationController::class, 'create'])->name('innovation.create');
    Route::post('integrity/innovation/store', [IntegrityInnovationController::class, 'store'])->name('innovation.store');

    // INTEGRITY MECHANISM
    Route::post('integrity/mechanism/search', [IntegrityMechanismController::class, 'search'])->name('mechanism.search');
    Route::post('integrity/mechanism/update', [IntegrityMechanismController::class, 'update'])->name('mechanism.update');
    Route::get('integrity/mechanism/destroy/{id}', [IntegrityMechanismController::class, 'destroy']);
    Route::post('integrity/mechanism/filter', [IntegrityMechanismController::class, 'filter'])->name('mechanism.filter');
    Route::get('integrity/mechanism/search', [IntegrityMechanismController::class, 'search'])->name('mechanism.search');
    Route::get('integrity/mechanism', [IntegrityMechanismController::class, 'index'])->name('mechanism.index');
    Route::get('integrity/mechanism/{id}/edit', [IntegrityMechanismController::class, 'edit'])->name('mechanism.edit');
    Route::get('integrity/mechanism/create', [IntegrityMechanismController::class, 'create'])->name('mechanism.create');
    Route::post('integrity/mechanism/store', [IntegrityMechanismController::class, 'store'])->name('mechanism.store');

    // INTEGRITY PROFESSIONALISM
    Route::post('integrity/professionalism/search', [IntegrityProfessionalismController::class, 'search'])->name('professionalism.search');
    Route::post('integrity/professionalism/update', [IntegrityProfessionalismController::class, 'update'])->name('professionalism.update');
    Route::get('integrity/professionalism/destroy/{id}', [IntegrityProfessionalismController::class, 'destroy']);
    Route::post('integrity/professionalism/filter', [IntegrityProfessionalismController::class, 'filter'])->name('professionalism.filter');
    Route::get('integrity/professionalism/search', [IntegrityProfessionalismController::class, 'search'])->name('professionalism.search');
    Route::get('integrity/professionalism', [IntegrityProfessionalismController::class, 'index'])->name('professionalism.index');
    Route::get('integrity/professionalism/{id}/edit', [IntegrityProfessionalismController::class, 'edit'])->name('professionalism.edit');
    Route::get('integrity/professionalism/create', [IntegrityProfessionalismController::class, 'create'])->name('professionalism.create');
    Route::post('integrity/professionalism/store', [IntegrityProfessionalismController::class, 'store'])->name('professionalism.store');

    // INTEGRITY SUPERVISION
    Route::post('integrity/supervision/search', [IntegritySupervisionController::class, 'search'])->name('supervision.search');
    Route::post('integrity/supervision/update', [IntegritySupervisionController::class, 'update'])->name('supervision.update');
    Route::get('integrity/supervision/destroy/{id}', [IntegritySupervisionController::class, 'destroy']);
    Route::post('integrity/supervision/filter', [IntegritySupervisionController::class, 'filter'])->name('supervision.filter');
    Route::get('integrity/supervision/search', [IntegritySupervisionController::class, 'search'])->name('supervision.search');
    Route::get('integrity/supervision', [IntegritySupervisionController::class, 'index'])->name('supervision.index');
    Route::get('integrity/supervision/{id}/edit', [IntegritySupervisionController::class, 'edit'])->name('supervision.edit');
    Route::get('integrity/supervision/create', [IntegritySupervisionController::class, 'create'])->name('supervision.create');
    Route::post('integrity/supervision/store', [IntegritySupervisionController::class, 'store'])->name('supervision.store');

    // CONTACT MEDSOS
    Route::post('contact/medsos/search', [ContactMedsosController::class, 'search'])->name('medsos.search');
    Route::post('contact/medsos/update', [ContactMedsosController::class, 'update'])->name('medsos.update');
    Route::get('contact/medsos/destroy/{id}', [ContactMedsosController::class, 'destroy']);
    Route::post('contact/medsos/filter', [ContactMedsosController::class, 'filter'])->name('medsos.filter');
    Route::get('contact/medsos/search', [ContactMedsosController::class, 'search'])->name('medsos.search');
    Route::get('contact/medsos', [ContactMedsosController::class, 'index'])->name('medsos.index');
    Route::get('contact/medsos/{id}/edit', [ContactMedsosController::class, 'edit'])->name('medsos.edit');
    Route::get('contact/medsos/create', [ContactMedsosController::class, 'create'])->name('medsos.create');
    Route::post('contact/medsos/store', [ContactMedsosController::class, 'store'])->name('medsos.store');


    // CONFERENCE NEWS
    Route::post('conference/news/search', [ConferenceNewsController::class, 'search'])->name('news.search');
    Route::post('conference/news/update', [ConferenceNewsController::class, 'update'])->name('news.update');
    Route::get('conference/news/destroy/{id}', [ConferenceNewsController::class, 'destroy']);
    Route::post('conference/news/filter', [ConferenceNewsController::class, 'filter'])->name('news.filter');
    Route::get('conference/news/search', [ConferenceNewsController::class, 'search'])->name('news.search');
    Route::get('conference/news', [ConferenceNewsController::class, 'index'])->name('news.index');
    Route::get('conference/news/{id}/edit', [ConferenceNewsController::class, 'edit'])->name('news.edit');
    Route::get('conference/news/create', [ConferenceNewsController::class, 'create'])->name('news.create');
    Route::post('conference/news/store', [ConferenceNewsController::class, 'store'])->name('news.store');

    
    // INFORMATION DPO
    Route::post('information/dpo/search', [InformationDpoController::class, 'search'])->name('dpo.search');
    Route::post('information/dpo/update', [InformationDpoController::class, 'update'])->name('dpo.update');
    Route::get('information/dpo/destroy/{id}', [InformationDpoController::class, 'destroy']);
    Route::post('information/dpo/filter', [InformationDpoController::class, 'filter'])->name('dpo.filter');
    Route::get('information/dpo/search', [InformationDpoController::class, 'search'])->name('dpo.search');
    Route::get('information/dpo', [InformationDpoController::class, 'index'])->name('dpo.index');
    Route::get('information/dpo/{id}/edit', [InformationDpoController::class, 'edit'])->name('dpo.edit');
    Route::get('information/dpo/create', [InformationDpoController::class, 'create'])->name('dpo.create');
    Route::post('information/dpo/store', [InformationDpoController::class, 'store'])->name('dpo.store');

    // INFORMATION UNIT
    Route::post('information/unit/search', [InformationUnitController::class, 'search'])->name('unit.search');
    Route::post('information/unit/update', [InformationUnitController::class, 'update'])->name('unit.update');
    Route::get('information/unit/destroy/{id}', [InformationUnitController::class, 'destroy']);
    Route::post('information/unit/filter', [InformationUnitController::class, 'filter'])->name('unit.filter');
    Route::get('information/unit/search', [InformationUnitController::class, 'search'])->name('unit.search');
    Route::get('information/unit', [InformationUnitController::class, 'index'])->name('unit.index');
    Route::get('information/unit/{id}/edit', [InformationUnitController::class, 'edit'])->name('unit.edit');
    Route::get('information/unit/create', [InformationUnitController::class, 'create'])->name('unit.create');
    Route::post('information/unit/store', [InformationUnitController::class, 'store'])->name('unit.store');

    // INFORMATION STRUCTURAL
    Route::post('information/structural/search', [InformationStructuralController::class, 'search'])->name('structural.search');
    Route::post('information/structural/update', [InformationStructuralController::class, 'update'])->name('structural.update');
    Route::get('information/structural/destroy/{id}', [InformationStructuralController::class, 'destroy']);
    Route::post('information/structural/filter', [InformationStructuralController::class, 'filter'])->name('structural.filter');
    Route::get('information/structural/search', [InformationStructuralController::class, 'search'])->name('structural.search');
    Route::get('information/structural', [InformationStructuralController::class, 'index'])->name('structural.index');
    Route::get('information/structural/{id}/edit', [InformationStructuralController::class, 'edit'])->name('structural.edit');
    Route::get('information/structural/create', [InformationStructuralController::class, 'create'])->name('structural.create');
    Route::post('information/structural/store', [InformationStructuralController::class, 'store'])->name('structural.store');

    // INFORMATION SERVICE
    Route::post('information/service/search', [InformationServiceController::class, 'search'])->name('service.search');
    Route::post('information/service/update', [InformationServiceController::class, 'update'])->name('service.update');
    Route::get('information/service/destroy/{id}', [InformationServiceController::class, 'destroy']);
    Route::post('information/service/filter', [InformationServiceController::class, 'filter'])->name('service.filter');
    Route::get('information/service/search', [InformationServiceController::class, 'search'])->name('service.search');
    Route::get('information/service', [InformationServiceController::class, 'index'])->name('service.index');
    Route::get('information/service/{id}/edit', [InformationServiceController::class, 'edit'])->name('service.edit');
    Route::get('information/service/create', [InformationServiceController::class, 'create'])->name('service.create');
    Route::post('information/service/store', [InformationServiceController::class, 'store'])->name('service.store');

    // INFORMATION INFRASTRUCTURE
    Route::post('information/infrastructure/search', [InformationInfrastructureController::class, 'search'])->name('infrastructure.search');
    Route::post('information/infrastructure/update', [InformationInfrastructureController::class, 'update'])->name('infrastructure.update');
    Route::get('information/infrastructure/destroy/{id}', [InformationInfrastructureController::class, 'destroy']);
    Route::post('information/infrastructure/filter', [InformationInfrastructureController::class, 'filter'])->name('infrastructure.filter');
    Route::get('information/infrastructure/search', [InformationInfrastructureController::class, 'search'])->name('infrastructure.search');
    Route::get('information/infrastructure', [InformationInfrastructureController::class, 'index'])->name('infrastructure.index');
    Route::get('information/infrastructure/{id}/edit', [InformationInfrastructureController::class, 'edit'])->name('infrastructure.edit');
    Route::get('information/infrastructure/create', [InformationInfrastructureController::class, 'create'])->name('infrastructure.create');
    Route::post('information/infrastructure/store', [InformationInfrastructureController::class, 'store'])->name('infrastructure.store');

    // ARCHIVE PHOTO
    Route::post('archive/photo/search', [ArchivePhotoController::class, 'search'])->name('photo.search');
    Route::post('archive/photo/update', [ArchivePhotoController::class, 'update'])->name('photo.update');
    Route::get('archive/photo/destroy/{id}', [ArchivePhotoController::class, 'destroy']);
    Route::post('archive/photo/filter', [ArchivePhotoController::class, 'filter'])->name('photo.filter');
    Route::get('archive/photo/search', [ArchivePhotoController::class, 'search'])->name('photo.search');
    Route::get('archive/photo', [ArchivePhotoController::class, 'index'])->name('photo.index');
    Route::get('archive/photo/{id}/edit', [ArchivePhotoController::class, 'edit'])->name('photo.edit');
    Route::get('archive/photo/create', [ArchivePhotoController::class, 'create'])->name('photo.create');
    Route::post('archive/photo/store', [ArchivePhotoController::class, 'store'])->name('photo.store');

    // ARCHIVE REGULATION
    Route::post('archive/regulation/search', [ArchiveRegulationController::class, 'search'])->name('regulation.search');
    Route::post('archive/regulation/update', [ArchiveRegulationController::class, 'update'])->name('regulation.update');
    Route::get('archive/regulation/destroy/{id}', [ArchiveRegulationController::class, 'destroy']);
    Route::post('archive/regulation/filter', [ArchiveRegulationController::class, 'filter'])->name('regulation.filter');
    Route::get('archive/regulation/search', [ArchiveRegulationController::class, 'search'])->name('regulation.search');
    Route::get('archive/regulation', [ArchiveRegulationController::class, 'index'])->name('regulation.index');
    Route::get('archive/regulation/{id}/edit', [ArchiveRegulationController::class, 'edit'])->name('regulation.edit');
    Route::get('archive/regulation/create', [ArchiveRegulationController::class, 'create'])->name('regulation.create');
    Route::post('archive/regulation/store', [ArchiveRegulationController::class, 'store'])->name('regulation.store');

    // ARCHIVE MOVIE
    Route::post('archive/movie/search', [ArchiveMovieController::class, 'search'])->name('movie.search');
    Route::post('archive/movie/update', [ArchiveMovieController::class, 'update'])->name('movie.update');
    Route::get('archive/movie/destroy/{id}', [ArchiveMovieController::class, 'destroy']);
    Route::post('archive/movie/filter', [ArchiveMovieController::class, 'filter'])->name('movie.filter');
    Route::get('archive/movie/search', [ArchiveMovieController::class, 'search'])->name('movie.search');
    Route::get('archive/movie', [ArchiveMovieController::class, 'index'])->name('movie.index');
    Route::get('archive/movie/{id}/edit', [ArchiveMovieController::class, 'edit'])->name('movie.edit');
    Route::get('archive/movie/create', [ArchiveMovieController::class, 'create'])->name('movie.create');
    Route::post('archive/movie/store', [ArchiveMovieController::class, 'store'])->name('movie.store');

    //Configure
    Route::get('configure', [ConfigureController::class, 'edit'])->name('configure.edit');
    //Route::post('configure-update', [ConfigureController::class, 'update'])->name('configure.update');
    Route::post('configure/update-info', [ConfigureController::class, 'updateinfo'])->name('configure.updateinfo');
    Route::post('configure/update-medsos', [ConfigureController::class, 'updatemedsos'])->name('configure.updatemedsos');
    Route::post('configure/update-support', [ConfigureController::class, 'updatesupport'])->name('configure.updatesupport');
    Route::post('configure/update-videos', [ConfigureController::class, 'updatevideos'])->name('configure.updatevideos');
    Route::post('configure-process', [ConfigureController::class, 'process'])->name('configure.process');
    Route::post('configure/update-patterns', [ConfigureController::class, 'updatepatterns'])->name('configure.updatepatterns');
    Route::post('configure/update-backgrounds', [ConfigureController::class, 'updatebackgrounds'])->name('configure.updatebackgrounds');
});