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

        $id = $this->param('id');
        $sides = array('attacker', 'defender');
        $campaign = $module->getCampaign($id);
        $stats = $module->getCampaignStats($campaign);
        $info = $campaign->toArray();

        foreach ($sides as $side) {
            $info[$side] = array('country' => $info[$side]);
            foreach ($stats[$side]['divisions'] as &$division) {
                $division['top_fighters']['@nodeName'] = 'citizen';
            }
            $stats[$side]['divisions']['@nodeName'] = 'division';
        }

        $data = array_merge_recursive(
            $info,
            $stats
        );

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
