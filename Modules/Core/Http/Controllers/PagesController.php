<?php
namespace Modules\Core\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tickets\Models\Ticket;
use Carbon;
use Modules\Relations\Models\Relation;
use DB;
use Modules\Core\Models\User;
use Modules\Core\Models\Staff;
use Modules\Core\Models\Settings;
use Modules\Leads\Models\Lead;
use Modules\Core\Services\User\UserServiceContract;
use Modules\Core\Services\Staff\StaffServiceContract;
use Modules\Relations\Services\Relation\RelationServiceContract;
use Modules\Core\Services\Setting\SettingServiceContract;
use Modules\Tickets\Services\Ticket\TicketServiceContract;
use Modules\Leads\Services\Lead\LeadServiceContract;

class PagesController extends Controller
{

    protected $users;
    protected $staff;
    protected $relations;
    protected $settings;
    protected $tickets;
    protected $leads;

    public function __construct(
        UserServiceContract $users,
        StaffServiceContract $staff,
        RelationServiceContract $relations,
        SettingServiceContract $settings,
        TicketServiceContract $tickets,
        LeadServiceContract $leads
    )
    {
        $this->users = $users;
        $this->relations = $relations;
        $this->settings = $settings;
        $this->tickets = $tickets;
        $this->leads = $leads;
    }

    public function hellodashboard()
    {
        /**
         * Other Statistics
         *
         */
        $companyname = $this->settings->getCompanyName();
        $users = $this->users->getAllUsers();
        $totalRelations = $this->relations->getAllRelationsCount();
        $totalTimeSpent = $this->tickets->totalTimeSpent();
        /**
         * Statistics for all-time tickets.
         *
         */
        $alltickets = $this->tickets->allTickets();
        $allCompletedTickets = $this->tickets->allCompletedTickets();
        $totalPercentageTickets = $this->tickets->percantageCompleted();
        /**
         * Statistics for today tickets.
         *
         */
        $completedTicketsToday = $this->tickets->completedTicketsToday();
        $createdTicketsToday = $this->tickets->createdTicketsToday();
        /**
         * Statistics for tickets this month.
         *
         */
        $ticketCompletedThisMonth = $this->tickets->completedTicketsThisMonth();
        /**
         * Statistics for tickets each month(For Charts).
         *
         */
        $createdTicketsMonthly = $this->tickets->createdTicketsMothly();
        $completedTicketsMonthly = $this->tickets->completedTicketsMothly();
        /**
         * Statistics for all-time Leads.
         *
         */
        $allleads = $this->leads->allLeads();
        $allCompletedLeads = $this->leads->allCompletedLeads();
        $totalPercentageLeads = $this->leads->percantageCompleted();
        /**
         * Statistics for today leads.
         *
         */
        $completedLeadsToday = $this->leads->completedLeadsToday();
        $createdLeadsToday = $this->leads->completedLeadsToday();
        /**
         * Statistics for leads this month.
         *
         */
        $leadCompletedThisMonth = $this->leads->completedLeadsThisMonth();
        /**
         * Statistics for leads each month(For Charts).
         *
         */
        $completedLeadsMonthly = $this->leads->createdLeadsMonthly();
        $createdLeadsMonthly = $this->leads->completedLeadsMonthly();
        


       
        return view('pages.dashboard', compact(
            'completedTicketsToday',
            'completedLeadsToday',
            'createdTicketsToday',
            'createdLeadsToday',
            'createdTicketsMonthly',
            'completedTicketsMonthly',
            'completedLeadsMonthly',
            'createdLeadsMonthly',
            'ticketCompletedThisMonth',
            'leadCompletedThisMonth',
            'totalTimeSpent',
            'totalRelations',
            'users',
            'companyname',
            'alltickets',
            'allCompletedTickets',
            'totalPercentageTickets',
            'allleads',
            'allCompletedLeads',
            'totalPercentageLeads'
        ));
    }
}
