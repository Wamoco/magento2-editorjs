<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Block\Renderer\Blocks;

class Widget extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = "Wamoco_EditorJS::renderer/widget.phtml";

    /**
     * @var mixed
     */
    protected $widget;

    /**
     * __construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Widget\Model\Widget $widget
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Widget\Model\Widget $widget,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->widget = $widget;
    }

    /**
     * getWidgetHtml
     * @return string
     */
    public function getWidgetHtml()
    {
        $data = $this->getData('data');
        if (!array_key_exists('options', $data)) {
            return '';
        }

        // Determine what name block should have in layout
        $name = null;
        if (isset($data['name'])) {
            $name = $data['name'];
        }

        $options = $data['options'];

        if (!array_key_exists('type', $options)) {
            return '';
        }

        $type = $options['type'];

        // we have no other way to avoid fatal errors for type like 'cms/widget__link', '_cms/widget_link' etc.
        $xml = $this->widget->getWidgetByClassType($type);
        if ($xml === null) {
            return '';
        }

        // define widget block and check the type is instance of Widget Interface
        $widget = $this->_layout->createBlock($type, $name, ['data' => $options]);
        if (!$widget instanceof \Magento\Widget\Block\BlockInterface) {
            return '';
        }

        return $widget->toHtml();
    }
}
