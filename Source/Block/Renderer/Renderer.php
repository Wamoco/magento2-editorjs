<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Block\Renderer;

class Renderer extends \Magento\Framework\View\Element\AbstractBlock
{
    /**
     * @var array
     */
    protected $blocks = [];

    /**
     * @var array
     */
    protected $renderer = [];

    /**
     * __construct
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param array $renderer
     * @param array $blocks
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        array $renderer = [],
        array $blocks = [],
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->renderer = $renderer;
        $this->blocks    = $blocks;
    }

    /**
     * toHtml
     * @return string
     */
    public function toHtml()
    {
        if (!is_array($this->blocks)) {
            return "";
        }

        $html = "";
        // for debug
        // $html .= print_r($this->blocks, true);
        foreach ($this->blocks as $blockData) {
            $html .= $this->renderBlock($blockData);
        }

        return $html;
    }

    /**
     * renderBlock
     *
     * @param array $blockData
     * @return string
     */
    protected function renderBlock(array $blockData)
    {
        $renderer = $this->getRenderer($blockData['type']);
        if ($renderer) {
            $renderer->addData($blockData);
            return $renderer->toHtml();
        }
        return "";
    }

    /**
     * getRenderer
     *
     * @param string $type
     * @return \Magento\Framework\View\Element\Template|null
     */
    protected function getRenderer(string $type)
    {
        if (array_key_exists($type, $this->renderer)) {
            return $this->renderer[$type];
        }
        return null;
    }
}
