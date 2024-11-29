<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\ApiClientManager;

class RegisteredUserController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Find users having the role "Administrateur" to verify if the register page can be displayed or not
        $data = 'Administrateur';
        $user_admins = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_role/' . $data, getApiToken());

        if (count($user_admins->data) > 0) {
            abort(403);

        } else {
            return view('auth.register');
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Find role by name API
        $role_data = 'Administrateur';
        $admin_role = $this::$api_client_manager::call('GET', getApiURL() . '/role/search/' . $role_data, getApiToken());

        if ($admin_role->success) {
            // Find status by name API
            $status_data = 'Actif';
            $active_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/' . $status_data, getApiToken());

            if ($active_status->success) {
                // User inputs
                $user_inputs = [
                    'firstname' => $request->register_firstname,
                    'lastname' => $request->register_lastname,
                    'surname' => $request->register_surname,
                    'phone' => $request->register_phone,
                    'email' => $request->register_email,
                    'password' => $request->register_password,
                    'confirm_password' => $request->confirm_password,
                    'status_id' => $active_status->data->id,
                    'role_id' => $admin_role->data->id
                ];
                // Register user API
                $user = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $user_inputs);

                if ($user->success) {
                    // Authentication datas (E-mail or Phone number)
                    $auth_phone = Auth::attempt(['phone' => $user->data->user->phone, 'password' => $user_inputs['password']]);
                    $auth_email = Auth::attempt(['email' => $user->data->user->email, 'password' => $user_inputs['password']]);

                    if ($auth_phone || $auth_email) {
                        $request->session()->regenerate();

                        return redirect()->route('home');
                    }

                } else {
                    $resp_error = $user_inputs['firstname']                     // array[0]
                                    . '-' . $user_inputs['lastname']            // array[1]
                                    . '-' . $user_inputs['surname']             // array[2]
                                    . '-' . $user_inputs['phone']               // array[3]
                                    . '-' . $user_inputs['email']               // array[4]
                                    . '-' . $user_inputs['password']            // array[5]
                                    . '-' . $user_inputs['confirm_password']    // array[6]
                                    . '-' . $user->message                      // array[7]
                                    . '-' . $user->data;                        // array[8]

                    return redirect('/register')->with('response_error', $resp_error);
                }    

            } else {
                // Group by name API
                $group_data = 'Fonctionnement';
                $functioning_group = $this::$api_client_manager::call('GET', getApiURL() . '/group/search/' . $group_data, getApiToken());

                if ($functioning_group->success) {
                    // Status inputs
                    $status_inputs = [
                        'status_name' => 'Actif',
                        'status_description' => 'Fonctionnement normal pour l\'utilisateur et travail quotidien pour l\'employé.',
                        'icon' => 'bi bi-check-circle',
                        'color' => 'success',
                        'group_id' => $functioning_group->data->id
                    ];
                    $status = $this::$api_client_manager::call('POST', getApiURL() . '/status', getApiToken(), $status_inputs);
                    // User inputs
                    $user_inputs = [
                        'firstname' => $request->register_firstname,
                        'lastname' => $request->register_lastname,
                        'surname' => $request->register_surname,
                        'phone' => $request->register_phone,
                        'email' => $request->register_email,
                        'password' => $request->register_password,
                        'confirm_password' => $request->confirm_password,
                        'status_id' => $status->data->id,
                        'role_id' => $admin_role->data->id
                    ];
                    // Register user API
                    $user = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $user_inputs);

                    if ($user->success) {
                        // Authentication datas (E-mail or Phone number)
                        $auth_phone = Auth::attempt(['phone' => $user->data->user->phone, 'password' => $user_inputs['password']]);
                        $auth_email = Auth::attempt(['email' => $user->data->user->email, 'password' => $user_inputs['password']]);

                        if ($auth_phone || $auth_email) {
                            $request->session()->regenerate();

                            return redirect()->route('home');
                        }

                    } else {
                        $resp_error = $user_inputs['firstname']                     // array[0]
                                        . '-' . $user_inputs['lastname']            // array[1]
                                        . '-' . $user_inputs['surname']             // array[2]
                                        . '-' . $user_inputs['phone']               // array[3]
                                        . '-' . $user_inputs['email']               // array[4]
                                        . '-' . $user_inputs['password']            // array[5]
                                        . '-' . $user_inputs['confirm_password']    // array[6]
                                        . '-' . $user->message                      // array[7]
                                        . '-' . $user->data;                        // array[8]

                        return redirect('/register')->with('response_error', $resp_error);
                    }    

                } else {
                    // Group inputs
                    $group_inputs = [
                        'group_name' => 'Fonctionnement',
                        'group_description' => 'Grouper les états permettant de gérer le fonctionnement des utilisateurs et autres dans l\'application.'
                    ];
                    $group = $this::$api_client_manager::call('POST', getApiURL() . '/group', getApiToken(), $group_inputs);
                    // Status inputs
                    $status_inputs = [
                        'status_name' => 'Actif',
                        'status_description' => 'Fonctionnement normal pour l\'utilisateur et travail quotidien pour l\'employé.',
                        'icon' => 'bi bi-check-circle',
                        'color' => 'success',
                        'group_id' => $group->data->id
                    ];
                    $status = $this::$api_client_manager::call('POST', getApiURL() . '/status', getApiToken(), $status_inputs);
                    // User inputs
                    $user_inputs = [
                        'firstname' => $request->register_firstname,
                        'lastname' => $request->register_lastname,
                        'surname' => $request->register_surname,
                        'phone' => $request->register_phone,
                        'email' => $request->register_email,
                        'password' => $request->register_password,
                        'confirm_password' => $request->confirm_password,
                        'status_id' => $status->data->id,
                        'role_id' => $admin_role->data->id
                    ];
                    // Register user API
                    $user = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $user_inputs);

                    if ($user->success) {
                        // Authentication datas (E-mail or Phone number)
                        $auth_phone = Auth::attempt(['phone' => $user->data->user->phone, 'password' => $user_inputs['password']]);
                        $auth_email = Auth::attempt(['email' => $user->data->user->email, 'password' => $user_inputs['password']]);

                        if ($auth_phone || $auth_email) {
                            $request->session()->regenerate();

                            return redirect()->route('home');
                        }

                    } else {
                        $resp_error = $user_inputs['firstname']                     // array[0]
                                        . '-' . $user_inputs['lastname']            // array[1]
                                        . '-' . $user_inputs['surname']             // array[2]
                                        . '-' . $user_inputs['phone']               // array[3]
                                        . '-' . $user_inputs['email']               // array[4]
                                        . '-' . $user_inputs['password']            // array[5]
                                        . '-' . $user_inputs['confirm_password']    // array[6]
                                        . '-' . $user->message                      // array[7]
                                        . '-' . $user->data;                        // array[8]

                        return redirect('/register')->with('response_error', $resp_error);
                    }    
                }
            }

        } else {
            // Role inputs
            $role_inputs = [
                'role_name' => 'Administrateur',
                'role_description' => 'Gestion de données qui permettent le fonctionnement de l\'application.',
                'icon' => 'bi bi-person-gear',
                'color' => 'warning'
            ];
            $role = $this::$api_client_manager::call('POST', getApiURL() . '/role', getApiToken(), $role_inputs);
            // Find status by name API
            $status_data = 'Actif';
            $active_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/' . $status_data, getApiToken());

            if ($active_status->success) {
                // User inputs
                $user_inputs = [
                    'firstname' => $request->register_firstname,
                    'lastname' => $request->register_lastname,
                    'surname' => $request->register_surname,
                    'phone' => $request->register_phone,
                    'email' => $request->register_email,
                    'password' => $request->register_password,
                    'confirm_password' => $request->confirm_password,
                    'status_id' => $active_status->data->id,
                    'role_id' => $role->data->id
                ];
                // Register user API
                $user = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $user_inputs);

                if ($user->success) {
                    // Authentication datas (E-mail or Phone number)
                    $auth_phone = Auth::attempt(['phone' => $user->data->user->phone, 'password' => $user_inputs['password']]);
                    $auth_email = Auth::attempt(['email' => $user->data->user->email, 'password' => $user_inputs['password']]);

                    if ($auth_phone || $auth_email) {
                        $request->session()->regenerate();

                        return redirect()->route('home');
                    }

                } else {
                    $resp_error = $user_inputs['firstname']                     // array[0]
                                    . '-' . $user_inputs['lastname']            // array[1]
                                    . '-' . $user_inputs['surname']             // array[2]
                                    . '-' . $user_inputs['phone']               // array[3]
                                    . '-' . $user_inputs['email']               // array[4]
                                    . '-' . $user_inputs['password']            // array[5]
                                    . '-' . $user_inputs['confirm_password']    // array[6]
                                    . '-' . $user->message                      // array[7]
                                    . '-' . $user->data;                        // array[8]

                    return redirect('/register')->with('response_error', $resp_error);
                }    

            } else {
                // Group by name API
                $group_data = 'Fonctionnement';
                $functioning_group = $this::$api_client_manager::call('GET', getApiURL() . '/group/search/' . $group_data, getApiToken());

                if ($functioning_group->success) {
                    // Status inputs
                    $status_inputs = [
                        'status_name' => 'Actif',
                        'status_description' => 'Fonctionnement normal pour l\'utilisateur et travail quotidien pour l\'employé.',
                        'icon' => 'bi bi-check-circle',
                        'color' => 'success',
                        'group_id' => $functioning_group->data->id
                    ];
                    $status = $this::$api_client_manager::call('POST', getApiURL() . '/status', getApiToken(), $status_inputs);
                    // User inputs
                    $user_inputs = [
                        'firstname' => $request->register_firstname,
                        'lastname' => $request->register_lastname,
                        'surname' => $request->register_surname,
                        'phone' => $request->register_phone,
                        'email' => $request->register_email,
                        'password' => $request->register_password,
                        'confirm_password' => $request->confirm_password,
                        'status_id' => $status->data->id,
                        'role_id' => $role->data->id
                    ];
                    // Register user API
                    $user = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $user_inputs);

                    if ($user->success) {
                        // Authentication datas (E-mail or Phone number)
                        $auth_phone = Auth::attempt(['phone' => $user->data->user->phone, 'password' => $user_inputs['password']]);
                        $auth_email = Auth::attempt(['email' => $user->data->user->email, 'password' => $user_inputs['password']]);

                        if ($auth_phone || $auth_email) {
                            $request->session()->regenerate();

                            return redirect()->route('home');
                        }

                    } else {
                        $resp_error = $user_inputs['firstname']                     // array[0]
                                        . '-' . $user_inputs['lastname']            // array[1]
                                        . '-' . $user_inputs['surname']             // array[2]
                                        . '-' . $user_inputs['phone']               // array[3]
                                        . '-' . $user_inputs['email']               // array[4]
                                        . '-' . $user_inputs['password']            // array[5]
                                        . '-' . $user_inputs['confirm_password']    // array[6]
                                        . '-' . $user->message                      // array[7]
                                        . '-' . $user->data;                        // array[8]

                        return redirect('/register')->with('response_error', $resp_error);
                    }    

                } else {
                    // Group inputs
                    $group_inputs = [
                        'group_name' => 'Fonctionnement',
                        'group_description' => 'Grouper les états permettant de gérer le fonctionnement des utilisateurs et autres dans l\'application.'
                    ];
                    $group = $this::$api_client_manager::call('POST', getApiURL() . '/group', getApiToken(), $group_inputs);
                    // Status inputs
                    $status_inputs = [
                        'status_name' => 'Actif',
                        'status_description' => 'Fonctionnement normal pour l\'utilisateur et travail quotidien pour l\'employé.',
                        'icon' => 'bi bi-check-circle',
                        'color' => 'success',
                        'group_id' => $group->data->id
                    ];
                    $status = $this::$api_client_manager::call('POST', getApiURL() . '/status', getApiToken(), $status_inputs);
                    // User inputs
                    $user_inputs = [
                        'firstname' => $request->register_firstname,
                        'lastname' => $request->register_lastname,
                        'surname' => $request->register_surname,
                        'phone' => $request->register_phone,
                        'email' => $request->register_email,
                        'password' => $request->register_password,
                        'confirm_password' => $request->confirm_password,
                        'status_id' => $status->data->id,
                        'role_id' => $role->data->id
                    ];
                    // Register user API
                    $user = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $user_inputs);

                    if ($user->success) {
                        // Authentication datas (E-mail or Phone number)
                        $auth_phone = Auth::attempt(['phone' => $user->data->user->phone, 'password' => $user_inputs['password']]);
                        $auth_email = Auth::attempt(['email' => $user->data->user->email, 'password' => $user_inputs['password']]);

                        if ($auth_phone || $auth_email) {
                            $request->session()->regenerate();

                            return redirect()->route('home');
                        }

                    } else {
                        $resp_error = $user_inputs['firstname']                     // array[0]
                                        . '-' . $user_inputs['lastname']            // array[1]
                                        . '-' . $user_inputs['surname']             // array[2]
                                        . '-' . $user_inputs['phone']               // array[3]
                                        . '-' . $user_inputs['email']               // array[4]
                                        . '-' . $user_inputs['password']            // array[5]
                                        . '-' . $user_inputs['confirm_password']    // array[6]
                                        . '-' . $user->message                      // array[7]
                                        . '-' . $user->data;                        // array[8]

                        return redirect('/register')->with('response_error', $resp_error);
                    }    
                }
            }
        }
    }
}
