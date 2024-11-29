<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiClientManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/**
 * @author Xanders
 * @see https://www.xsamtech.com
 */
class AdminController extends Controller
{
    public static $api_client_manager;

    public function __construct()
    {
        $this::$api_client_manager = new ApiClientManager();

        $this->middleware('auth');
    }

    // ==================================== HTTP GET METHODS ====================================
    /**
     * GET: Provinces list page
     *
     * @return \Illuminate\View\View
     */
    public function province()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all provinces
        $provinces = $this::$api_client_manager::call('GET', getApiURL() . '/province', getApiToken());

        if ($user->success == false OR $notification->success == false OR $provinces->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('province', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'provinces' => $provinces->data
                ]);
            }
        }
    }

    /**
     * GET: Province details page
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function provinceDatas($id)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select province by ID
        $province = $this::$api_client_manager::call('GET', getApiURL() . '/province/' . $id, getApiToken());

        if ($user->success == false OR $notification->success == false OR $province->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('province', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'province' => $province->data
                ]);
            }
        }
    }

    /**
     * GET: Provinces list page
     *
     * @param  string $entity
     * @return \Illuminate\View\View
     */
    public function provinceEntity($entity)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all provinces
        $provinces = $this::$api_client_manager::call('GET', getApiURL() . '/province', getApiToken());

        if ($entity == 'city') {
            // Select all cities
            $cities = $this::$api_client_manager::call('GET', getApiURL() . '/city', getApiToken());
    
            if ($user->success == false OR $notification->success == false OR $provinces->success == false OR $cities->success == false) {
                abort(500);
    
            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('province', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'provinces' => $provinces->data,
                        'cities' => $cities->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.province.city')
                    ]);
                }
            }
        }
    }

    /**
     * GET: Province details page
     *
     * @param  string $entity
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function provinceEntityDatas($entity, $id)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all provinces
        $provinces = $this::$api_client_manager::call('GET', getApiURL() . '/province', getApiToken());

        if ($entity == 'city') {
            // Select city by ID
            $city = $this::$api_client_manager::call('GET', getApiURL() . '/city/' . $id, getApiToken());

            if ($user->success == false OR $notification->success == false OR $provinces->success == false OR $city->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('province', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'provinces' => $provinces->data,
                        'city' => $city->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.province.city'),
                        'entity_details' => __('miscellaneous.pages_content.admin.province.city.details')
                    ]);
                }
            }
        }
    }

    /**
     * GET: Groups list page
     *
     * @return \Illuminate\View\View
     */
    public function group()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all groups
        $groups = $this::$api_client_manager::call('GET', getApiURL() . '/group', getApiToken());

        if ($user->success == false OR $notification->success == false OR $groups->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('group', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'groups' => $groups->data
                ]);
            }
        }
    }

    /**
     * GET: Group details page
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function groupDatas($id)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select group by ID
        $group = $this::$api_client_manager::call('GET', getApiURL() . '/group/' . $id, getApiToken());

        if ($user->success == false OR $notification->success == false OR $group->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('group', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'group' => $group->data
                ]);
            }
        }
    }

    /**
     * GET: Group entities list page
     *
     * @param  string $entity
     * @return \Illuminate\View\View
     */
    public function groupEntity($entity)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all groups
        $groups = $this::$api_client_manager::call('GET', getApiURL() . '/group', getApiToken());

        if ($entity == 'status') {
            // Select all statuses
            $statuses = $this::$api_client_manager::call('GET', getApiURL() . '/status', getApiToken());

            if ($user->success == false OR $notification->success == false OR $groups->success == false OR $statuses->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('group', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'groups' => $groups->data,
                        'statuses' => $statuses->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.group.status')
                    ]);
                }
            }
        }

        if ($entity == 'type') {
            // Select all types
            $types = $this::$api_client_manager::call('GET', getApiURL() . '/type', getApiToken());

            if ($user->success == false OR $notification->success == false OR $groups->success == false OR $types->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('group', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'groups' => $groups->data,
                        'types' => $types->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.group.type')
                    ]);
                }
            }
        }
    }

    /**
     * GET: Group entity details page
     *
     * @param  string $entity
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function groupEntityDatas($entity, $id)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all groups
        $groups = $this::$api_client_manager::call('GET', getApiURL() . '/group', getApiToken());

        if ($entity == 'status') {
            // Select status by ID
            $status = $this::$api_client_manager::call('GET', getApiURL() . '/status/' . $id, getApiToken());

            if ($user->success == false OR $notification->success == false OR $groups->success == false OR $status->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('group', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'groups' => $groups->data,
                        'status' => $status->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.group.status'),
                        'entity_details' => __('miscellaneous.pages_content.admin.group.status.details')
                    ]);
                }
            }
        }

        if ($entity == 'type') {
            // Select type by ID
            $type = $this::$api_client_manager::call('GET', getApiURL() . '/type/' . $id, getApiToken());

            if ($user->success == false OR $notification->success == false OR $groups->success == false OR $type->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('group', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'groups' => $groups->data,
                        'type' => $type->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.group.type'),
                        'entity_details' => __('miscellaneous.pages_content.admin.group.type.details')
                    ]);
                }
            }
        }
    }

    /**
     * GET: Roles list page
     *
     * @return \Illuminate\View\View
     */
    public function role()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all roles
        $roles = $this::$api_client_manager::call('GET', getApiURL() . '/role', getApiToken());

        if ($user->success == false OR $notification->success == false OR $roles->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('role', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'roles' => $roles->data
                ]);
            }
        }
    }

    /**
     * GET: Role details page
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function roleDatas($id)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select role by ID
        $role = $this::$api_client_manager::call('GET', getApiURL() . '/role/' . $id, getApiToken());

        if ($user->success == false OR $notification->success == false OR $role->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('role', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'role' => $role->data
                ]);
            }
        }
    }

    /**
     * GET: Role entities page
     *
     * @param  string $entity
     * @return \Illuminate\View\View
     */
    public function roleEntity($entity)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());

        if ($entity == 'other_admins') {
            // Select all admins
            $admin_role_name = 'Administrateur';
            $admins = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_role/' . $admin_role_name, getApiToken());

            if ($user->success == false OR $notification->success == false OR $admins->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('role', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'admins' => $admins->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.role.other_admins')
                    ]);
                }
            }
        }

        if ($entity == 'managers') {
            // Select all managers
            $manager_role_name = 'Manager';
            $managers = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_role/' . $manager_role_name, getApiToken());

            if ($user->success == false OR $notification->success == false OR $managers->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('role', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'managers' => $managers->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.role.managers')
                    ]);
                }
            }
        }
    }

    /**
     * GET: Role details page
     *
     * @param  string $entity
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function roleEntityDatas($entity, $id)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all statuses having group "Fonctionnement"
        $functioning_group_name = 'Fonctionnement';
        $statuses = $this::$api_client_manager::call('GET', getApiURL() . '/status/find_by_group/' . $functioning_group_name, getApiToken());
        // Select all roles other than given
        $employee_role_name = 'Employé';
        $roles = $this::$api_client_manager::call('GET', getApiURL() . '/role/find_all_except/' . $employee_role_name, getApiToken());

        if ($entity == 'other_admins') {
            // Select admin by ID
            $admin = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . $id, getApiToken());

            if ($user->success == false OR $notification->success == false OR $admin->success == false OR $statuses->success == false OR $roles->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('role', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'admin' => $admin->data,
                        'statuses' => $statuses->data,
                        'roles' => $roles->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.role.other_admins'),
                        'entity_details' => __('miscellaneous.pages_content.admin.role.admins.details')
                    ]);
                }
            }
        }

        if ($entity == 'managers') {
            // Select manager by ID
            $manager = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . $id, getApiToken());

            if ($user->success == false OR $notification->success == false OR $manager->success == false OR $statuses->success == false OR $roles->success == false) {
                abort(500);

            } else {
                // Find user ordinary message
                $ordinary_message_name = 'Message ordinaire';
                $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

                if ($message->success == false) {
                    abort(500);

                } else {
                    return view('role', [
                        'current_user' => $user->data,
                        'ordinary_chats' => $message->data,
                        'unread_notifications' => $notification->data,
                        'manager' => $manager->data,
                        'statuses' => $statuses->data,
                        'roles' => $roles->data,
                        'entity' => $entity,
                        'entity_title' => __('miscellaneous.menu.admin.role.managers'),
                        'entity_details' => __('miscellaneous.pages_content.admin.role.managers.details')
                    ]);
                }
            }
        }
    }

    /**
     * GET: Vacations list page
     *
     * @return \Illuminate\View\View
     */
    public function vacation()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all vacations
        $vacations = $this::$api_client_manager::call('GET', getApiURL() . '/vacation', getApiToken());

        if ($user->success == false OR $notification->success == false OR $vacations->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('vacation', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'vacations' => $vacations->data
                ]);
            }
        }
    }

    /**
     * GET: Vacation details page
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function vacationDatas($id)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select vacation by ID
        $vacation = $this::$api_client_manager::call('GET', getApiURL() . '/vacation/' . $id, getApiToken());

        if ($user->success == false OR $notification->success == false OR $vacation->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('vacation', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'vacation' => $vacation->data
                ]);
            }
        }
    }

    /**
     * GET: Departments list page
     *
     * @return \Illuminate\View\View
     */
    public function department()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all departments
        $departments = $this::$api_client_manager::call('GET', getApiURL() . '/department', getApiToken());

        if ($user->success == false OR $notification->success == false OR $departments->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('department', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'departments' => $departments->data
                ]);
            }
        }
    }

    /**
     * GET: Department details page
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function departmentDatas($id)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all departments
        $departments = $this::$api_client_manager::call('GET', getApiURL() . '/department', getApiToken());
        // Select department by ID
        $department = $this::$api_client_manager::call('GET', getApiURL() . '/department/' . $id, getApiToken());

        if ($user->success == false OR $notification->success == false OR $department->success == false OR $departments->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('department', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'departments' => $departments->data,
                    'department' => $department->data
                ]);
            }
        }
    }

    /**
     * GET: Branches list page
     *
     * @return \Illuminate\View\View
     */
    public function branch()
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all provinces
        $provinces = $this::$api_client_manager::call('GET', getApiURL() . '/province', getApiToken());
        // Select all cities
        $cities = $this::$api_client_manager::call('GET', getApiURL() . '/city', getApiToken());
        // Select all managers and those who doesn't belong to any branch
        $manager_role_name = 'Manager';
        $managers = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_role/' . $manager_role_name, getApiToken());
        $free_managers = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_empty_branch_role/' . $manager_role_name, getApiToken());
        // Select all branches
        $branches = $this::$api_client_manager::call('GET', getApiURL() . '/branch', getApiToken());

        if ($user->success == false OR $notification->success == false OR $provinces->success == false OR $cities->success == false OR $branches->success == false OR $free_managers->success == false OR $managers->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());

            if ($message->success == false) {
                abort(500);

            } else {
                return view('branch', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'provinces' => $provinces->data,
                    'cities' => $cities->data,
                    'managers' => $managers->data,
                    'free_managers' => $free_managers->data,
                    'branches' => $branches->data
                ]);
            }
        }
    }

    /**
     * GET: Branch details page
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function branchDatas($id)
    {
        // Current authenticated user
        $user = $this::$api_client_manager::call('GET', getApiURL() . '/user/' . Auth::user()->id, getApiToken());
        // All unread notifications
        $notification = $this::$api_client_manager::call('GET', getApiURL() . '/notification/select_unread_by_user/'. Auth::user()->id, getApiToken());
        // Select all provinces
        $provinces = $this::$api_client_manager::call('GET', getApiURL() . '/province', getApiToken());
        // Select branch by ID
        $branch = $this::$api_client_manager::call('GET', getApiURL() . '/branch/' . $id, getApiToken());

        if ($user->success == false OR $notification->success == false OR $provinces->success == false OR $branch->success == false) {
            abort(500);

        } else {
            // Find user ordinary message
            $ordinary_message_name = 'Message ordinaire';
            $message = $this::$api_client_manager::call('GET', getApiURL() . '/message/chat_role/'. $ordinary_message_name . '/' . $user->data->roles[0]->role_name, getApiToken());
            // Select managers who don't belong to any branch or who belong to the current branch
            $manager_role_name = 'Manager';
            $available_managers = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_empty_or_specific_branch_role/' . $branch->data->id . '/' . $manager_role_name, getApiToken());
            // Select branch managers
            $branch_managers = $this::$api_client_manager::call('GET', getApiURL() . '/user/find_by_branch_role/' . $branch->data->id . '/' . $manager_role_name, getApiToken());

            if ($message->success == false OR $available_managers->success == false OR $branch_managers->success == false) {
                abort(500);

            } else {
                return view('branch', [
                    'current_user' => $user->data,
                    'ordinary_chats' => $message->data,
                    'unread_notifications' => $notification->data,
                    'provinces' => $provinces->data,
                    'available_managers' => $available_managers->data,
                    'branch_managers' => $branch_managers->data,
                    'branch' => $branch->data
                ]);
            }
        }
    }

    // ==================================== HTTP POST METHODS ====================================
    /**
     * POST: Add a province
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeProvince(Request $request)
    {
        // Add a province
        $province = $this::$api_client_manager::call('POST', getApiURL() . '/province', getApiToken(), [
            'province_name' => $request->register_name
        ]);

        if ($province->success) {
            return Redirect::back()->with('success_message', __('notifications.registered_data'));

        } else {
            $resp_error = $request->register_name . '_' . $province->message . '_' . $province->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Update a province
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateProvince(Request $request, $id)
    {
        // Update a province
        $province = $this::$api_client_manager::call('PUT', getApiURL() . '/province/' . $id, getApiToken(), [
            'id' => $request->province_id,
            'province_name' => $request->register_name
        ]);

        if ($province->success) {
            return Redirect::to('/province')->with('success_message', __('notifications.updated_data'));

        } else {
            $resp_error = $request->register_name . '_' . $province->message . '_' . $province->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Add a city
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $entity
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeProvinceEntity(Request $request, $entity)
    {
        if ($entity == 'city') {
            // Add a city
            $city = $this::$api_client_manager::call('POST', getApiURL() . '/city', getApiToken(), [
                'city_name' => $request->register_name,
                'province_id' => $request->province_id
            ]);

            if ($city->success) {
                return Redirect::back()->with('success_message', __('notifications.registered_data'));

            } else {
                $resp_error = $request->register_name . '_' . $request->province_id . '_' . $city->message . '_' . $city->data;

                return Redirect::back()->with('response_error', $resp_error);
            }
        }
    }

    /**
     * POST: Update a city
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $entity
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateProvinceEntity(Request $request, $entity, $id)
    {
        if ($entity == 'city') {
            // Update a city
            $city = $this::$api_client_manager::call('PUT', getApiURL() . '/city/' . $id, getApiToken(), [
                'id' => $request->city_id,
                'city_name' => $request->register_name,
                'province_id' => $request->province_id
            ]);

            if ($city->success) {
                return Redirect::to('/province/city')->with('success_message', __('notifications.updated_data'));

            } else {
                $resp_error = $request->register_name . '_' . $request->province_id . '_' . $city->message . '_' . $city->data;

                return Redirect::back()->with('response_error', $resp_error);
            }
        }
    }

    /**
     * POST: Add a group
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeGroup(Request $request)
    {
        // Add a group
        $group = $this::$api_client_manager::call('POST', getApiURL() . '/group', getApiToken(), [
            'group_name' => $request->register_name,
            'group_description' => $request->register_description,
        ]);

        if ($group->success) {
            return Redirect::back()->with('success_message', __('notifications.registered_data'));

        } else {
            $resp_error = $request->register_name . '_' . $group->message . '_' . $group->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Update a group
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateGroup(Request $request, $id)
    {
        // Update a group
        $group = $this::$api_client_manager::call('PUT', getApiURL() . '/group/' . $id, getApiToken(), [
            'id' => $request->group_id,
            'group_name' => $request->register_name,
            'group_description' => $request->register_description,
        ]);

        if ($group->success) {
            return Redirect::to('/group')->with('success_message', __('notifications.updated_data'));

        } else {
            $resp_error = $request->register_name . '_' . $group->message . '_' . $group->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Add a status/type
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $entity
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeGroupEntity(Request $request, $entity)
    {
        if ($entity == 'status') {
            // Add a status
            $status = $this::$api_client_manager::call('POST', getApiURL() . '/status', getApiToken(), [
                'status_name' => $request->register_name,
                'status_description' => $request->register_description,
                'icon' => $request->register_icon,
                'color' => $request->register_color,
                'group_id' => $request->group_id
            ]);

            if ($status->success) {
                return Redirect::back()->with('success_message', __('notifications.registered_data'));

            } else {
                $resp_error = $request->register_name . '_' . $request->group_id . '_' . $status->message . '_' . $status->data;

                return Redirect::back()->with('response_error', $resp_error);
            }
        }

        if ($entity == 'type') {
            // Add a type
            $status = $this::$api_client_manager::call('POST', getApiURL() . '/type', getApiToken(), [
                'type_name' => $request->register_name,
                'type_description' => $request->register_description,
                'icon' => $request->register_icon,
                'color' => $request->register_color,
                'group_id' => $request->group_id
            ]);

            if ($status->success) {
                return Redirect::back()->with('success_message', __('notifications.registered_data'));

            } else {
                $resp_error = $request->register_name . '_' . $request->group_id . '_' . $status->message . '_' . $status->data;

                return Redirect::back()->with('response_error', $resp_error);
            }
        }
    }

    /**
     * POST: Update a status/type
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $entity
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateGroupEntity(Request $request, $entity, $id)
    {
        if ($entity == 'status') {
            // Update a status
            $status = $this::$api_client_manager::call('PUT', getApiURL() . '/status/' . $id, getApiToken(), [
                'id' => $request->status_id,
                'status_name' => $request->register_name,
                'status_description' => $request->register_description,
                'icon' => $request->register_icon,
                'color' => $request->register_color,
                'group_id' => $request->group_id
            ]);

            if ($status->success) {
                return Redirect::to('/group/status')->with('success_message', __('notifications.updated_data'));

            } else {
                $resp_error = $request->register_name . '_' . $request->group_id . '_' . $status->message . '_' . $status->data;

                return Redirect::back()->with('response_error', $resp_error);
            }
        }

        if ($entity == 'type') {
            // Update a type
            $type = $this::$api_client_manager::call('PUT', getApiURL() . '/type/' . $id, getApiToken(), [
                'id' => $request->type_id,
                'type_name' => $request->register_name,
                'type_description' => $request->register_description,
                'icon' => $request->register_icon,
                'color' => $request->register_color,
                'group_id' => $request->group_id
            ]);

            if ($type->success) {
                return Redirect::to('/group/type')->with('success_message', __('notifications.updated_data'));

            } else {
                $resp_error = $request->register_name . '_' . $request->group_id . '_' . $type->message . '_' . $type->data;

                return Redirect::back()->with('response_error', $resp_error);
            }
        }
    }

    /**
     * POST: Add a role
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeRole(Request $request)
    {
        // Add a role
        $role = $this::$api_client_manager::call('POST', getApiURL() . '/role', getApiToken(), [
            'role_name' => $request->register_name,
            'role_description' => $request->register_description,
            'icon' => $request->register_icon,
            'color' => $request->register_color
        ]);

        if ($role->success) {
            return Redirect::back()->with('success_message', __('notifications.registered_data'));

        } else {
            $resp_error = $request->register_name . '_' . $role->message . '_' . $role->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Update a role
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateRole(Request $request, $id)
    {
        // Update a role
        $role = $this::$api_client_manager::call('PUT', getApiURL() . '/role/' . $id, getApiToken(), [
            'id' => $request->role_id,
            'role_name' => $request->register_name,
            'role_description' => $request->register_description,
            'icon' => $request->register_icon,
            'color' => $request->register_color
        ]);

        if ($role->success) {
            return Redirect::to('/role')->with('success_message', __('notifications.updated_data'));

        } else {
            $resp_error = $request->register_name . '_' . $role->message . '_' . $role->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Add a administrateur/manager
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $entity
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeRoleEntity(Request $request, $entity)
    {
        if ($entity == 'other_admins') {
            // Find role by name
            $admin_role_name = 'Administrateur';
            $admin_role = $this::$api_client_manager::call('GET', getApiURL() . '/role/search/' . $admin_role_name, getApiToken());
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
                'role_id' => $admin_role->data->id
            ];
            // Add an admin
            $admin = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $inputs);

            if ($admin->success) {
                // Udpate avatar if it is changed
                if ($request->data_other_user != null) {
                    $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_avatar_picture/' . $admin->data->id, getApiToken(), [
                        'user_id' => $admin->data->id,
                        'image_64' => $request->data_other_user
                    ]);
                }

                return Redirect::back()->with('success_message', __('notifications.registered_data'));

            } else {
                $resp_error = $inputs['number'] . '~' . $inputs['firstname'] . '~' . $inputs['lastname'] . '~' . $inputs['surname'] . '~' . $inputs['birth_city'] . '~' . $request->register_birth_date . '~' . $inputs['address_1'] . '~' . $inputs['address_2'] . '~' . $inputs['p_o_box'] . '~' . $inputs['phone'] . '~' . $inputs['email'] . '~' . $inputs['username'] . '~' . $inputs['password'] . '~' . $inputs['confirm_password'] . '~' . $admin->message . '~' . $admin->data;

                return Redirect::to('/role/other_admins')->with('response_error', $resp_error);
            }
        }

        if ($entity == 'managers') {
            // Find role by name
            $manager_role_name = 'Manager';
            $manager_role = $this::$api_client_manager::call('GET', getApiURL() . '/role/search/' . $manager_role_name, getApiToken());
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
                'role_id' => $manager_role->data->id
            ];
            // Add a manager
            $manager = $this::$api_client_manager::call('POST', getApiURL() . '/user', getApiToken(), $inputs);

            if ($manager->success) {
                // Udpate avatar if it is changed
                if ($request->data_other_user != null) {
                    $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_avatar_picture/' . $manager->data->user->id, getApiToken(), [
                        'user_id' => $manager->data->user->id,
                        'image_64' => $request->data_other_user
                    ]);
                }

                return Redirect::back()->with('success_message', __('notifications.registered_data'));

            } else {
                $resp_error = $inputs['number'] . '~' . $inputs['firstname'] . '~' . $inputs['lastname'] . '~' . $inputs['surname'] . '~' . $inputs['birth_city'] . '~' . $request->register_birth_date . '~' . $inputs['address_1'] . '~' . $inputs['address_2'] . '~' . $inputs['p_o_box'] . '~' . $inputs['phone'] . '~' . $inputs['email'] . '~' . $inputs['username'] . '~' . $inputs['password'] . '~' . $inputs['confirm_password'] . '~' . $manager->message . '~' . $manager->data;

                return Redirect::to('/role/managers')->with('response_error', $resp_error);
            }
        }
    }

    /**
     * POST: Update a administrateur/manager
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $entity
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateRoleEntity(Request $request, $entity, $id)
    {
        if ($entity == 'other_admins') {
            // Find role by name
            $admin_role_name = 'Administrateur';
            $admin_role = $this::$api_client_manager::call('GET', getApiURL() . '/role/search/' . $admin_role_name, getApiToken());
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
                'role_id' => $request->role_id
            ];
            // Update an admin
            $admin = $this::$api_client_manager::call('PUT', getApiURL() . '/user/' . $id, getApiToken(), $inputs);

            // Udpate avatar if it is changed
            if ($request->data_other_user != null) {
                $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_avatar_picture/' . $id, getApiToken(), [
                    'user_id' => $inputs['id'],
                    'image_64' => $request->data_other_user
                ]);
            }

            if ($admin->success) {
                if ($inputs['role_id'] == $admin_role->data->id) {
                    return Redirect::to('/role/other_admins')->with('success_message', __('notifications.updated_data'));

                } else {
                    return Redirect::to('/role/managers')->with('success_message', __('notifications.updated_data'));
                }

            } else {
                $resp_error = $inputs['number'] . '~' . $inputs['firstname'] . '~' . $inputs['lastname'] . '~' . $inputs['surname'] . '~' . $inputs['birth_city'] . '~' . $request->register_birth_date . '~' . $inputs['address_1'] . '~' . $inputs['address_2'] . '~' . $inputs['p_o_box'] . '~' . $inputs['phone'] . '~' . $inputs['email'] . '~' . $inputs['username'] . '~' . $inputs['password'] . '~' . $inputs['confirm_password'] . '~' . $admin->message . '~' . $admin->data;

                return Redirect::back()->with('response_error', $resp_error);
            }
        }

        if ($entity == 'managers') {
            $manager_role_name = 'Manager';
            $manager_role = $this::$api_client_manager::call('GET', getApiURL() . '/role/search/' . $manager_role_name, getApiToken());
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
                'role_id' => $request->role_id
            ];
            $manager = $this::$api_client_manager::call('PUT', getApiURL() . '/user/' . $id, getApiToken(), $inputs);

            // Udpate avatar if it is changed
            if ($request->data_other_user != null) {
                $this::$api_client_manager::call('PUT', getApiURL() . '/user/update_avatar_picture/' . $id, getApiToken(), [
                    'user_id' => $inputs['id'],
                    'image_64' => $request->data_other_user
                ]);
            }

            if ($manager->success) {
                if ($inputs['role_id'] == $manager_role->data->id) {
                    return Redirect::to('/role/managers')->with('success_message', __('notifications.updated_data'));

                } else {
                    return Redirect::to('/role/other_admins')->with('success_message', __('notifications.updated_data'));
                }

            } else {
                $resp_error = $inputs['number'] . '~' . $inputs['firstname'] . '~' . $inputs['lastname'] . '~' . $inputs['surname'] . '~' . $inputs['birth_city'] . '~' . $request->register_birth_date . '~' . $inputs['address_1'] . '~' . $inputs['address_2'] . '~' . $inputs['p_o_box'] . '~' . $inputs['phone'] . '~' . $inputs['email'] . '~' . $inputs['username'] . '~' . $inputs['password'] . '~' . $inputs['confirm_password'] . '~' . $manager->message . '~' . $manager->data;

                return Redirect::back()->with('response_error', $resp_error);
            }
        }
    }

    /**
     * POST: Add a vacation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeVacation(Request $request)
    {
        // Inputs
        $inputs = [
            'day_month' => !empty($request->register_other_date) ? explode('/', $request->register_other_date)[1] . '-' . explode('/', $request->register_other_date)[0] : null,
            'year' => !empty($request->register_other_date) ? explode('/', $request->register_other_date)[2] : null,
            'vacation_description' => $request->register_description
        ];
        // Add a vacation
        $vacation = $this::$api_client_manager::call('POST', getApiURL() . '/vacation', getApiToken(), $inputs);

        if ($vacation->success) {
            return Redirect::back()->with('success_message', __('notifications.registered_data'));

        } else {
            $resp_error = $inputs['day_month'] . '_' . $inputs['year'] . '_' . $vacation->message . '_' . $vacation->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Update a vacation
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateVacation(Request $request, $id)
    {
        // Inputs
        $inputs = [
            'id' => $request->vacation_id,
            'day_month' => !empty($request->register_other_date) ? explode('/', $request->register_other_date)[1] . '-' . explode('/', $request->register_other_date)[0] : null,
            'year' => !empty($request->register_other_date) ? explode('/', $request->register_other_date)[2] : null,
            'vacation_description' => $request->register_description
        ];
        // Update a vacation
        $vacation = $this::$api_client_manager::call('PUT', getApiURL() . '/vacation/' . $id, getApiToken(), $inputs);

        if ($vacation->success) {
            return Redirect::to('/vacation')->with('success_message', __('notifications.updated_data'));

        } else {
            $resp_error = $inputs['day_month'] . '_' . $inputs['year'] . '_' . $vacation->message . '_' . $vacation->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Add a department
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeDepartment(Request $request)
    {
        // Add a department
        $department = $this::$api_client_manager::call('POST', getApiURL() . '/department', getApiToken(), [
            'department_name' => $request->register_name,
            'department_description' => $request->register_description,
            'belongs_to' => $request->belongs_to
        ]);

        if ($department->success) {
            return Redirect::back()->with('success_message', __('notifications.registered_data'));

        } else {
            $resp_error = $request->register_name . '_' . $department->message . '_' . $department->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Update a department
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateDepartment(Request $request, $id)
    {
        // Update a department
        $department = $this::$api_client_manager::call('PUT', getApiURL() . '/department/' . $id, getApiToken(), [
            'id' => $request->department_id,
            'department_name' => $request->register_name,
            'department_description' => $request->register_description,
            'belongs_to' => $request->belongs_to
        ]);

        if ($department->success) {
            return Redirect::to('/department')->with('success_message', __('notifications.updated_data'));

        } else {
            $resp_error = $request->register_name . '_' . $department->message . '_' . $department->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Add a branch
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function storeBranch(Request $request)
    {
        // Add a branch
        $branch = $this::$api_client_manager::call('POST', getApiURL() . '/branch', getApiToken(), [
            'branch_name' => $request->register_name,
            'email' => $request->register_email,
            'phones' => $request->register_phones,
            'address' => $request->register_address,
            'p_o_box' => $request->register_p_o_box,
            'city_id' => $request->city_id,
            'users_ids' => $request->users_ids
        ]);

        if ($branch->success) {
            return Redirect::back()->with('success_message', __('notifications.registered_data'));

        } else {
            $resp_error = $request->register_name . '_' . $request->register_email . '_' . $request->register_phones . '_' . $request->register_address . '_' . $request->register_p_o_box . '_' . $request->city_id . '_' . $branch->message . '_' . $branch->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }

    /**
     * POST: Update a branch
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function updateBranch(Request $request, $id)
    {
        // Update a branch
        $branch = $this::$api_client_manager::call('PUT', getApiURL() . '/branch/' . $id, getApiToken(), [
            'id' => $request->branch_id,
            'branch_name' => $request->register_name,
            'email' => $request->register_email,
            'phones' => $request->register_phones,
            'address' => $request->register_address,
            'p_o_box' => $request->register_p_o_box,
            'city_id' => $request->city_id,
            'users_ids' => $request->users_ids
        ]);

        if ($branch->success) {
            return Redirect::to('/branch')->with('success_message', __('notifications.updated_data'));

        } else {
            $resp_error = $request->register_name . '_' . $request->register_email . '_' . $request->register_phones . '_' . $request->register_address . '_' . $request->register_p_o_box . '_' . $request->city_id . '_' . $branch->message . '_' . $branch->data;

            return Redirect::back()->with('response_error', $resp_error);
        }
    }
}
