<?php

namespace Tests\Feature;

use App\ModelFactories\UserFactory;
use App\Models\PersonDetails;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PersonDetailsTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_can_create_person_details_when_the_current_user_does_not_have_one() {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        // Act
        $response = $this->put(route('personDetails.update'));

        // Assert
        $response->assertRedirect(session()->previousUrl());
        $this->assertCount(1, PersonDetails::all());
        $this->assertEquals($user->id, PersonDetails::first()->user_id);
    }

    public function test_can_update_person_details_when_the_current_user_has_one() {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);
        $details = PersonDetails::create([
            'name' => 'John',
            'surname' => 'Smith',
            'day_of_birth' => '23-11-1998',
            'country' => 'Poland',
            'city' => 'Lublin',
            'phone_number' => '123456789',
            'email' => 'john@example.com',
            'user_id' => $user->id,
        ]);

        // Act
        $response = $this->put(route('personDetails.update'));

        // Assert
        $response->assertRedirect(session()->previousUrl());
        $this->assertCount(1, PersonDetails::all());
        $this->assertEquals($details->name, $user->personDetails->name);
        $this->assertEquals($details->surname, $user->personDetails->surname);
        $this->assertEquals($details->day_of_birth, $user->personDetails->day_of_birth);
        $this->assertEquals($details->country, $user->personDetails->country);
        $this->assertEquals($details->city, $user->personDetails->city);
        $this->assertEquals($details->phone_number, $user->personDetails->phone_number);
        $this->assertEquals($details->email, $user->personDetails->email);
        $this->assertEquals($user->id, PersonDetails::first()->user_id);
    }

    public function test_can_display_values_from_person_details_of_current_user() {
        // Arrange
        $user = UserFactory::createWithDefaultValues();
        Auth::login($user);

        $details = PersonDetails::create([
            'name' => 'John',
            'surname' => 'Smith',
            'day_of_birth' => '23-11-1998',
            'country' => 'Poland',
            'city' => 'Lublin',
            'phone_number' => '123456789',
            'email' => 'john@example.com',
            'user_id' => $user->id,
        ]);

        // Act
        $response = $this->get(route('auth.edit'));

        // Assert
        $response->assertViewIs('auth.edit');
        $response->assertSee($details->name);
        $response->assertSee($details->surname);
        $response->assertSee($details->day_of_birth);
        $response->assertSee($details->country);
        $response->assertSee($details->city);
        $response->assertSee($details->phone_number);
        $response->assertSee($details->email);
    }
}
