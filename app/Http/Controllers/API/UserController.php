<?php

namespace App\Http\Controllers\API;

use stdClass;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Group;
use App\Models\History;
use App\Models\Notification;
use App\Models\PaidUnpaid;
use App\Models\PasswordReset;
use App\Models\PresenceAbsence;
use App\Models\Role;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\User as ResourcesUser;
use App\Http\Resources\PasswordReset as ResourcesPasswordReset;
use App\Http\Resources\PresenceAbsence as ResourcesPresenceAbsence;
use Carbon\Carbon;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByDesc('updated_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get inputs
        $inputs = [
            'number' => $request->number,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'surname' => $request->surname,
            'gender' => $request->gender,
            'birth_city' => $request->birth_city,
            'birth_date' => $request->birth_date,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'p_o_box' => $request->p_o_box,
            'phone' => $request->phone,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'email_verified_at' => $request->email_verified_at,
            'remember_token' => $request->remember_token,
            'api_token' => $request->api_token,
            'avatar_url' => $request->avatar_url,
            'office' => $request->office,
            'is_department_chief' => !empty($request->is_department_chief) ? $request->is_department_chief : 0,
            'status_id' => $request->status_id,
            'department_id' => $request->department_id
        ];
        $users = User::all();
        $password_resets = PasswordReset::all();
        // ===== VONAGE API FOR SENDING SMS =====
        // $basic  = new \Vonage\Client\Credentials\Basic('', '');
        // $client = new \Vonage\Client($basic);

        // Validate required fields
        if ($inputs['firstname'] == null OR $inputs['firstname'] == ' ') {
            return $this->handleError($inputs['firstname'], __('validation.required'), 400);
        }

        if ($inputs['username'] != null) {
            // Check if username already exists
            foreach ($users as $another_user):
                if ($another_user->username == $inputs['username']) {
                    return $this->handleError($inputs['username'], __('validation.custom.username.exists'), 400);
                }
            endforeach;

            // Check correct username
            if (preg_match('#^[\w]+$#', $inputs['username']) == 0) {
                return $this->handleError($inputs['username'], __('miscellaneous.username.error'), 400);
            }
        }

        if ($inputs['email'] == null AND $inputs['phone'] == null) {
            return $this->handleError($inputs['phone'], __('validation.custom.email_or_phone.required'), 400);
        }

        if ($inputs['email'] == ' ' AND $inputs['phone'] == ' ') {
            return $this->handleError($inputs['phone'], __('validation.custom.email_or_phone.required'), 400);
        }

        if ($inputs['email'] == null AND $inputs['phone'] == ' ') {
            return $this->handleError($inputs['phone'], __('validation.custom.email_or_phone.required'), 400);
        }

        if ($inputs['email'] == ' ' AND $inputs['phone'] == null) {
            return $this->handleError($inputs['phone'], __('validation.custom.email_or_phone.required'), 400);
        }

        if ($inputs['phone'] != null) {
            // Check if user phone already exists
            foreach ($users as $another_user):
                if ($another_user->phone == $inputs['phone']) {
                    return $this->handleError($inputs['phone'], __('validation.custom.phone.exists'), 400);
                }
            endforeach;

            // If phone exists in "password_reset" table, delete it
            if ($password_resets != null) {
                foreach ($password_resets as $password_reset):
                    if ($password_reset->phone == $inputs['phone']) {
                        $password_reset->delete();
                    }
                endforeach;
            }
        }

        if ($inputs['email'] != null) {
            // Check if user email already exists
            foreach ($users as $another_user):
                if ($another_user->email == $inputs['email']) {
                    return $this->handleError($inputs['email'], __('validation.custom.email.exists'), 400);
                }
            endforeach;

            // If email exists in "password_reset" table, delete it
            if ($password_resets != null) {
                foreach ($password_resets as $password_reset):
                    if ($password_reset->email == $inputs['email']) {
                        $password_reset->delete();
                    }
                endforeach;
            }
        }

        if ($inputs['password'] == null OR $inputs['password'] == ' ') {
            return $this->handleError($inputs['password'], __('validation.required'), 400);
        }

        if (preg_match('#^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#', $inputs['password']) == 0) {
            return $this->handleError($inputs['password'], __('miscellaneous.password.error'), 400);
        }

        if ($request->confirm_password == null OR $request->confirm_password == ' ') {
            return $this->handleError($request->confirm_password, __('validation.required'), 400);
        }

        if ($request->confirm_password != $inputs['password'] OR $request->confirm_password == null) {
            return $this->handleError($request->confirm_password, __('miscellaneous.confirm_password.error'), 400);
        }

        $random_string = (string) random_int(1000000, 9999999);

        if ($inputs['email'] != null AND $inputs['phone'] != null) {
            $password_reset = PasswordReset::create([
                'email' => $inputs['email'],
                'phone' => $inputs['phone'],
                'token' => $random_string,
                'former_password' => $inputs['password']
            ]);

            // ===== VONAGE API FOR SENDING SMS =====
            // try {
            //     $client->sms()->send(new \Vonage\SMS\Message\SMS($password_reset->phone, 'ACR', (string) $password_reset->token));

            // } catch (\Throwable $th) {
            //     return $this->handleError($th->getMessage(), __('notifications.create_user_SMS_failed'), 500);
            // }

        } else {
            if ($inputs['email'] != null) {
                PasswordReset::create([
                    'email' => $inputs['email'],
                    'token' => $random_string,
                    'former_password' => $inputs['password']
                ]);
            }

            if ($inputs['phone'] != null) {
                $password_reset = PasswordReset::create([
                    'phone' => $inputs['phone'],
                    'token' => $random_string,
                    'former_password' => $inputs['password']
                ]);

                // ===== VONAGE API FOR SENDING SMS =====
                // try {
                //     $client->sms()->send(new \Vonage\SMS\Message\SMS($password_reset->phone, 'ACR', (string) $password_reset->token));

                // } catch (\Throwable $th) {
                //     return $this->handleError($th->getMessage(), __('notifications.create_user_SMS_failed'), 500);
                // }
            }
        }

        $user = User::create($inputs);

        if ($request->role_id != null) {
            $user->roles()->attach([$request->role_id]);

            /*
                HISTORY AND/OR NOTIFICATION MANAGEMENT
            */
            $role = Role::find($request->role_id);

            if (!is_null($role)) {
                if ($role->role_name == 'Manager') {
                    $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
                    $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();

                    Notification::create([
                        'notification_url' => '/about',
                        'notification_content' => __('notifications.welcome_manager'),
                        'icon' => 'bi bi-person-plus-fill',
                        'color' => 'primary',
                        'status_id' => $status_unread->id,
                        'user_id' => $user->id,
                    ]);
                }

                if ($role->role_name == 'Employé') {
                    $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
                    $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();

                    Notification::create([
                        'notification_url' => '/about',
                        'notification_content' => __('notifications.welcome_employee'),
                        'icon' => 'bi bi-person-badge',
                        'color' => 'primary',
                        'status_id' => $status_unread->id,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }

        if ($request->branch_id != null) {
            $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
            $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();

            $user->branches()->attach([$request->branch_id]);

            /*
                HISTORY AND/OR NOTIFICATION MANAGEMENT
            */
            $branch = Branch::find($request->branch_id);

            if (!is_null($branch)) {
                Notification::create([
                    'notification_url' => '/account',
                    'notification_content' => __('notifications.you_are_placed_branch', ['placed' => ($user->gender == 'F' ? __('notifications.placed_feminine') : __('notifications.placed_masculine'))]) . $branch->branch_name . '.',
                    'icon' => 'bi bi-building-check',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $user->id,
                ]);
            }
        }

        $object = new stdClass();
        $object->password_reset = new ResourcesPasswordReset($password_reset);
        $object->user = new ResourcesUser($user);

        return $this->handleResponse($object, __('notifications.create_user_success') . ($request->branch_id != null ? (is_null($branch) ? ' | ' . __('notifications.find_branch_404') : '') : ''));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        return $this->handleResponse(new ResourcesUser($user), __('notifications.find_user_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'number' => $request->number,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'surname' => $request->surname,
            'gender' => $request->gender,
            'birth_city' => $request->birth_city,
            'birth_date' => $request->birth_date,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'p_o_box' => $request->p_o_box,
            'phone' => $request->phone,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'email_verified_at' => $request->email_verified_at,
            'remember_token' => $request->remember_token,
            'api_token' => $request->api_token,
            'avatar_url' => $request->avatar_url,
            'office' => $request->office,
            'is_department_chief' => $request->is_department_chief,
            'status_id' => $request->status_id,
            'department_id' => $request->department_id
        ];
        $users = User::all();
        $current_user = User::find($inputs['id']);

        if ($inputs['number'] != null) {
            $user->update([
                'number' => $request->number,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['firstname'] != null) {
            $user->update([
                'firstname' => $request->firstname,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['lastname'] != null) {
            $user->update([
                'lastname' => $request->lastname,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['surname'] != null) {
            $user->update([
                'surname' => $request->surname,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['gender'] != null) {
            $user->update([
                'gender' => $request->gender,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['birth_city'] != null) {
            $user->update([
                'birth_city' => $request->birth_city,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['birth_date'] != null) {
            $user->update([
                'birth_date' => $request->birth_date,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['address_1'] != null) {
            $user->update([
                'address_1' => $request->address_1,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['address_2'] != null) {
            $user->update([
                'address_2' => $request->address_2,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['p_o_box'] != null) {
            $user->update([
                'p_o_box' => $request->p_o_box,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['phone'] != null) {
            // Check if phone already exists
            foreach ($users as $another_user):
                if ($current_user->phone != $inputs['phone']) {
                    if ($another_user->phone == $inputs['phone']) {
                        return $this->handleError($inputs['phone'], __('validation.custom.phone.exists'), 400);
                    }
                }
            endforeach;

            $user->update([
                'phone' => $request->phone,
                'updated_at' => now(),
            ]);

            $password_reset_by_phone = PasswordReset::where('phone', $inputs['phone'])->first();

            if ($password_reset_by_phone == null) {
                $password_reset_by_email = PasswordReset::where('email', $current_user->email)->first();

                if ($password_reset_by_email != null) {
                    $password_reset_by_email->update([
                        'phone' => $inputs['phone'],
                        'updated_at' => now(),
                    ]);

                } else {
                    PasswordReset::create([
                        'phone' => $inputs['phone'],
                    ]);
                }
            }
        }

        if ($inputs['email'] != null) {
            // Check if email already exists
            foreach ($users as $another_user):
                if ($current_user->email != $inputs['email']) {
                    if ($another_user->email == $inputs['email']) {
                        return $this->handleError($inputs['email'], __('validation.custom.email.exists'), 400);
                    }
                }
            endforeach;

            $user->update([
                'email' => $request->email,
                'updated_at' => now(),
            ]);

            $password_reset_by_email = PasswordReset::where('email', $inputs['email'])->first();

            if ($password_reset_by_email == null) {
                $password_reset_by_phone = PasswordReset::where('phone', $current_user->phone)->first();

                if ($password_reset_by_phone != null) {
                    $password_reset_by_phone->update([
                        'email' => $inputs['email'],
                        'updated_at' => now(),
                    ]);

                } else {
                    PasswordReset::create([
                        'email' => $inputs['email'],
                    ]);
                }
            }
        }

        if ($inputs['username'] != null) {
            // Check if username already exists
            foreach ($users as $another_user):
                if ($current_user->username != $inputs['username']) {
                    if ($another_user->username == $inputs['username']) {
                        return $this->handleError($inputs['username'], __('validation.custom.username.exists'), 400);
                    }
                }
            endforeach;

            // Check correct username
            if (preg_match('#^[\w]+$#i', $inputs['username']) == 0) {
                return $this->handleError($inputs['username'], __('miscellaneous.username.error'), 400);
            }

            $user->update([
                'username' => $request->username,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['password'] != null) {
            if (preg_match('#^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#', $inputs['password']) == 0) {
                return $this->handleError($inputs['password'], __('miscellaneous.password.error'), 400);
            }

            if ($request->confirm_password != $inputs['password'] OR $request->confirm_password == null) {
                return $this->handleError($request->confirm_password, __('notifications.confirm_password_error'), 400);
            }

            $password_reset_by_email = PasswordReset::where('email', $inputs['email'])->first();
            $password_reset_by_phone = PasswordReset::where('phone', $inputs['phone'])->first();
            $random_string = (string) random_int(1000000, 9999999);

            // If password_reset doesn't exist, create it.
            if ($password_reset_by_email == null AND $password_reset_by_phone == null) {
                if ($inputs['email'] != null AND $inputs['phone'] != null) {
                    PasswordReset::create([
                        'email' => $inputs['email'],
                        'phone' => $inputs['phone'],
                        'token' => $random_string,
                        'former_password' => $inputs['password'],
                    ]);

                } else {
                    if ($inputs['email'] != null) {
                        PasswordReset::create([
                            'email' => $inputs['email'],
                            'token' => $random_string,
                            'former_password' => $inputs['password']
                        ]);
                    }

                    if ($inputs['phone'] != null) {
                        PasswordReset::create([
                            'phone' => $inputs['phone'],
                            'token' => $random_string,
                            'former_password' => $inputs['password']
                        ]);
                    }
                }

            // Otherwise, update it.
            } else {
                if ($password_reset_by_email != null) {
                    // Update password reset
                    $password_reset_by_email->update([
                        'token' => $random_string,
                        'former_password' => $inputs['password'],
                        'updated_at' => now(),
                    ]);
                }

                if ($password_reset_by_phone != null) {
                    // Update password reset
                    $password_reset_by_phone->update([
                        'token' => $random_string,
                        'former_password' => $inputs['password'],
                        'updated_at' => now(),
                    ]);
                }
            }

            $inputs['password'] = Hash::make($inputs['password']);

            $user->update([
                'password' => $inputs['password'],
                'updated_at' => now(),
            ]);
        }

        if ($inputs['email_verified_at'] != null) {
            $user->update([
                'email_verified_at' => $request->email_verified_at,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['remember_token'] != null) {
            $user->update([
                'remember_token' => $request->remember_token,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['api_token'] != null) {
            $user->update([
                'api_token' => $request->api_token,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['avatar_url'] != null) {
            $user->update([
                'avatar_url' => $request->avatar_url,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['office'] != null) {
            $user->update([
                'office' => $request->office,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['is_department_chief'] != null) {
            $user->update([
                'is_department_chief' => $request->is_department_chief,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['status_id'] != null) {
            $user->update([
                'status_id' => $request->status_id,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['department_id'] != null) {
            $user->update([
                'department_id' => $request->department_id,
                'updated_at' => now(),
            ]);
        }

        if ($request->role_id != null) {
            $user->roles()->sync([$request->role_id]);
        }

        if ($request->branch_id != null) {
            $user->branches()->syncWithoutDetaching([$request->branch_id]);

            /*
                HISTORY AND/OR NOTIFICATION MANAGEMENT
            */
            $branch = Branch::find($request->branch_id);

            Notification::create([
                'notification_url' => '/account',
                'notification_content' => __('notifications.admin_placed_you') . $branch->branch_name . '.',
                'icon' => 'bi bi-building-check',
                'color' => 'primary',
                'status_id' => $status_unread->id,
                'user_id' => $user->id,
            ]);
        }

        if ($request->account_owner_id != null) {
            /*
                HISTORY AND/OR NOTIFICATION MANAGEMENT
            */
            History::create([
                'history_content' => __('notifications.you_updated_account'),
                'history_url' => '/account',
                'icon' => 'bi bi-person-square',
                'color' => 'danger',
                'type_id' => $activities_history_type->id,
                'user_id' => $request->account_owner_id,
            ]);
        }

        return $this->handleResponse(new ResourcesUser($user), __('notifications.update_user_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        $users = User::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.delete_user_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search a user by his firstname / lastname / number and having role and/or branch.
     *
     * @param  string $data
     * @param  int $visitor_id
     * @param  string $role_name
     * @param  int $branch_id
     * @return \Illuminate\Http\Response
     */
    public function search($data, $visitor_id, $role_name, $branch_id)
    {
        if ($branch_id == 'ANONYMOUS') {
            $users = User::when($data && $role_name, function ($query) use ($data, $role_name) {
                $query->whereHas('roles', function ($query) use ($role_name) {
                    $query->where('roles.role_name', '=', $role_name);
                });

                $query->where('firstname', 'LIKE', '%' . $data . '%')->orWhere('lastname', 'LIKE', '%' . $data . '%')->orWhere('number', 'LIKE', '%' . $data . '%');

            })->orderByDesc('created_at')->get();

            if (is_null($users)) {
                return $this->handleResponse(null, __('miscellaneous.empty_list'));
            }

        } else {
            $users = User::whereHas('roles', function ($query) use ($role_name) {
                            $query->latest('roles.created_at')->where('roles.role_name', '=', $role_name);
                        })->whereHas('branches', function ($query) use ($branch_id) {
                            $query->latest('branches.created_at')->where('branches.id', '=', $branch_id);
                        })->when($data, function ($query) use ($data) {
                            $query->where('firstname', 'LIKE', '%' . $data . '%')->orWhere('lastname', 'LIKE', '%' . $data . '%')->orWhere('number', 'LIKE', '%' . $data . '%');
                        })->get();

            if (is_null($users)) {
                return $this->handleResponse(null, __('miscellaneous.empty_list'));
            }
        }

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $search_history_type = Type::where([['type_name', 'Historique de recherche'], ['group_id', $history_type_group->id]])->first();

        if ($role_name == 'Administrateur') {
            History::create([
                'history_content' => $data,
                'history_url' => '/search/admins/?query=' . $data,
                'type_id' => $search_history_type->id,
                'user_id' => $visitor_id,
            ]);
        }

        if ($role_name == 'Manager') {
            History::create([
                'history_content' => $data,
                'history_url' => '/search/managers/?query=' . $data,
                'type_id' => $search_history_type->id,
                'user_id' => $visitor_id,
            ]);
        }

        if ($role_name == 'Employé') {
            $visitor = User::find($visitor_id);

            if (!is_null($visitor)) {
                History::create([
                    'history_content' => $data,
                    'history_url' => '/search/employees/?branch_id=' . $visitor->branches[0]->id . '&query=' . $data,
                    'type_id' => $search_history_type->id,
                    'user_id' => $visitor->id,
                ]);
            }
        }

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));
    }

    /**
     * Search all users having a specific role
     *
     * @param  string $role_name
     * @return \Illuminate\Http\Response
     */
    public function findByRole($role_name)
    {
        $users = User::whereHas('roles', function ($query) use ($role_name) {
                                    $query->where('role_name', $role_name);
                                })->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));    
    }

    /**
     * Search all users having a role different than the given
     *
     * @param  string $role_name
     * @return \Illuminate\Http\Response
     */
    public function findByNotRole($role_name)
    {
        $users = User::whereDoesntHave('roles', function ($query) use ($role_name) {
                                    $query->where('role_name', $role_name);
                                })->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));    
    }

    /**
     * Search all users belonging to a specific branch
     *
     * @param  int $branch_id
     * @return \Illuminate\Http\Response
     */
    public function findByBranch($branch_id)
    {
        $users = User::whereHas('branches', function ($query) use ($branch_id) {
                                    $query->where('branches.id', $branch_id);
                                })->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));    
    }

    /**
     * Search all users belonging to no branch
     *
     * @return \Illuminate\Http\Response
     */
    public function findByEmptyBranch()
    {
        $users = User::whereDoesntHave('branches')->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));    
    }

    /**
     * Search all users belonging to a specific branch and having a specific role
     *
     * @param  int $branch_id
     * @param  string $role_name
     * @return \Illuminate\Http\Response
     */
    public function findByBranchRole($branch_id, $role_name)
    {
        $users = User::whereHas('branches', function ($query) use ($branch_id) {
                            $query->where('branches.id', $branch_id);
                        })->whereHas('roles', function ($query) use ($role_name) {
                            $query->where('roles.role_name', $role_name);
                        })->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));    
    }

    /**
     * Search all users belonging to a specific branch and having a specific role and status
     *
     * @param  int $branch_id
     * @param  string $role_name
     * @param  string $status_name
     * @return \Illuminate\Http\Response
     */
    public function findByBranchRoleStatus($branch_id, $role_name, $status_name)
    {
        $users = User::whereHas('branches', function ($query) use ($branch_id) {
                            $query->where('branches.id', $branch_id);
                        })->whereHas('roles', function ($query) use ($role_name) {
                            $query->where('roles.role_name', $role_name);
                        })->whereHas('status', function ($query) use ($status_name) {
                            $query->where('statuses.status_name', $status_name);
                        })->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));    
    }

    /**
     * Search all users belonging to no branch and having a specific role
     *
     * @param  string $role_name
     * @return \Illuminate\Http\Response
     */
    public function findByEmptyBranchRole($role_name)
    {
        $users = User::whereDoesntHave('branches')->whereHas('roles', function ($query) use ($role_name) {
                                    $query->where('roles.role_name', $role_name);
                                })->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));    
    }

    /**
     * Search all users belonging to no branch or to a specific branch, and having a specific role
     *
     * @param  int $branch_id
     * @param  string $role_name
     * @return \Illuminate\Http\Response
     */
    public function findByEmptyOrSpecificBranchRole($branch_id, $role_name)
    {
        $users = User::whereHas('roles', function ($query) use ($role_name) {
                            $query->where('roles.role_name', $role_name);
                        })->where(function ($query) use ($branch_id) {
                            $query->doesntHave('branches')->orWhereHas('branches', function ($query) use ($branch_id) {
                                $query->where('branches.id', $branch_id);
                            });
                        })->orderByDesc('users.created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));    
    }

    /**
     * Search all users having specific status.
     *
     * @param  int $status_id
     * @return \Illuminate\Http\Response
     */
    public function findByStatus($status_id)
    {
        $users = User::where('status_id', $status_id)->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesUser::collection($users), __('notifications.find_all_users_success'));
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Get inputs
        $inputs = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if ($inputs['username'] == null OR $inputs['username'] == ' ') {
            return $this->handleError($inputs['username'], __('validation.required'), 400);
        }

        if ($inputs['password'] == null) {
            return $this->handleError($inputs['password'], __('validation.required'), 400);
        }

        if (is_numeric($inputs['username'])) {
            $user = User::where('phone', $inputs['username'])->first();

            if (!$user) {
                return $this->handleError($inputs['username'], __('auth.username'), 400);
            }

            if (!Hash::check($inputs['password'], $user->password)) {
                return $this->handleError($inputs['password'], __('auth.password'), 400);
            }

            // If user is a manager, ensure that payment for the month and presence 
            // for today are registered for all its branch employees
            if (inArrayR('Manager', $user->roles, 'role_name')) {
                $this->checkPresencesPayments($user->id);
            }

            // If user is an employee and has the status "Actif",
            // ensure that his payment for the month and his presence for today are registered
            if (inArrayR('Employé', $user->roles, 'role_name')) {
                $this->checkPresencePayment($user->id);
            }

            return $this->handleResponse(new ResourcesUser($user), __('notifications.find_user_success'));

        } else {
            $user = User::where('email', $inputs['username'])->orWhere('username', $inputs['username'])->first();

            if (!$user) {
                return $this->handleError($inputs['username'], __('auth.username'), 400);
            }

            if (!Hash::check($inputs['password'], $user->password)) {
                return $this->handleError($inputs['password'], __('auth.password'), 400);
            }

            // If user is a manager, ensure that payment for the month and presence 
            // for today are registered for all its branch employees
            if (inArrayR('Manager', $user->roles, 'role_name')) {
                $this->checkPresencesPayments($user->id);
            }

            // If user is an employee and has the status "Actif",
            // ensure that his payment for the month and his presence for today are registered
            if (inArrayR('Employé', $user->roles, 'role_name')) {
                $this->checkPresencePayment($user->id);
            }

            return $this->handleResponse(new ResourcesUser($user), __('notifications.find_user_success'));
        }
    }

    /**
     * The manager can automatically check all presences and payments
     *
     * @param  $manager_id
     * @return \Illuminate\Http\Response
     */
    public function checkPresencesPayments($manager_id)
    {
        $user = User::find($manager_id);
        $all_branch_employees = User::whereHas('branches', function ($query) use ($user) {
                                            $query->where('branches.id', $user->branches[0]->id);
                                        })->whereHas('roles', function ($query) {
                                            $query->where('roles.role_name', 'Employé');
                                        })->whereHas('status', function ($query) {
                                            $query->where('statuses.status_name', 'Actif');
                                        })->get();
        $employees_presences = PresenceAbsence::whereHas('user', function ($query) use ($user) {
                                                    $query->whereHas('branches', function ($query) use ($user) {
                                                        $query->where('branches.id', $user->branches[0]->id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    });
                                                })->whereDate('presence_absences.daytime', '=', Carbon::today()->toDateString())->get();
        $employees_payments = PaidUnpaid::where('paid_unpaids.month_year', date('m-Y'))
                                            ->whereHas('user', function ($query) use ($user) {
                                                $query->whereHas('branches', function ($query) use ($user) {
                                                    $query->where('branches.id', $user->branches[0]->id);
                                                })->whereHas('roles', function ($query) {
                                                    $query->where('roles.role_name', 'Employé');
                                                })->whereHas('status', function ($query) {
                                                    $query->where('statuses.status_name', 'Actif');
                                                });
                                            })->get();

        // Presences checking
        if (count($employees_presences) == 0) {
            foreach ($all_branch_employees as $branch_employee) {
                $presence_absence_last = PresenceAbsence::where('user_id', $branch_employee->id)->latest('created_at')->first();

                PresenceAbsence::create([
                    'daytime' => Carbon::today()->toDateString(),
                    'is_present' => 0,
                    'status_id' => $presence_absence_last->status_id,
                    'user_id' => $branch_employee->id
                ]);
            }
        }

        if (count($employees_presences) > 0) {
            if (count($employees_presences) < count($all_branch_employees)) {
                foreach ($employees_presences as $employee_presence) {
                    $some_branch_employees = User::whereNot('users.id', $employee_presence->user_id)
                                                    ->whereHas('branches', function ($query) use ($user) {
                                                        $query->where('branches.id', $user->branches[0]->id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    })->orderByDesc('users.updated_at')->get();

                    foreach ($some_branch_employees as $branch_employee) {
                        $presence_absence_last = PresenceAbsence::where('user_id', $branch_employee->id)->latest('created_at')->first();

                        PresenceAbsence::create([
                            'daytime' => Carbon::today()->toDateString(),
                            'is_present' => 0,
                            'status_id' => $presence_absence_last->status_id,
                            'user_id' => $branch_employee->id
                        ]);
                    }
                }
            }
        }

        // Payments checking
        if (count($employees_payments) == 0) {
            foreach ($all_branch_employees as $branch_employee) {
                PaidUnpaid::create([
                    'month_year' => date('m-Y'),
                    'is_paid' => 0,
                    'user_id' => $branch_employee->id
                ]);
            }
        }

        if (count($employees_payments) > 0) {
            if (count($employees_payments) < count($all_branch_employees)) {
                foreach ($employees_payments as $employee_payment) {
                    $some_branch_employees = User::whereNot('users.id', $employee_payment->user_id)
                                                    ->whereHas('branches', function ($query) use ($user) {
                                                        $query->where('branches.id', $user->branches[0]->id);
                                                    })->whereHas('roles', function ($query) {
                                                        $query->where('roles.role_name', 'Employé');
                                                    })->whereHas('status', function ($query) {
                                                        $query->where('statuses.status_name', 'Actif');
                                                    })->orderByDesc('users.updated_at')->get();

                    foreach ($some_branch_employees as $branch_employee) {
                        PaidUnpaid::create([
                            'month_year' => date('m-Y'),
                            'is_paid' => 0,
                            'user_id' => $branch_employee->id
                        ]);
                    }
                }
            }
        }

        return $this->handleResponse(ResourcesPresenceAbsence::collection($employees_presences), __('notifications.find_all_presence_absences_success'));
    }

    /**
     * Automatically check employee presence for today and payment for current month
     *
     * @param  $employee_id
     * @return \Illuminate\Http\Response
     */
    public function checkPresencePayment($employee_id)
    {
        $user = User::find($employee_id);
        $paid_unpaid = PaidUnpaid::where([['user_id', $user->id], ['month_year', date('m-Y')]])->first();
        $presence_absence_today = PresenceAbsence::where([['user_id', $user->id], ['daytime', Carbon::today()->toDateString()]])->first();

        if ($user->status->status_name == 'Actif') {
            // If payment doesn't exist, create it
            if (is_null($paid_unpaid)) {
                PaidUnpaid::create([
                    'month_year' => date('m-Y'),
                    'is_paid' => 0,
                    'user_id' => $user->id
                ]);
            }

            // If presence exists and the column "is_present" equals "0", change it to "1"
            if ($presence_absence_today != null) {
                if ($presence_absence_today->is_present == 0 AND $presence_absence_today->status->status_name == 'Opérationnel') {
                    $presence_absence_today->update([
                        'is_present' => 1,
                        'updated_at' => now()
                    ]);
                }

            // Otherwise, search last presence to get the status
            } else {
                $presence_absence_last = PresenceAbsence::where('user_id', $user->id)->latest('created_at')->first();

                PresenceAbsence::create([
                    'daytime' => Carbon::today()->toDateString(),
                    'is_present' => 1,
                    'status_id' => $presence_absence_last->status_id,
                    'user_id' => $user->id
                ]);
            }
        }

        return $this->handleResponse(new ResourcesPresenceAbsence($presence_absence_today), __('notifications.find_presence_absence_success'));
    }

    /**
     * Switch between user statuses.
     *
     * @param  $id
     * @param  $status_id
     * @param  $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function switchStatus($id, $status_id, $visitor_id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        $current_status = Status::find($status_id);

        if (is_null($current_status)) {
            return $this->handleError(__('notifications.find_status_404'));
        }

        // update "status_id" column
        $user->update([
            'status_id' => $current_status->id,
            'updated_at' => now()
        ]);

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();

        if ($id == $visitor_id) {
            if ($current_status->status_name == 'Désactivé') {
                History::create([
                    'history_content' => __('notifications.you_deactivate_account'),
                    'history_url' => '/account',
                    'icon' => 'bi bi-toggle-on',
                    'color' => 'warning',
                    'type_id' => $activities_history_type->id,
                    'user_id' => $visitor_id,
                ]);

            } else {
                History::create([
                    'history_content' => __('notifications.you_activate_account'),
                    'history_url' => '/account',
                    'icon' => 'bi bi-toggle-on',
                    'color' => 'warning',
                    'type_id' => $activities_history_type->id,
                    'user_id' => $visitor_id,
                ]);
            }

        } else {
            History::create([
                'history_content' => __('notifications.you_changed_status') . $user->firstname . ' ' . $user->lastname,
                'history_url' => '/employee/' . $user->id,
                'icon' => 'bi bi-toggle-on',
                'color' => 'warning',
                'type_id' => $activities_history_type->id,
                'user_id' => $visitor_id,
            ]);

            Notification::create([
                'notification_url' => '/account',
                'notification_content' =>  !inArrayR('Employé', $user->roles, 'role_name') ? __('notifications.admin_changed_status') : __('notifications.manager_changed_status'),
                'icon' => 'bi bi-toggle-on',
                'color' => 'warning',
                'status_id' => $status_unread->id,
                'user_id' => $user->id,
            ]);
        }

        return $this->handleResponse(new ResourcesUser($user), __('notifications.update_user_success'));
    }

    /**
     * Update user role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @param  $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, $id, $visitor_id)
    {
        $user = User::find($id);

        $user->roles()->sync([$request->role_id]);

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();
        $visitor = User::find($visitor_id);

        if (!is_null($visitor)) {
            History::create([
                'history_content' => __('notifications.you_changed_role') . $user->firstname . ' ' . $user->lastname,
                'history_url' => inArrayR('Administrateur', $visitor->roles, 'role_name') ? (inArrayR('Administrateur', $user->roles, 'role_name') ? '/role/other_admins/' . $user->id : '/role/managers/' . $user->id) : '/employee/' . $user->id,
                'icon' => 'bi bi-mortarboard',
                'color' => 'info',
                'type_id' => $activities_history_type->id,
                'user_id' => $visitor->id,
            ]);
        }

        Notification::create([
            'notification_url' => '/account',
            'notification_content' => !inArrayR('Employé', $user->roles, 'role_name') ? __('notifications.admin_changed_role') : __('notifications.manager_changed_role'),
            'icon' => 'bi bi-mortarboard',
            'color' => 'info',
            'status_id' => $status_unread->id,
            'user_id' => $user->id,
        ]);

        return $this->handleResponse(new ResourcesUser($user), __('notifications.update_user_success'));
    }

    /**
     * Update user department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @param  $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function updateDepartment(Request $request, $id, $visitor_id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        $user->update([
            'department_id' => $request->department_id,
            'updated_at' => now(),
        ]);

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $department = Department::find($request->department_id);
        $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();

        History::create([
            'history_content' => __('notifications.you_placed_to_department', ['employee_names' => $user->firstname . ' ' . $user->lastname]) . $department->department_name . '.',
            'history_url' => inArrayR('Employé', $user->roles, 'role_name') ? '/employee/' . $user->id : (inArrayR('Manager', $user->roles, 'role_name') ? '/role/managers/' . $user->id : '/role/other_admins/' . $user->id),
            'icon' => 'bi bi-diagram-3',
            'color' => 'danger',
            'type_id' => $activities_history_type->id,
            'user_id' => $visitor_id,
        ]);

        Notification::create([
            'notification_url' => '/account',
            'notification_content' => __('notifications.you_are_placed_department', ['placed' => ($user->gender == 'F' ? __('notifications.placed_feminine') : __('notifications.placed_masculine'))]) . $department->department_name . '.',
            'icon' => 'bi bi-diagram-3',
            'color' => 'danger',
            'status_id' => $status_unread->id,
            'user_id' => $user->id,
        ]);

        return $this->handleResponse(new ResourcesUser($user), __('notifications.update_user_success'));
    }

    /**
     * Update department chief in storage.
     *
     * @param  $id
     * @param  $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function updateDepartmentChief($id, $visitor_id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404') . __('miscellaneous.colon_after_word') . 'CURRENT-USER');
        }

        if (count($user->branches) > 0) {
            $branch = Branch::find($user->branches[0]->id);

            // Get the former department chief
            $former_chief = User::whereHas('branches', function ($query) use ($branch) {
                                    $query->where('branches.id', $branch->id);
                                })->where([['department_id', $user->department_id], ['is_department_chief', 1]])->first();

            if ($former_chief != null) {
                $former_chief->update([
                    'is_department_chief' => 0,
                    'updated_at' => now(),
                ]);
            }

            $user->update([
                'is_department_chief' => 1,
                'updated_at' => now(),
            ]);

            /*
                HISTORY AND/OR NOTIFICATION MANAGEMENT
            */
            $notif_status_group = Group::where('group_name', 'Etat de la notification')->first();
            $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
            $status_unread = Status::where([['status_name', 'Non lue'], ['group_id', $notif_status_group->id]])->first();
            $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();

            History::create([
                'history_content' => __('notifications.you_choose_department_chief', ['chief_names' => $user->firstname . ' ' . $user->lastname]),
                'history_url' => inArrayR('Employé', $user->roles, 'role_name') ? '/employee/' . $user->id : (inArrayR('Manager', $user->roles, 'role_name') ? '/role/managers/' . $user->id : '/role/other_admins/' . $user->id),
                'icon' => 'bi bi-person-badge',
                'color' => 'primary',
                'type_id' => $activities_history_type->id,
                'user_id' => $visitor_id,
            ]);

            if ($former_chief != null) {
                Notification::create([
                    'notification_url' => '/account',
                    'notification_content' => __('notifications.you_are_no_longer_chief'),
                    'icon' => 'bi bi-person-badge',
                    'color' => 'primary',
                    'status_id' => $status_unread->id,
                    'user_id' => $former_chief->id,
                ]);
            }

            Notification::create([
                'notification_url' => '/account',
                'notification_content' => __('notifications.you_are_now_chief'),
                'icon' => 'bi bi-person-badge',
                'color' => 'primary',
                'status_id' => $status_unread->id,
                'user_id' => $user->id,
            ]);
        }

        return $this->handleResponse(new ResourcesUser($user), __('notifications.update_user_success'));
    }

    /**
     * Update user password in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @param  int $visitor_id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id, $visitor_id)
    {
        // Get inputs
        $inputs = [
            'former_password' => $request->former_password,
            'new_password' => $request->new_password,
            'confirm_new_password' => $request->confirm_new_password
        ];
        $user = User::find($id);

        if ($inputs['former_password'] == null) {
            return $this->handleError($inputs['former_password'], __('validation.custom.former_password.empty'), 400);
        }

        if ($inputs['new_password'] == null) {
            return $this->handleError($inputs['new_password'], __('validation.custom.new_password.empty'), 400);
        }

        if ($inputs['confirm_new_password'] == null) {
            return $this->handleError($inputs['confirm_new_password'], __('notifications.confirm_new_password'), 400);
        }

        if (Hash::check($inputs['former_password'], $user->password) == false) {
            return $this->handleError($inputs['former_password'], __('auth.password'), 400);
        }

        if ($inputs['confirm_new_password'] != $inputs['new_password']) {
            return $this->handleError($inputs['confirm_new_password'], __('notifications.confirm_new_password'), 400);
        }

        if (preg_match('#^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#', $inputs['new_password']) == 0) {
            return $this->handleError($inputs['new_password'], __('validation.custom.new_password.incorrect'), 400);
        }

        // Update password reset
        $password_reset_by_email = PasswordReset::where('email', $user->email)->first();
        $password_reset_by_phone = PasswordReset::where('phone', $user->phone)->first();

        if ($password_reset_by_email != null) {
            // Update password reset in the case user want to reset his password
            $password_reset_by_email->update([
                'token' => random_int(1000000, 9999999),
                'former_password' => $inputs['new_password'],
                'updated_at' => now(),
            ]);
        }

        if ($password_reset_by_phone != null) {
            // Update password reset in the case user want to reset his password
            $password_reset_by_phone->update([
                'token' => random_int(1000000, 9999999),
                'former_password' => $inputs['new_password'],
                'updated_at' => now(),
            ]);
        }

        // update "password"
        $user->update([
            'password' => Hash::make($inputs['new_password']),
            'updated_at' => now()
        ]);

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();

        History::create([
            'history_content' => $visitor_id == $id ? __('notifications.you_changed_password') : __('notifications.you_changed_password_of') .  $user->firstname . ' ' . $user->lastname,
            'history_url' => $visitor_id == $id ? '/account' : (inArrayR('Employé', $user->roles, 'role_name') ? '/employee/' . $user->id : (inArrayR('Manager', $user->roles, 'role_name') ? '/role/managers/' . $user->id : '/role/other_admins/' . $user->id)),
            'icon' => 'bi bi-shield-lock',
            'color' => 'info',
            'type_id' => $activities_history_type->id,
            'user_id' => $visitor_id,
        ]);

        return $this->handleResponse(new ResourcesUser($user), __('notifications.update_password_success'));
    }

    /**
     * Get user api token in storage.
     *
     * @param  $phone
     * @return \Illuminate\Http\Response
     */
    public function getApiToken($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        return $this->handleResponse($user->api_token, __('notifications.find_api_token_success'));
    }

    /**
     * Update user api token in storage.
     *
     * @param  string $phone
     * @return \Illuminate\Http\Response
     */
    public function updateApiToken($id)
    {
        // find user by given ID
        $user = User::find($id);

        if (is_null($user)) {
            return $this->handleError(__('notifications.find_user_404'));
        }

        // update "api_token" column
        $user->update([
            'api_token' => Str::random(100),
            'updated_at' => now()
        ]);

        return $this->handleResponse(new ResourcesUser($user), __('notifications.update_user_success'));
    }

    /**
     * Update user avatar picture in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAvatarPicture(Request $request, $id)
    {
        $inputs = [
            'user_id' => $request->user_id,
            'image_64' => $request->image_64
        ];
        $replace = substr($inputs['image_64'], 0, strpos($inputs['image_64'], ',') + 1);
        // Find substring from replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $inputs['image_64']);
        $image = str_replace(' ', '+', $image);

        // Create image URL
		$image_url = 'images/users/' . $id . '/avatar/' . Str::random(50) . '.png';

		// Upload image
		Storage::url(Storage::disk('public')->put($image_url, base64_decode($image)));

		$user = User::find($id);

        $user->update([
            'avatar_url' => $image_url,
            'updated_at' => now()
        ]);

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $history_type_group = Group::where('group_name', 'Type d\'historique')->first();
        $activities_history_type = Type::where([['type_name', 'Historique des activités'], ['group_id', $history_type_group->id]])->first();

        if ($request->account_owner_id) {
            History::create([
                'history_content' => __('notifications.you_changed_avatar'),
                'history_url' => '/account',
                'icon' => 'bi bi-image',
                'color' => 'secondary',
                'type_id' => $activities_history_type->id,
                'user_id' => $request->account_owner_id,
            ]);
        }

        return $this->handleResponse(new ResourcesUser($user), __('notifications.update_user_success'));
    }
}
