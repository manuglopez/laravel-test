<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Team;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeneralTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_exist(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertViewIs('home')
            ->assertSee('Homepage');
    }

    public function test_post_form_request()
    {
        $response = $this->post(route('posts.store'));
        $response->assertSessionHasErrors(['title', 'body']);

        $response = $this->post(route('posts.store'), [
            'title' => $title = fake()->text(30),
            'body' => fake()->text(),
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ]);
        $response->assertOk();

        $this->assertDatabaseCount('posts', 1);
        $this->assertDatabaseHas('posts', ['title' => $title]);
    }

    public function test_remove_oldfiles_on_update_post()
    {
        $response = $this->post(route('posts.store'), [
            'title' => fake()->text(30),
            'body' => fake()->text(),
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ]);
        $response->assertOk();

        $post = Post::first();
        $this->assertTrue(Storage::exists($post->photo));

        $response = $this->put(route('posts.update', $post), [
            'title' => fake()->text(30),
            'body' => fake()->text(),
            'photo' => UploadedFile::fake()->image('photo.jpg'),
        ]);
        $response->assertOk();
        $this->assertFalse(Storage::exists($post->photo));
    }

    public function test_teams_user()
    {
        $user = User::factory()->create();
        $team = Team::create(['name' => 'Team 1']);
        $team->users()->attach($user, [
            'position' => 'Manager',
            'created_at' => $createdAt = now()->toDateTimeString(),
        ]);

        $response = $this->get(route('teams.index'));
        $response->assertOk()
            ->assertSee($team->name)
            ->assertSee('Manager')
            ->assertSee($createdAt);
    }

    public function test_user_check_or_update()
    {
        $response = $this->get(route('user', ['john', 'john@doe.com']));
        $response->assertOk();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['name' => 'john', 'email' => 'john@doe.com']);

        $response = $this->get(route('user', ['john', 'john@doe.com']));
        $response->assertOk();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['name' => 'john', 'email' => 'john@doe.com']);

        $response = $this->get(route('user', ['john', 'john@fakery.com']));
        $response->assertOk();
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['name' => 'john', 'email' => 'john@fakery.com']);

        $response = $this->get(route('user', ['Peter', 'peter@griffin.com']));
        $response->assertOk();
        $this->assertDatabaseCount('users', 2);
    }

    public function test_password_strength_uppercase_lowercase_numbers_letter()
    {
        // We need to ensure that the password contains at least one uppercase letter, one lowercase letter, and one number and a minimum of 8 characters.
        // If you need to change this test it will be ok to do so. to adjust to requeriments.
        $user = [
            'name'  => 'New name',
            'email' => 'new@email.com',
        ];

        $invalidPassword = '12345678';
        $validPassword = 'a12345678';

        $this->post('/register', $user + [
                'password'              => $invalidPassword,
                'password_confirmation' => $invalidPassword,
            ]);
        $this->assertDatabaseMissing('users', $user);

        $this->post('/register', $user + [
                'password'              => $validPassword,
                'password_confirmation' => $validPassword,
            ]);

        $this->assertDatabaseHas('users', $user);
    }

    public function test_shows_table_loop()
    {
        $response = $this->get(route('users'));
        $this->assertStringContainsString('No content', $response->content());

        User::factory()->create();
        $response = $this->get(route('users'));
        $this->assertStringNotContainsString('No content', $response->content());
    }

    public function test_delete_parent_child_record()
    {
        // We just test if the test succeeds or throws an exception
        $this->expectNotToPerformAssertions();

        Artisan::call('migrate:fresh', ['--path' => '/database/migrations/task6']);

        $category = Category::create(['name' => fake()->text(30)]);
        Product::create(['name' => fake()->text(30), 'category_id' => $category->id]);
        $category->delete();
    }
}
