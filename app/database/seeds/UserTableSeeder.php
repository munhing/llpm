<?php

use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker::create();

		$user = User::register(
			'Kevin Su',
			'kevin',
			'munhing1980@gmail.com', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(1);

		$user = User::register(
			'Violeta Binasbas', 
			'violeta', 
			'violy.coyoca@yahoo.com', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(1);

		$user = User::register(
			'Aileena', 
			'leena', 
			'ijalrico@yahoo.com', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(2);

		$user = User::register(
			'Mariani', 
			'mariani', 
			'airyn_arrishya@yahoo.com', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(2);

		$user = User::register(
			'Alina', 
			'alina', 
			'alinabibbiey@yahoo.com', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(2);

		$user = User::register(
			'Siti Normala', 
			'normala', 
			'syamirasyamira@yahoo.com', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(2);

		$user = User::register(
			'Saidah', 
			'saidah', 
			'saidah@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(2);

		$user = User::register(
			'Zuliha', 
			'zuliha', 
			'lia_harry57@yahoo.com', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(10);

		$user = User::register(
			'Noruizawani', 
			'wani', 
			'sw8ty_gurlz@yahoo.com', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(9);

		$user = User::register(
			'Mohamadun', 
			'mohamadun', 
			'mohamadun@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(6);

		$user = User::register(
			'Majai', 
			'majai', 
			'majai@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(6);

		$user = User::register(
			'Sulaiman', 
			'sulaiman', 
			'sulaiman@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(6);

		$user = User::register(
			'Dzulfikri', 
			'dzul', 
			'dzul@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(6);

		$user = User::register(
			'Supian', 
			'supian', 
			'supian@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(6);

		$user = User::register(
			'Senol', 
			'senol', 
			'senol@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(7);

		$user = User::register(
			'Fazli', 
			'fazli', 
			'fazli@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(7);

		$user = User::register(
			'Dzulqarnai', 
			'dzulqarnai', 
			'dzulqarnai@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(7);

		$user = User::register(
			'Gopala Khrisnan', 
			'gopala', 
			'gopala@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);

		$user = User::register(
			'Idris Ajih', 
			'idris', 
			'idris@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);

		$user = User::register(
			'Ak. Zakaria', 
			'zakaria', 
			'zakaria@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);

		$user = User::register(
			'Ramle Asmat', 
			'ramle', 
			'ramle@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);		

		$user = User::register(
			'Raimie', 
			'raimie', 
			'raimie@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(8);

		$user = User::register(
			'Abu Bakar', 
			'abu', 
			'abu@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);

		$user = User::register(
			'Jailani', 
			'jailani', 
			'jailani@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);

		$user = User::register(
			'Rahim', 
			'rahim', 
			'rahim@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);

		$user = User::register(
			'Polis Bantuan', 
			'polis', 
			'polis@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(5);

		$user = User::register(
			'Main Gate Officer', 
			'maingate', 
			'maingate@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(4);		
		// for($i=0; $i<30; $i++) {

		// 	$username = $faker->bothify('??#');

		// 	$user = User::register(
		// 		$faker->name,
		// 		$username,
		// 		$username . '@llpm.com.my',
		// 		'1234'
		// 	);

		// 	$user->save();
		// 	$user->roles()->attach($faker->randomElement([1, 2, 3, 4, 5, 6, 7]));
		// }

		// $user = User::create([
		// 	'id' => 100,
		// 	'username' => 'migration', 
		// 	'name' => 'Migration', 
		// 	'email' => 'migration@llpm.com.my', 
		// 	'password' => '1234'
		// ]);
		// $user->roles()->attach([1, 2, 3, 4, 5, 6, 7]);





	}
}