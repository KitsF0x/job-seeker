<?php

namespace Tests\Feature;

use App\ModelFactories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_display_login_form_page()
    {
        // Act
        $response = $this->get(route('auth.loginForm'));

        // Assert
        $response->assertOk();
        $response->assertViewIs('auth.login');
    }
    public function test_can_login_user_when_inputs_from_login_form_are_valid()
    {
        //Arrange
        UserFactory::createWithDefaultValues();

        // Act
        $response = $this->post(route('auth.login'), [
            'email' => UserFactory::DEFAULT_EMAIL,
            'password' => UserFactory::DEFAULT_PASSWORD
        ]);

        // Assert
        $this->assertAuthenticated();
    }
    public function test_cannot_login_user_when_password_is_incorrect()
    {
        //Arrange
        UserFactory::createWithDefaultValues();

        // Act
        $response = $this->post(route('auth.login'), [
            'email' => UserFactory::DEFAULT_NAME,
            'password' => UserFactory::DEFAULT_PASSWORD . "asdf"
        ]);

        // Assert
        $this->assertGuest();
    }

    public function test_can_logout_user() {
        // Arrange
        UserFactory::createWithDefaultValues();

        // Act
        $this->delete(route('auth.logout'));

        // Assert
        $this->assertGuest();

    }
}
