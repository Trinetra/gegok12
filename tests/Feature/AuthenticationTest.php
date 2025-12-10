<?php
/**
 * SPDX-License-Identifier: MIT
 * (c) 2025 GegoSoft Technologies and GegoK12 Contributors
 */

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup test fixtures
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Seed or create necessary base data
    }

    /**
     * Test School Admin Can Login
     */
    public function test_school_admin_can_login(): void
    {
        // Create a school
        $school = School::factory()->create();

        // Create a school admin user
        $schoolAdmin = User::factory()
            ->schoolAdmin()
            ->for($school)
            ->create([
                'email' => 'admin@school.com',
                'password' => bcrypt('password123'),
            ]);

        // Attempt login
        $response = $this->post('/login', [
            'email' => 'admin@school.com',
            'password' => 'password123',
        ]);

        // Assert successful login
        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($schoolAdmin);
    }

    /**
     * Test School Librarian Can Login
     */
    public function test_school_librarian_can_login(): void
    {
        // Create a school
        $school = School::factory()->create();

        // Create a librarian user
        $librarian = User::factory()
            ->librarian()
            ->for($school)
            ->create([
                'email' => 'librarian@school.com',
                'password' => bcrypt('password123'),
            ]);

        // Attempt login
        $response = $this->post('/login', [
            'email' => 'librarian@school.com',
            'password' => 'password123',
        ]);

        // Assert successful login
        $response->assertRedirect('/library/dashboard');
        $this->assertAuthenticatedAs($librarian);
    }

    /**
     * Test Student Can Login
     */
    public function test_student_can_login(): void
    {
        // Create a school
        $school = School::factory()->create();

        // Create a student user
        $student = User::factory()
            ->student()
            ->for($school)
            ->create([
                'email' => 'student@school.com',
                'password' => bcrypt('password123'),
            ]);

        // Attempt login
        $response = $this->post('/login', [
            'email' => 'student@school.com',
            'password' => 'password123',
        ]);

        // Assert successful login
        $response->assertRedirect('/student/dashboard');
        $this->assertAuthenticatedAs($student);
    }

    /**
     * Test Teacher Can Login
     */
    public function test_teacher_can_login(): void
    {
        // Create a school
        $school = School::factory()->create();

        // Create a teacher user
        $teacher = User::factory()
            ->teacher()
            ->for($school)
            ->create([
                'email' => 'teacher@school.com',
                'password' => bcrypt('password123'),
            ]);

        // Attempt login
        $response = $this->post('/login', [
            'email' => 'teacher@school.com',
            'password' => 'password123',
        ]);

        // Assert successful login
        $response->assertRedirect('/teacher/dashboard');
        $this->assertAuthenticatedAs($teacher);
    }

    /**
     * Test Accountant Can Login
     */
    public function test_accountant_can_login(): void
    {
        // Create a school
        $school = School::factory()->create();

        // Create an accountant user
        $accountant = User::factory()
            ->accountant()
            ->for($school)
            ->create([
                'email' => 'accountant@school.com',
                'password' => bcrypt('password123'),
            ]);

        // Attempt login
        $response = $this->post('/login', [
            'email' => 'accountant@school.com',
            'password' => 'password123',
        ]);

        // Assert successful login
        $response->assertRedirect('/accountant/dashboard');
        $this->assertAuthenticatedAs($accountant);
    }

    /**
     * Test login with invalid credentials
     */
    public function test_login_fails_with_invalid_credentials(): void
    {
        $school = School::factory()->create();

        User::factory()
            ->schoolAdmin()
            ->for($school)
            ->create([
                'email' => 'admin@school.com',
                'password' => bcrypt('password123'),
            ]);

        $response = $this->post('/login', [
            'email' => 'admin@school.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /**
     * Test login fails with non-existent user
     */
    public function test_login_fails_with_non_existent_user(): void
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@school.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
