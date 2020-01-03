<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_create_post()
    {
        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph
        ];
        $this->post(route('posts.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    public function test_can_list_all_posts() {
        $post = factory(Post::class, 2)->create()->map(function($post) {
            return $post->only(['id', 'title', 'content']);
        });

        $this->get(route('posts'))
            ->assertStatus(200)
            ->assertJson($post->toArray())
            ->assertJsonStructure([
                '*' => ['id', 'title', 'content']
            ]);
    }

    public function test_can_show_post() {
        $post = factory(Post::class)->create();
        $this->get(route('posts.show', $post->id))->assertStatus(200)->assertJson($post->toArray());
    }


    public function test_can_update_post() {
        $post = factory(Post::class)->create();
        $data = [
            'content' => 'This is pelumi here'
        ];
        $post['content'] = $data['content'];
        $this->put(route('posts.update', $post->id), $data)
            ->assertStatus(200)
            ->assertJson($post->toArray());
    }

    public function test_can_delete_post() {
        $post = factory(Post::class)->create();
        $this->delete(route('posts.delete', $post->id))
            ->assertStatus(204);
    }
}
