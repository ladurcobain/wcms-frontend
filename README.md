# wcms-frontend

A. inisialisasi menjadi https : 

1. Buka file app/provider/AppServiceProvider.php
2. Replace function boot, menjadi seperti dibawah ini :

public function boot()
    {
        //
        Paginator::useBootstrap();
        if(config('app.env') === 'local') {
            \URL::forceScheme('https');
        }
    }