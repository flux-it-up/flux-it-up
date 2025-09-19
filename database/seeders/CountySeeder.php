<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\County;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $counties = [
            ['state_id' => 4, 'name' => 'Arkansas', 'code' => '01-00', 'tax_rate' => 1],
            ['state_id' => 4, 'name' => 'Ashley', 'code' => '02-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Baxter', 'code' => '03-00', 'tax_rate' => 1.25],
            ['state_id' => 4, 'name' => 'Benton', 'code' => '04-00', 'tax_rate' => 1],
            ['state_id' => 4, 'name' => 'Boone', 'code' => '05-00', 'tax_rate' => 1.25],
            ['state_id' => 4, 'name' => 'Bradley', 'code' => '06-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Calhoun', 'code' => '07-00', 'tax_rate' => 2.625],
            ['state_id' => 4, 'name' => 'Carroll', 'code' => '08-00', 'tax_rate' => 0.5],
            ['state_id' => 4, 'name' => 'Chicot', 'code' => '09-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Clark', 'code' => '10-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Clay', 'code' => '11-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Cleburne', 'code' => '12-00', 'tax_rate' => 1.625],
            ['state_id' => 4, 'name' => 'Cleveland', 'code' => '13-00', 'tax_rate' => 3.25],
            ['state_id' => 4, 'name' => 'Columbia', 'code' => '14-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Conway', 'code' => '15-00', 'tax_rate' => 1.75],
            ['state_id' => 4, 'name' => 'Craighead', 'code' => '16-00', 'tax_rate' => 1],
            ['state_id' => 4, 'name' => 'Crawford', 'code' => '17-00', 'tax_rate' => 1.25],
            ['state_id' => 4, 'name' => 'Crittenden', 'code' => '18-00', 'tax_rate' => 1.75],
            ['state_id' => 4, 'name' => 'Cross', 'code' => '19-00', 'tax_rate' => 3],
            ['state_id' => 4, 'name' => 'Dallas', 'code' => '20-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Desha', 'code' => '21-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Drew', 'code' => '22-00', 'tax_rate' => 2.25],
            ['state_id' => 4, 'name' => 'Faulkner', 'code' => '23-00', 'tax_rate' => 0.5],
            ['state_id' => 4, 'name' => 'Franklin', 'code' => '24-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Fulton', 'code' => '25-00', 'tax_rate' => 3],
            ['state_id' => 4, 'name' => 'Garland', 'code' => '26-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Grant', 'code' => '27-00', 'tax_rate' => 1.25],
            ['state_id' => 4, 'name' => 'Greene', 'code' => '28-00', 'tax_rate' => 1.375],
            ['state_id' => 4, 'name' => 'Hempstead', 'code' => '29-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Hot Spring', 'code' => '30-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Howard', 'code' => '31-00', 'tax_rate' => 1.75],
            ['state_id' => 4, 'name' => 'Independence', 'code' => '32-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Izard', 'code' => '33-00', 'tax_rate' => 0.5],
            ['state_id' => 4, 'name' => 'Jackson', 'code' => '34-00', 'tax_rate' => 2.25],
            ['state_id' => 4, 'name' => 'Jefferson', 'code' => '35-00', 'tax_rate' => 1.25],
            ['state_id' => 4, 'name' => 'Johnson', 'code' => '36-00', 'tax_rate' => 1],
            ['state_id' => 4, 'name' => 'Lafayette', 'code' => '37-00', 'tax_rate' => 2.25],
            ['state_id' => 4, 'name' => 'Lawrence', 'code' => '38-00', 'tax_rate' => 2.5],
            ['state_id' => 4, 'name' => 'Lee', 'code' => '39-00', 'tax_rate' => 1],
            ['state_id' => 4, 'name' => 'Lincoln', 'code' => '40-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Little River', 'code' => '41-00', 'tax_rate' => 2.875],
            ['state_id' => 4, 'name' => 'Logan', 'code' => '42-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Lonoke', 'code' => '43-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Madison', 'code' => '44-00', 'tax_rate' => 3.5],
            ['state_id' => 4, 'name' => 'Marion', 'code' => '45-00', 'tax_rate' => 1.75],
            ['state_id' => 4, 'name' => 'Miller', 'code' => '46-00', 'tax_rate' => 1.25],
            ['state_id' => 4, 'name' => 'Mississippi', 'code' => '47-00', 'tax_rate' => 2.5],
            ['state_id' => 4, 'name' => 'Monroe', 'code' => '48-00', 'tax_rate' => 0],
            ['state_id' => 4, 'name' => 'Montgomery', 'code' => '49-00', 'tax_rate' => 3],
            ['state_id' => 4, 'name' => 'Nevada', 'code' => '50-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Newton', 'code' => '51-00', 'tax_rate' => 1],
            ['state_id' => 4, 'name' => 'Ouachita', 'code' => '52-00', 'tax_rate' => 2.5],
            ['state_id' => 4, 'name' => 'Perry', 'code' => '53-00', 'tax_rate' => 2.75],
            ['state_id' => 4, 'name' => 'Phillips', 'code' => '54-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Pike', 'code' => '55-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Poinsett', 'code' => '56-00', 'tax_rate' => 1.75],
            ['state_id' => 4, 'name' => 'Polk', 'code' => '57-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Pope', 'code' => '58-00', 'tax_rate' => 1],
            ['state_id' => 4, 'name' => 'Prairie', 'code' => '59-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Pulaski', 'code' => '60-00', 'tax_rate' => 1],
            ['state_id' => 4, 'name' => 'Randolph', 'code' => '61-00', 'tax_rate' => 1.25],
            ['state_id' => 4, 'name' => 'Saline', 'code' => '62-00', 'tax_rate' => 0],
            ['state_id' => 4, 'name' => 'Scott', 'code' => '63-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Searcy', 'code' => '64-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Sebastian', 'code' => '65-00', 'tax_rate' => 1],
            ['state_id' => 4, 'name' => 'Sevier', 'code' => '66-00', 'tax_rate' => 3.125],
            ['state_id' => 4, 'name' => 'Sharp', 'code' => '67-00', 'tax_rate' => 1.75],
            ['state_id' => 4, 'name' => 'St. Francis', 'code' => '68-00', 'tax_rate' => 2.875],
            ['state_id' => 4, 'name' => 'Stone', 'code' => '69-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Union', 'code' => '70-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Van Buren', 'code' => '71-00', 'tax_rate' => 1.5],
            ['state_id' => 4, 'name' => 'Washington', 'code' => '72-00', 'tax_rate' => 1.25],
            ['state_id' => 4, 'name' => 'White', 'code' => '73-00', 'tax_rate' => 1.75],
            ['state_id' => 4, 'name' => 'Woodruff', 'code' => '74-00', 'tax_rate' => 2],
            ['state_id' => 4, 'name' => 'Yell', 'code' => '75-00', 'tax_rate' => 1.125],
        ];

        foreach ($counties as $county) {
            County::updateOrCreate(
                ['code' => $county['code']],
                ['state_id' => $county['state_id'], 'name' => $county['name'], 'tax_rate' => $county['tax_rate']]
            );
        }
    }
}
