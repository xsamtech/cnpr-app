<?php
/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| ROUTES FOR EVERY ROLES
|--------------------------------------------------------------------------
*/
// Home
Route::get('/', 'App\Http\Controllers\Web\HomeController@index')->name('home');
// Change language
Route::get('/lang/{locale}', 'App\Http\Controllers\Web\HomeController@changeLanguage')->name('change_language');
// Generate symbolic link
Route::get('/symlink', 'App\Http\Controllers\Web\HomeController@symlink')->name('generate_symlink');
// About application
Route::get('/about', 'App\Http\Controllers\Web\HomeController@about')->name('about');
// Search something
Route::get('/search/{entity}', 'App\Http\Controllers\Web\HomeController@search')->name('search');
// Remove data
Route::get('/delete/{entity}/{id}', 'App\Http\Controllers\Web\HomeController@delete')->whereNumber('id')->name('delete');
// Message
Route::get('/messages', 'App\Http\Controllers\Web\HomeController@message')->name('message.home');
Route::post('/messages', 'App\Http\Controllers\Web\HomeController@storeMessage');
Route::get('/messages/new', 'App\Http\Controllers\Web\HomeController@newMessage')->name('message.new');
Route::get('/messages/{id}', 'App\Http\Controllers\Web\HomeController@messageDatas')->whereNumber('id')->name('message.datas');
Route::post('/messages/{id}', 'App\Http\Controllers\Web\HomeController@updateMessage')->whereNumber('id');
Route::get('/messages/{entity}', 'App\Http\Controllers\Web\HomeController@messageEntity')->name('message.entity.home');
Route::post('/messages/{entity}', 'App\Http\Controllers\Web\HomeController@storeMessageEntity');
Route::get('/messages/{entity}/{id}', 'App\Http\Controllers\Web\HomeController@messageEntityDatas')->whereNumber('id')->name('message.entity.datas');
Route::post('/messages/{entity}/{id}', 'App\Http\Controllers\Web\HomeController@updateMessageEntity')->whereNumber('id');
// Account
Route::get('/account', 'App\Http\Controllers\Web\HomeController@account')->name('account');
Route::post('/account', 'App\Http\Controllers\Web\HomeController@updateAccount');
Route::post('/update_password', 'App\Http\Controllers\Web\HomeController@updatePassword')->name('account.update.password');
// Notification
Route::get('/notifications', 'App\Http\Controllers\Web\HomeController@notification')->name('notifications');
// History
Route::get('/history', 'App\Http\Controllers\Web\HomeController@history')->name('history');

/*
|--------------------------------------------------------------------------
| ROUTES FOR "Manager" AND "Employé"
|--------------------------------------------------------------------------
*/
// Communique
Route::get('/communiques', 'App\Http\Controllers\Web\ManagerController@communiques')->name('communique.home');
Route::post('/communiques', 'App\Http\Controllers\Web\ManagerController@storeCommunique');
Route::get('/communiques/{id}', 'App\Http\Controllers\Web\ManagerController@communiqueDatas')->whereNumber('id')->name('communique.datas');
Route::post('/communiques/{id}', 'App\Http\Controllers\Web\ManagerController@updateCommunique')->whereNumber('id');
// Task
Route::get('/tasks', 'App\Http\Controllers\Web\ManagerController@tasks')->name('task.home');
Route::post('/tasks', 'App\Http\Controllers\Web\ManagerController@storeTask');
Route::get('/tasks/{id}', 'App\Http\Controllers\Web\ManagerController@taskDatas')->whereNumber('id')->name('task.datas');
Route::post('/tasks/{id}', 'App\Http\Controllers\Web\ManagerController@updateTask')->whereNumber('id');

