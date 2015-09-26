<?php

namespace SupportYard\FrameworkBundle\Tests\Unit\Validator\Constraints;

use SupportYard\FrameworkBundle\Test\TestCase;
use SupportYard\FrameworkBundle\Validator\Constraints\Virus;
use SupportYard\FrameworkBundle\Validator\Constraints\VirusValidator;

class VirusValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function ifPhpExtensionIsNotInstalledValidationIsSkipped()
    {
        $this->validator->validate('', $this->constraint);
    }

    /**
     * @test
     */
    public function ifValueIsNotUploadedFileInstanceValidationIsSkipped()
    {
        $this->loadFakeFileScanner();

        $this->validator->validate('', $this->constraint);
    }

    /**
     * @test
     */
    public function ifFileDoesNotExistValidationIsSkipped()
    {
        $this->loadFakeFileScanner();

        $this->validator->validate($this->uploadedFile, $this->constraint);
    }

    protected function setUp()
    {
        $this->uploadedFile = $this->createUploadedFile();
        $this->context = $this->createExecutionContextInterface();
        $this->constraint = new Virus();
        $this->validator = new VirusValidator();

        $this->validator->initialize($this->context);
    }

    private function loadFakeFileScanner()
    {
        include_once $this->getPath().'cl_scanfile.php';
    }

    private function getPath()
    {
        return __DIR__
            .DIRECTORY_SEPARATOR
            .'..'
            .DIRECTORY_SEPARATOR
            .'..'.DIRECTORY_SEPARATOR
            .'..'.DIRECTORY_SEPARATOR
            .'Fixtures'
            .DIRECTORY_SEPARATOR
            .'Validator'
            .DIRECTORY_SEPARATOR;
    }

    private function createUploadedFile()
    {
        return $this
            ->getMockBuilder('Symfony\Component\HttpFoundation\File\UploadedFile')
            ->setConstructorArgs([$this->getPath().'baz.txt', 'baz.txt'])
            ->getMock();
    }

    private function createExecutionContextInterface()
    {
        return $this->createMockFor(
            'Symfony\Component\Validator\ExecutionContextInterface'
        );
    }
}
