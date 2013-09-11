<?php
namespace Erpk\Harserver\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Erpk\Harserver\ViewModel;
use Erpk\Harvester\Module\Exchange\ExchangeModule;

class ExchangeController extends Controller
{
    public function get()
    {
        switch ($this->param('mode')) {
            case 'cc':
                $buy = ExchangeModule::CURRENCY;
                break;
            case 'gold':
            default:
                $buy = ExchangeModule::GOLD;
                break;
        }

        $module = new ExchangeModule($this->client);
        $offers = $module->scan($buy, $this->param('page'));

        $data = array(
            'paginator' => $offers->getPaginator()->toArray(),
            'offers'    => $offers->getArrayCopy()
        );
        $data['offers']['@nodeName'] = 'offer';

        $vm = new ViewModel($data);
        $vm->setRootNodeName('offers');
        return $vm;
    }
}
