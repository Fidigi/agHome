<?php
namespace App\Tests\Command;

use App\Command\CallWheatherCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CallWheatherCommandTest extends KernelTestCase
{
    /**
     * @group cmd
     */
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        
        $command = $application->find('app:call:wheather');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            // pass arguments to the helper
            //'username' => 'Wouter',
            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ]);
        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('Wheather call successfully!', $output);
        
    }
}