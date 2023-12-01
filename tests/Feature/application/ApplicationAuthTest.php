<?php

namespace Tests\Feature\application;

use App\ModelFactories\JobOfferFactory;
use App\ModelFactories\UserFactory;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ApplicationAuthTest extends TestCase
{
    use RefreshDatabase;
    /*
        Create
    */
    public function test_guest_cannot_view_application_create_form()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        Auth::logout();

        // Act
        $response = $this->get(route('application.create', $jobOffer));
    
        // Assert
        $response->assertRedirect(route('auth.loginForm'));
    }
    public function test_user_can_view_application_create_form()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        Auth::login(UserFactory::createWithDefaultValues());

        // Act
        $response = $this->get(route('application.create', $jobOffer));
    
        // Assert
        $response->assertViewIs('application.create');
    }
    public function test_offer_creator_cannot_view_application_create_form_of_their_own_offer()
    {
        // Arrange
        Auth::login(UserFactory::createWithDefaultValues());
        $jobOffer = JobOfferFactory::createWithDefaultValues(Auth::id());

        // Act
        $response = $this->get(route('application.create', $jobOffer));
    
        // Assert
        $response->assertForbidden();
    }

    /*
        Store
    */
    public function test_guest_cannot_store_application()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        Auth::logout();

        // Act
        $response = $this->post(route('application.store', $jobOffer));
    
        // Assert
        $response->assertRedirect(route('auth.loginForm'));
    }
    public function test_user_can_store_application()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        Auth::login(UserFactory::createWithDefaultValues());

        // Act
        $response = $this->post(route('application.store', $jobOffer));
    
        // Assert
        $this->assertCount(1, Application::all());
        $response->assertRedirect(route('application.index'));
    }

    public function test_offer_creator_cannot_store_application_for_their_own_offer()
    {
        // Arrange
        Auth::login(UserFactory::createWithDefaultValues());
        $jobOffer = JobOfferFactory::createWithDefaultValues(Auth::id());

        // Act
        $response = $this->post(route('application.store', $jobOffer));
    
        // Assert
        $response->assertForbidden();
    }

    /*
        Index
    */
    public function test_guest_cannot_view_application_index()
    {
        // Arrange
        Auth::logout();

        // Act
        $response = $this->get(route('application.index'));
    
        // Assert
        $response->assertRedirect(route('auth.loginForm'));
    }

    public function test_user_can_view_application_index()
    {
        // Arrange
        Auth::login(UserFactory::createWithDefaultValues());

        // Act
        $response = $this->get(route('application.index'));
    
        // Assert
        $response->assertViewIs('application.index');
    }

    /*
        Destroy
    */
    public function test_guest_cannot_delete_application()
    {
        // Arrange
        Auth::logout();
        $application = Application::create([
            'user_id' => 123,
            'offer_id' => 123
        ]);

        // Act
        $response = $this->delete(route('application.destroy', $application->id));
    
        // Assert
        $response->assertRedirect(route('auth.loginForm'));
    }

    public function test_application_creator_can_delete_application()
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        $application = Application::create([
            'user_id' => $user->id,
            'offer_id' => 123
        ]);

        // Act
        $response = $this->delete(route('application.destroy', $application->id));
    
        // Assert
        $response->assertRedirect(route('application.index'));
    }
    public function test_other_users_cannot_delete_not_their_applications()
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        $application = Application::create([
            'user_id' => 123,
            'offer_id' => 123
        ]);

        // Act
        $response = $this->delete(route('application.destroy', $application->id));
    
        // Assert
        $response->assertForbidden();
    }
}
