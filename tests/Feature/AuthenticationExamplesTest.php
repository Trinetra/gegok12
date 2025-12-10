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

/**
 * Class AuthenticationExamplesTest
 *
 * This file demonstrates various testing patterns and examples
 * that you can use as a reference when writing your own tests.
 */
class AuthenticationExamplesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ============================================================
     * EXAMPLE 1: Basic Login Test
     * ============================================================
     *
     * This is the simplest form of authentication test.
     * It follows the Arrange-Act-Assert pattern.
     */
    public function test_example_basic_school_admin_login(): void
    {
        // ARRANGE: Create test data
        $school = School::factory()->create();
        $admin = User::factory()
            ->schoolAdmin()
            ->for($school)
            ->create([
                'email' => 'admin@example.com',
                'password' => bcrypt('password123'),
            ]);

        // ACT: Attempt to login
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        // ASSERT: Verify the results
        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    /**
     * ============================================================
     * EXAMPLE 2: Login with Custom Factory Data
     * ============================================================
     *
     * Shows how to create users with specific attributes
     * while still using factory states.
     */
    public function test_example_login_with_custom_data(): void
    {
        $school = School::factory()->create();

        $teacher = User::factory()
            ->teacher()
            ->for($school)
            ->create([
                'email' => 'john.doe@school.com',
                'name' => 'John Doe',
                'mobile_no' => '1234567890',
                'password' => bcrypt('secure_password'),
            ]);

        $response = $this->post('/login', [
            'email' => 'john.doe@school.com',
            'password' => 'secure_password',
        ]);

        $response->assertRedirect('/teacher/dashboard');
        $this->assertAuthenticatedAs($teacher);
    }

    /**
     * ============================================================
     * EXAMPLE 3: Testing Authentication via actingAs()
     * ============================================================
     *
     * Instead of posting to login, you can use actingAs()
     * to directly authenticate a user for testing protected routes.
     */
    public function test_example_authenticated_user_access_dashboard(): void
    {
        $school = School::factory()->create();
        $student = User::factory()->student()->for($school)->create();

        // This authenticates the user directly without posting to login
        $response = $this->actingAs($student)->get('/student/dashboard');

        // Verify the user is authenticated and can access the page
        $this->assertAuthenticatedAs($student);
        $response->assertStatus(200);
    }

    /**
     * ============================================================
     * EXAMPLE 4: Creating Multiple Test Users
     * ============================================================
     *
     * Shows how to create multiple users at once using factory count.
     */
    public function test_example_multiple_users_different_roles(): void
    {
        $school = School::factory()->create();

        // Create 3 students
        $students = User::factory(3)->student()->for($school)->create();

        // Create 2 teachers
        $teachers = User::factory(2)->teacher()->for($school)->create();

        // Create 1 admin
        $admin = User::factory()->schoolAdmin()->for($school)->create();

        // Verify counts
        $this->assertCount(3, $students);
        $this->assertCount(2, $teachers);
        $this->assertEquals(User::SCHOOLADMIN_USERGROUP_ID, $admin->usergroup_id);
    }

    /**
     * ============================================================
     * EXAMPLE 5: Testing Login with Different Schools
     * ============================================================
     *
     * Shows how to test user isolation between schools.
     */
    public function test_example_users_isolated_by_school(): void
    {
        // Create two schools
        $school1 = School::factory()->create(['name' => 'School A']);
        $school2 = School::factory()->create(['name' => 'School B']);

        // Create admins for each school
        $admin1 = User::factory()
            ->schoolAdmin()
            ->for($school1)
            ->create(['email' => 'admin1@school.com']);

        $admin2 = User::factory()
            ->schoolAdmin()
            ->for($school2)
            ->create(['email' => 'admin2@school.com']);

        // Verify they belong to different schools
        $this->assertEquals($school1->id, $admin1->school_id);
        $this->assertEquals($school2->id, $admin2->school_id);
        $this->assertNotEquals($admin1->school_id, $admin2->school_id);
    }

    /**
     * ============================================================
     * EXAMPLE 6: Testing Failed Login Attempts
     * ============================================================
     *
     * Shows how to test negative scenarios (things that should fail).
     */
    public function test_example_login_with_wrong_password_fails(): void
    {
        $school = School::factory()->create();

        User::factory()
            ->schoolAdmin()
            ->for($school)
            ->create([
                'email' => 'admin@school.com',
                'password' => bcrypt('correct_password'),
            ]);

        // Try to login with wrong password
        $response = $this->post('/login', [
            'email' => 'admin@school.com',
            'password' => 'wrong_password',
        ]);

        // Verify login failed
        $response->assertSessionHasErrors();
        $this->assertGuest();  // User should not be authenticated
    }

    /**
     * ============================================================
     * EXAMPLE 7: Testing Form Validation
     * ============================================================
     *
     * Shows how to test that required fields are validated.
     */
    public function test_example_login_requires_email(): void
    {
        // Post login without email field
        $response = $this->post('/login', [
            'password' => 'password123',
        ]);

        // Verify email error is present
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * ============================================================
     * EXAMPLE 8: Testing Database State After Login
     * ============================================================
     *
     * Shows how to verify database state after an action.
     */
    public function test_example_verify_database_after_login(): void
    {
        $school = School::factory()->create();

        $librarian = User::factory()
            ->librarian()
            ->for($school)
            ->create([
                'email' => 'librarian@school.com',
                'name' => 'Ms. Smith',
            ]);

        // Login
        $this->post('/login', [
            'email' => 'librarian@school.com',
            'password' => 'password',
        ]);

        // Verify user exists in database with correct attributes
        $this->assertDatabaseHas('users', [
            'email' => 'librarian@school.com',
            'name' => 'Ms. Smith',
            'usergroup_id' => User::LIBRARIAN_USERGROUP_ID,
        ]);
    }

    /**
     * ============================================================
     * EXAMPLE 9: Testing Unauthenticated User Cannot Access Protected Route
     * ============================================================
     *
     * Shows how to test that unauthenticated users are blocked.
     */
    public function test_example_unauthenticated_user_cannot_access_dashboard(): void
    {
        // Try to access admin dashboard without being logged in
        $response = $this->get('/admin/dashboard');

        // User should be redirected to login
        $response->assertRedirect('/login');

        // User should not be authenticated
        $this->assertGuest();
    }

    /**
     * ============================================================
     * EXAMPLE 10: Testing User Attributes After Creation
     * ============================================================
     *
     * Shows how to verify that factory-created users have correct attributes.
     */
    public function test_example_verify_user_attributes(): void
    {
        $school = School::factory()->create();

        $user = User::factory()
            ->accountant()
            ->for($school)
            ->create();

        // Verify user has expected attributes
        $this->assertEquals(User::ACCOUNTANT_USERGROUP_ID, $user->usergroup_id);
        $this->assertEquals('active', $user->status);
        $this->assertTrue($user->email_verified);
        $this->assertNotNull($user->email_verified_at);
    }

    /**
     * ============================================================
     * EXAMPLE 11: Chain Multiple Assertions
     * ============================================================
     *
     * Shows how to test multiple things in one test.
     */
    public function test_example_comprehensive_login_scenario(): void
    {
        // Setup
        $school = School::factory()->create();
        $teacher = User::factory()
            ->teacher()
            ->for($school)
            ->create([
                'email' => 'teacher@school.com',
                'password' => bcrypt('password123'),
            ]);

        // Action
        $response = $this->post('/login', [
            'email' => 'teacher@school.com',
            'password' => 'password123',
        ]);

        // Multiple assertions
        $response->assertRedirect('/teacher/dashboard');
        $this->assertAuthenticatedAs($teacher);
        $this->assertEquals($school->id, auth()->user()->school_id);
        $this->assertEquals(User::TEACHER_USERGROUP_ID, auth()->user()->usergroup_id);
        $this->assertDatabaseHas('users', [
            'email' => 'teacher@school.com',
            'usergroup_id' => User::TEACHER_USERGROUP_ID,
        ]);
    }

    /**
     * ============================================================
     * EXAMPLE 12: Using Helper Methods for Cleaner Tests
     * ============================================================
     *
     * Shows how to extract common logic into helper methods.
     */
    public function test_example_using_helpers(): void
    {
        // This is cleaner when using helper method (see bottom of file)
        $admin = $this->createSchoolAdmin();

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    /**
     * ============================================================
     * HELPER METHODS
     * ============================================================
     *
     * These helper methods reduce code duplication across tests.
     */

    /**
     * Create a school with a school admin
     */
    private function createSchoolAdmin(): User
    {
        $school = School::factory()->create();
        return User::factory()
            ->schoolAdmin()
            ->for($school)
            ->create();
    }

    /**
     * Login as a user
     */
    private function loginAs(User $user): void
    {
        $this->actingAs($user);
    }

    /**
     * Create and login a user
     */
    private function createAndLoginAs(string $role, ?School $school = null): User
    {
        if (!$school) {
            $school = School::factory()->create();
        }

        $user = User::factory()
            ->$role()  // Use dynamic method name
            ->for($school)
            ->create();

        $this->loginAs($user);

        return $user;
    }

    /**
     * ============================================================
     * TIPS FOR WRITING GOOD TESTS
     * ============================================================
     *
     * 1. One assertion per test (or related assertions in one test)
     * 2. Use descriptive test names: test_[scenario]_[expected_result]
     * 3. Follow Arrange-Act-Assert pattern
     * 4. Create minimal test data (only what you need)
     * 5. Use factories instead of manually creating data
     * 6. Test edge cases and error conditions
     * 7. Keep tests independent (use RefreshDatabase)
     * 8. Use helper methods to avoid code duplication
     * 9. Test behavior, not implementation details
     * 10. Make assertions clear and specific
     */
}
