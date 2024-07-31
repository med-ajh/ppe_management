<?php
use Illuminate\Database\Seeder;
use App\Models\CostCenter;

class CostCentersTableSeeder extends Seeder
{
    public function run()
    {
        CostCenter::insert([
            ['name' => 'CC-001'],
            ['name' => 'CC-002'],
            ['name' => 'CC-003'],
        ]);
    }
}
