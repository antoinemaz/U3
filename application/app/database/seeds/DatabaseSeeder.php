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
		Etat::create(array('libelle' => 'Envoyée'));
		Etat::create(array('libelle' => 'Validée'));
		Etat::create(array('libelle' => 'A revoir'));
		Etat::create(array('libelle' => 'Refusée'));

		Utilisateur::create(array(
			'email' => 'admin@admin.fr',
			'password' => Hash::make('aaaaaa'),
			'active' => 1,
			'role_id' => 2));
	}
}
