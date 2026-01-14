<?php 

namespace App\Repositories\Contracts;

use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface LeadRepositoryInterface 
{
    public function show(int $id): Lead;
    public function all(Request $request): LengthAwarePaginator;
    public function store(LeadRequest $request): Lead;
    public function update(int $id, LeadRequest $lead): Lead;
    public function delete(int $id): bool;
}