<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\Service;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class GenericSuggestService
 *
 * @author Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class GenericSuggestService extends AbstractExtbaseSuggestService
{
    protected const DEFAULT_TABLE = 'tx_news_domain_model_news';
    protected const DEFAULT_FIELD = 'title';

    /**
     * Generates a list of items for the auto suggest field.
     *
     * @return array
     *
     * @throws Exception
     */
    public function generateItems(): array
    {
        if (empty($pids = $this->resolveStoragePidsByType())) {
            return [];
        }

        $table = isset($this->getUriParameters()['table'])
            ? $this->getUriParameters()['table'] : static::DEFAULT_TABLE;
        $field = isset($this->getUriParameters()['field'])
            ? $this->getUriParameters()['field'] : static::DEFAULT_FIELD;

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);
        return $queryBuilder
            ->select($field . ' AS name')
            ->from($table)
            ->where(
                $queryBuilder->expr()->in(
                    'pid',
                    $queryBuilder->createNamedParameter($pids, ArrayParameterType::INTEGER)
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
