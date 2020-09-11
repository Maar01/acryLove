<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('f_users')->insert([
            ['email' => 'lic.RaulPrieto90@outlook.com', 'email_password' => 'SociedadCivil30', 'f_password' => 'SociedadCivil30', 'f_profile_name'=> 'Raul Gonzalez'],
            ['email' => 'lareynadelsurynorte1992@gmail.com', 'email_password' => 'SantaANA_1', 'f_password' => 'SantaANA_1', 'f_profile_name'=>'Regina Reynoza'],
            ['email' => "lazonasafari@outlook.com", 'email_password' => 'SociedadCivil_2', 'f_password' => 'SociedadCivil_2', 'f_profile_name'=> 'Jesica Lozano'],
            ['email' => 'belindanais87@outlook.com', 'email_password' => 'SociedadCivil_3', 'f_password' => 'SociedadCivil_3', 'f_profile_name'=> 'Belinda Lopez Alcala'],
            ['email' => 'aguasdesabores958@gmail.com', 'email_password' => 'SociedadCivil_4', 'f_password' => 'SociedadCivil_4', 'f_profile_name'=> 'Karla Herrera'],
            ['email' => 'dulcevenganza20202020@outlook.com', 'email_password' => 'SociedadCivil_5', 'f_password' => 'SociedadCivil_5', 'f_profile_name'=> 'Noma Martha Stalin'],
            ['email' => 'labolsadevalores239@gmail.com', 'email_password' => 'SociedadCivil_6', 'f_password' => 'SociedadCivil_6', 'f_profile_name'=> 'Roberta Fernandez'],
            ['email' => 'mariomendozayasociados@gmail.com', 'email_password' => 'SociedadCivil_7', 'f_password' => 'SociedadCivil_7', 'f_profile_name'=> 'Melisa Amezcua'],
            ['email' => 'latiendadearroz@gmail.com', 'email_password' => 'SociedadCivil_8',	'f_password' => 'SociedadCivil_8',	'f_profile_name'=> 'Mary Morales']
        ]);
    }
}
