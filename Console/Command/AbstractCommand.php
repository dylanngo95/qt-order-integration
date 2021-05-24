<?php

declare(strict_types=1);

namespace QT\OrderIntegration\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;

/**
 * Class AbstractCommand
 * @package QT\OrderIntegration\Console\Command
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var State
     */
    private $state;

    /**
     * AbstractCommand constructor.
     * @param State $state
     */
    public function __construct(
        State $state
    ) {
        parent::__construct();
        $this->state = $state;
    }

    /**
     * @throws LocalizedException
     */
    protected function setAreaIfNotDefined()
    {
        try {
            $this->state->getAreaCode();
        } catch (LocalizedException $e) {
            $this->state->setAreaCode(Area::AREA_CRONTAB);
        }
    }
}
