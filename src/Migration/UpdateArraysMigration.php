<?php

namespace con4gis\PwaBundle\Migration;

use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\CoreBundle\Migration\MigrationInterface;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

class UpdateArraysMigration implements MigrationInterface
{

    private array $pushSubscriptionFields = [
        'types', // simple_array
        'content', // json
        'config', // int
    ];

    public function __construct(
        private readonly Connection $connection,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function getName(): string
    {
        return "con4gis_pwa_update_arrays_migration";
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (
            !$schemaManager->tablesExist([
                'tl_c4g_push_subscription',
            ])
        ) {
            return false;
        }

        $sql = "SELECT types,content,config FROM tl_c4g_push_subscription";
        $pushSubs = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        foreach ($pushSubs as $sub) {
            foreach ($this->pushSubscriptionFields as $field) {
                if ($this->checkForSerializedValue($sub[$field])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function run(): MigrationResult
    {
        $updatedPushSubs = 0;

        $sql = "SELECT id,types,content,config FROM tl_c4g_push_subscription";
        $pushSubs = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        if ($this->shouldRun()) {
            $this->logger->info("Running migration...");
            foreach ($pushSubs as $sub) {

                // check again if we have to migrate these router fields
                if ($this->checkForSerializedValue($sub['types'])) {
                    $types = StringUtil::deserialize($sub['types'], true);
                    $types = implode(",", $types);
                }

                if ($this->checkForSerializedValue($sub['content'])) {
                    $content = StringUtil::deserialize($sub['content'], true);
                    $content = json_encode($content);
                }

                if ($this->checkForSerializedValue($sub['config'])) {

                    // we use unserialize here because StringUtil::deserialize does not work correctly with integers and objects
                    $config = unserialize($sub['config'], ['allowed_classes' => [WebPushConfiguration::class]]);

                    if (is_object($config)) {
                        $config = $config->getId();
                    }
                }

                $sql = "UPDATE tl_c4g_push_subscription SET types = ?, content = ?, config = ? WHERE id=?";
                $this->connection->executeQuery(
                    $sql,
                    [
                        $types ?? $sub['types'],
                        $content ?? $sub['content'],
                        $config ?? $sub['config'],
                        $sub['id']
                    ]
                );
                $updatedPushSubs++;
            }

            return new MigrationResult(
                true,
                sprintf(
                    "Es wurden %d Push-Subscriptions aktualisiert",
                    $updatedPushSubs
                )
            );
        } else {

            return new MigrationResult(
                true,
                "Keine Migration erforderlich."
            );
        }

    }

    private function checkForSerializedValue($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        if (
            str_starts_with($value, "a:")
            || str_starts_with($value, "O:")
            || str_starts_with($value, "i:")
        ) {
            // serialized array, object or int
            return true;
        }

        return false;
    }
}