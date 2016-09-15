<?php
namespace Modules\Core\Http\Controllers;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests;

use Modules\Email\Requests\SmtpRequest;
use Modules\Email\Models\Smtp;
// models
use Modules\Core\Models\Plugin;
use Modules\Core\Models\Widgets;
use Modules\Core\Models\VersionCheck;

use Modules\Core\Models\Role;

use Modules\Core\Models\User;

// models
use Modules\Core\Models\Department;
use Modules\Email\Models\Emails;
use Modules\Email\Models\MailTemplate;
use Modules\Tickets\Models\TicketHelpTopic;
use Modules\Tickets\Models\SlaPlan;
use Modules\Core\Models\Access;
use Modules\Core\Models\Alert;
use Modules\Core\Models\Company;
use Modules\Email\Models\Mailbox;
use Modules\Core\Models\AutoResponder;
use Modules\Core\Models\System;

use Modules\Tickets\Models\Settings;
use Modules\Tickets\Models\TicketSetting;
use Modules\Tickets\Models\TicketPriority;
use Modules\Core\Models\DateFormat;
use Modules\Core\Models\DateTimeFormat;
use Modules\Core\Models\TimeFormat;
use Modules\Core\Models\TimeZone;



use Config;
// classes
use Crypt;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Auth;
use Modules\Core\Requests\Setting\UpdateSettingOverallRequest;
use Modules\Core\Services\Setting\SettingServiceContract;
use Modules\Core\Services\Role\RoleServiceContract;

class SettingsController extends Controller
{

    protected $settings;
    protected $roles;

    public function __construct(
        SettingServiceContract $settings,
        RoleServiceContract $roles
    )
    {
        $this->settings = $settings;
        $this->roles = $roles;
        //$this->middleware('user.is.admin', ['only' => ['index']]);
    }

    public function index()
    {
        return view('settings.index')
            ->withSettings($this->settings->getSetting())
            ->withPermission($this->roles->allPermissions())
            ->withRoles($this->roles->allRoles());
    }

    public function updateOverall(UpdateSettingOverallRequest $request)
    {
        $this->settings->updateOverall($request);
        Session::flash('flash_message', 'Overall settings successfully updated');
        return redirect()->back();
    }

    public function permissionsUpdate(Request $request)
    {
        $this->roles->permissionsUpdate($request);
        Session::flash('flash_message', 'Role is updated');
        return redirect()->back();
    }


