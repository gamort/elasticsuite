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
 * ConversionRates graph block.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteAnalytics
 */
class ConversionRates extends \Magento\Backend\Block\Template implements ChartInterface
{
    /**
     * @var \Smile\ElasticsuiteAnalytics\Model\Search\Usage\Kpi\ConversionRates\Report
     */
    private $report;

    /**
     * Constructor.
     *
     * @param \Magento\Backend\Block\Template\Context                                    $context Context.
     * @param \Smile\ElasticsuiteAnalytics\Model\Search\Usage\Kpi\ConversionRates\Report $report  Report model.
     * @param array                                                                      $data    Data.
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Smile\ElasticsuiteAnalytics\Model\Search\Usage\Kpi\ConversionRates\Report $report,
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
                ['type' => 'number', 'label' => __('Conversion rate (%)')],
            ],
            'rows' => [],
        ];

        try {
            $reportData = $this->report->getData();

            if (array_key_exists('all', $reportData)) {
                $data['rows'][] = [
                    'c' => [
                        ['v' => __('All sessions')],
                        ['v' => (float) $reportData['all'] * 100.0],
                    ],
                ];
            }

            if (array_key_exists('searches', $reportData)) {
                $data['rows'][] = [
                    'c' => [
                        ['v' => __('With search')],
                        ['v' => (float) $reportData['searches'] * 100.0],
                    ],
                ];
            }

            if (array_key_exists('no_searches', $reportData)) {
                $data['rows'][] = [
                    'c' => [
                        ['v' => __('Without search')],
                        ['v' => (float) $reportData['no_searches'] * 100.0],
                    ],
                ];
            }
        } catch (\LogicException $e) {
            ;
        }

        return $data;
    }
}
