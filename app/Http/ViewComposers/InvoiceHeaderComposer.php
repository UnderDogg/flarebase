<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Services\invoice\InvoiceServiceContract;

class InvoiceHeaderComposer
{
    /**
     * The invoice repository implementation.
     *
     * @var invoiceService
     */
    protected $invoices;

    /**
     * Create a new profile composer.
     *
     * @param  invoiceService $invoices
     * @return void
     */
    public function __construct(InvoiceRepositoryContract $invoices)
    {
        $this->invoices = $invoices;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $invoices = $this->invoices->find($view->getData()['invoice']['id']);

        $relation = $invoices->relations->first();
        $view->with('relation', $relation);
    }
}
