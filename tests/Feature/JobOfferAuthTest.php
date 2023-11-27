<?php

namespace Tests\Feature;

use App\ModelFactories\JobOfferFactory;
use App\ModelFactories\UserFactory;
use App\Models\JobOffer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class JobOfferAuthTest extends TestCase
{
    use RefreshDatabase;
    /*
        Create
    */
    public function test_guest_cannot_view_job_offer_create_form()
    {
        // Arrange
        Auth::logout();

        //Act
        $response = $this->get(route('jobOffer.create'));

        // Assert
        $response->assertRedirect(route('auth.loginForm'));
    }

    public function test_user_can_view_job_offer_create_form() 
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        //Act
        $response = $this->get(route('jobOffer.create'));

        // Assert
        $response->assertOk();
        $response->assertViewIs('jobOffer.create');
    }

    /*
        Store
    */
    public function test_guest_cannot_store_job_offer()
    {
        // Arrange
        Auth::logout();

        //Act
        $response = $this->post(route('jobOffer.store'));

        // Assert
        $response->assertRedirect(route('auth.loginForm'));
        $this->assertCount(0, JobOffer::all());
    }
    public function test_user_can_store_job_offer()
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        //Act
        $response = $this->post(route('jobOffer.store', [
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION
        ]));

        // Assert
        $this->assertCount(1, JobOffer::all());
    }

    /*
        Edit
    */
    public function test_creator_of_the_offer_can_view_edit_form_of_this_offer() 
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $jobOffer = JobOffer::create([
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION,
            'user_id' => $user->id
        ]);

        // Act
        $response = $this->get(route('jobOffer.edit', $jobOffer->id));

        // Assert
        $response->assertViewIs('jobOffer.edit');
        $response->assertSee($jobOffer->name);
        $response->assertSee($jobOffer->description);
    }

    public function test_users_cannot_view_edit_form_of_not_their_offers() 
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        
        $jobOffer = JobOffer::create([
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION,
            'user_id' => 123
        ]);


        // Act
        $response = $this->get(route('jobOffer.edit', $jobOffer->id));

        // Assert
        $response->assertUnauthorized();
    }

    public function test_guest_cannot_view_edit_form_of_any_offer() 
    {
        // Arrange
        Auth::logout();
        
        $jobOffer = JobOffer::create([
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION,
            'user_id' => 123
        ]);


        // Act
        $response = $this->get(route('jobOffer.edit', $jobOffer->id));

        // Assert
        $response->assertRedirect(route('auth.loginForm'));
    }

    /*
        Update
    */
    public function test_creator_of_the_offer_can_update_job_offer() 
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $jobOffer = JobOffer::create([
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION,
            'user_id' => $user->id
        ]);

        // Act
        $response = $this->put(route('jobOffer.update', $jobOffer->id), [
            'name' => 'NewName',
            'description' => 'NewDescription'
        ]);

        // Assert
        $this->assertEquals('NewName', JobOffer::first()->name);
        $this->assertEquals('NewDescription', JobOffer::first()->description);
    }

    public function test_other_users_cannot_update_their_job_offer() 
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        
        $jobOffer = JobOffer::create([
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION,
            'user_id' => 123
        ]);


        // Act
        $response = $this->put(route('jobOffer.update', $jobOffer->id), [
            'name' => 'NewName',
            'description' => 'NewDescription'
        ]);

        // Assert
        $response->assertUnauthorized();
    }

    public function test_guest_cannot_update_job_offer() 
    {
        // Arrange
        Auth::logout();
        
        $jobOffer = JobOffer::create([
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION,
            'user_id' => 123
        ]);


        // Act
        $response = $this->put(route('jobOffer.update', $jobOffer->id), [
            'name' => 'NewName',
            'description' => 'NewDescription'
        ]);

        // Assert
        $response->assertRedirect(route('auth.loginForm'));
    }

    /*
        Delete
    */
    public function test_creator_of_the_offer_can_delete_their_job_offer() 
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $jobOffer = JobOffer::create([
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION,
            'user_id' => $user->id
        ]);

        // Act
        $response = $this->delete(route('jobOffer.destroy', $jobOffer->id));

        // Assert
        $this->assertCount(0, JobOffer::all());
    }

    public function test_other_users_cannot_delete_job_offer() 
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $jobOffer = JobOffer::create([
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION,
            'user_id' => 123
        ]);

        // Act
        $response = $this->delete(route('jobOffer.destroy', $jobOffer->id));

        // Assert
        $response->assertUnauthorized();
    }
    public function test_guest_cannot_cannot_update_job_offer() 
    {
        // Arrange
        Auth::logout();
        
        $jobOffer = JobOffer::create([
            'name' => JobOfferFactory::DEFAULT_NAME,
            'description' => JobOfferFactory::DEFAULT_DESCRIPTION,
            'user_id' => 123
        ]);


        // Act
        $response = $this->delete(route('jobOffer.destroy', $jobOffer->id));

        // Assert
        $response->assertRedirect(route('auth.loginForm'));
    }
}
