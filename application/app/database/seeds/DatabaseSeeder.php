<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		Role::create(array('libelle' => 'Etudiant'));
		Role::create(array('libelle' => 'Gestionnaire'));

		Etat::create(array('libelle' => 'Brouillon'));
		Etat::create(array('libelle' => 'Validé'));
		Etat::create(array('libelle' => 'Refusé'));

	}

}
