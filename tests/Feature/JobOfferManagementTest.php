<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\JobOffer;
use App\ModelFactories\JobOfferFactory;

class JobOfferManagementTest extends TestCase
{
    use RefreshDatabase;
    public function testIndex()
    {
        // Arrange
        JobOfferFactory::createWithDefaultValues();

        // Act
        $response = $this->get(route('jobOffer.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('jobOffer.index');
        $response->assertSee(JobOfferFactory::DEFAULT_NAME);
        $response->assertSee(JobOfferFactory::DEFAULT_DESCRIPTION);
    }

    public function testCreate()
    {
        // Act
        $response = $this->get(route('jobOffer.create'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('jobOffer.create');
    }

    public function testStore()
    {
        // Act
        $response = $this->post(route('jobOffer.store'), [
            'name' => 'Junior PHP Developer',
            'description' => 'We are looking for junior PHP Developer'
        ]);

        // Assert
        $response->assertRedirect();
        $this->assertCount(1, JobOffer::all());
    }

    public function testShow()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues();

        // Act
        $response = $this->get(route('jobOffer.show', $jobOffer));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('jobOffer.show');
        $response->assertSee(JobOfferFactory::DEFAULT_NAME);
        $response->assertSee(JobOfferFactory::DEFAULT_DESCRIPTION);
    }

    public function testEdit()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues();

        // Act
        $response = $this->get(route('jobOffer.edit', $jobOffer));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('jobOffer.edit');
        $response->assertSee(JobOfferFactory::DEFAULT_NAME);
        $response->assertSee(JobOfferFactory::DEFAULT_DESCRIPTION);
    }

    public function testUpdate()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues();

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

    public function testDestroy()
    {
        // Arrange
        $jobOffer = JobOfferFactory::createWithDefaultValues();

        // Act
        $response = $this->delete(route('jobOffer.destroy', $jobOffer));

        // Assert
        $response->assertRedirect(route('jobOffer.index'));
        $this->assertDatabaseMissing('job_offers', ['id' => $jobOffer]);
    }
}
