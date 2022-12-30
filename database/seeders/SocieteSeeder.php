<?php

namespace Database\Seeders;

use App\Models\Societe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocieteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $societe = [
            'name' => 'OpenData-Madagascar',
            'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac urna in odio consectetur rhoncus sed vitae lectus. In nec lorem nulla. Fusce velit massa, ultrices quis leo vitae, malesuada pulvinar lorem. Mauris venenatis congue lacinia. Etiam luctus eu libero a lobortis. Donec nibh dui, fermentum non metus id, laoreet finibus nisl. Sed maximus dolor at nisl condimentum vehicula. Pellentesque facilisis dapibus justo pulvinar sollicitudin. Integer nec scelerisque mi. Suspendisse tincidunt laoreet lorem egestas tempus. Fusce fringilla venenatis vulputate.

            Etiam auctor dictum mi, id bibendum lacus mattis quis. Sed sodales faucibus neque, nec cursus dolor euismod at. Sed sodales turpis non tellus ultrices aliquet. Morbi hendrerit risus nec ligula mattis blandit. Sed mauris dui, euismod sed orci auctor, sollicitudin faucibus ex. Maecenas et sagittis odio. Sed pulvinar urna sit amet nisi sodales, in efficitur metus luctus. Integer ut odio sem.

            Suspendisse cursus consectetur elit. Sed pretium malesuada ante, at suscipit diam ultrices quis. Proin ante neque, iaculis in fermentum id, facilisis fermentum ante. Suspendisse id finibus nibh. Pellentesque viverra nisl lacus. Integer interdum ultrices enim condimentum ornare. Ut quis pellentesque est. Curabitur ut facilisis enim, eget dignissim ipsum. Aenean lorem enim, vestibulum nec maximus vel, rhoncus ac arcu. Mauris pellentesque condimentum eros a volutpat.',
            'adresse' => '0120 B 282 IVORY',
            'NIF' => 3000693200,
            'STAT' => random_int(0000000000, 9999999999),
            'tel' => '+261 34 08 728 10',
            'email' => 'opendata.m@gmail.com'
        ];

        Societe::create($societe);
    }
}