/*
|--------------------------------------------------------------------------
| ROUTES FOR "Administrateur"
|--------------------------------------------------------------------------
*/
// Province
Route::get('/province', 'App\Http\Controllers\Web\AdminController@province')->name('province.home');
Route::post('/province', 'App\Http\Controllers\Web\AdminController@storeProvince');
Route::get('/province/{id}', 'App\Http\Controllers\Web\AdminController@provinceDatas')->whereNumber('id')->name('province.datas');
Route::post('/province/{id}', 'App\Http\Controllers\Web\AdminController@updateProvince')->whereNumber('id');
Route::get('/province/{entity}', 'App\Http\Controllers\Web\AdminController@provinceEntity')->name('province.entity.home');
Route::post('/province/{entity}', 'App\Http\Controllers\Web\AdminController@storeProvinceEntity');
Route::get('/province/{entity}/{id}', 'App\Http\Controllers\Web\AdminController@provinceEntityDatas')->whereNumber('id')->name('province.entity.datas');
Route::post('/province/{entity}/{id}', 'App\Http\Controllers\Web\AdminController@updateProvinceEntity')->whereNumber('id');
// Group
Route::get('/group', 'App\Http\Controllers\Web\AdminController@group')->name('group.home');
Route::post('/group', 'App\Http\Controllers\Web\AdminController@storeGroup');
Route::get('/group/{id}', 'App\Http\Controllers\Web\AdminController@groupDatas')->whereNumber('id')->name('group.datas');
Route::post('/group/{id}', 'App\Http\Controllers\Web\AdminController@updateGroup')->whereNumber('id');
Route::get('/group/{entity}', 'App\Http\Controllers\Web\AdminController@groupEntity')->name('group.entity.home');
Route::post('/group/{entity}', 'App\Http\Controllers\Web\AdminController@storeGroupEntity');
Route::get('/group/{entity}/{id}', 'App\Http\Controllers\Web\AdminController@groupEntityDatas')->whereNumber('id')->name('group.entity.datas');
Route::post('/group/{entity}/{id}', 'App\Http\Controllers\Web\AdminController@updateGroupEntity')->whereNumber('id');
// Role
Route::get('/role', 'App\Http\Controllers\Web\AdminController@role')->name('role.home');
Route::post('/role', 'App\Http\Controllers\Web\AdminController@storeRole');
Route::get('/role/{id}', 'App\Http\Controllers\Web\AdminController@roleDatas')->whereNumber('id')->name('role.datas');
Route::post('/role/{id}', 'App\Http\Controllers\Web\AdminController@updateRole')->whereNumber('id');
Route::get('/role/{entity}', 'App\Http\Controllers\Web\AdminController@roleEntity')->name('role.entity.home');
Route::post('/role/{entity}', 'App\Http\Controllers\Web\AdminController@storeRoleEntity');
Route::get('/role/{entity}/{id}', 'App\Http\Controllers\Web\AdminController@roleEntityDatas')->whereNumber('id')->name('role.entity.datas');
Route::post('/role/{entity}/{id}', 'App\Http\Controllers\Web\AdminController@updateRoleEntity')->whereNumber('id');
// Vacation
Route::get('/vacation', 'App\Http\Controllers\Web\AdminController@vacation')->name('vacation.home');
Route::post('/vacation', 'App\Http\Controllers\Web\AdminController@storeVacation');
Route::get('/vacation/{id}', 'App\Http\Controllers\Web\AdminController@vacationDatas')->whereNumber('id')->name('vacation.datas');
Route::post('/vacation/{id}', 'App\Http\Controllers\Web\AdminController@updateVacation')->whereNumber('id');
// Department
Route::get('/department', 'App\Http\Controllers\Web\AdminController@department')->name('department.home');
Route::post('/department', 'App\Http\Controllers\Web\AdminController@storeDepartment');
Route::get('/department/{id}', 'App\Http\Controllers\Web\AdminController@departmentDatas')->whereNumber('id')->name('department.datas');
Route::post('/department/{id}', 'App\Http\Controllers\Web\AdminController@updateDepartment')->whereNumber('id');
// Branch
Route::get('/branch', 'App\Http\Controllers\Web\AdminController@branch')->name('branch.home');
Route::post('/branch', 'App\Http\Controllers\Web\AdminController@storeBranch');
Route::get('/branch/{id}', 'App\Http\Controllers\Web\AdminController@branchDatas')->whereNumber('id')->name('branch.datas');
Route::post('/branch/{id}', 'App\Http\Controllers\Web\AdminController@updateBranch')->whereNumber('id');

/*
|--------------------------------------------------------------------------
| ROUTES FOR "Manager"
|--------------------------------------------------------------------------
*/
// Employee
Route::get('/employee', 'App\Http\Controllers\Web\ManagerController@employee')->name('employee.home');
Route::post('/employee', 'App\Http\Controllers\Web\ManagerController@storeEmployee');
Route::get('/employee/{id}', 'App\Http\Controllers\Web\ManagerController@employeeDatas')->whereNumber('id')->name('employee.datas');
Route::post('/employee/{id}', 'App\Http\Controllers\Web\ManagerController@updateEmployee')->whereNumber('id');
Route::get('/employee/{entity}', 'App\Http\Controllers\Web\ManagerController@employeeEntity')->name('employee.entity.home');
Route::post('/employee/{entity}', 'App\Http\Controllers\Web\ManagerController@storeEmployeeEntity');
Route::get('/employee/{entity}/{id}', 'App\Http\Controllers\Web\ManagerController@employeeEntityDatas')->whereNumber('id')->name('employee.entity.datas');
Route::post('/employee/{entity}/{id}', 'App\Http\Controllers\Web\ManagerController@updateEmployeeEntity')->whereNumber('id');

/*
|--------------------------------------------------------------------------
| ROUTES FOR "Employé"
|--------------------------------------------------------------------------
*/
// PresenceAbsence
Route::get('/presence_absence', 'App\Http\Controllers\Web\ManagerController@presenceAbsence')->name('presence_absence.home');
Route::post('/presence_absence', 'App\Http\Controllers\Web\ManagerController@storePresenceAbsence');
Route::get('/presence_absence/{id}', 'App\Http\Controllers\Web\ManagerController@presenceAbsenceDatas')->whereNumber('id')->name('presence_absence.datas');
Route::post('/presence_absence/{id}', 'App\Http\Controllers\Web\ManagerController@updatePresenceAbsence')->whereNumber('id');

require __DIR__.'/auth.php';
