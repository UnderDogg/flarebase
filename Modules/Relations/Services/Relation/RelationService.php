<?php
namespace Modules\Relations\Services\Relation;

use Modules\Core\Models\Relation;
use Modules\Core\Models\Industry;
use Modules\Core\Models\Invoices;
use Modules\Core\Models\TicketTime;

class RelationService implements RelationServiceContract
{

    public function find($id)
    {
        return Relation::findOrFail($id);
    }

    public function listAllRelations()
    {
        return Relation::pluck('name', 'id');
    }

    public function getInvoices($id)
    {
        $invoice = Relation::findOrFail($id)->invoices()->with('tickettime')->get();
        return $invoice;
    }

    public function getAllRelationsCount()
    {
        return Relation::all()->count();
    }

    public function listAllIndustries()
    {
        return Industry::pluck('name', 'id');
    }

    public function create($requestData)
    {
        Relation::create($requestData);
    }

    public function update($id, $requestData)
    {
        $relation = Relation::findOrFail($id);
        $relation->fill($requestData->all())->save();
    }

    public function destroy($id)
    {
        try {
            $relation = Relation::findorFail($id);
            $relation->delete();
            Session()->flash('flash_message', 'Relation successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            Session()->flash('flash_message_warning', 'Relation can NOT have, leads, or tickets assigned when deleted');
        }
    }

    public function vat($requestData)
    {
        $vat = $requestData->input('vat');
        $country = $requestData->input('country');
        $company_name = $requestData->input('company_name');
        // Strip all other characters than numbers
        $vat = preg_replace('/[^0-9]/', '', $vat);
        function cvrApi($vat)
        {
            if (empty($vat)) {
                // Print error message
                return ('Please insert VAT');
            } else {
                // Start cURL
                $ch = curl_init();
                // Set cURL options
                curl_setopt($ch, CURLOPT_URL, 'http://cvrapi.dk/api?search=' . $vat . '&country=dk');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Flashpoint');
                // Parse result
                $result = curl_exec($ch);
                // Close connection when done
                curl_close($ch);
                // Return our decoded result
                return json_decode($result, 1);
            }
        }

        $result = cvrApi($vat, 'dk');
        return $result;
    }
}
