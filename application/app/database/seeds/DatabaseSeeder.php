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
		Role::create(array('libelle' => 'Administrateur'));

		Etat::create(array('libelle' => 'Brouillon'));
		Etat::create(array('libelle' => 'Envoyée'));
		Etat::create(array('libelle' => 'Validée'));
		Etat::create(array('libelle' => 'A revoir'));
		Etat::create(array('libelle' => 'Refusée'));

		Utilisateur::create(array(
			'email' => 'admin@admin.fr',
			'password' => Hash::make('aaaaaa'),
			'active' => 1,
			'role_id' => 3));
	
		Configuration::create(array(
			'libelle' => 'sendMailsToGestionnaires',
			'active' => true,
			'date_debut_periode' => '2015-01-01',
			'date_fin_periode' => '2015-12-31'
			));
	}
}
