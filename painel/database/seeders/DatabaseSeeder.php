<?php

namespace Database\Seeders;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (Env('APP_ENV') == 'develop') {
            $this->DumpWebTestsSystemUsersTable();
        } else {
            $this->DumpSystemUsersTable();
        }

        $this->DumpConfigurationsTable();
    }

    private function DumpWebTestsSystemUsersTable()
    {
        $usuarioAdm = User::where('email', 'admin@admin')->first();
        if (!$usuarioAdm){
            DB::table('users')->insert([
                'id' => 1,
                'fullname' => 'admin',
                'name' => 'admin',
                'email' => 'admin@admin',
                'password' => Hash::make("admin"), 
                'activeted' => 1,
                'attempts_logins' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d  H:i:s")
            ]);
        }
    }

    private function DumpSystemUsersTable() 
    {

        $dumpUser = Env('adminUser');
        $dumpUserPwd = Env('adminPassword');

        $usuarioAdm = User::where('email', $dumpUser)->first();
        if (!$usuarioAdm){
            DB::table('users')->insert([
                'id' => 1,
                'fullname' => $dumpUser,
                'name' => $dumpUser,
                'email' => $dumpUser,
                'password' => Hash::make($dumpUserPwd), 
                'activeted' => 1,
                'attempts_logins' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d  H:i:s")
            ]);
        }
    }

    private function DumpConfigurationsTable() 
    {

        //Site title
        $config = Configuration::where('key', 'WEBSITE_TITLE')->first();
        if (!$config){
            DB::table('configuration')->insert([
                'id' => 1,
                'key' => 'WEBSITE_TITLE',
                'value' => 'Tudo Sobre Portugal',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d  H:i:s")
            ]);
        }

        //Site description
        $config = Configuration::where('key', 'WEBSITE_META_DESCRIPTION')->first();
        if (!$config){
            DB::table('configuration')->insert([
                'id' => 2,
                'key' => 'WEBSITE_META_DESCRIPTION',
                'value' => 'Tudo sobre Morar, Visitar ou Investir em Portugal, Nacionalidade Portuguesa, vistos de residência, documentação, custos de vida, como empreender.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d  H:i:s")
            ]);
        }

    }
}
