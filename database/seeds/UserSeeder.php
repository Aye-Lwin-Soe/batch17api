<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      $student= new User();//object
      $student->name="Aye Lwin Soe";
      $student->email="ayelwinsoe@gmail.com";
      $student->password=Hash::make('123456789');
      $student->save();
    }
}
