<?php
/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Default API resource
|--------------------------------------------------------------------------
 */
Route::middleware('localization')->group(function () {
    Route::apiResource('province', 'App\Http\Controllers\API\ProvinceController');
    Route::apiResource('city', 'App\Http\Controllers\API\CityController');
    Route::apiResource('group', 'App\Http\Controllers\API\GroupController');
    Route::apiResource('status', 'App\Http\Controllers\API\StatusController');
    Route::apiResource('type', 'App\Http\Controllers\API\TypeController');
    Route::apiResource('file', 'App\Http\Controllers\API\FileController');
    Route::apiResource('role', 'App\Http\Controllers\API\RoleController');
    Route::apiResource('user', 'App\Http\Controllers\API\UserController');
    Route::apiResource('password_reset', 'App\Http\Controllers\API\PasswordResetController');
    Route::apiResource('session', 'App\Http\Controllers\API\SessionController');
    Route::apiResource('department', 'App\Http\Controllers\API\DepartmentController');
    Route::apiResource('branch', 'App\Http\Controllers\API\BranchController');
    Route::apiResource('presence_absence', 'App\Http\Controllers\API\PresenceAbsenceController');
    Route::apiResource('message', 'App\Http\Controllers\API\MessageController');
    Route::apiResource('notification', 'App\Http\Controllers\API\NotificationController');
    Route::apiResource('history', 'App\Http\Controllers\API\HistoryController');
    Route::apiResource('task', 'App\Http\Controllers\API\TaskController');
    Route::apiResource('paid_unpaid', 'App\Http\Controllers\API\PaidUnpaidController');
    Route::apiResource('vacation', 'App\Http\Controllers\API\VacationController');
});
// Route::middleware(['auth:api', 'localization'])->group(function () {
// });
/*
|--------------------------------------------------------------------------
| Custom API resource without authentication
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['api', 'localization']], function () {
    Route::resource('province', 'App\Http\Controllers\API\ProvinceController');
    Route::resource('city', 'App\Http\Controllers\API\CityController');
    Route::resource('group', 'App\Http\Controllers\API\GroupController');
    Route::resource('status', 'App\Http\Controllers\API\StatusController');
    Route::resource('type', 'App\Http\Controllers\API\TypeController');
    Route::resource('role', 'App\Http\Controllers\API\RoleController');
    Route::resource('user', 'App\Http\Controllers\API\UserController');
    Route::resource('password_reset', 'App\Http\Controllers\API\PasswordResetController');
    Route::resource('department', 'App\Http\Controllers\API\DepartmentController');
    Route::resource('branch', 'App\Http\Controllers\API\BranchController');
    Route::resource('presence_absence', 'App\Http\Controllers\API\PresenceAbsenceController');
    Route::resource('message', 'App\Http\Controllers\API\MessageController');
    Route::resource('notification', 'App\Http\Controllers\API\NotificationController');
    Route::resource('history', 'App\Http\Controllers\API\HistoryController');
    Route::resource('task', 'App\Http\Controllers\API\TaskController');
    Route::resource('paid_unpaid', 'App\Http\Controllers\API\PaidUnpaidController');
    Route::resource('vacation', 'App\Http\Controllers\API\VacationController');

    // Province
    Route::get('province/search/{data}/{visitor_id}', 'App\Http\Controllers\API\ProvinceController@search')->name('province.api.search');
    // City
    Route::get('city/search/{data}/{visitor_id}', 'App\Http\Controllers\API\CityController@search')->name('city.api.search');
    Route::get('city/find_by_province/{province_id}', 'App\Http\Controllers\API\CityController@findByProvince')->name('city.api.find_by_province');
    // Group
    Route::get('group/search/{data}', 'App\Http\Controllers\API\GroupController@search')->name('group.api.search');
    // Status
    Route::get('status/search/{data}', 'App\Http\Controllers\API\StatusController@search')->name('status.api.search');
    Route::get('status/find_by_group/{group_name}', 'App\Http\Controllers\API\StatusController@findByGroup')->name('status.api.find_by_group');
    Route::get('status/find_by_group_except/{group_name}/{data}', 'App\Http\Controllers\API\StatusController@findByGroupExcept')->name('status.api.find_by_group_except');
    // Type
    Route::get('type/search/{data}', 'App\Http\Controllers\API\TypeController@search')->name('type.api.search');
    Route::get('type/find_by_group/{group_name}', 'App\Http\Controllers\API\TypeController@findByGroup')->name('type.api.find_by_group');
    // Role
    Route::get('role/search/{data}', 'App\Http\Controllers\API\RoleController@search')->name('role.api.search');
    Route::get('role/find_all_except/{data}', 'App\Http\Controllers\API\RoleController@findAllExcept')->name('role.api.find_all_except');
    // User
    Route::get('user/search/{data}/{visitor_id}/{role_name}/{branch_id}', 'App\Http\Controllers\API\UserController@search')->name('user.api.search');
    Route::get('user/find_by_role/{role_name}', 'App\Http\Controllers\API\UserController@findByRole')->name('user.api.find_by_role');
    Route::get('user/find_by_not_role/{role_name}', 'App\Http\Controllers\API\UserController@findByNotRole')->name('user.api.find_by_not_role');
    Route::get('user/find_by_branch/{branch_id}', 'App\Http\Controllers\API\UserController@findByBranch')->name('user.api.find_by_branch');
    Route::get('user/find_by_empty_branch', 'App\Http\Controllers\API\UserController@findByEmptyBranch')->name('user.api.find_by_empty_branch');
    Route::get('user/find_by_branch_role/{branch_id}/{role_name}', 'App\Http\Controllers\API\UserController@findByBranchRole')->name('user.api.find_by_branch_role');
    Route::get('user/find_by_branch_role_status/{branch_id}/{role_name}/{status_name}', 'App\Http\Controllers\API\UserController@findByBranchRoleStatus')->name('user.api.find_by_branch_role_status');
    Route::get('user/find_by_empty_branch_role/{role_name}', 'App\Http\Controllers\API\UserController@findByEmptyBranchRole')->name('user.api.find_by_empty_branch_role');
    Route::get('user/find_by_empty_or_specific_branch_role/{branch_id}/{role_name}', 'App\Http\Controllers\API\UserController@findByEmptyOrSpecificBranchRole')->name('user.api.find_by_empty_or_specific_branch_role');
    Route::get('user/find_by_status/{status_id}', 'App\Http\Controllers\API\UserController@findByStatus')->name('user.api.find_by_status');
    Route::post('user/login', 'App\Http\Controllers\API\UserController@login')->name('user.api.login');
    Route::put('user/check_presences_payments/{manager_id}', 'App\Http\Controllers\API\UserController@checkPresencesPayments')->name('user.api.check_presences_payments');
    Route::put('user/check_presence_payment/{employee_id}', 'App\Http\Controllers\API\UserController@checkPresencePayment')->name('user.api.check_presence_payment');
    Route::put('user/switch_status/{id}/{status_id}/{visitor_id}', 'App\Http\Controllers\API\UserController@switchStatus')->name('user.api.switch_status');
    Route::put('user/update_role/{id}/{visitor_id}', 'App\Http\Controllers\API\UserController@updateRole')->name('user.api.update_role');
    Route::put('user/update_department/{id}/{visitor_id}', 'App\Http\Controllers\API\UserController@updateDepartment')->name('user.api.update_department');
    Route::put('user/update_department_chief/{id}/{visitor_id}', 'App\Http\Controllers\API\UserController@updateDepartmentChief')->name('user.api.update_department_chief');
    Route::put('user/update_password/{id}/{visitor_id}', 'App\Http\Controllers\API\UserController@updatePassword')->name('user.api.update_password');
    Route::get('user/get_api_token/{id}', 'App\Http\Controllers\API\UserController@getApiToken')->name('user.api.get_api_token');
    Route::put('user/update_api_token/{id}', 'App\Http\Controllers\API\UserController@updateApiToken')->name('user.api.update_api_token');
    Route::put('user/update_avatar_picture/{id}', 'App\Http\Controllers\API\UserController@updateAvatarPicture')->name('user.api.update_avatar_picture');
    // PasswordReset
    Route::get('password_reset/search_by_email/{data}', 'App\Http\Controllers\API\PasswordResetController@searchByEmail')->name('password_reset.api.search_by_email');
    Route::get('password_reset/search_by_phone/{data}', 'App\Http\Controllers\API\PasswordResetController@searchByPhone')->name('password_reset.api.search_by_phone');
    // Department
    Route::get('department/find_by_belongs_to/{belongs_to}', 'App\Http\Controllers\API\DepartmentController@findByBelongsTo')->name('department.api.find_by_belongs_to');
    // Branch
    Route::get('branch/search/{data}/{visitor_id}', 'App\Http\Controllers\API\BranchController@search')->name('branch.api.search');
    Route::get('branch/find_by_city/{city_id}', 'App\Http\Controllers\API\BranchController@findByCity')->name('branch.api.find_by_city');
    Route::put('branch/update_users/{id}/{visitor_id}', 'App\Http\Controllers\API\BranchController@updateUsers')->name('branch.api.update_users');
    Route::put('branch/remove_users/{id}/{visitor_id}', 'App\Http\Controllers\API\BranchController@removeUsers')->name('branch.api.remove_users');
    // PresenceAbsence
    Route::get('presence_absence/find_by_user_date/{user_id}/{date}', 'App\Http\Controllers\API\PresenceAbsenceController@findByUserDate')->name('presence_absence.api.find_by_user_date');
    Route::get('presence_absence/find_by_user_month_year/{user_id}/{month_year}', 'App\Http\Controllers\API\PresenceAbsenceController@findByUserMonthYear')->name('presence_absence.api.find_by_user_month_year');
    Route::get('presence_absence/find_by_user_year/{user_id}/{year}', 'App\Http\Controllers\API\PresenceAbsenceController@findByUserYear')->name('presence_absence.api.find_by_user_year');
    Route::get('presence_absence/find_by_branch_date/{branch_id}/{date}', 'App\Http\Controllers\API\PresenceAbsenceController@findByBranchDate')->name('presence_absence.api.find_by_branch_date');
    Route::get('presence_absence/find_by_branch_month_year/{branch_id}/{month_year}', 'App\Http\Controllers\API\PresenceAbsenceController@findByBranchMonthYear')->name('presence_absence.api.find_by_branch_month_year');
    Route::get('presence_absence/find_by_branch_year/{branch_id}/{year}', 'App\Http\Controllers\API\PresenceAbsenceController@findByBranchYear')->name('presence_absence.api.find_by_branch_year');
    Route::get('presence_absence/find_by_branch_status_date/{branch_id}/{status_id}/{date}', 'App\Http\Controllers\API\PresenceAbsenceController@findByBranchStatusDate')->name('presence_absence.api.find_by_branch_status_date');
    Route::get('presence_absence/find_by_branch_status_month_year/{branch_id}/{status_id}/{month_year}', 'App\Http\Controllers\API\PresenceAbsenceController@findByBranchStatusMonthYear')->name('presence_absence.api.find_by_branch_status_month_year');
    Route::get('presence_absence/find_by_branch_status_year/{branch_id}/{status_id}/{year}', 'App\Http\Controllers\API\PresenceAbsenceController@findByBranchStatusYear')->name('presence_absence.api.find_by_branch_status_year');
    Route::get('presence_absence/find_by_branch_is_present_date/{branch_id}/{is_present}/{status_id}/{date}', 'App\Http\Controllers\API\PresenceAbsenceController@findByBranchIsPresentDate')->name('presence_absence.api.find_by_branch_is_present_date');
    Route::get('presence_absence/find_by_branch_is_present_month_year/{branch_id}/{is_present}/{status_id}/{month_year}', 'App\Http\Controllers\API\PresenceAbsenceController@findByBranchIsPresentMonthYear')->name('presence_absence.api.find_by_branch_is_present_month_year');
    Route::get('presence_absence/find_by_branch_is_present_year/{branch_id}/{is_present}/{status_id}/{year}', 'App\Http\Controllers\API\PresenceAbsenceController@findByBranchIsPresentYear')->name('presence_absence.api.find_by_branch_is_present_year');
    Route::put('presence_absence/switch_is/{id}', 'App\Http\Controllers\API\PresenceAbsenceController@switchIs')->name('presence_absence.api.switch_is');
    // Message
    Route::get('message/search/{data}/{visitor_id}/{type_name}', 'App\Http\Controllers\API\MessageController@search')->name('message.api.search');
    Route::get('message/chat_user/{type_name}/{addressee_user_id}', 'App\Http\Controllers\API\MessageController@chatUser')->name('message.api.chat_user');
    Route::get('message/chat_role/{type_name}/{addressee_role_name}', 'App\Http\Controllers\API\MessageController@chatRole')->name('message.api.chat_role');
    Route::get('message/chat_branch/{type_name}/{addressee_branch_id}', 'App\Http\Controllers\API\MessageController@chatBranch')->name('message.api.chat_branch');
    Route::get('message/chat_department/{type_name}/{addressee_department_id}', 'App\Http\Controllers\API\MessageController@chatDepartment')->name('message.api.chat_department');
    Route::get('message/answers/{message_id}', 'App\Http\Controllers\API\MessageController@answers')->name('message.api.answers');
    Route::put('message/switch_status/{id}', 'App\Http\Controllers\API\MessageController@switchStatus')->name('message.api.switch_status');
    Route::put('message/mark_all_read/{message_id}', 'App\Http\Controllers\API\MessageController@markAllRead')->name('message.api.mark_all_read');
    Route::put('message/upload_doc/{id}', 'App\Http\Controllers\API\MessageController@uploadDoc')->name('message.api.upload_doc');
    Route::put('message/upload_audio/{id}', 'App\Http\Controllers\API\MessageController@uploadAudio')->name('message.api.upload_audio');
    Route::put('message/upload_video/{id}', 'App\Http\Controllers\API\MessageController@uploadVideo')->name('message.api.upload_video');
    Route::put('message/upload_image/{id}', 'App\Http\Controllers\API\MessageController@uploadImage')->name('message.api.upload_image');
    // Notification
    Route::get('notification/select_by_user/{user_id}', 'App\Http\Controllers\API\NotificationController@selectByUser')->name('notification.api.select_by_user');
    Route::get('notification/select_unread_by_user/{user_id}', 'App\Http\Controllers\API\NotificationController@selectUnreadByUser')->name('notification.api.select_unread_by_user');
    Route::put('notification/switch_status/{id}', 'App\Http\Controllers\API\NotificationController@switchStatus')->name('notification.api.switch_status');
    Route::put('notification/mark_all_read/{user_id}', 'App\Http\Controllers\API\NotificationController@markAllRead')->name('notification.api.mark_all_read');
    // History
    Route::get('history/select_by_type/{user_id}/{type_id}', 'App\Http\Controllers\API\HistoryController@selectByType')->name('history.api.select_by_type');
    // Task
    Route::get('task/search/{data}/{visitor_id}', 'App\Http\Controllers\API\TaskController@search')->name('task.api.search');
    Route::get('task/find_by_user/{user_id}', 'App\Http\Controllers\API\TaskController@findByUser')->name('task.api.find_by_user');
    Route::get('task/find_by_department/{user_id}', 'App\Http\Controllers\API\TaskController@findByDepartment')->name('task.api.find_by_department');
    // PaidUnpaid
    Route::get('paid_unpaid/find_by_user_month_year/{user_id}/{month_year}', 'App\Http\Controllers\API\PaidUnpaidController@findByUserMonthYear')->name('paid_unpaid.api.find_by_user_month_year');
    Route::get('paid_unpaid/find_by_user_year/{user_id}/{year}', 'App\Http\Controllers\API\PaidUnpaidController@findByUserYear')->name('paid_unpaid.api.find_by_user_year');
    Route::get('paid_unpaid/find_by_branch_month_year/{branch_id}/{month_year}', 'App\Http\Controllers\API\PaidUnpaidController@findByBranchMonthYear')->name('paid_unpaid.api.find_by_branch_month_year');
    Route::get('paid_unpaid/find_by_branch_year/{branch_id}/{year}', 'App\Http\Controllers\API\PaidUnpaidController@findByBranchYear')->name('paid_unpaid.api.find_by_branch_year');
    Route::get('paid_unpaid/find_by_branch_month_year_status/{branch_id}/{month_year}/{status_name}', 'App\Http\Controllers\API\PaidUnpaidController@findByBranchMonthYearStatus')->name('paid_unpaid.api.find_by_branch_month_year_status');
    Route::get('paid_unpaid/find_by_branch_year_status/{branch_id}/{year}/{status_name}', 'App\Http\Controllers\API\PaidUnpaidController@findByBranchYearStatus')->name('paid_unpaid.api.find_by_branch_year_status');
    Route::get('paid_unpaid/find_by_branch_is_paid_month_year/{branch_id}/{is_paid}/{month_year}', 'App\Http\Controllers\API\PaidUnpaidController@findByBranchIsPaidMonthYear')->name('paid_unpaid.api.find_by_branch_is_paid_month_year');
    Route::get('paid_unpaid/find_by_branch_is_paid_year/{branch_id}/{is_paid}/{year}', 'App\Http\Controllers\API\PaidUnpaidController@findByBranchIsPaidYear')->name('paid_unpaid.api.find_by_branch_is_paid_year');
    Route::get('paid_unpaid/find_by_branch_is_paid_month_year_status/{branch_id}/{is_paid}/{month_year}/{status_name}', 'App\Http\Controllers\API\PaidUnpaidController@findByBranchIsPaidMonthYearStatus')->name('paid_unpaid.api.find_by_branch_is_paid_month_year_status');
    Route::get('paid_unpaid/find_by_branch_is_paid_year_status/{branch_id}/{is_paid}/{year}/{status_name}', 'App\Http\Controllers\API\PaidUnpaidController@findByBranchIsPaidYearStatus')->name('paid_unpaid.api.find_by_branch_is_paid_year_status');
    Route::put('paid_unpaid/switch_is/{id}', 'App\Http\Controllers\API\PaidUnpaidController@switchIs')->name('paid_unpaid.api.switch_is');
    // Vacation
    Route::get('vacation/find_by_year/{year}', 'App\Http\Controllers\API\VacationController@findByYear')->name('vacation.api.find_by_year');
});
