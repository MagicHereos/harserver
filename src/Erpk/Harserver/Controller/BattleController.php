<?php
namespace Erpk\Harserver\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Erpk\Harserver\ViewModel;
use Erpk\Harvester\Module\Military\MilitaryModule;

class BattleController extends Controller
{
    public function battle()
    {
        $module = new MilitaryModule($this->client);

        $campaign = $module->getCampaign($this->param('id'));
        $stats = $module->getCampaignStats($campaign);
        
        $data = array_merge($campaign->toArray(), $stats);

        foreach (array('attacker','defender') as $side) {
            for ($i=1; $i <= 4; $i++) {
                $data[$side]['divisions'][$i]['top_fighters']['@nodeName']='citizen';
            }
            $data[$side]['divisions']['@nodeName'] = 'division';
        }

        $vm = new ViewModel($data);
        $vm->setRootNodeName('battle');
        return $vm;
    }
    
    public function active()
    {
        $module = new MilitaryModule($this->client);

        $data = $module->getActiveCampaigns();
        $data = $data['all'];
        $data['@nodeName'] = 'battle';
        
        $vm = new ViewModel($data);
        $vm->setRootNodeName('battles');
        return $vm;
    }
}