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

    public function test_creator_of_the_offer_can_see_edit_button_of_theirs_offers_in_index_view() 
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $jobOffer = JobOfferFactory::createWithDefaultValues($user->id);

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertSee('edit');
    }

    public function test_other_users_cannot_see_edit_button_of_others_offers_in_index_view() 
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $jobOffer = JobOfferFactory::createWithDefaultValues(321);

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertDontSee('edit');
    }

    public function test_cannot_see_days_counter_when_start_date_of_offer_is_null() 
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        $jobOfferDetails = JobOfferDetailsFactory::createWithDefaultValues($jobOffer->id);
        $jobOfferDetails->start_date = null;
        $jobOfferDetails->save();

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertDontSee('Days to offer end');
        $this->assertNull($jobOfferDetails->start_date);
        $this->assertNotNull($jobOfferDetails->end_date);
    }

    public function test_cannot_see_days_counter_when_end_date_of_offer_is_null() 
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        $jobOfferDetails = JobOfferDetailsFactory::createWithDefaultValues($jobOffer->id);
        $jobOfferDetails->end_date = null;
        $jobOfferDetails->save();

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertDontSee('Days to offer end');
        $this->assertNotNull($jobOfferDetails->start_date);
        $this->assertNull($jobOfferDetails->end_date);
    }

    public function test_can_see_days_counter_when_start_date_and_end_date_are_not_null() 
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        $jobOfferDetails = JobOfferDetailsFactory::createWithDefaultValues($jobOffer->id);

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertSee('Days to offer end');
        $this->assertNotNull($jobOfferDetails->start_date);
        $this->assertNotNull($jobOfferDetails->end_date);
    }

    public function test_cannot_see_salary_when_lowest_salary_is_null()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        $jobOfferDetails = JobOfferDetailsFactory::createWithDefaultValues($jobOffer->id);
        $jobOfferDetails->lowest_salary = null;
        $jobOfferDetails->save();

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertDontSee(JobOfferDetailsFactory::DEFAULT_HIGHEST_SALARY);
    }

    public function test_cannot_see_salary_when_highest_salary_is_null()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        $jobOfferDetails = JobOfferDetailsFactory::createWithDefaultValues($jobOffer->id);
        $jobOfferDetails->highest_salary = null;
        $jobOfferDetails->save();

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertDontSee(JobOfferDetailsFactory::DEFAULT_LOWEST_SALARY);
    }
    public function test_cannot_see_salary_when_salary_type_is_null()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(123);
        $jobOfferDetails = JobOfferDetailsFactory::createWithDefaultValues($jobOffer->id);
        $jobOfferDetails->salary_type = null;
        $jobOfferDetails->save();

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertDontSee(JobOfferDetailsFactory::DEFAULT_LOWEST_SALARY);
        $response->assertDontSee(JobOfferDetailsFactory::DEFAULT_HIGHEST_SALARY);
    }
}
