<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 *
 * @category  Smile
 * @package   Smile\Elasticsuite
 * @author    Richard BAYET <richard.bayet@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ElasticsuiteAnalytics\Block\Adminhtml\Search\Usage;

/**
 * Interface ChartInterface
 *
 * @category Smile
 * @package  Smile\ElasticsuiteAnalytics
 */
interface ChartInterface
{
    /**
     * Return chart data in the format expected by Google Charts API
     *
     * @return array
     */
    public function getChartData();

    /**
     * Return chart options as a JSON encoded string.
     *
     * @return string
     */
    public function getChartOptions();
}
