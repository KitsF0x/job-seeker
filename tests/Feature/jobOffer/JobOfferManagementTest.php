<?php

namespace Tests\Feature;

use App\ModelFactories\JobOfferDetailsFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\JobOffer;
use App\ModelFactories\JobOfferFactory;
use App\ModelFactories\UserFactory;
use App\Models\JobOfferDetails;
use Illuminate\Support\Facades\Auth;

class JobOfferManagementTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_show_list_of_offers()
    {
        // Arrange
        JobOfferFactory::createWithDefaultValues(1);

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('jobOffer.index');
        $response->assertSee(JobOfferFactory::DEFAULT_NAME);
        $response->assertSee(JobOfferFactory::DEFAULT_DESCRIPTION);
    }

    public function test_can_display_offer_create_form()
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        // Act
        $response = $this->get(route('jobOffer.create'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('jobOffer.create');
    }

    public function test_can_store_new_offer()
    {
        //Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        // Act
        $response = $this->post(route('jobOffer.store'), [
            'name' => 'Junior PHP Developer',
            'description' => 'We are looking for junior PHP Developer'
        ]);

        // Assert
        $response->assertRedirect();
        $this->assertCount(1, JobOffer::all());
    }

    public function test_can_show_offer_details()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(1);

        // Act
        $response = $this->get(route('jobOffer.show', $jobOffer));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('jobOffer.show');
        $response->assertSee(JobOfferFactory::DEFAULT_NAME);
        $response->assertSee(JobOfferFactory::DEFAULT_DESCRIPTION);
    }

    public function test_can_show_offer_edit_form()
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        $jobOffer = JobOfferFactory::createWithDefaultValues($user->id);

        // Act
        $response = $this->get(route('jobOffer.edit', $jobOffer));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('jobOffer.edit');
        $response->assertSee(JobOfferFactory::DEFAULT_NAME);
        $response->assertSee(JobOfferFactory::DEFAULT_DESCRIPTION);
    }

    public function test_can_update_offer()
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $jobOffer = JobOfferFactory::createWithDefaultValues($user->id);

        $newName = 'Junior Java Developer';
        $newDescription = 'We are looking for junior Java Developers';

        $updatedData = ['name' => $newName, 'description' => $newDescription];

        // Act
        $response = $this->put(route('jobOffer.update', $jobOffer), $updatedData);

        // Assert
        $response->assertRedirect(route('jobOffer.show', $jobOffer));
        $this->assertEquals($newName, JobOffer::first()->name);
        $this->assertEquals($newDescription, JobOffer::first()->description);
    }

    public function test_can_destroy_offer()
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $jobOffer = JobOfferFactory::createWithDefaultValues($user->id);

        // Act
        $response = $this->delete(route('jobOffer.destroy', $jobOffer));

        // Assert
        $response->assertRedirect(route('jobOffer.index'));
        $this->assertDatabaseMissing('job_offers', ['id' => $jobOffer]);
    }
}
