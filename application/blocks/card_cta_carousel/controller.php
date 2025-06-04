<?php
namespace Application\Block\CardCtaCarousel;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\Page\Page;
use Concrete\Core\File\File;

class Controller extends BlockController
{
    protected $btTable = 'btCardCtaCarousel';
    protected $btExportTables = ['btCardCtaCarousel', 'btCardCtaCarouselCards'];
    protected $btInterfaceWidth = 600;
    protected $btInterfaceHeight = 550;
    protected $btWrapperClass = 'ccm-ui';
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;

    public function getBlockTypeDescription()
    {
        return t('Carousel of cards with optional call to action.');
    }

    public function getBlockTypeName()
    {
        return t('Card CTA Carousel');
    }

    public function add()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
    }

    public function edit()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
        $db = $this->app->make('database')->connection();
        $rows = $db->fetchAll('SELECT * FROM btCardCtaCarouselCards WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $this->set('rows', $rows);
    }

    public function view()
    {
        $db = $this->app->make('database')->connection();
        $rows = $db->fetchAll('SELECT * FROM btCardCtaCarouselCards WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($rows as &$row) {
            $row['description'] = LinkAbstractor::translateFrom($row['description']);
            switch ((int)$row['linkType']) {
                case 1:
                    if ($row['internalLinkCID']) {
                        $page = Page::getByID($row['internalLinkCID']);
                        if (is_object($page) && !$page->isError()) {
                            $row['linkURL'] = $page->getCollectionLink();
                        }
                    }
                    break;
                case 3:
                    if ($row['fileLinkFID']) {
                        $f = File::getByID($row['fileLinkFID']);
                        if (is_object($f)) {
                            $row['linkURL'] = $f->getDownloadURL();
                        }
                    }
                    break;
            }
        }
        $this->set('rows', $rows);
    }

    public function duplicate($newBID)
    {
        $db = $this->app->make('database')->connection();
        $rows = $db->fetchAll('SELECT * FROM btCardCtaCarouselCards WHERE bID = ?', [$this->bID]);
        foreach ($rows as $row) {
            $db->insert('btCardCtaCarouselCards', [
                'bID' => $newBID,
                'iconFID' => $row['iconFID'],
                'title' => $row['title'],
                'description' => $row['description'],
                'linkType' => $row['linkType'],
                'linkURL' => $row['linkURL'],
                'internalLinkCID' => $row['internalLinkCID'],
                'fileLinkFID' => $row['fileLinkFID'],
                'sortOrder' => $row['sortOrder'],
            ]);
        }
    }

    public function delete()
    {
        $db = $this->app->make('database')->connection();
        $db->delete('btCardCtaCarouselCards', ['bID' => $this->bID]);
        parent::delete();
    }

    public function save($args)
    {
        $db = $this->app->make('database')->connection();
        $db->delete('btCardCtaCarouselCards', ['bID' => $this->bID]);
        parent::save($args);
        if (isset($args['title']) && is_array($args['title'])) {
            $count = count($args['title']);
            for ($i = 0; $i < $count; $i++) {
                $desc = isset($args['description'][$i]) ? LinkAbstractor::translateTo($args['description'][$i]) : '';
                $db->insert('btCardCtaCarouselCards', [
                    'bID' => $this->bID,
                    'iconFID' => intval($args['iconFID'][$i]),
                    'title' => $args['title'][$i],
                    'description' => $desc,
                    'linkType' => intval($args['linkType'][$i]),
                    'linkURL' => $args['linkURL'][$i],
                    'internalLinkCID' => intval($args['internalLinkCID'][$i]),
                    'fileLinkFID' => intval($args['fileLinkFID'][$i]),
                    'sortOrder' => intval($args['sortOrder'][$i]),
                ]);
            }
        }
    }

    public function getSearchableContent()
    {
        $db = $this->app->make('database')->connection();
        $rows = $db->fetchAll('SELECT * FROM btCardCtaCarouselCards WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $content = '';
        foreach ($rows as $row) {
            $content .= $row['title'] . ' ' . $row['description'] . ' ';
        }
        return $content;
    }
}
