<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\Service;

use SyntaxOOps\Autosuggest\Core\Request;
use SyntaxOOps\Autosuggest\Utility\ExtensionUtility;
use TYPO3\CMS\Backend\Tree\Repository\PageTreeRepository;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Class AbstractExtbaseSuggestService
 *
 * @author Haythem Daoud <haythemdaoud.x@gmail.com>
 */
abstract class AbstractExtbaseSuggestService implements SuggestServiceInterface, SingletonInterface
{
    protected string $objectType;
    protected array $settings = [];

    /**
     * @param PersistenceManager $persistenceManager
     */
    public function __construct(
        protected PersistenceManager $persistenceManager
    ) {}

    /**
     * Inject extension settings
     */
    public function initializeObject(): void
    {
        $this->settings = ExtensionUtility::getSettings();
    }

    /**
     * Generates and returns a list of items
     * to be rendered in JSON format
     *
     * @return array
     */
    abstract public function generateItems(): array;

    /**
     * Creates a new query instance for the current object type
     *
     * @return QueryInterface
     */
    protected function createQuery(): QueryInterface
    {
        return $this->persistenceManager->createQueryForType($this->objectType);
    }

    /**
     * Resolves the allowed storage PIDs
     * based on settings and GET parameters
     *
     * @return array
     */
    protected function resolveStoragePidsByType(): array
    {
        $storagePids = $this->getStoragePidsFromSettings();
        $pids = $this->getIdsFromGetParams();
        $pids = array_unique(array_merge($pids, $storagePids));

        if (count($pids) == 0) {
            return [];
        }

        return $this->applyRecursiveFromGetParams($pids);
    }

    /**
     * Extracts PID values from GET parameters
     *
     * @return array
     */
    protected function getIdsFromGetParams(): array
    {
        $pids = '';
        $params = $this->getUriParameters();

        if (isset($params['pids'])) {
            $pids = $params['pids'];
        }

        if ($pids) {
            return GeneralUtility::trimExplode(',', $pids);
        }

        return [];
    }

    /**
     * Expands the given PIDs recursively
     * if requested via GET parameters
     *
     * @param array $pids
     * @return array
     */
    protected function applyRecursiveFromGetParams(array $pids): array
    {
        $params = $this->getUriParameters();

        if (isset($params['recursive'])) {
            $pageTreeRepository = GeneralUtility::makeInstance(PageTreeRepository::class);
            $recursivePids = $pageTreeRepository->getFlattenedPages(
                $pids,
                isset($params['recursive_depth']) ? (int)$params['recursive_depth'] : 1
            );
            $pids = array_column($recursivePids, 'uid');
        }

        return $pids;
    }

    /**
     * Returns the current request's query parameters
     *
     * @return array
     */
    protected function getUriParameters(): array
    {
        $params = [];

        $request = Request::getRequest();

        if (is_array($request->getQueryParams())) {
            $params = $request->getQueryParams();
        }

        return $params;
    }

    /**
     * Retrieves the configured storage PIDs
     * for the current type in the frontend
     *
     * @return array
     */
    protected function getStoragePidsFromSettings(): array
    {
        if (Request::isFrontend() &&
            isset($this->settings[$this->type])
        ) {
            $storagePids = $this->settings[$this->type]['storagePids'];
        }

        return $storagePids ?? [];
    }
}
