<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Plugin\Cms\Block;

use Magento\Cms\Block\Page as PageBlock;
use Wamoco\EditorJS\Block\Renderer\RendererFactory;

class Page
{
    /**
     * @var RendererFactory
     */
    protected $rendererFactory;

    /**
     * __construct
     *
     * @param RendererFactory $rendererFactory
     */
    public function __construct(RendererFactory $rendererFactory)
    {
        $this->rendererFactory = $rendererFactory;
    }

    /**
     * aroundToHtml
     *
     * @param PageBlock $subject
     * @param callable $proceed
     * @return string
     */
    public function aroundToHtml(PageBlock $subject, callable $proceed)
    {
        $page    = $subject->getPage();
        $content = $page->getContent();
        $data = json_decode($content, true);
        if (is_array($data) && array_key_exists('blocks', $data)) {
            $renderer = $this->rendererFactory->create([
                'blocks' => $data['blocks']
            ]);
            return $renderer->toHtml();
        }
        return $content;
    }
}
