<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {
    private $loginPage;
    
    protected function setUp(): void {
        $this->loginPage = new Login();
    }

    public function testLoginPageLoads() {
        $this->assertTrue(file_exists('Website/PC-Store/login.php'));
    }

    public function testLoginFormExists() {
        ob_start();
        include 'Website/PC-Store/login.php';
        $output = ob_get_clean();
        
        $this->assertStringContainsString('<form', $output);
        $this->assertStringContainsString('method="post"', $output);
    }

    public function testLoginInputFieldsExist() {
        ob_start();
        include 'Website/PC-Store/login.php';
        $output = ob_get_clean();
        
        $this->assertStringContainsString('input', $output);
        $this->assertStringContainsString('type="text"', $output);
        $this->assertStringContainsString('type="password"', $output);
    }

    public function testLoginSubmitButtonExists() {
        ob_start();
        include 'Website/PC-Store/login.php';
        $output = ob_get_clean();
        
        $this->assertStringContainsString('type="submit"', $output);
    }

    public function testSessionStarted() {
        ob_start();
        include 'Website/PC-Store/login.php';
        ob_end_clean();
        
        $this->assertTrue(session_status() === PHP_SESSION_ACTIVE);
    }
}
