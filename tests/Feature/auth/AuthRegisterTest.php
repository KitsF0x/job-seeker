<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthRegisterTest extends TestCase
{
    const FORM_DATA = [
        'name' => 'John',
        'email' => 'john.doe@example.com',
        'password' => 'pass12345',
        'password-repeat' => 'pass12345',
    ];
    use RefreshDatabase;
    public function test_can_display_register_form_page()
    {
        // Act
        $response = $this->get(route('auth.registerForm'));

        // Assert
        $response->assertOk();
        $response->assertViewIs('auth.register');
    }

    public function test_can_create_user_when_inputs_from_register_form_are_valid()
    {
        // Act
        $this->post(route('auth.register'), self::FORM_DATA);

        // Assert
        $this->assertCount(1, User::all());
    }

    public function test_should_redirect_to_home_after_user_registration()
    {
        // Act
        $response = $this->post(route('auth.register'), self::FORM_DATA);

        // Assert
        $response->assertRedirect(route('home'));
    }

    public function test_should_login_new_user_after_successful_registration()
    {
        // Act
        $response = $this->post(route('auth.register'), self::FORM_DATA);

        // Assert
        $this->assertAuthenticated();
    }

    public function test_cannot_create_new_user_when_name_is_empty()
    {
        // Arrange
        $formData = self::FORM_DATA;
        $formData['name'] = '';

        // Act
        $response = $this->post(route('auth.register'), $formData);

        // Assert
        $response->assertSessionHasErrors('name');
    }

    public function test_cannot_create_new_user_when_email_is_empty()
    {
        // Arrange
        $formData = self::FORM_DATA;
        $formData['email'] = '';

        // Act
        $response = $this->post(route('auth.register'), $formData);

        // Assert
        $response->assertSessionHasErrors('email');
    }
    
    public function test_cannot_create_new_user_when_email_is_not_valid_empty()
    {
        // Arrange
        $formData = self::FORM_DATA;
        $formData['email'] = 'asdf';

        // Act
        $response = $this->post(route('auth.register'), $formData);

        // Assert
        $response->assertSessionHasErrors('email');
    }

    public function test_cannot_create_new_user_when_password_has_less_than_5_chars()
    {
        $formData = self::FORM_DATA;
        $formData['password'] = '1234';
        $formData['password-repeat'] = '1234';

        // Act
        $response = $this->post(route('auth.register'), $formData);

        // Assert
        $response->assertSessionHasErrors('password');
    }

    public function test_can_create_new_user_when_password_has_more_than_5_chars()
    {
        // Act
        $response = $this->post(route('auth.register'), self::FORM_DATA);

        // Assert
        $this->assertCount(1, User::all());
    }

    public function test_cannot_create_new_user_when_repeat_password_is_invalid()
    {
        // Arrange
        $formData = self::FORM_DATA;
        $formData['password-repeat'] = 'abcde';

        // Act
        $response = $this->post(route('auth.register'), $formData);

        // Assert
        $response->assertSessionHasErrors('password-repeat');
    }
}
