<?php

use App\Http\Controllers\FeesController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\WalletController;
    use App\Http\Controllers\FeeReportController;
use App\Http\Middleware\Adminauth;
use Illuminate\Support\Facades\Route;
use App\Models\FeeCycle;
use Ramsey\Uuid\FeatureSet;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UserAuthController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','admin'])->group(function () {
Route::get('/admin/student', [StudentController::class, 'index'])->name('admin.student.index');
Route::get('/students', [StudentController::class, 'index'])->name('admin.students');
Route::post('/add_student', [StudentController::class, 'store'])->name('student.store');
Route::get('/admin/seat', [SeatController::class, 'index'])->name('admin.seat.index');

Route::post('/admin/seat', [SeatController::class, 'store'])->name('admin.seat.store');
Route::post('/seats/{seat}/assign', [SeatController::class, 'assign'])
    ->name('admin.seat.assign');
Route::post('/seats/{seat}/release', [SeatController::class, 'release'])
    ->name('admin.seat.release');
Route::post('/students/{student}/wallet/add-money', [WalletController::class, 'addMoney'])
    ->name('admin.wallet.add-money');

Route::post('/seats/bulk-change-plan', [SeatController::class, 'bulkChangePlan'])
    ->name('admin.seat.bulk-change-plan');



Route::get('/students/{student}/edit', [StudentController::class, 'edit'])
    ->name('student.edit');

Route::put('/students/{student}', [StudentController::class, 'update'])
    ->name('student.update');

Route::delete('/students/{student}', [StudentController::class, 'destroy'])
    ->name('student.destroy');




    Route::get('/students/{student}/fees', function (\App\Models\Student $student) {

    $feeCycles = \App\Models\FeeCycle::with(['fees', 'seatAssignment.seat'])
        ->where('student_id', $student->id)
        ->latest('period_start')
        ->paginate(20);

    return view('admin.fees.student', compact(
        'student',
        'feeCycles'
    ));

})->name('admin.student.fees');

Route::post('/fee-cycles/{feeCycle}/debit', [WalletController::class, 'debitForFee'])
    ->name('admin.fee-cycle.debit');


Route::get('/fee-wallet-report', [FeeReportController::class, 'index'])
    ->name('admin.fee-wallet-report');

Route::get('/students/{student}/wallet', [WalletController::class, 'history'])
    ->name('admin.wallet.history');
Route::delete('/admin/seat/{seat}', [SeatController::class, 'destroy'])->name('admin.seat.destroy');
Route::get('/admin/fees', [FeesController::class, 'index'])->name('admin.fees.index');
Route::get('/admin/index', [LibraryController::class, 'index'])->name('admin.library.index');
Route::post('/admin/store', [LibraryController::class, 'store'])->name('admin.library.store');
Route::delete('/admin/fees/{fees}', [FeesController::class, 'destroy'])
    ->name('admin.fees.destroy');
Route::get('/admin/fees', [FeesController::class, 'index'])
    ->name('admin.fees.index');

Route::post('/admin/fees', [FeesController::class, 'store'])
    ->name('admin.fees.store');

Route::delete('/admin/fees/{fees}', [FeesController::class, 'destroy'])
    ->name('admin.fees.destroy');
Route::delete('/admin/library/{library}', [LibraryController::class, 'destroy'])
    ->name('admin.library.destroy');



});

require __DIR__.'/auth.php';
