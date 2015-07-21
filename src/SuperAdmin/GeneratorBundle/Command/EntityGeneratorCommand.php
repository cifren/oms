<?php

namespace SuperAdmin\GeneratorBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineEntityCommand;
use Earls\FlamingoCommandQueueBundle\Model\FlgCommand;

class EntityGeneratorCommand extends GenerateDoctrineEntityCommand
{

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cmdManager = $this->getContainer()->get('flamingo.manager.command');

        $scriptName = 'EntityGenerator';
        $cmdManager->start($scriptName, $this->getFlgCommand());

        parent::execute($input, $output);

        $cmdManager->stop($this->getLogs());
    }

    protected function getFlgCommand()
    {
        $flgCommand = new FlgCommand();
        $flgCommand->setArchiveEnable(false);
        $flgCommand->set(false);
    }

}
