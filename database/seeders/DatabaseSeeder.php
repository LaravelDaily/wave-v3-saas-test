<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Wave\Facades\Wave;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ChangelogsTableSeeder::class);
        $this->call(ApiKeysTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(ProfileKeyValuesTableSeeder::class);
        $this->call(ThemesTableSeeder::class);
        fixPostgresSequence();
    }
}

if (!function_exists('fixPostgresSequence')) {

    function fixPostgresSequence()
    {
        if (config('database.default') === 'pgsql') {
            $tables = \DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = \'public\' ORDER BY table_name;');
            foreach ($tables as $table) {
                if (\Schema::hasColumn($table->table_name, 'id')) {
                    $seq = \DB::table($table->table_name)->max('id') + 1;
                    \DB::select('SELECT setval(pg_get_serial_sequence(\'' . $table->table_name . '\', \'id\'), coalesce(' . $seq . ',1), false) FROM ' . $table->table_name);
                }
            }
        }
    }
}