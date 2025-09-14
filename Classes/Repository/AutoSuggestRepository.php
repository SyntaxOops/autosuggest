<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\Repository;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AutoSuggestRepository
 *
 * @author  Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class AutoSuggestRepository
{
    protected QueryBuilder $queryBuilder;
    protected string $tableName;

    /**
     * @param string $tableName
     */
    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        $this->queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($tableName);
    }

    /**
     * Fetches records from the configured table
     * for a given page ID
     *
     * @param int $pid
     * @param string $fields
     * @return array
     *
     * @throws Exception
     */
    public function getRecords(int $pid, string $fields): array
    {
        foreach (GeneralUtility::trimExplode(',', $fields) as $field) {
            $this->queryBuilder->addSelect($field);
        }
        return $this->queryBuilder
            ->from($this->tableName)
            ->where(
                $this->queryBuilder->expr()->eq('pid', $pid)
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
