<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            QuartersSeeder::class,
            HewanSeeder::class,
            PopulasiHewanSeeder::class,
            RolesSeeder::class,
            PermissionsSeeder::class,
            PermissionRoleSeeder::class,
            RoleUserSeeder::class,
            TanamanSeeder::class,
            JumlahTanamanSeeder::class,
            OrganismePenggangguSeeder::class,
            KelompokTaniSeeder::class,
        ]);
    }
}
