<?php

namespace App\Command\Console;

use App\Repository\JobRepository;
use App\Util\StateMachine\JobTransitions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use SM\Factory\FactoryInterface as StateMachineFactory;

class SymfonyjobsExpirationCheckerCommand extends Command
{
    protected static $defaultName = 'symfonyjobs:expiration:checker';

    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     * @var StateMachineFactory
     */
    private $stateMachineFactory;

    public function __construct(JobRepository $jobRepository, StateMachineFactory $stateMachineFactory)
    {
        $this->jobRepository = $jobRepository;

        parent::__construct(self::$defaultName);
        $this->stateMachineFactory = $stateMachineFactory;
    }

    protected function configure()
    {
        $this
            ->setDescription('Check expired jobs command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $expiredJobs = $this->jobRepository->findAllExpired();

        $jobData = [];
        foreach ($expiredJobs as $job) {
            $jobData[] = [$job->getTitle(), $job->getExpirationDate()->format('d-m-Y H:m'), $job->getStatus(). ' -> expired', $job->getCompany()->getName()];
        }

        foreach ($expiredJobs as $job) {
            $jobStateMachine = $this->stateMachineFactory->get($job, JobTransitions::GRAPH);
            if ($jobStateMachine->can(JobTransitions::TRANSITION_EXPIRE)) {
                $jobStateMachine->apply(JobTransitions::TRANSITION_EXPIRE);
                $this->jobRepository->save($job);
            }
        }

        $io->table(['Job title', (new \DateTime())->format('d-m-Y H:m'), 'status', 'company'], $jobData);

        $io->writeln('<info>Expired job finished successfully</info>');
    }
}
