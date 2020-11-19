<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /*public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/

    public function testRegistrationSuccess()
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => $email = substr(md5(time()), 0, 6) . '@example.com',
            'password' => $password = md5(time()),
            'name' => $name = substr(md5(time()), 0, 6)
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $responseArray = json_decode($response->getContent(), true);

        $this->assertEquals($email, $responseArray['email']);
        $this->assertEquals($name, $responseArray['name']);

        $response = $this->postJson('/api/auth/login', [
            'email'     => $email,
            'password'  => $password
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $responseArray = json_decode($response->getContent(), true);
        $this->assertTrue(isset($responseArray['token']));


    }

    public function testRegistrationValidationFailed()
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => $email = substr(md5(time()), 0, 6) . '@example.com',
            'password' => $password = md5(time()),
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response = $this->postJson('/api/auth/register', [
            'email' => $email = substr(md5(time()), 0, 6) . '@example.com',
            'name' => $password = md5(time()),
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response = $this->postJson('/api/auth/register', [
            'name' => $password = md5(time()),
            'password' => $password = md5(time()),
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response = $this->postJson('/api/auth/register', [
            'email' => '1',
            'password' => $password = md5(time()),
            'name' => $name = substr(md5(time()), 0, 6)
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response = $this->postJson('/api/auth/register', [
            'email' => $email = substr(md5(time()), 0, 6) . '@example.com',
            'password' => $password = substr(md5(time()), 0, 5),
            'name' => $name = substr(md5(time()), 0, 6)
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response = $this->postJson('/api/auth/register', [
            'email' => $email = substr(md5(time()), 0, 6) . '@example.com',
            'password' => $password = substr(md5(time()), 0, 6),
            'name' => $name = substr(md5(time()), 0, 1)
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /*
    public function testAuthTest()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer 123',
        ])->json('GET', '/user', []);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);

    }*/
}
