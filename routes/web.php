    <?php

    use App\Http\Controllers\AuthController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/maps', function () {
        return view('maps');
    })->name('maps');

    Route::get('/risk-check', function () {
        return view('risk-check');
    })->name('risk-check');

    // Profil pengguna
    Route::get('/profil', function () {
        return view('profil');
    })->middleware('auth')->name('profil');

    // Autentikasi untuk pengunjung yang belum login
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('login.store');

        Route::get('/register', [AuthController::class, 'showRegister'])
            ->name('register');

        Route::post('/register', [AuthController::class, 'register'])
            ->name('register.store');
    });

    // Logout hanya untuk pengguna yang sudah login
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
