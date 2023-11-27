<?php

namespace Tests\Feature\jobOffer;

use App\ModelFactories\JobOfferDetailsFactory;
use App\ModelFactories\JobOfferFactory;
use App\ModelFactories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class JobOfferIndexViewTest extends TestCase
{
    use RefreshDatabase;
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
