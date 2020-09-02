<?php


use App\Controllers\UserController;
use App\Helpers\Services\Account;
use Symfony\Component\HttpFoundation\Request;


class UserTest extends \PHPUnit\Framework\TestCase
{

    // getInfo method should accept the appropriate argument value
    // Test to accept the requirement information when creating a new user model
    // Test if the store method return the expected results

    private $requestId = 12345;

    private $account;

    public function setUp(): void
    {
        parent::setUp();

        $this->account = Mockery::mock(Account::class);
        $this->account->shouldReceive('getInfo')
            ->with($this->requestId)
            ->andReturn(json_encode(['nationalId'=>'123456789', 'birthDate'=>'2000/01/01']));

    }

    public function testStoreShouldCallGetInfoWithTheSpecificArguments()
    {

        $userController = new UserController($this->account);
        $request = new Request([], ['name'=>'Mohammad', 'lastName'=>'Kaab', 'phoneNumber'=>'2838304940', 'request_id'=>$this->requestId]);

        $userController->store($request);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testStoreShouldCreateANewInstanceOfUserWithSpecificArguments()
    {
        $userController = new UserController($this->account);
        $request = new Request([], ['name'=>'Mohammad', 'lastName'=>'Kaab', 'phoneNumber'=>'2838304940', 'request_id'=>$this->requestId]);

        $mockedUser = Mockery::mock('overload:'.\App\Models\User::class);
        $mockedUser->shouldReceive('__construct')->with('Mohammad', 'Kaab', '123456789', '2000/01/01', '2838304940');

        $userController->store($request);
    }

    public function testStoreShouldReturnTheExpectedResults()
    {

        $userController = new UserController($this->account);
        $requestArray = ['name'=>'Mohammad', 'lastName'=>'Kaab', 'phoneNumber'=>'2838304940'];
        $request = new Request([], $requestArray + ['request_id'=>$this->requestId]);
        $response = $userController->store($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode($requestArray + ['nationalId'=>'123456789', 'birthDate'=>'2000/01/01']), $response->getContent());
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $container = Mockery::getContainer();
        $this->addToAssertionCount($container->mockery_getExpectationCount());

        Mockery::close();
    }

}
