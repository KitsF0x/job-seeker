<?php

namespace Tests\Feature\application;

use App\ModelFactories\JobOfferFactory;
use App\ModelFactories\UserFactory;
use App\Models\Application;
use App\Models\JobOffer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ApplicationManagementTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_show_application_create_form()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        Auth::login(UserFactory::createWithDefaultValues());

        // Act
        $response = $this->get(route('application.create', $jobOffer));
    
        // Assert
        $response->assertViewIs('application.create');
        $response->assertSee(JobOfferFactory::DEFAULT_NAME);
    }

    public function test_can_store_application_for_offers()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        Auth::login(UserFactory::createWithDefaultValues());

        // Act
        $response = $this->post(route('application.store', $jobOffer));
    
        // Assert
        $this->assertCount(1, Application::all());
        $this->assertEquals($jobOffer->name, Application::first()->offer->name);
        $this->assertEquals(Auth::id(), Application::first()->user_id);
        $this->assertEquals($jobOffer->id, Application::first()->offer->id);
        $response->assertRedirect(route('application.index'));
    }

    public function test_the_user_can_see_the_list_of_offers_he_applied_for() 
    {
        // Arrange
        Auth::login(UserFactory::createWithDefaultValues());
        $offer = JobOfferFactory::createWithDefaultValues(123);
        $offer2 = JobOfferFactory::createWithDefaultValues(Auth::id());
        $offer2->name = "Junior tester";
        $offer2->save();

        Application::create([
            'user_id' => Auth::id(),
            'offer_id' => $offer2->id,
        ]);

        // Act
        $response = $this->get(route('application.index'));

        // Assert
        $response->assertViewIs('application.index');
        $response->assertSee($offer2->name);
    }

    public function test_user_cannot_view_application_create_form_for_already_applied_offer() 
    {
        //Arrange
        Auth::login(UserFactory::createWithDefaultValues());
        $offer = JobOfferFactory::createWithDefaultValues(123);
        Application::create([
            'user_id' => Auth::id(),
            'offer_id' => $offer->id
        ]);

        // Act
        $response = $this->get(route('application.create', $offer));

        // Assert
        $response->assertForbidden();
    }
    
    public function test_user_cannot_reapply_for_already_applied_offer() 
    {
        //Arrange
        Auth::login(UserFactory::createWithDefaultValues());
        $offer = JobOfferFactory::createWithDefaultValues(123);
        Application::create([
            'user_id' => Auth::id(),
            'offer_id' => $offer->id
        ]);

        // Act
        $response = $this->get(route('application.create', $offer));

        // Assert
        $response->assertForbidden();
    }
}
