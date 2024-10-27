<?php

use PHPUnit\Framework\TestCase;

class ProductDetailsTest extends TestCase
{
    private $con;
    private $mockSession;

    protected function setUp(): void
    {
        $this->con = $this->createMock(mysqli::class);
        $_SESSION = [];
        $_POST = [];
        $_GET = [];
    }

    public function testSuccessfulCommentInsertion()
    {
        $_SESSION['id_user'] = 1;
        $_GET['idprod'] = 2;
        $_POST = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'textarea' => 'Test comment'
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->con->expects($this->once())
            ->method('query')
            ->with($this->stringContains("INSERT INTO avis"))
            ->willReturn(true);

        $this->assertTrue($isSuccess);
    }

    public function testFailedCommentInsertionWithEmptyFields()
    {
        $_SESSION['id_user'] = 1;
        $_GET['idprod'] = 2;
        $_POST = [
            'name' => '',
            'email' => '',
            'textarea' => ''
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->con->expects($this->never())
            ->method('query');

        $this->assertFalse($isSuccess);
    }

    public function testNoInsertionWhenUserNotLoggedIn()
    {
        unset($_SESSION['id_user']);
        $_POST = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'textarea' => 'Test comment'
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->con->expects($this->never())
            ->method('query');
    }

    public function testSQLInjectionPrevention()
    {
        $_SESSION['id_user'] = 1;
        $_GET['idprod'] = 2;
        $_POST = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'textarea' => "'; DROP TABLE users; --"
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->con->expects($this->once())
            ->method('real_escape_string')
            ->with("'; DROP TABLE users; --")
            ->willReturn('\'; DROP TABLE users; --');

        $this->con->expects($this->once())
            ->method('query')
            ->with($this->stringContains('\'; DROP TABLE users; --'))
            ->willReturn(true);
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        $_POST = [];
        $_GET = [];
    }
}
