<?php
/**
 * Created by PhpStorm.
 * User: igorfilippov
 * Date: 15.07.2018
 * Time: 13:26.
 */

namespace App\Command;

use App\Service\ExcelService;
use App\Service\SwiftmailerService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OneCommand extends Command
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ExcelService
     */
    private $excelService;
    /**
     * @var SwiftmailerService
     */
    private $swiftmailerService;

    public function __construct(ExcelService $excelService,UserService $userService, SwiftmailerService $swiftmailerService)
    {
        parent::__construct();
        $this->excelService = $excelService;
        $this->userService = $userService;
        $this->swiftmailerService = $swiftmailerService;
    }

    protected static $defaultName = 'exceltoemail';

    protected function configure()
    {
        $this->setName('exceltoemail');
        $this->setDescription('send excel to email');
        $this->setHelp('This command will send');
        $this->addArgument('email', InputArgument::REQUIRED, 'email for sending');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '<fg=cyan>script begin</>',
            '===============================',
        ]);
        $users = $this->userService->getAllData();
//        mail()
        $excelFilepath =  $this->excelService->getExcel($users);
        $email = $input->getArgument('email');
        $this->swiftmailerService->sendEmail($email,$excelFilepath);
        $output->writeln([
            '<fg=cyan>end script</>',
        ]);
    }
}
