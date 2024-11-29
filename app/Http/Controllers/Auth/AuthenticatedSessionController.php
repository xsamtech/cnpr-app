<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\ApiClientManager;

class AuthenticatedSessionController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        $data = 'Administrateur';
        $user_admins = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_role/' . $data, getApiToken());

        return view('auth.login', ['admins' => $user_admins->data]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        // Get inputs
        $inputs = [
            'username' => $request->username,
            'password' => $request->password
        ];
        // Login API
        $user = $this::$api_client_manager::call('POST', getApiURL() . '/user/login', getApiToken(), $inputs);

        if ($user->success) {
            if ($user->data->roles[0]->role_name != 'Administrateur') {
                if (!empty($user->data->branches)) {
                    // Authentication datas (E-mail or Phone number)
                    $auth_phone = Auth::attempt(['phone' => $user->data->phone, 'password' => $inputs['password']], $request->remember);
                    $auth_email = Auth::attempt(['email' => $user->data->email, 'password' => $inputs['password']], $request->remember);

                    if ($auth_phone || $auth_email) {
                        $request->session()->regenerate();

                        return redirect()->route('home');
                    }

                } else {
                    return redirect('/login')->with('error_message', __('auth.no_branch'));
                }

            } else {
                // Authentication datas (E-mail or Phone number)
                $auth_phone = Auth::attempt(['phone' => $user->data->phone, 'password' => $inputs['password']], $request->remember);
                $auth_email = Auth::attempt(['email' => $user->data->email, 'password' => $inputs['password']], $request->remember);

                if ($auth_phone || $auth_email) {
                    $request->session()->regenerate();

                    return redirect()->route('home');
                }
            }

        } else {
            $resp_error = $inputs['username'] . '-' . $inputs['password'] . '-' . $user->message . '-' . $user->data;

            return redirect('/login')->with('response_error', $resp_error);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
