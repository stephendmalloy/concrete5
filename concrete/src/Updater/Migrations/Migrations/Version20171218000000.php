<?php

namespace Concrete\Core\Updater\Migrations\Migrations;

use Concrete\Core\Updater\Migrations\AbstractMigration;
use Concrete\Core\Updater\Migrations\DirectSchemaUpgraderInterface;
use Concrete\Core\Updater\Migrations\ManagedSchemaUpgraderInterface;
use Concrete\Core\Updater\Migrations\RepeatableMigrationInterface;
use Concrete\Core\Updater\Migrations\Routine\AddPageDraftsBooleanTrait;
use Doctrine\DBAL\Schema\Schema;

class Version20171218000000 extends AbstractMigration implements RepeatableMigrationInterface, ManagedSchemaUpgraderInterface, DirectSchemaUpgraderInterface
{
    use AddPageDraftsBooleanTrait;

    /**
     * {@inheritdoc}
     *
     * @see \Doctrine\DBAL\Migrations\AbstractMigration::getDescription()
     */
    public function getDescription()
    {
        return '8.3.1';
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Updater\Migrations\ManagedSchemaUpgraderInterface::upgradeSchema()
     */
    public function upgradeSchema(Schema $schema)
    {
        $this->addColumnIfMissing($schema);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Updater\Migrations\DirectSchemaUpgraderInterface::upgradeDatabase()
     */
    public function upgradeDatabase()
    {
        $this->migrateDrafts();
    }
}
