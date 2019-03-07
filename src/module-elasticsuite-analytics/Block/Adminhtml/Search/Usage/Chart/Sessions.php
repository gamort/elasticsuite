<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 *
 * @category  Smile
 * @package   Smile\ElasticsuiteAnalytics
 * @author    Richard BAYET <richard.bayet@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ElasticsuiteAnalytics\Block\Adminhtml\Search\Usage\Chart;

use Smile\ElasticsuiteAnalytics\Block\Adminhtml\Search\Usage\ChartInterface;

/**
 * Sessions graph block.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteAnalytics\Block\Adminhtml\Search\Usage
 */
class Sessions extends \Magento\Backend\Block\Template implements ChartInterface
{
    /**
     * @var \Smile\ElasticsuiteAnalytics\Model\Search\Usage\Kpi\Report
     */
    private $report;

    /**
     * Constructor.
     *
     * @param \Magento\Backend\Block\Template\Context                    $context Context.
     * @param \Smile\ElasticsuiteAnalytics\Model\Search\Usage\Kpi\Report $report  KPI report model.
     * @param array                                                      $data    Data.
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Smile\ElasticsuiteAnalytics\Model\Search\Usage\Kpi\Report $report,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->report = $report;
    }

    /**
     * {@inheritdoc}
     */
    public function getChartOptions()
    {
        return json_encode([
            'title'     => $this->getTitle(),
            'animation' => [
                'startup' => true,
                'duration' => 1000,
                'easing'   => 'out',
            ],
            'colors' => ['#367AFF', '#FE7F53'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getChartData()
    {
        $data = [
            'cols' => [
                ['type' => 'string', 'label' => __('Session type')],
                ['type' => 'number', 'label' => __('Count')],
            ],
            'rows' => [],
        ];

        try {
            $reportData = $this->report->getData();
            if (array_key_exists('sessions_count', $reportData)
                && array_key_exists('search_sessions_count', $reportData)
            ) {
                $withSearch     = $reportData['search_sessions_count'];
                $withoutSearch  = $reportData['sessions_count'] - $reportData['search_sessions_count'];

                $data['rows'] = [
                    [
                        'c' => [
                            ['v' => __('Sessions with search')],
                            ['v' => (int) $withSearch],
                        ],
                    ],
                    [
                        'c' => [
                            ['v' => __('Sessions without search')],
                            ['v' => (int) $withoutSearch],
                        ],
                    ],
                ];
            }
        } catch (\LogicException $e) {
            ;
        }

        return $data;
    }
}
