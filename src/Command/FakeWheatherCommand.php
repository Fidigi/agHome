<?php
namespace App\Command;

use App\Service\WheatherManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakeWheatherCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:fake:wheather';
    
    private $wheatherManager;
    
    public function __construct(WheatherManager $wheatherManager)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->wheatherManager = $wheatherManager;
        
        parent::__construct();
    }
    
    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Fake call api wheather.')
        
        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command fake wheather data')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Call Wheather FAKE',
            '==================',
            '',
        ]);
        $wheather = $this->wheatherManager->generateFake();
        
        $output->writeln([
            'Loc : '.$wheather->getLocation(),
            'Temp. : '.$wheather->getTemperature(),
            'Hum. : '.$wheather->getHumidity(),
            '',
        ]);
        
        // outputs a message without adding a "\n" at the end of the line
        $output->write('Wheather');
        // outputs a message followed by a "\n"
        $output->writeln(' fake successfully!');
    }
}
