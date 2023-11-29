<?php

namespace Tests\Feature;

use App\ModelFactories\JobOfferDetailsFactory;
use App\ModelFactories\JobOfferFactory;
use App\ModelFactories\UserFactory;
use App\Models\JobOffer;
use App\Models\JobOfferDetails;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class JobOfferDetailsManagementTest extends TestCase
{
    use RefreshDatabase;
    public function test_when_called_update_and_details_are_not_assigned_to_offer_new_details_should_be_created()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(1);

        // Act
        $response = $this->put(route('jobOfferDetails.update', $jobOffer->id), [
            'jobOffer_id' => $jobOffer->id
        ]);

        // Assert
        $this->assertCount(1, JobOfferDetails::all());
        $this->assertEquals($jobOffer->id, JobOffer::first()->jobOfferDetails->id);
    }

    public function test_when_called_update_on_already_assigned_details_to_offer_details_should_be_updated()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(1);
        $details = JobOfferDetailsFactory::createWithDefaultValues($jobOffer->id);
        $details->lowest_salary = 2000;
        $details->save();

        // Act
        $this->put(route('jobOfferDetails.update', $jobOffer->id), [
            'lowest_salary' => 3000
        ]);

        // Assert
        $this->assertCount(1, JobOfferDetails::all());
        $this->assertEquals($jobOffer->id, JobOffer::first()->jobOfferDetails->id);
        $this->assertEquals(3000, JobOffer::first()->jobOfferDetails->lowest_salary);
    }

    public function test_can_display_days_to_offer_end_and_salary_info_in_job_offer_index_view()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(1);
        JobOfferDetailsFactory::create('19-01-2023', '29-01-2023', '1234', '5678', 'PLN', $jobOffer->id);

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertSee('10');
        $response->assertSee('1234');
        $response->assertSee('5678');
        $response->assertSee('PLN');
    }

    public function test_can_display_days_to_offer_end_and_salary_info_in_job_offer_show_view()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(1);
        $details = JobOfferDetailsFactory::createWithDefaultValues($jobOffer->id);

        // Act
        $response = $this->get(route('jobOffer.show', $jobOffer));

        // Assert
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_START_DATE);
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_END_DATE);
        $response->assertSee($jobOffer->daysToOfferEnd());
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_LOWEST_SALARY);
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_HIGHEST_SALARY);
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_SALARY_TYPE);
    }
    public function test_can_display_days_to_offer_end_and_salary_info_in_job_offer_edit_view()
    {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        $jobOffer = JobOfferFactory::createWithDefaultValues($user->id);
        $details = JobOfferDetailsFactory::createWithDefaultValues($jobOffer->id);

        // Act
        $response = $this->get(route('jobOffer.edit', $jobOffer));

        // Assert
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_START_DATE);
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_END_DATE);
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_LOWEST_SALARY);
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_HIGHEST_SALARY);
        $response->assertSee(JobOfferDetailsFactory::DEFAULT_SALARY_TYPE);
    }

    public function test_can_calculate_days_to_offer_end()
    {
        // Arrange
        $date = Carbon::today()->addDays(4);
        $jobOfferDetails = JobOfferDetailsFactory::createWithDefaultValues(0);
        $jobOfferDetails->end_date = $date;

        // Act
        $calculatedDays = $jobOfferDetails->daysToOfferEnd();

        // Assert
        $this->assertEquals(4, $calculatedDays);
    }

    public function test_can_return_empty_string_when_start_date_is_null()
    {
        // Arrange
        $jobOfferDetails = JobOfferDetailsFactory::createWithDefaultValues(0);
        $jobOfferDetails->start_date = null;

        // Act
        $calculatedDays = $jobOfferDetails->daysToOfferEnd();

        // Assert
        $this->assertEquals('', $calculatedDays);
    }
    public function test_can_return_empty_string_when_end_date_is_null()
    {
        // Arrange
        $jobOfferDetails = JobOfferDetailsFactory::createWithDefaultValues(0);
        $jobOfferDetails->end_date = null;

        // Act
        $calculatedDays = $jobOfferDetails->daysToOfferEnd();

        // Assert
        $this->assertEquals('', $calculatedDays);
    }
}