    /**
     * @param int $id
     * @param $compant instance of company table
     *
     * get the form for company setting page
     *
     * @return Response
     */
    public function getcompany(Company $company)
    {
        //try {
            /* fetch the values of company from company table */
            $companies = $company->whereId('1')->first();
            /* Direct to Company Settings Page */
            return view('core::companies.company', compact('companies'));
        //} catch (Exception $e) {
        //    return redirect()->back()->with('fails', $e->getMessage());
        //}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int            $id
     * @param type Company        $company
     * @param type CompanyRequest $request
     *
     * @return Response
     */
    public function postcompany($id, Company $company, CompanyRequest $request)
    {
        /* fetch the values of company request  */
        $companys = $company->whereId('1')->first();
        if (Input::file('logo')) {
            $name = Input::file('logo')->getClientOriginalName();
            $destinationPath = 'lb-faveo/media/company/';
            $fileName = rand(0000, 9999).'.'.$name;
            Input::file('logo')->move($destinationPath, $fileName);
            $companys->logo = $fileName;
        }
        if ($request->input('use_logo') == null) {
            $companys->use_logo = '0';
        }
        /* Check whether function success or not */
        try {
            $companys->fill($request->except('logo'))->save();
            /* redirect to Index page with Success Message */
            return redirect('getcompany')->with('success', 'Company Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getcompany')->with('fails', 'Company can not Updated'.'<li>'.$e->getMessage().'</li>');
        }
    }




    /**
     * function to delete system logo.
     *
     *  @return type string
     */
    public function deleteLogo()
    {
        $path = $_GET['data1']; //get file path of logo image
        if (!unlink($path)) {
            return 'false';
        } else {
            $companies = Company::where('id', '=', 1)->first();
            $companies->logo = null;
            $companies->use_logo = '0';
            $companies->save();

            return 'true';
        }
        // return $res;
    }

    /**
     * get the form for System setting page.
     *
     * @param type System           $system
     * @param type Department       $department
     * @param type Timezones        $timezone
     * @param type Date_format      $date
     * @param type Date_time_format $date_time
     * @param type Time_format      $time
     *
     * @return type Response
     */
    public function getsystem(System $system, Department $department, Timezones $timezone, Date_format $date, Date_time_format $date_time, Time_format $time)
    {
        try {
            /* fetch the values of system from system table */
            $systems = $system->whereId('1')->first();
            /* Fetch the values from Department table */
            $departments = $department->get();
            /* Fetch the values from Timezones table */
            $timezones = $timezone->get();
            /* Direct to System Settings Page */
            return view('core::settings.system', compact('systems', 'departments', 'timezones', 'time', 'date', 'date_time'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int           $id
     * @param type System        $system
     * @param type SystemRequest $request
     *
     * @return type Response
     */
    public function postsystem($id, System $system, SystemRequest $request)
    {
        try {
            // dd($request);
            /* fetch the values of system request  */
            $systems = $system->whereId('1')->first();
            /* fill the values to coompany table */
            /* Check whether function success or not */
            $systems->fill($request->input())->save();
            /* redirect to Index page with Success Message */
            return redirect('getsystem')->with('success', 'System Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getsystem')->with('fails', 'System can not Updated'.'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * get the form for Ticket setting page.
     *
     * @param type Ticket     $ticket
     * @param type Sla_plan   $sla
     * @param type Help_topic $topic
     * @param type Priority   $priority
     *
     * @return type Response
     */
    public function getticket(Ticket $ticket, Sla_plan $sla, Help_topic $topic, Ticket_Priority $priority)
    {
        try {
            /* fetch the values of ticket from ticket table */
            $tickets = $ticket->whereId('1')->first();
            /* Fetch the values from SLA Plan table */
            $slas = $sla->get();
            /* Fetch the values from Help_topic table */
            $topics = $topic->get();
            /* Direct to Ticket Settings Page */
            return view('core::settings.ticket', compact('tickets', 'slas', 'topics', 'priority'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int     $id
     * @param type Ticket  $ticket
     * @param type Request $request
     *
     * @return type Response
     */
    public function postticket($id, Ticket $ticket, Request $request)
    {
        try {
            /* fetch the values of ticket request  */
            $tickets = $ticket->whereId('1')->first();
            /* fill the values to coompany table */
            $tickets->fill($request->except('captcha', 'claim_response', 'assigned_ticket', 'answered_ticket', 'agent_mask', 'html', 'client_update'))->save();
            /* insert checkbox to Database  */
            $tickets->captcha = $request->input('captcha');
            $tickets->claim_response = $request->input('claim_response');
            $tickets->assigned_ticket = $request->input('assigned_ticket');
            $tickets->answered_ticket = $request->input('answered_ticket');
            $tickets->agent_mask = $request->input('agent_mask');
            $tickets->html = $request->input('html');
            $tickets->client_update = $request->input('client_update');
            $tickets->collision_avoid = $request->input('collision_avoid');
            /* Check whether function success or not */
            $tickets->save();
            /* redirect to Index page with Success Message */
            return redirect('getticket')->with('success', 'Ticket Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getticket')->with('fails', 'Ticket can not Updated'.'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * get the form for Email setting page.
     *
     * @param type Email    $email
     * @param type Template $template
     * @param type Emails   $email1
     *
     * @return type Response
     */
    public function getemail(Email $email, Template $template, Emails $email1)
    {
        try {
            /* fetch the values of email from Email table */
            $emails = $email->whereId('1')->first();
            /* Fetch the values from Template table */
            $templates = $template->get();
            /* Fetch the values from Emails table */
            $emails1 = $email1->get();
            /* Direct to Email Settings Page */
            return view('core::settings.email', compact('emails', 'templates', 'emails1'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int          $id
     * @param type Email        $email
     * @param type EmailRequest $request
     *
     * @return type Response
     */
    public function postemail($id, Email $email, EmailRequest $request)
    {
        try {
            /* fetch the values of email request  */
            $emails = $email->whereId('1')->first();
            /* fill the values to email table */
            $emails->fill($request->except('email_fetching', 'all_emails', 'email_collaborator', 'strip', 'attachment'))->save();
            /* insert checkboxes  to database */
            // $emails->email_fetching = $request->input('email_fetching');
            // $emails->notification_cron = $request->input('notification_cron');
            $emails->all_emails = $request->input('all_emails');
            $emails->email_collaborator = $request->input('email_collaborator');
            $emails->strip = $request->input('strip');
            $emails->attachment = $request->input('attachment');
            /* Check whether function success or not */
            $emails->save();
            /* redirect to Index page with Success Message */
            return redirect('getemail')->with('success', 'Email Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getemail')->with('fails', 'Email can not Updated'.'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * get the form for cron job setting page.
     *
     * @param type Email    $email
     * @param type Template $template
     * @param type Emails   $email1
     *
     * @return type Response
     */
    public function getSchedular(Email $email, Template $template, Emails $email1)
    {
        // try {
             /* fetch the values of email from Email table */
            $emails = $email->whereId('1')->first();
            /* Fetch the values from Template table */
            $templates = $template->get();
            /* Fetch the values from Emails table */
            $emails1 = $email1->get();

        return view('core::settings.crone', compact('emails', 'templates', 'emails1'));
        // } catch {

        // }
    }

    /**
     * Update the specified resource in storage for cron job.
     *
     * @param type Email        $email
     * @param type EmailRequest $request
     *
     * @return type Response
     */
    public function postSchedular(Email $email, Template $template, Emails $email1, Request $request)
    {
        // dd($request);
        try {
            /* fetch the values of email request  */
            $emails = $email->whereId('1')->first();
            if ($request->email_fetching) {
                $emails->email_fetching = $request->email_fetching;
            } else {
                $emails->email_fetching = 0;
            }
            if ($request->notification_cron) {
                $emails->notification_cron = $request->notification_cron;
            } else {
                $emails->notification_cron = 0;
            }
            $emails->save();
            /* redirect to Index page with Success Message */
            return redirect('job-scheduler')->with('success', Lang::get('core::lang.job-scheduler-success'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('job-scheduler')->with('fails', Lang::get('core::lang.job-scheduler-error').'<li>'.$e->getMessage().'</li>');
        }
    }


    /**
     * get the form for Responder setting page.
     *
     * @param type Responder $responder
     *
     * @return type Response
     */
    public function getresponder(Responder $responder)
    {
        try {
            /* fetch the values of responder from responder table */
            $responders = $responder->whereId('1')->first();
            /* Direct to Responder Settings Page */
            return view('core::settings.responder', compact('responders'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type Responder $responder
     * @param type Request   $request
     *
     * @return type
     */
    public function postresponder(Responder $responder, Request $request)
    {
        try {
            /* fetch the values of responder request  */
            $responders = $responder->whereId('1')->first();
            /* insert Checkbox value to DB */
            $responders->new_ticket = $request->input('new_ticket');
            $responders->agent_new_ticket = $request->input('agent_new_ticket');
            $responders->submitter = $request->input('submitter');
            $responders->participants = $request->input('participants');
            $responders->overlimit = $request->input('overlimit');
            /* fill the values to coompany table */
            /* Check whether function success or not */
            $responders->save();
            /* redirect to Index page with Success Message */
            return redirect('getresponder')->with('success', 'Responder Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getresponder')->with('fails', 'Responder can not Updated'.'<li>'.$e->getMessage().'</li>');
        }
    }

    /**
     * get the form for Alert setting page.
     *
     * @param type Alert $alert
     *
     * @return type Response
     */
    public function getalert(Alert $alert)
    {
        try {
            /* fetch the values of alert from alert table */
            $alerts = $alert->whereId('1')->first();
            /* Direct to Alert Settings Page */
            return view('core::settings.alert', compact('alerts'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type         $id
     * @param type Alert   $alert
     * @param type Request $request
     *
     * @return type Response
     */
    public function postalert($id, Alert $alert, Request $request)
    {
        try {
            /* fetch the values of alert request  */
            $alerts = $alert->whereId('1')->first();
            /* Insert Checkbox to DB */
            $alerts->assignment_status = $request->input('assignment_status');
            $alerts->ticket_status = $request->input('ticket_status');
            $alerts->overdue_department_member = $request->input('overdue_department_member');
            $alerts->sql_error = $request->input('sql_error');
            $alerts->excessive_failure = $request->input('excessive_failure');
            $alerts->overdue_status = $request->input('overdue_status');
            $alerts->overdue_assigned_agent = $request->input('overdue_assigned_agent');
            $alerts->overdue_department_manager = $request->input('overdue_department_manager');
            $alerts->internal_status = $request->input('internal_status');
            $alerts->internal_last_responder = $request->input('internal_last_responder');
            $alerts->internal_assigned_agent = $request->input('internal_assigned_agent');
            $alerts->internal_department_manager = $request->input('internal_department_manager');
            $alerts->assignment_assigned_agent = $request->input('assignment_assigned_agent');
            $alerts->assignment_team_leader = $request->input('assignment_team_leader');
            $alerts->assignment_team_member = $request->input('assignment_team_member');
            $alerts->system_error = $request->input('system_error');
            $alerts->transfer_department_member = $request->input('transfer_department_member');
            $alerts->transfer_department_manager = $request->input('transfer_department_manager');
            $alerts->transfer_assigned_agent = $request->input('transfer_assigned_agent');
            $alerts->transfer_status = $request->input('transfer_status');
            $alerts->message_organization_accmanager = $request->input('message_organization_accmanager');
            $alerts->message_department_manager = $request->input('message_department_manager');
            $alerts->message_assigned_agent = $request->input('message_assigned_agent');
            $alerts->message_last_responder = $request->input('message_last_responder');
            $alerts->message_status = $request->input('message_status');
            $alerts->ticket_organization_accmanager = $request->input('ticket_organization_accmanager');
            $alerts->ticket_department_manager = $request->input('ticket_department_manager');
            $alerts->ticket_department_member = $request->input('ticket_department_member');
            $alerts->ticket_admin_email = $request->input('ticket_admin_email');

            if ($request->input('system_error') == null) {
                $str = '%0%';
                $path = app_path('../config/app.php');
                $content = \File::get($path);
                $content = str_replace('%1%', $str, $content);
                \File::put($path, $content);
            } else {
                $str = '%1%';
                $path = app_path('../config/app.php');
                $content = \File::get($path);
                $content = str_replace('%0%', $str, $content);
                \File::put($path, $content);
            }
            /* fill the values to coompany table */
            /* Check whether function success or not */
            $alerts->save();
            /* redirect to Index page with Success Message */
            return redirect('getalert')->with('success', 'Alert Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getalert')->with('fails', 'Alert can not Updated'.'<li>'.$e->getMessage().'</li>');
        }
    }


    /**
     * Driver.
     *
     * @return type void
     */
    public static function driver()
    {
        $set = new Smtp();
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.host', $settings->driver);
    }

    /**
     * SMTP host.
     *
     * @return type void
     */
    public static function host()
    {
        $set = new Smtp();
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.host', $settings->host);
    }

    /**
     * SMTP port.
     *
     * @return type void
     */
    public static function port()
    {
        $set = new Smtp();
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.port', intval($settings->port));
    }

    /**
     * SMTP from.
     *
     * @return type void
     */
    public static function from()
    {
        $set = new Smtp();
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.from', ['address' => $settings->email, 'name' => $settings->company_name]);
    }

    /**
     * SMTP encryption.
     *
     * @return type void
     */
    public static function encryption()
    {
        $set = new Smtp();
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.encryption', $settings->encryption);
    }

    /**
     * SMTP username.
     *
     * @return type void
     */
    public static function username()
    {
        $set = new Smtp();
        $settings = Smtp::where('id', '=', '1')->first();
        Config::set('mail.username', $settings->email);
    }

    /**
     * SMTP password.
     *
     * @return type void
     */
    public static function password()
    {
        $settings = Smtp::first();
        if ($settings->password) {
            $pass = $settings->password;
            $password = Crypt::decrypt($pass);
            Config::set('mail.password', $password);
        }
    }

    /**
     * get SMTP.
     *
     * @return type view
     */
    public function getsmtp()
    {
        $settings = Smtp::where('id', '=', '1')->first();

        return view('themes.default1.admin.helpdesk.emails.smtp', compact('settings'));
    }

    /**
     * POST SMTP.
     *
     * @return type view
     */
    public function postsmtp(SmtpRequest $request)
    {
        $data = Smtp::where('id', '=', 1)->first();
        $data->driver = $request->input('driver');
        $data->host = $request->input('host');
        $data->port = $request->input('port');
        $data->encryption = $request->input('encryption');
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->password = Crypt::encrypt($request->input('password'));
        try {
            $data->save();

            return \Redirect::route('getsmtp')->with('success', 'success');
        } catch (Exception $e) {
            return \Redirect::route('getsmtp')->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * SMTP.
     *
     * @return type void
     */
    public static function smtp()
    {
        $settings = Smtp::where('id', '=', '1')->first();
        if ($settings->password) {
            $password = Crypt::decrypt($settings->password);
            Config::set('mail.driver', $settings->driver);
            Config::set('mail.password', $password);
            Config::set('mail.username', $settings->email);
            Config::set('mail.encryption', $settings->encryption);
            Config::set('mail.from', ['address' => $settings->email, 'name' => $settings->name]);
            Config::set('mail.port', intval($settings->port));
            Config::set('mail.host', $settings->host);
        }
    }

    /**
     * Settings.
     *
     * @param type Smtp $set
     *
     * @return type view\
     */
    public function settings(Smtp $set)
    {
        $settings = $set->where('id', '1')->first();

        return view('themes.default1.admin.settings', compact('settings'));
    }

    /**
     * Post settings.
     *
     * @param type Settings $set
     * @param type Request  $request
     *
     * @return type view
     */
    public function PostSettings(Settings $set, Request $request)
    {
        $settings = $set->where('id', '1')->first();
        $pass = $request->input('password');
        $password = Crypt::encrypt($pass);
        $settings->password = $password;
        try {
            $settings->save();
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
        if (Input::file('logo')) {
            $name = Input::file('logo')->getClientOriginalName();
            $destinationPath = 'dist/logo';
            $fileName = rand(0000, 9999).'.'.$name;
            Input::file('logo')->move($destinationPath, $fileName);
            $settings->logo = $fileName;
            $settings->save();
        }
        try {
            $settings->fill($request->except('logo', 'password'))->save();

            return redirect()->back()->with('success', 'Settings updated Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * version_check.
     *
     * @return type
     */
    public function version_check()
    {
        $response_url = \URL::route('post-version-check');
        echo "<form action='http://www.faveohelpdesk.com/bill/version' method='post' name='redirect'>";
        echo "<input type='hidden' name='_token' value='csrf_token()'/>";
        echo "<input type='hidden' name='title' value='helpdeskcommunityedition'/>";
        echo "<input type='hidden' name='id' value='19'/>";
        echo "<input type='hidden' name='response_url' value='".$response_url."' />";
        echo '</form>';
        echo "<script language='javascript'>document.redirect.submit();</script>";
    }

    /**
     * post_version_check.
     *
     * @return type
     */
    public function post_version_check(Request $request)
    {
        $current_version = \Config::get('app.version');
        $new_version = $request->value;
        if ($current_version == $new_version) {
            // echo "No, new Updates";
            return redirect()->route('checkupdate')->with('info', ' No, new Updates');
        } elseif ($current_version < $new_version) {
            $version = Version_Check::where('id', '=', '1')->first();
            $version->current_version = $current_version;
            $version->new_version = $new_version;
            $version->save();
            // echo "Version " . $new_version . " is Available";
            return redirect()->route('checkupdate')->with('info', ' Version '.$new_version.' is Available');
        } else {
            // echo "Error Checking Version";
            return redirect()->route('checkupdate')->with('info', ' Error Checking Version');
        }
    }

    public function getupdate()
    {
        return \View::make('themes.default1.admin.helpdesk.settings.checkupdate');
    }

    public function Plugins()
    {
        return view('themes.default1.admin.helpdesk.settings.plugins');
    }

    public function GetPlugin()
    {
        $plugins = $this->fetchConfig();
        //dd($plugins);

        return \Datatable::collection(new Collection($plugins))
                        ->searchColumns('name')
                        ->addColumn('name', function ($model) {
                            if (array_has($model, 'path')) {
                                if ($model['status'] == 0) {
                                    $activate = '<a href='.url('plugin/status/'.$model['path']).'>Activate</a>';
                                    $settings = ' ';
                                } else {
                                    $settings = '<a href='.url($model['settings']).'>Settings</a> | ';
                                    $activate = '<a href='.url('plugin/status/'.$model['path']).'>Deactivate</a>';
                                }

                                $delete = '<a href=  id=delete'.$model['path'].' data-toggle=modal data-target=#del'.$model['path']."><span style='color:red'>Delete</span></a>"
                                        ."<div class='modal fade' id=del".$model['path'].">
                                            <div class='modal-dialog'>
                                                <div class=modal-content>  
                                                    <div class=modal-header>
                                                        <h4 class=modal-title>Delete</h4>
                                                    </div>
                                                    <div class=modal-body>
                                                       <p>Are you Sure ?</p>
                                                        <div class=modal-footer>
                                                            <button type=button class='btn btn-default pull-left' data-dismiss=modal id=dismis>".\Lang::get('core::lang.close').'</button>
                                                            <a href='.url('plugin/delete/'.$model['path'])."><button class='btn btn-danger'>Delete</button></a>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                $action = '<br><br>'.$delete.' | '.$settings.$activate;
                            } else {
                                $action = '';
                            }

                            return ucfirst($model['name']).$action;
                        })
                        ->addColumn('description', function ($model) {
                            return ucfirst($model['description']);
                        })
                        ->addColumn('author', function ($model) {
                            return ucfirst($model['author']);
                        })
                        ->addColumn('website', function ($model) {
                            return '<a href='.$model['website'].' target=_blank>'.$model['website'].'</a>';
                        })
                        ->addColumn('version', function ($model) {
                            return $model['version'];
                        })
                        ->make();
    }

    /**
     * Reading the Filedirectory.
     *
     * @return type
     */
    public function ReadPlugins()
    {
        $dir = app_path().DIRECTORY_SEPARATOR.'Plugins';
        $plugins = array_diff(scandir($dir), ['.', '..']);

        return $plugins;
    }

    /**
     * After plugin post.
     *
     * @param Request $request
     *
     * @return type
     */
    public function PostPlugins(Request $request)
    {
        $v = $this->validate($request, ['plugin' => 'required|mimes:application/zip,zip,Zip']);
        $plug = new Plugin();
        $file = $request->file('plugin');
        //dd($file);
        $destination = app_path().DIRECTORY_SEPARATOR.'Plugins';
        $zipfile = $file->getRealPath();
        /*
         * get the file name and remove .zip
         */
        $filename2 = $file->getClientOriginalName();
        $filename2 = str_replace('.zip', '', $filename2);
        $filename1 = ucfirst($file->getClientOriginalName());
        $filename = str_replace('.zip', '', $filename1);
        mkdir($destination.DIRECTORY_SEPARATOR.$filename);
        /*
         * extract the zip file using zipper
         */
        \Zipper::make($zipfile)->folder($filename2)->extractTo($destination.DIRECTORY_SEPARATOR.$filename);

        $file = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.$filename; // Plugin file path

        if (file_exists($file)) {
            $seviceporvider = $file.DIRECTORY_SEPARATOR.'ServiceProvider.php';
            $config = $file.DIRECTORY_SEPARATOR.'config.php';
            if (file_exists($seviceporvider) && file_exists($config)) {
                /*
                 * move to faveo config
                 */
                $faveoconfig = config_path().DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$filename.'.php';
                if ($faveoconfig) {

                    //copy($config, $faveoconfig);
                    /*
                     * write provider list in app.php line 128
                     */
                    $app = base_path().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'app.php';
                    $str = "\n\n\t\t\t'App\\Plugins\\$filename"."\\ServiceProvider',";
                    $line_i_am_looking_for = 144;
                    $lines = file($app, FILE_IGNORE_NEW_LINES);
                    $lines[$line_i_am_looking_for] = $str;
                    file_put_contents($app, implode("\n", $lines));
                    $plug->create(['name' => $filename, 'path' => $filename, 'status' => 1]);

                    return redirect()->back()->with('success', 'Installed SuccessFully');
                } else {
                    /*
                     * delete if the plugin hasn't config.php and ServiceProvider.php
                     */
                    $this->deleteDirectory($file);

                    return redirect()->back()->with('fails', 'Their is no '.$file);
                }
            } else {
                /*
                 * delete if the plugin hasn't config.php and ServiceProvider.php
                 */
                $this->deleteDirectory($file);

                return redirect()->back()->with('fails', 'Their is no <b>config.php or ServiceProvider.php</b>  '.$file);
            }
        } else {
            /*
             * delete if the plugin Name is not equal to the folder name
             */
            $this->deleteDirectory($file);

            return redirect()->back()->with('fails', '<b>Plugin File Path is not exist</b>  '.$file);
        }
    }

    /**
     * Delete the directory.
     *
     * @param type $dir
     *
     * @return bool
     */
    public function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            chmod($dir.DIRECTORY_SEPARATOR.$item, 0777);
            if (!$this->deleteDirectory($dir.DIRECTORY_SEPARATOR.$item)) {
                return false;
            }
        }
        chmod($dir, 0777);

        return rmdir($dir);
    }

    public function ReadConfigs()
    {
        $dir = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR;
        $directories = scandir($dir);
        $files = [];
        foreach ($directories as $key => $file) {
            if ($file === '.' or $file === '..') {
                continue;
            }

            if (is_dir($dir.DIRECTORY_SEPARATOR.$file)) {
                $files[$key] = $file;
            }
        }
        //dd($files);
        $config = [];
        $plugins = [];
        if (count($files) > 0) {
            foreach ($files as $key => $file) {
                $plugin = $dir.$file;
                $plugins[$key] = array_diff(scandir($plugin), ['.', '..', 'ServiceProvider.php']);
                $plugins[$key]['file'] = $plugin;
            }
            foreach ($plugins as $plugin) {
                $dir = $plugin['file'];
                //opendir($dir);
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        if ($file == 'config.php') {
                            $config[] = $dir.DIRECTORY_SEPARATOR.$file;
                        }
                    }
                    closedir($dh);
                }
            }

            return $config;
        } else {
            return 'null';
        }
    }

    public function fetchConfig()
    {
        $configs = $this->ReadConfigs();
        //dd($configs);
        $plug = new Plugin();
        $plug = $plug->select('path', 'status')->orderBy('name')->get()->toArray();
        //$fields = [];
        if ($configs !== 'null') {
            foreach ($configs as $key => $config) {
                $fields[$key] = include $config;

                if ($plug != null) {
                    $fields[$key]['path'] = $plug[$key]['path'];
                    $fields[$key]['status'] = $plug[$key]['status'];
                } else {
                    $fields[$key]['path'] = $fields[$key]['name'];
                    $fields[$key]['status'] = 0;
                }
            }

            return $fields;
        }
    }

    public function DeletePlugin($slug)
    {
        $dir = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.$slug;
        $this->deleteDirectory($dir);
        /*
         * remove service provider from app.php
         */
        $str = "'App\\Plugins\\$slug"."\\ServiceProvider',";
        $path_to_file = base_path().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'app.php';
        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace($str, '//', $file_contents);
        file_put_contents($path_to_file, $file_contents);
        $plugin = new Plugin();
        $plugin = $plugin->where('path', $slug)->first();
        if ($plugin) {
            $plugin->delete();
        }

        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    public function StatusPlugin($slug)
    {
        $plugs = new Plugin();
        $plug = $plugs->where('name', $slug)->first();
        if (!$plug) {
            $app = base_path().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'app.php';
            $str = "'App\\Plugins\\$slug"."\\ServiceProvider',";
            $line_i_am_looking_for = 144;
            $lines = file($app, FILE_IGNORE_NEW_LINES);
            $lines[$line_i_am_looking_for] = $str;
            file_put_contents($app, implode("\n", $lines));
            $plugs->create(['name' => $slug, 'path' => $slug, 'status' => 1]);

            return redirect()->back()->with('success', 'Status has changed');
        }
        $status = $plug->status;
        if ($status == 0) {
            $plug->status = 1;

            $app = base_path().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'app.php';
            $str = "'App\\Plugins\\$slug"."\\ServiceProvider',";
            $line_i_am_looking_for = 144;
            $lines = file($app, FILE_IGNORE_NEW_LINES);
            $lines[$line_i_am_looking_for] = $str;
            file_put_contents($app, implode("\n", $lines));
        }
        if ($status == 1) {
            $plug->status = 0;
            /*
             * remove service provider from app.php
             */
            $str = "'App\\Plugins\\$slug"."\\ServiceProvider',";
            $path_to_file = base_path().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'app.php';

            $file_contents = file_get_contents($path_to_file);
            $file_contents = str_replace($str, '//', $file_contents);
            file_put_contents($path_to_file, $file_contents);
        }
        $plug->save();

        return redirect()->back()->with('success', 'Status has changed');
    }











}
