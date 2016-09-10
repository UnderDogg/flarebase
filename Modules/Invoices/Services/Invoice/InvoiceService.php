<?php
namespace Modules\Invoices\Services\Invoice;

use App\Models\Invoice;
use App\Models\Relations;
use App\Models\TicketTime;

class InvoiceService implements InvoiceServiceContract
{

  public function getAllInvoices()
  {
    return Invoice::all();
  }

  public function find($id)
  {
    return Invoice::findOrFail($id);
  }

  public function create($relationid, $timeticketid, $requestData)
  {
    $invoice = Invoice::create();
    $invoice->relations()->attach($relationid);
    foreach ($timeticketid as $tk) {
      $testid[] = $tk->id;
    }
    $invoice->tickettime()->attach($testid);
    $invoice->save();
  }

  public function updateSentStatus($id, $requestData)
  {
    $invoice = invoice::findOrFail($id);
    $input = array_replace($requestData->all(), ['sent' => 1]);
    $invoice->fill($input)->save();
  }

  public function updateSentReopen($id, $requestData)
  {
    $invoice = invoice::findOrFail($id);
    $input = array_replace($requestData->all(), ['sent' => 0]);
    $invoice->fill($input)->save();
  }

  public function updatePayment($id, $requestData)
  {
    $invoice = invoice::findOrFail($id);
    $input = $requestData->get('payment_date');
    $input = array_replace($requestData->all(), ['payment_date' => $input, 'received' => 1]);
    $invoice->fill($input)->save();
  }

  public function reopenPayment($id, $requestData)
  {
    $invoice = invoice::findOrFail($id);
    $input = array_replace($requestData->all(), ['received' => 0]);
    $invoice->fill($input)->save();
  }

  public function newItem($id, $requestData)
  {
    $invoice = invoice::findOrFail($id);
    $tickettimeId = $invoice->tickettime()->first()->fk_ticket_id;
    $relationid = $invoice->relations()->first()->id;
    $input = array_replace($requestData->all(), ['fk_ticket_id' => "$tickettimeId"]);
    $tickettime = TicketTime::create($input);
    $insertedId = $tickettime->id;
    $invoice->tickettime()->attach($insertedId);
    $invoice->relations()->attach($relationid);
  }

  public function destroy($id)
  {
    return Invoice::destroy($id);
  }

  public function getAllOpenInvoices()
  {
  }

  public function getAllClosedInvoices()
  {
  }

  public function GetAllSentInvoices()
  {
  }

  public function GetAllNotSentInvoices()
  {
  }

  public function GetAllInvoicesPaymentNotReceived()
  {
  }
}
