<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {

        /*
         * 1. Créer un faux client (navigateur) de pointeur vers une URL
         * 2. Remplir les champs de mon formulaire
         * 3. Est-ce que tu peux regarder si dans ma page j'ai le message (alerte) suivante:
         * 'Votre compte est correctement crée, veuillez vous connecter.'
         */

        // 1.
        $client = static::createClient();
        $client->request('GET', '/inscription');

        // 2. (firstname, lastname, email, password, confirm password)
        // register_user[firstname]
        // register_user[lastname]
        // register_user[email]
        // register_user[plainPassword][first]
        // register_user[plainPassword][second]

        $client->submitForm('Valider', [
            'register_user[email]' => 'units@test.fr',
            'register_user[plainPassword][first]' => '12345678',
            'register_user[plainPassword][second]' => '12345678',
            'register_user[firstname]' => 'Julie',
            'register_user[lastname]' => 'Doe'
        ]);

        // Follow
        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();

        // 3.
        $this->assertSelectorExists("div:contains('Votre compte est correctement crée, veuillez vous connecter.')");


    }
}
