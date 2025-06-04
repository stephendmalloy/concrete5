<?php
namespace Application\Block\TeamMemberRepeater;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\File\File;

class Controller extends BlockController
{
    protected $btTable = 'btTeamMemberRepeater';
    protected $btExportTables = ['btTeamMemberRepeater', 'btTeamMemberRepeaterMembers'];
    protected $btInterfaceWidth = 600;
    protected $btInterfaceHeight = 600;
    protected $btWrapperClass = 'ccm-ui';
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;

    public function getBlockTypeName()
    {
        return t('Team Member Repeater');
    }

    public function getBlockTypeDescription()
    {
        return t('List team members with headshot and bio.');
    }

    public function add()
    {
        $this->requireAsset('core/file-manager');
    }

    public function edit()
    {
        $this->requireAsset('core/file-manager');
        $db = $this->app->make('database')->connection();
        $this->set('rows', $db->fetchAll('SELECT * FROM btTeamMemberRepeaterMembers WHERE bID = ? ORDER BY sortOrder', [$this->bID]));
    }

    public function view()
    {
        $db = $this->app->make('database')->connection();
        $rows = $db->fetchAll('SELECT * FROM btTeamMemberRepeaterMembers WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        foreach ($rows as &$row) {
            $row['bio'] = LinkAbstractor::translateFrom($row['bio']);
        }
        $this->set('rows', $rows);
    }

    public function duplicate($newBID)
    {
        $db = $this->app->make('database')->connection();
        $rows = $db->fetchAll('SELECT * FROM btTeamMemberRepeaterMembers WHERE bID = ?', [$this->bID]);
        foreach ($rows as $row) {
            $db->insert('btTeamMemberRepeaterMembers', [
                'bID' => $newBID,
                'firstName' => $row['firstName'],
                'lastName' => $row['lastName'],
                'headshotFID' => $row['headshotFID'],
                'bio' => $row['bio'],
                'sortOrder' => $row['sortOrder'],
            ]);
        }
    }

    public function delete()
    {
        $db = $this->app->make('database')->connection();
        $db->delete('btTeamMemberRepeaterMembers', ['bID' => $this->bID]);
        parent::delete();
    }

    public function save($args)
    {
        $db = $this->app->make('database')->connection();
        $db->delete('btTeamMemberRepeaterMembers', ['bID' => $this->bID]);
        parent::save($args);
        if (isset($args['firstName']) && is_array($args['firstName'])) {
            $count = count($args['firstName']);
            for ($i = 0; $i < $count; $i++) {
                $bio = isset($args['bio'][$i]) ? LinkAbstractor::translateTo($args['bio'][$i]) : '';
                $db->insert('btTeamMemberRepeaterMembers', [
                    'bID' => $this->bID,
                    'firstName' => $args['firstName'][$i],
                    'lastName' => $args['lastName'][$i],
                    'headshotFID' => intval($args['headshotFID'][$i]),
                    'bio' => $bio,
                    'sortOrder' => intval($args['sortOrder'][$i]),
                ]);
            }
        }
    }

    public function getSearchableContent()
    {
        $db = $this->app->make('database')->connection();
        $rows = $db->fetchAll('SELECT * FROM btTeamMemberRepeaterMembers WHERE bID = ? ORDER BY sortOrder', [$this->bID]);
        $content = '';
        foreach ($rows as $row) {
            $content .= $row['firstName'] . ' ' . $row['lastName'] . ' ' . $row['bio'] . ' ';
        }
        return $content;
    }
}
