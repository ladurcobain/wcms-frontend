<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
// use Illuminate\Routing\Controller;
use Log;
use Sarfraznawaz2005\BackupManager\Facades\BackupManager;
use Session;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;

class BackupManagerController extends Controller
{
    public function index()
    {
        $data['title'] = 'Pencadangan & Pemulihan';
        $data['subtitle'] = '';
        
        $backups = BackupManager::getBackups();

        return view('backupmanager.index', $data, compact('backups'));
    }

    public function createBackup()
    {
        $message = '';
        $messages = [];

        // create backups
        $result = BackupManager::createBackup();

        // set status messages
        if ($result['f'] === true) {
            $alrt    = 'success';
            $message = 'Pencadangan Berhasil';

            $messages[] = [
                'type' => 'success',
                'message' => $message
            ];

            Log::info($message);
        } else {
            if (config('backupmanager.backups.files.enable')) {
                $alrt    = 'error';
                $message = 'Pencadangan Gagal';

                $messages[] = [
                    'type' => 'danger',
                    'message' => $message
                ];

                Log::error($message);
            }
        }

        if ($result['d'] === true) {
            $alrt    = 'success';
            $message = 'Pencadangan Berhasil';

            $messages[] = [
                'type' => 'success',
                'message' => $message
            ];

            Log::info($message);
        } else {
            if (config('backupmanager.backups.database.enable')) {
                $alrt    = 'error';
                $message = 'Pencadangan Gagal';

                $messages[] = [
                    'type' => 'danger',
                    'message' => $message
                ];

                Log::error($message);
            }
        }
        
        Session::flash('alrt', $alrt);    
        Session::flash('msgs', $message); 
        Session::flash('messages', $messages);

        return redirect()->back();
    }

    public function restoreOrDeleteBackups()
    {
        $alrt    = '';
        $message = '';

        $messages = [];
        $backups = request()->backups;
        $type = request()->type;

        if ($type === 'restore' && count($backups) > 2) {
            $alrt    = 'error';
            $message = 'Hanya satu berkas yg dapat dipulihkan.';
            
            $messages[] = [
                'type' => 'danger',
                'message' => $message
            ];

            Session::flash('alrt', $alrt);    
            Session::flash('msgs', $message); 
            Session::flash('messages', $messages);

            return redirect()->back();
        }

        if ($type === 'restore') {
            // restore backups
            $results = BackupManager::restoreBackups($backups);

            // set status messages
            foreach ($results as $result) {
                if (isset($result['f'])) {
                    if ($result['f'] === true) {
                        $alrt    = 'success';
                        $message = 'Pemulihan Berhasil';

                        $messages[] = [
                            'type' => 'success',
                            'message' => $message
                        ];

                        Log::info($message);
                    } else {
                        $alrt    = 'error';
                        $message = 'Pemulihan Gagal';

                        $messages[] = [
                            'type' => 'danger',
                            'message' => $message
                        ];

                        Log::error($message);
                    }
                } elseif (isset($result['d'])) {
                    if ($result['d'] === true) {
                        $alrt    = 'success';
                        $message = 'Pemulihan Berhasil';

                        $messages[] = [
                            'type' => 'success',
                            'message' => $message
                        ];

                        Log::info($message);
                    } else {
                        $alrt    = 'error';
                        $message = 'Pemulihan Gagal';

                        $messages[] = [
                            'type' => 'danger',
                            'message' => $message
                        ];

                        Log::error($message);
                    }
                }
            }
        } else {
            // delete backups
            $results = BackupManager::deleteBackups($backups);

            if ($results) {
                $alrt    = 'success';
                $message = 'Hapus Pencadangan Berhasil';

                $messages[] = [
                    'type' => 'success',
                    'message' => $message
                ];
            } else {
                $alrt    = 'error';
                $message = 'Hapus Pencadangan Gagal';

                $messages[] = [
                    'type' => 'danger',
                    'message' => $message
                ];
            }
        }

        Session::flash('alrt', $alrt);    
        Session::flash('msgs', $message);
        Session::flash('messages', $messages);

        return redirect()->back();
    }

    public function download($file)
    {
        $path = config('backupmanager.backups.backup_path') . DIRECTORY_SEPARATOR . $file;

        $file = Storage::disk(config('backupmanager.backups.disk'))
                // ->getDriver()
                // ->getAdapter()
                ->path($path);

        return response()->download($file);
    }
}
