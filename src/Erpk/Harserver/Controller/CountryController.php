<?php
namespace Erpk\Harserver\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Erpk\Harserver\ViewModel;
use Erpk\Harvester\Module\Country\CountryModule;
use Erpk\Common\EntityManager;

class CountryController extends Controller
{
    protected function get($type)
    {
        $module = new CountryModule($this->client);
        $em = EntityManager::getInstance();
        $countries = $em->getRepository('\Erpk\Common\Entity\Country');
        $country = $countries->findOneByCode($this->param('code'));
        $data = $module->{'get'.$type}($country);

        switch ($type) {
            case 'Economy':
                $data['embargoes']['@nodeName'] = 'embargo';
                break;
            case 'Society':
                $data['regions']['@nodeName'] = 'region';
                break;
        }
        $vm = new ViewModel($data);
        $vm->setRootNodeName('country');
        
        return $vm;
    }
    
    public function society()
    {
        return $this->get('Society', $this->param('code'));
    }
    
    public function economy()
    {
        return $this->get('Economy', $this->param('code'));
    }
}
