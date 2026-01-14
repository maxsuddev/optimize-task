<?php 

namespace App\Repositories\Contracts;

use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use Illuminate\Http\Request;

interface LeadRepositoryInterface 
{
    public function find($id);
    public function all(Request $request);
    public function store(LeadRequest $request);
    public function update($id, LeadRequest $lead);
    public function delete($id);
}