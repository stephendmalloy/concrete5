<?php
namespace Concrete\Core\Install\Preconditions;

use Concrete\Core\Foundation\Environment\FunctionInspector;
use Concrete\Core\Install\PreconditionInterface;
use Concrete\Core\Install\PreconditionResult;

class FileinfoExtension implements PreconditionInterface
{
    /**
     * The FunctionInspector instance.
     *
     * @var FunctionInspector
     */
    protected $functionInspector;

    /**
     * Initialize the instance.
     *
     * @param FunctionInspector $functionInspector the FunctionInspector instance
     */
    public function __construct(FunctionInspector $functionInspector)
    {
        $this->functionInspector = $functionInspector;
    }

    /**
     * {@inheritdoc}
     *
     * @see PreconditionInterface::getName()
     */
    public function getName()
    {
        return t('Fileinfo Extension Enabled');
    }

    /**
     * {@inheritdoc}
     *
     * @see PreconditionInterface::getUniqueIdentifier()
     */
    public function getUniqueIdentifier()
    {
        return 'fileinfo_extension';
    }

    /**
     * {@inheritdoc}
     *
     * @see PreconditionInterface::isOptional()
     */
    public function isOptional()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @see PreconditionInterface::performCheck()
     */
    public function performCheck()
    {
        $result = new PreconditionResult();
        if (!$this->functionInspector->functionAvailable('finfo_open')) {
            $result
                ->setState(PreconditionResult::STATE_FAILED)
                ->setMessage(t('You must enable the PHP Fileinfo extension.'))
            ;
        }

        return $result;
    }
}
