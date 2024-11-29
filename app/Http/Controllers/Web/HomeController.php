<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;
use Carbon\Carbon;

/**
 * @author Xanders
 * @see https://www.xsam-tech.com
 */
class HomeController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();

        $this->middleware('auth')->except(['changeLanguage', 'symlink', 'about']);
    }

    // ==================================== HTTP GET METHODS ====================================
    /**
     * GET: Change language
     *
     * @param  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }

    /**
     * GET: Generate symbolic link for images
     *
     * @return \Illuminate\View\View
     */
    public function symlink()
    {
        return view('symlink');
    }

    /**
     * GET: Search something
     *
     * @param  Illuminate\Http\Request $request
     * @param  string $entity
     * @param  string $data
     * @return \Illuminate\View\View
     */
    public function search(Request $request, $entity)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        /*
            Check type and/or group to ensure that search history are registered
        */
        // Find type by name
        $search_history_type_name = 'Historique de recherche';
        $search_history_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/' . $search_history_type_name, getApiToken());

        if ($search_history_type->success == false) {
            // Find group by name
            $history_type_group_name = 'Type d\'historique';
            $history_type_group = $this::$api_client_manager::call('GET', getApiURL() . '/group/search/' . $history_type_group_name, getApiToken());

            if ($history_type_group->success) {
                $this::$api_client_manager::call('POST', getApiURL() . '/type', getApiToken(), [
                    'type_name' => 'Historique de recherche',
                    'type_description' => 'Historique des données recherchées par un utilisateur.',
                    'icon' => 'bi bi-search',
                    'group_id' => $history_type_group->data->id,
                ]);

            } else {
                $group = $this::$api_client_manager::call('POST', getApiURL() . '/group', getApiToken(), [
                    'group_name' => 'Type d\'historique',
                    'group_description' => 'Grouper les types permettant de gérer les historiques des utilisateurs de l\'application.',
                ]);

                $this::$api_client_manager::call('POST', getApiURL() . '/type', getApiToken(), [
                    'type_name' => 'Historique de recherche',
                    'type_description' => 'Historique des données recherchées par un utilisateur.',
                    'icon' => 'bi bi-search',
                    'group_id' => $group->data->id,
                ]);
            }
        }

        /*
            Start search
        */
        // Search an entity
        if ($entity == 'all') {
            $admins = $this::$api_client_manager::call('GET', getApiURL() . '/user/search/' . $request->get('query') . '/' . Auth::user()->id . '/Administrateur/ANONYMOUS', getApiToken());
            $managers = $this::$api_client_manager::call('GET', getApiURL() . '/user/search/' . $request->get('query') . '/' . Auth::user()->id . '/Manager/ANONYMOUS', getApiToken());
            $employees = $this::$api_client_manager::call('GET', getApiURL() . '/user/search/' . $request->get('query') . '/' . Auth::user()->id . '/Employé/' . (!empty($request->branch_id) ? $request->branch_id : 'ANONYMOUS'), getApiToken());
            $provinces = $this::$api_client_manager::call('GET', getApiURL() . '/province/search/' . $request->get('query') . '/' . Auth::user()->id, getApiToken());
            $cities = $this::$api_client_manager::call('GET', getApiURL() . '/city/search/' . $request->get('query') . '/' . Auth::user()->id, getApiToken());
            $branches = $this::$api_client_manager::call('GET', getApiURL() . '/branch/search/' . $request->get('query') . '/' . Auth::user()->id, getApiToken());
            $tasks = $this::$api_client_manager::call('GET', getApiURL() . '/task/search/' . $request->get('query') . '/' . Auth::user()->id, getApiToken());

            if ($user->success == false OR $notification->success == false OR $admins->success == false OR $managers->success == false OR $employees->success == false OR $provinces->success == false OR $cities->success == false OR $branches->success == false OR $tasks->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('search', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'admins' => $admins->data,
                        'managers' => $managers->data,
                        'employees' => $employees->data,
                        'provinces' => $provinces->data,
                        'cities' => $cities->data,
                        'branches' => $branches->data,
                        'tasks' => $tasks->data,
                        'entity' => $entity,
                        'data' => $request->get('query')
                    ]);
                }
            }
        }

        if ($entity == 'admins') {
            $entity_result = $this::$api_client_manager::call('GET', getApiURL() . '/user/search/' . $request->get('query') . '/' . Auth::user()->id . '/Administrateur/ANONYMOUS', getApiToken());

            if ($user->success == false OR $notification->success == false OR $entity_result->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('search', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'results_list' => $entity_result->data,
                        'entity' => $entity,
                        'data' => $request->get('query')
                    ]);
                }
            }
        }

        if ($entity == 'managers') {
            $entity_result = $this::$api_client_manager::call('GET', getApiURL() . '/user/search/' . $request->get('query') . '/' . Auth::user()->id . '/Manager/ANONYMOUS', getApiToken());

            if ($user->success == false OR $notification->success == false OR $entity_result->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('search', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'results_list' => $entity_result->data,
                        'entity' => $entity,
                        'data' => $request->get('query')
                    ]);
                }
            }
        }

        if ($entity == 'employees') {
            $entity_result = $this::$api_client_manager::call('GET', getApiURL() . '/user/search/' . $request->get('query') . '/' . Auth::user()->id . '/Employé/' . $request->branch_id, getApiToken());

            if ($user->success == false OR $notification->success == false OR $entity_result->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('search', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'results_list' => $entity_result->data,
                        'entity' => $entity,
                        'data' => $request->get('query')
                    ]);
                }
            }
        }

        if ($entity == 'message') {
            $entity_result = $this::$api_client_manager::call('GET', getApiURL() . '/message/search/' . $request->get('query') . '/' . Auth::user()->id . '/' . $request->type_name, getApiToken());

            if ($user->success == false OR $notification->success == false OR $entity_result->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('search', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'results_list' => $entity_result->data,
                        'entity' => $entity,
                        'data' => $request->get('query')
                    ]);
                }
            }
        }

        if ($entity != 'all' AND $entity != 'admins' AND $entity != 'managers' AND $entity != 'employees' AND $entity != 'message') {
            $entity_result = $this::$api_client_manager::call('GET', getApiURL() . '/' . $entity . '/search/' . $request->get('query') . '/' . Auth::user()->id, getApiToken());

            if ($user->success == false OR $notification->success == false OR $entity_result->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('search', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'results_list' => $entity_result->data,
                        'entity' => $entity,
                        'data' => $request->get('query')
                    ]);
                }
            }
        }
    }

    /**
     * GET: Delete something
     *
     * @param  string $entity
     * @param  int  $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function delete($entity, $id)
    {
        // Current authenticated user
        $entity_request = $this::$api_client_manager::call('DELETE', getApiURL() . '/' . $entity . '/' . $id, getApiToken());

        if ($entity_request->success) {
            return Redirect::back()->with('success_message', __('notifications.deleted_data'));

        } else {
            return Redirect::back()->with('error_message', $entity_request->data);
        }
    }

    /**
     * GET: Home page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // Find type by name
        $ordinary_message_type_name = 'Message ordinaire';
        $ordinary_message_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/' . $ordinary_message_type_name, getApiToken());
        // Find status by name
        $read_status_name = 'Lue';
        $read_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/' . $read_status_name, getApiToken());

        if ($ordinary_message_type->success == false) {
            // Find group by name
            $message_type_group_name = 'Type de message';
            $message_type_group = $this::$api_client_manager::call('GET', getApiURL() . '/group/search/' . $message_type_group_name, getApiToken());

            if ($message_type_group->success) {
                $this::$api_client_manager::call('POST', getApiURL() . '/type', getApiToken(), [
                    'type_name' => 'Message ordinaire',
                    'type_description' => 'Echange entre utilisateurs.',
                    'icon' => 'bi bi-chat-quote',
                    'group_id' => $message_type_group->data->id
                ]);

            } else {
                $group = $this::$api_client_manager::call('POST', getApiURL() . '/group', getApiToken(), [
                    'group_name' => 'Type de message',
                    'group_description' => 'Grouper les types permettant de gérer les messages échangés entre utilisateurs de l\'application.'
                ]);

                $this::$api_client_manager::call('POST', getApiURL() . '/type', getApiToken(), [
                    'type_name' => 'Message ordinaire',
                    'type_description' => 'Echange entre utilisateurs.',
                    'icon' => 'bi bi-chat-quote',
                    'group_id' => $group->data->id
                ]);
            }
        }

        if ($read_status->success == false) {
            // Find group by name
            $notification_status_group_name = 'Etat de la notification';
            $notification_status_group = $this::$api_client_manager::call('GET', getApiURL() . '/group/search/' . $notification_status_group_name, getApiToken());

            if ($notification_status_group->success) {
                $this::$api_client_manager::call('POST', getApiURL() . '/status', getApiToken(), [
                    'status_name' => 'Non lue',
                    'status_description' => 'Notification envoyée mais pas encore lue par le destinataire.',
                    'icon' => 'bi bi-circle-fill',
                    'group_id' => $notification_status_group->data->id
                ]);
                $this::$api_client_manager::call('POST', getApiURL() . '/status', getApiToken(), [
                    'status_name' => 'Lue',
                    'status_description' => 'Notification lue par le destinataire.',
                    'icon' => 'bi bi-circle',
                    'group_id' => $notification_status_group->data->id
                ]);

            } else {
                $group = $this::$api_client_manager::call('POST', getApiURL() . '/group', getApiToken(), [
                    'group_name' => 'Etat de la notification',
                    'group_description' => 'Grouper les états permettant de gérer la lecture des notifications.'
                ]);

                $this::$api_client_manager::call('POST', getApiURL() . '/status', getApiToken(), [
                    'status_name' => 'Non lue',
                    'status_description' => 'Notification envoyée mais pas encore lue par le destinataire.',
                    'icon' => 'bi bi-circle-fill',
                    'group_id' => $group->data->id
                ]);
                $this::$api_client_manager::call('POST', getApiURL() . '/status', getApiToken(), [
                    'status_name' => 'Lue',
                    'status_description' => 'Notification lue par le destinataire.',
                    'icon' => 'bi bi-circle',
                    'group_id' => $group->data->id
                ]);
            }
        }

        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Find user by role
        $admin_role_name = 'Administrateur';
        $manager_role_name = 'Manager';
        $admins = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_role/'. $admin_role_name, getApiToken());
        $managers = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_role/'. $manager_role_name, getApiToken());
        $groups = $this::$api_client_manager::call('GET', getApiURL() . '/group', getApiToken());
        $departments = $this::$api_client_manager::call('GET', getApiURL() . '/department', getApiToken());
        $branches = $this::$api_client_manager::call('GET', getApiURL() . '/branch', getApiToken());

        if ($user->success == false OR $notification->success == false OR $admins->success == false OR $managers->success == false OR $groups->success == false OR $departments->success == false OR $branches->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                if (inArrayR('Administrateur', $user->data->roles, 'role_name')) {
                    return view('dashboard', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'admins' => $admins->data,
                        'managers' => $managers->data,
                        'groups' => $groups->data,
                        'branches' => $branches->data,
                        'departments' => $departments->data
                    ]);
                }

                if (inArrayR('Manager', $user->data->roles, 'role_name')) {
                    // Select all employees of the current user branch
                    $employee_role_name = 'Employé';
                    $all_employees = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_branch_role_status/' . $user->data->branches[0]->id . '/' . $employee_role_name . '/Actif', getApiToken());
                    // Find status by name
                    $operational_status_name = 'Opérationnel';
                    $operational_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/' . $operational_status_name, getApiToken());

                    if ($operational_status->success == false) {
                        abort(500);

                    } else {
                        // Select all vacations of this year
                        $this_year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . date('Y'), getApiToken());
                        // Select all employees present/absent today
                        $employees_present_absent_today = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $user->data->branches[0]->id . '/' . Carbon::today()->toDateString(), getApiToken());
                        $employees_present_today = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_is_present_date/' . $user->data->branches[0]->id . '/1/' . $operational_status->data->id . '/' . Carbon::today()->toDateString(), getApiToken());
                        $employees_absent_today = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_is_present_date/' . $user->data->branches[0]->id . '/0/' . $operational_status->data->id . '/' . Carbon::today()->toDateString(), getApiToken());
                        // Select all paid/unpaid employees this month
                        $current_paid_unpaid = $this::$api_client_manager::call('GET', getApiURL() . '/paid_unpaid/find_by_branch_month_year/' . $user->data->branches[0]->id . '/' . date('m-Y'));

                        if ($all_employees->success == false OR $this_year_vacations->success == false OR $employees_present_absent_today->success == false OR $employees_present_today->success == false OR $employees_absent_today->success == false OR $current_paid_unpaid->success == false) {
                            abort(500);

                        } else {
                            return view('dashboard', [
                                'current_user' => $user->data,
                                'ordinary_chats' => $message->data,
                                'unread_notifications' => $notification->data,
                                'all_employees' => $all_employees->data,
                                'this_year_vacations' => $this_year_vacations->data,
                                'employees_present_absent_today' => $employees_present_absent_today->data,
                                'employees_present_today' => $employees_present_today->data,
                                'employees_absent_today' => $employees_absent_today->data,
                                'current_paid_unpaid' => $current_paid_unpaid->data
                            ]);
                        }
                    }
                }

                if (inArrayR('Employé', $user->data->roles, 'role_name')) {
                    return view('dashboard', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                    ]);
                }

            }
        }
    }

    /**
     * GET: About page
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());

        if ($user->success == false OR $notification->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('about', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data
                ]);
            }
        }
    }

    /**
     * GET: Account page
     *
     * @return \Illuminate\View\View
     */
    public function account()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/' . Auth::user()->id, getApiToken());
        // All departments
        $departments = $this::$api_client_manager::call('GET', getApiURL() . '/department', getApiToken());

        if ($user->success == false OR $notification->success == false OR $departments->success == false) {
            abort(500);

        } else {
            if ($user->data->number != null) {
                // QR code
                $qr_code = Builder::create()->writer(new PngWriter())->writerOptions([])->data($user->data->number)
                                            ->encoding(new Encoding('UTF-8'))->errorCorrectionLevel(ErrorCorrectionLevel::High)
                                            ->size(300)->margin(10)->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                                            ->logoPath(asset('assets/img/logo-qrcode.png'))->logoResizeToWidth(50)->logoPunchoutBackground(true)
                                            ->labelText(__('miscellaneous.pages_content.account.personal_infos.qr_code'))
                                            ->labelFont(new NotoSans(14))->labelAlignment(LabelAlignment::Center)->validateResult(false)->build();

                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/' . $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('account', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'departments' => $departments->data,
                        'qr_code' => $qr_code->getDataUri()
                    ]);
                }

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('account', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'departments' => $departments->data,
                        'qr_code' => null
                    ]);
                }
            }
        }
    }

    /**
     * GET: Notification page
     *
     * @return \Illuminate\View\View
     */
    public function notification()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        $notifications = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_by_user/'. Auth::user()->id, getApiToken());

        if ($user->success == false OR $notification->success == false OR $notifications->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('notification', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'all_notifications' => $notifications->data
                ]);
            }
        }
    }

    /**
     * GET: Notification page
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Search type by name
        $activities_history_type_name = 'Historique des activités';
        $activities_history_type = $this::$api_client_manager::call('GET', getApiURL() . '/type/search/'. $activities_history_type_name, getApiToken());

        if ($user->success == false OR $notification->success == false OR $activities_history_type->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());
            // Find user activities history
            $history = $this::$api_client_manager::call('GET', getApiURL() . '/history/select_by_type/'. Auth::user()->id . '/'. $activities_history_type->data->id, getApiToken());

            if ($message->success == false OR $history->success == false) {
                abort(500);

            } else {
                return view('history', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'activities_history' => $history->data
                ]);
            }
        }
    }

    // ==================================== HTTP POST METHODS ====================================
    /**
     * POST: Update a account
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateAccount(Request $request)
    {
        // User inputs
        $inputs = [
            'id' => $request->user_id,
            'number' => $request->register_number,
            'firstname' => $request->register_firstname,
            'lastname' => $request->register_lastname,
            'surname' => $request->register_surname,
            'gender' => $request->register_gender,
            'birth_city' => $request->register_birth_city,
            'birth_date' => !empty($request->register_birth_date) ? explode('/', $request->register_birth_date)[2] . '-' . explode('/', $request->register_birth_date)[1] . '-' . explode('/', $request->register_birth_date)[0] : null,
            'address_1' => $request->register_address_1,
            'address_2' => $request->register_address_2,
            'p_o_box' => $request->register_p_o_box,
            'phone' => $request->register_phone,
            'email' => $request->register_email,
            'username' => $request->register_username,
            'office' => $request->register_office,
            'department_id' => $request->department_id,
            'account_owner_id' => $request->user_id
        ];
        $user = $this::$api_client_manager::call('PUT', getApiURL() . '/user/' . $inputs['id'], getApiToken(), $inputs);

        if ($user->success) {
            return Redirect::back()->with('success_message', __('notifications.updated_data'));

        } else {
            $resp_error = 'account-tabs-2_' . $inputs['number'] . '~' . $inputs['firstname'] . '~' . $inputs['lastname'] . '~' . $inputs['surname'] . '~' . $inputs['birth_city'] . '~' . $request->register_birth_date . '~' . $inputs['address_1'] . '~' . $inputs['address_2'] . '~' . $inputs['p_o_box'] . '~' . $inputs['phone'] . '~' . $inputs['email'] . '~' . $inputs['username'] . '~' . $user->message . '~' . $user->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Update password
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updatePassword(Request $request)
    {
        // User inputs
        $inputs = [
            'id' => $request->user_id,
            'former_password' => $request->register_former_password,
            'new_password' => $request->register_new_password,
            'confirm_new_password' => $request->register_confirm_new_password
        ];
        $user = $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_password/' . $inputs['id'] . '/' . $inputs['id'], getApiToken(), $inputs);

        if ($user->success) {
            return Redirect::back()->with('success_message', __('notifications.updated_data'));

        } else {
            $resp_error = 'account-tabs-3~' . $inputs['former_password'] . '~' . $inputs['new_password'] . '~' . $inputs['confirm_new_password'] . '~' . $user->message . '~' . $user->data;

            return Redirect::back()->with('response_pw_error', $resp_error);
        }
    }

}
