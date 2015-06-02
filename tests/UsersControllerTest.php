<?php

use App\Models\User;
use App\Models\Observers\User as UserObserver;

class UsersControllerTest extends TestCase {

    public function testRegisterSuccess()
    {
        $params = [
            'email' => 'test@test.com',
            'password' => 'testing',
            'password_confirmation' => 'testing'
        ];

        $response = $this->call('POST', '/api/v1/users/register', $params);
        $json = json_decode($response->getContent());

        $this->assertResponseOk();

        /*
         * check and test json response
         */
        $this->assertTrue(isset($json->status));
        $this->assertTrue(isset($json->data));
        $this->assertEquals('success', $json->status);
        $this->assertTrue(empty($json->data));

        /*
         * check and test database data
         */
        $user = User::where('email', 'test@test.com')->first();
        $this->assertTrue(!empty($user));
        $this->assertTrue(isset($user->email));
        $this->assertEquals('test@test.com', $user->email);
    }

    public function testRegisterFailedEmailExists()
    {
         $this->generateUser('test@test.com', 'testing');

         $params = [
             'email' => 'test@test.com',
             'password' => 'testing',
             'password_confirmation' => 'testing'
         ];

         $response = $this->call('POST', '/api/v1/users/register', $params);
         $this->assertResponseStatus(400);

         $json = json_decode($response->getContent());

         $this->assertTrue(isset($json->status));
         $this->assertEquals('error', $json->status);

         $this->assertTrue(isset($json->message));
         $this->assertEquals('Fail to validate.', $json->message);
    }

    public function testRegisterEmptyParams()
    {
        $response = $this->call('POST', '/api/v1/users/register', []);
        $this->assertResponseStatus(400);

        $json = json_decode($response->getContent());

        $this->assertTrue(isset($json->status));
        $this->assertEquals('error', $json->status);

        $this->assertTrue(isset($json->message));
        $this->assertEquals('Fail to validate.', $json->message);
    }

     private function generateUser($email, $password)
     {
         User::observe(new UserObserver);
         $user = new User;
         $user->register($email, $password);
     }
}
