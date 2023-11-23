<?php

namespace Tests\Feature;

use App\ModelFactories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;
    public function test_when_user_is_logged_in_should_display_logout_and_profile_links()
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        // Act
        $response = $this->get(route('home'));

        // Assert
        $this->assertAuthenticated();
        $response->assertSee('Logout');
        $response->assertSee(UserFactory::DEFAULT_NAME);
    }

    public function test_when_user_is_logged_in_should_display_login_and_register_links()
    {
        //Arrange
        Auth::logout();   
        
        // Act
        $response = $this->get(route('home'));
    
        // Assert
        $this->assertGuest();
        $response->assertSee('Log in');
        $response->assertSee('Register');
    }
}
