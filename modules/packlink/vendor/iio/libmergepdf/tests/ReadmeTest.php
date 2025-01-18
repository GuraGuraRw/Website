<?php
namespace hanneskod\libmergepdf;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ReadmeTest extends \hanneskod\readmetester\PHPUnit\ReadmeTestCase
{
    public function testReadmeExamples()
    {
        $this->assertReadme('README.md');
    }
}
