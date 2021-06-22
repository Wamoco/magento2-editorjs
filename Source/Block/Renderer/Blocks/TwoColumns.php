<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Block\Renderer\Blocks;

use Wamoco\EditorJS\Block\Renderer\RendererFactory as BlockRendererFactory;

class TwoColumns extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = "Wamoco_EditorJS::renderer/twoColumns.phtml";

    /**
     * @var BlockRendererFactory
     */
    protected $blockRendererFactory;

    /**
     * __construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param BlockRendererFactory $blockRendererFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        BlockRendererFactory $blockRendererFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blockRendererFactory = $blockRendererFactory;
    }

    public function renderColumn($index)
    {
        $data = $this->getData('data');
        if (!$data) {
            return "";
        }
        if (array_key_exists('itemContent', $data)) {
            if (isset($data['itemContent'][$index])) {
                return $this->renderBlocks($data['itemContent'][$index]['blocks']);
            }
        }
        return "";
    }

    protected function renderBlocks($blocks)
    {
        $renderer = $this->blockRendererFactory->create(['blocks' => $blocks]);
        return $renderer->toHtml();
    }
}
