<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use App\Http\Controllers\ApiClientManager;

class ManagerController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();

        $this->middleware('auth');
    }

    // ==================================== HTTP GET METHODS ====================================
    /**
     * GET: Employees list page
     *
     * @return \Illuminate\View\View
     */
    public function employee()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // All departments
        $departments = $this::$api_client_manager::call('GET', getApiURL() . '/department', getApiToken());

        // Find user ordinary message
        $ordinary_message_name = 'Message ordinaire';
        $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

        // Select all vacations of this year
        $this_year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . date('Y'), getApiToken());
        // Select all employees of the current user branch
        $employees_presence_payment = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $user->data->branches[0]->id . '/' . Carbon::today()->toDateString(), getApiToken());

        return view('employee', [
            'current_user' => $user->data,
            'ordinary_chats' => $message->data,
            'unread_notifications' => $notification->data,
            'departments' => $departments->data,
            'this_year_vacations' => $this_year_vacations->data,
            'all_employees' => $employees_presence_payment->data
        ]);
    }

    /**
     * GET: Employee details page
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function employeeDatas($id)
    {
        $months = [
            '01' => __('miscellaneous.month.complete.january'),
            '02' => __('miscellaneous.month.complete.february'),
            '03' => __('miscellaneous.month.complete.march'),
            '04' => __('miscellaneous.month.complete.april'),
            '05' => __('miscellaneous.month.complete.may'),
            '06' => __('miscellaneous.month.complete.june'),
            '07' => __('miscellaneous.month.complete.july'),
            '08' => __('miscellaneous.month.complete.august'),
            '09' => __('miscellaneous.month.complete.september'),
            '10' => __('miscellaneous.month.complete.october'),
            '11' => __('miscellaneous.month.complete.november'),
            '12' => __('miscellaneous.month.complete.december')
        ];
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // All departments
        $departments = $this::$api_client_manager::call('GET', getApiURL() . '/department', getApiToken());
        // Find status by group
        $employee_status_group_name = 'Etat de l\'employé';
        $employee_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/find_by_group/' . $employee_status_group_name, getApiToken());

        // Find user ordinary message
        $ordinary_message_name = 'Message ordinaire';
        $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

        // Select all vacations of this year
        $this_year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . date('Y'), getApiToken());
        // Select employee presences of current month
        $presences_month_year = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_user_month_year/' . $id . '/' . date('m-Y'), getApiToken());
        // Select employee presence/payment
        $employee = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_user_date/' . $id . '/' . Carbon::today()->toDateString(), getApiToken());

        if ($employee->data->user->number != null) {
            // QR code
            $qr_code = Builder::create()->writer(new PngWriter())->writerOptions([])->data($employee->data->user->number)
                                        ->encoding(new Encoding('UTF-8'))->errorCorrectionLevel(ErrorCorrectionLevel::High)
                                        ->size(300)->margin(10)->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                                        ->logoPath(asset('assets/img/logo-qrcode.png'))->logoResizeToWidth(50)->logoPunchoutBackground(true)
                                        ->labelText(__('miscellaneous.pages_content.manager.home.employees.qr_code'))
                                        ->labelFont(new NotoSans(14))->labelAlignment(LabelAlignment::Center)->validateResult(false)->build();

            return view('employee', [
                'current_user' => $user->data,
                'ordinary_chats' => $message->data,
                'unread_notifications' => $notification->data,
                'months' => $months,
                'departments' => $departments->data,
                'employee_statuses' => $employee_status->data,
                'qr_code' => $qr_code->getDataUri(),
                'this_year_vacations' => $this_year_vacations->data,
                'presences_month_year' => $presences_month_year->data,
                'employee' => $employee->data
            ]);

        } else {
            return view('employee', [
                'current_user' => $user->data,
                'ordinary_chats' => $message->data,
                'unread_notifications' => $notification->data,
                'months' => $months,
                'departments' => $departments->data,
                'employee_statuses' => $employee_status->data,
                'qr_code' => null,
                'this_year_vacations' => $this_year_vacations->data,
                'presences_month_year' => $presences_month_year->data,
                'employee' => $employee->data
            ]);
        }
    }

    /**
     * GET: Employees list page
     *
     * @param  string $entity
     * @return \Illuminate\View\View
     */
    public function employeeEntity($entity)
    {
        $months = [
            '01' => __('miscellaneous.month.complete.january'),
            '02' => __('miscellaneous.month.complete.february'),
            '03' => __('miscellaneous.month.complete.march'),
            '04' => __('miscellaneous.month.complete.april'),
            '05' => __('miscellaneous.month.complete.may'),
            '06' => __('miscellaneous.month.complete.june'),
            '07' => __('miscellaneous.month.complete.july'),
            '08' => __('miscellaneous.month.complete.august'),
            '09' => __('miscellaneous.month.complete.september'),
            '10' => __('miscellaneous.month.complete.october'),
            '11' => __('miscellaneous.month.complete.november'),
            '12' => __('miscellaneous.month.complete.december')
        ];
        $days = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
        $active_status_name = 'Actif';
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Find user ordinary message
        $ordinary_message_name = 'Message ordinaire';
        $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

        if ($entity == 'paid_unpaid') {
            if (request()->has('month')) {
                if (request()->has('year')) {
                    // Select all paid/unpaid employees this year
                    $paid_unpaids = $this::$api_client_manager::call('GET', getApiURL() . '/paid_unpaid/find_by_branch_month_year_status/' . $user->data->branches[0]->id . '/' . request()->get('month') . '-' . request()->get('year') . '/' . $active_status_name);

                    return view('employee', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'months' => $months,
                        'paid_unpaids' => $paid_unpaids->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.pages_content.manager.home.employees.remuneration.payments_month_year', ['month' => explicitMonth(request()->get('month')), 'year' => request()->get('year')]),
                    ]);

                } else {
                    // Select all paid/unpaid employees this year
                    $paid_unpaids = $this::$api_client_manager::call('GET', getApiURL() . '/paid_unpaid/find_by_branch_month_year_status/' . $user->data->branches[0]->id . '/' . request()->get('month') . '-' . date('Y') . '/' . $active_status_name);

                    return view('employee', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'months' => $months,
                        'paid_unpaids' => $paid_unpaids->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.pages_content.manager.home.employees.remuneration.payments_month', ['month' => explicitMonth(request()->get('month'))]),
                    ]);
                }

            } else if (request()->has('year')) {
                // Select all paid/unpaid employees this year
                $all_months_paid_unpaids = $this::$api_client_manager::call('GET', getApiURL() . '/paid_unpaid/find_by_branch_year_status/' . $user->data->branches[0]->id . '/' . request()->get('year') . '/' . $active_status_name);

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'all_months_paid_unpaids' => $all_months_paid_unpaids->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.remuneration.payments_year', ['year' => request()->get('year')]),
                ]);

            } else {
                // Select all paid/unpaid employees this month/year
                $paid_unpaids = $this::$api_client_manager::call('GET', getApiURL() . '/paid_unpaid/find_by_branch_month_year_status/' . $user->data->branches[0]->id . '/' . date('m-Y') . '/' . $active_status_name);

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'paid_unpaids' => $paid_unpaids->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.remuneration.recent'),
                ]);
            }
        }

        if ($entity == 'presence_absence') {
            if (request()->has('day') && request()->has('month') && request()->has('year')) {
                // Select all employees present/absent at this date
                $employees_present_absent = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $user->data->branches[0]->id . '/' . request()->get('year') . '-' . request()->get('month') . '-' . request()->get('day'), getApiToken());
                // Select all vacations of the year
                $year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . request()->get('year'), getApiToken());

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'days' => $days,
                    'employees_present_absent' => $employees_present_absent->data,
                    'year_vacations' => $year_vacations->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.presences_absences.presences_date', ['date' => explicitDate(request()->get('year') . '-' . request()->get('month') . '-' . request()->get('day'))])
                ]);

            } else if (!request()->has('day') && request()->has('month') && request()->has('year')) {
                // Select all employees present/absent at this date
                $employees_present_absent = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_month_year/' . $user->data->branches[0]->id . '/' . request()->get('month') . '-' . request()->get('year'), getApiToken());
                // Select all vacations of the year
                $year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . request()->get('year'), getApiToken());

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'days' => $days,
                    'employees_present_absent' => $employees_present_absent->data,
                    'year_vacations' => $year_vacations->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.presences_absences.presences_month_year', ['month' => explicitMonth(request()->get('month')), 'year' => request()->get('year')])
                ]);

            } else if (request()->has('day') && !request()->has('month') && request()->has('year')) {
                // Select all employees present/absent at this date
                $employees_present_absent = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $user->data->branches[0]->id . '/' . request()->get('year') . '-' . date('m') . '-' . request()->get('day') , getApiToken());
                // Select all vacations of the year
                $year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . request()->get('year'), getApiToken());

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'days' => $days,
                    'employees_present_absent' => $employees_present_absent->data,
                    'year_vacations' => $year_vacations->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.presences_absences.presences_date', ['date' => explicitDate(request()->get('year') . '-' . date('m') . '-' . request()->get('day'))])
                ]);

            } else if (request()->has('day') && request()->has('month') && !request()->has('year')) {
                // Select all employees present/absent at this date
                $employees_present_absent = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $user->data->branches[0]->id . '/' . date('Y') . '-' . request()->get('month') . '-' . request()->get('day') , getApiToken());
                // Select all vacations of the year
                $year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . date('Y'), getApiToken());

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'days' => $days,
                    'employees_present_absent' => $employees_present_absent->data,
                    'year_vacations' => $year_vacations->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.presences_absences.presences_date', ['date' => explicitDate(date('Y') . '-' . request()->get('month') . '-' . request()->get('day'))])
                ]);

            } else if (request()->has('day') && !request()->has('month') && !request()->has('year')) {
                // Select all employees present/absent at this date
                $employees_present_absent = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $user->data->branches[0]->id . '/' . date('Y') . '-' . date('m') . '-' . request()->get('day'), getApiToken());
                // Select all vacations of the year
                $year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . date('Y'), getApiToken());

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'days' => $days,
                    'employees_present_absent' => $employees_present_absent->data,
                    'year_vacations' => $year_vacations->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.presences_absences.presences_date', ['date' => explicitDate(date('Y') . '-' . date('m') . '-' . request()->get('day'))])
                ]);

            } else if (!request()->has('day') && request()->has('month') && !request()->has('year')) {
                // Select all employees present/absent at this date
                $employees_present_absent = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_month_year/' . $user->data->branches[0]->id . '/' . request()->get('month') . '-' . date('Y'), getApiToken());
                // Select all vacations of the year
                $year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . date('Y'), getApiToken());

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'days' => $days,
                    'employees_present_absent' => $employees_present_absent->data,
                    'year_vacations' => $year_vacations->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.presences_absences.presences_month_year', ['month' => explicitMonth(request()->get('month')), 'year' => date('Y')])
                ]);

            } else if (!request()->has('day') && !request()->has('month') && request()->has('year')) {
                // Select all employees present/absent of this year
                $employees_present_absent_year = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_year/' . $user->data->branches[0]->id . '/' . request()->get('year'), getApiToken());
                // Select all vacations of the year
                $year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . request()->get('year'), getApiToken());

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'days' => $days,
                    'employees_present_absent_year' => $employees_present_absent_year->data,
                    'year_vacations' => $year_vacations->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.presences_absences.presences_year', ['year' => request()->get('year')])
                ]);

            } else {
                // Select all vacations of this year
                $this_year_vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/find_by_year/' . date('Y'), getApiToken());
                // Select all employees present/absent today
                $employees_present_absent_today = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $user->data->branches[0]->id . '/' . Carbon::today()->toDateString(), getApiToken());

                return view('employee', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'months' => $months,
                    'days' => $days,
                    'this_year_vacations' => $this_year_vacations->data,
                    'employees_present_absent_today' => $employees_present_absent_today->data,
                    'entity' => $entity,
                    'entity_title' => __('miscellaneous.pages_content.manager.home.employees.presences_absences.recent')
                ]);
            }
        }
    }

    // ==================================== HTTP POST METHODS ====================================
    /**
     * POST: Add an employee
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeEmployee(Request $request)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // Find role by name
        $employee_role_name = 'Employé';
        $employee_role = $this::$api_client_manager::call('GET', getApiURL() . '/role/search/' . $employee_role_name, getApiToken());
        // Find status by name
        $active_status_name = 'Actif';
        $active_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/' . $active_status_name, getApiToken());

        // User inputs
        $inputs = [
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
            'password' => $request->register_password,
            'confirm_password' => $request->confirm_password,
            'office' => $request->register_office,
            'status_id' => $active_status->data->id,
            'department_id' => $request->department_id,
            'role_id' => $employee_role->data->id,
            'branch_id' => $user->data->branches[0]->id
        ];
        // Add an employee
        $employee = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $inputs);

        if ($employee->success) {
            // Udpate avatar
            if ($request->data_other_user != null) {
                $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_avatar_picture/' . $employee->data->user->id, getApiToken(), [
                    'user_id' => $employee->data->user->id,
                    'image_64' => $request->data_other_user
                ]);
            }

            // Register payment for current month
            $this::$api_client_manager::call('POST', getApiURL() . '/paid_unpaid', getApiToken(), [
                'month_year' => date('m-Y'),
                'user_id' => $employee->data->user->id
            ]);

            // Find status by name
            $operational_status_name = 'Opérationnel';
            $operational_status = $this::$api_client_manager::call('GET', getApiURL() . '/status/search/' . $operational_status_name, getApiToken());

            // Register presence for today
            $this::$api_client_manager::call('POST', getApiURL() . '/presence_absence', getApiToken(), [
                'daytime' => Carbon::today()->toDateString(),
                'status_id' => $operational_status->data->id,
                'user_id' => $employee->data->user->id
            ]);

            return Redirect::back()->with('success_message', __('notifications.registered_data'));

        } else {
            $resp_error = $inputs['number'] . '~' . $inputs['firstname'] . '~' . $inputs['lastname'] . '~' . $inputs['surname'] . '~' . $inputs['birth_city'] . '~' . $request->register_birth_date . '~' . $inputs['address_1'] . '~' . $inputs['address_2'] . '~' . $inputs['p_o_box'] . '~' . $inputs['phone'] . '~' . $inputs['email'] . '~' . $inputs['username'] . '~' . $inputs['password'] . '~' . $inputs['confirm_password'] . '~' . $employee->message . '~' . $employee->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Update an employee
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateEmployee(Request $request, $id)
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
            'password' => $request->register_password,
            'confirm_password' => $request->confirm_password,
            'office' => $request->register_office,
            'department_id' => $request->department_id
        ];
        // Update an employee
        $employee = $this::$api_client_manager::call('PUT', getApiURL() . '/user/' . $id, getApiToken(), $inputs);

        // Udpate avatar if it is changed
        if ($request->data_other_user != null) {
            $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_avatar_picture/' . $id, getApiToken(), [
                'user_id' => $inputs['id'],
                'image_64' => $request->data_other_user
            ]);
        }

        // Udpate department
        if ($inputs['department_id'] != null) {
            $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_department/' . $id . '/' . Auth::user()->id, getApiToken(), [
                'department_id' => $inputs['department_id']
            ]);
        }

        if ($employee->success) {
            return Redirect::to('/employee')->with('success_message', __('notifications.updated_data'));

        } else {
            $resp_error = $inputs['number'] . '~' . $inputs['firstname'] . '~' . $inputs['lastname'] . '~' . $inputs['surname'] . '~' . $inputs['birth_city'] . '~' . $request->register_birth_date . '~' . $inputs['address_1'] . '~' . $inputs['address_2'] . '~' . $inputs['p_o_box'] . '~' . $inputs['phone'] . '~' . $inputs['email'] . '~' . $inputs['username'] . '~' . $inputs['password'] . '~' . $inputs['confirm_password'] . '~' . $employee->message . '~' . $employee->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * GET: Tasks list page
     *
     * @return \Illuminate\View\View
     */
    public function tasks()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Find user ordinary message
        $ordinary_message_name = 'Message ordinaire';
        $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());
        // All departments
        $departments = $this::$api_client_manager::call('GET', getApiURL() . '/department', getApiToken());
        // Select all employees of the current user branch
        $employees_presence_payment = $this::$api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $user->data->branches[0]->id . '/' . Carbon::today()->toDateString(), getApiToken());

        return view('tasks', [
            'current_user' => $user->data,
            'ordinary_chats' => $message->data,
            'unread_notifications' => $notification->data,
            'departments' => $departments->data,
            'all_employees' => $employees_presence_payment->data
        ]);
    }
}
