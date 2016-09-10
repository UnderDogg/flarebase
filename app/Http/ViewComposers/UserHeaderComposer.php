<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Core\Users\UserServiceContract;

class UserHeaderComposer
{
    /**
     * The User repository implementation.
     *
     * @var UserService
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserService $users
     * @return void
     */
    public function __construct(UserServiceContract $users)
    {
        $this->users = $users;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('contact', $this->users->find($view->getData()['user']['id']));
    }
}
