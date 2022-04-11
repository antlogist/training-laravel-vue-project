<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Map;

class MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maps = [
            [
                'title' => 'Test Map',
                'slug' => 'test-map',
                'tiles' => json_encode([
                        [
                            '0-0' => [0, 0, '', '']
                        ],
                        (object)[],
                        (object)[]
                    ],
                ),
                'user_id' => 1
              ],
            ];

            foreach($maps as $map) {
                Map::create( $map );
            }


    }
}
