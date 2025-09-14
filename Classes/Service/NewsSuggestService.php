<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\Service;

/**
 * Class NewsSuggestService
 *
 * @author  Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class NewsSuggestService extends GenericSuggestService
{
    protected string $type = 'news';
}
