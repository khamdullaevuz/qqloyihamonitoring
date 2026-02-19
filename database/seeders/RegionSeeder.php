<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = Storage::disk('local')->get('regions.json');

        $data = json_decode($file, true);

        $regions   = $data['regions'];
        $districts = $data['districts'];

        foreach ($regions as $region) {
            $_region = Region::create(
                [
                    'id'   => uuid(),
                    'name' => $region['name'],
                ]
            );


            foreach ($districts as $district) {
                if ($district['region_id'] === $region['id']) {
                    $_region->districts()->create(
                        [
                            'id'   => uuid(),
                            'name' => $district['name'],
                        ]
                    );
                }
            }
        }
    }
}
