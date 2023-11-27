<?php

namespace Tests\Feature;

use App\ModelFactories\JobOfferFactory;
use App\ModelFactories\UserFactory;
use App\Models\Requirement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RequirementManagementTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_assign_requirement_to_job_offer()
    {
        //Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(0);

        //Act
        $response = $this->post(route('requirement.store', $jobOffer), [
            'description' => 'My description'
        ]);

        // Assert 
        $response->assertRedirect(session()->previousUrl());
        $this->assertCount(1, Requirement::all());
        $this->assertCount(1, $jobOffer->requirements);
        $this->assertEquals("My description", $jobOffer->requirements->first()->description);
    }

    public function test_can_delete_requirement()
    {
        //Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues(0);
        $requirement = Requirement::create([
            'description' => 'My description', 
            'jobOffer_id' => $jobOffer
        ]);

        //Act
        $response = $this->delete(route('requirement.destroy', $requirement));

        // Assert 
        $response->assertRedirect(session()->previousUrl());
        $this->assertCount(0, $jobOffer->requirements);
    }

    public function test_can_delete_all_requirements_assigned_to_job_offer_on_its_delete()
    {
        //Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $jobOffer = JobOfferFactory::createWithDefaultValues($user->id);
        Requirement::create([
            'description' => 'My description', 
            'jobOffer_id' => $jobOffer->id
        ]);
        Requirement::create([
            'description' => 'My description2', 
            'jobOffer_id' => $jobOffer->id
        ]);

        // Act
        $response = $this->delete(route('jobOffer.destroy', $jobOffer));

        // Assert
        $this->assertCount(0, Requirement::all());
    }

    public function test_can_update_requirement() {
        // Arrange
        $requirement = Requirement::create([
            'description' => 'PHP',
            'jobOffer_id' => 0
        ]);

        // Act
        $response = $this->put(route('requirement.update', $requirement), [
            'description'=> 'Java'
        ]);

        // Assert
        $this->assertEquals('Java', Requirement::first()->description);

    }
}
