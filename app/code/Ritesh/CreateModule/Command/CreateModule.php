<?php
namespace Ritesh\CreateModule\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;

class CreateModule extends Command
{
    const VENDORNAME='Vendor Name';
    const MODULENAME='Module Name';

    protected $filesystem;
    protected $newDir;

    public function __construct(
        FileSystem $filesystem
    )
    {
        $this->filesystem=$filesystem;
        $this->newDir=$filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);  
        parent::__construct();  
    }
    protected function configure()
    {
		$this->setName('create:module')
			->setDescription('Create : Module --vendorName="" --moduleName="" ');

        $this->addArgument(
            self::VENDORNAME,
            InputArgument::REQUIRED,
            'Vendor Name'
        );
        $this->addArgument(
            self::MODULENAME,
            InputArgument::REQUIRED,
            'Module Name'
        );

		parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $Nvendor=$input->getArgument(self::VENDORNAME);
        $Nmodule=$input->getArgument(self::MODULENAME);

        $path='app/code'.$Nvendor.'/'.$Nmodule;
        $newDirectory = false;

        try {
            $newDirectory = $this->newDir->create($path);
        } catch (FileSystemException $e) {
            throw new LocalizedException(
                __('We can\'t create directory "%1"', $path)
            );
        }
        $output->writeln($newDirectory);

        $output->writeln("Bingo ! Created new Module");
    }
}
