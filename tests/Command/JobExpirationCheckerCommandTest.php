<?php

namespace App\Tests\Command;

use App\Tests\JsonApiTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class JobExpirationCheckerCommandTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_changes_finds_expired_jobs_and_change_its_status()
    {
        $this->loadFixtures('jobs');

        $application = new Application(self::$kernel);

        $command = $application->find('symfonyjobs:expiration:checker');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Isteko sam do dna života', $output);
    }
}
