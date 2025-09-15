<?php

namespace App\Exports;

use App\Models\IndustryMasterData;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IndustryPolicyExport implements FromCollection, WithHeadings
{
    protected $userId;
    protected $search;

    public function __construct($userId, $search = null)
    {
        $this->userId = $userId;
        $this->search = $search;
    }

    public function collection()
    {
        $query = IndustryMasterData::where('user_id', $this->userId);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('insured_company_id', 'like', "%{$this->search}%")
                  ->orWhere('policy_number', 'like', "%{$this->search}%")
                  ->orWhere('name_of_insured_owner', 'like', "%{$this->search}%");
            });
        }

        return $query->get(['insured_company_id', 'policy_number', 'name_of_insured_owner', 'business_type', 'created_at']);
    }

    public function headings(): array
    {
        return ['Company Name', 'Policy Number', 'Owner Name', 'Business Type', 'Date'];
    }
}