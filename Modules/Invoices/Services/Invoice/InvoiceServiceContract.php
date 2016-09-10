<?php
namespace Modules\Invoices\Services\Invoice;
interface InvoiceServiceContract
{

  public function getAllInvoices();

  public function getAllOpenInvoices();

  public function getAllClosedInvoices();

  public function GetAllSentInvoices();

  public function GetAllNotSentInvoices();

  public function GetAllInvoicesPaymentNotReceived();

  public function updatePayment($id, $requestData);

  public function reopenPayment($id, $requestData);

  public function updateSentStatus($id, $requestData);

  public function newItem($id, $requestData);

  public function updateSentReopen($id, $requestData);

  public function find($id);

  public function create($relationid, $timeticketid, $requestData);

  public function destroy($id);
}
