<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\Modules\Billing\Models;

use Modules\Billing\Models\Invoice;
use Modules\Billing\Models\InvoiceType;
use Modules\Billing\Models\InvoiceStatus;
use phpOMS\Localization\ISO4217CharEnum;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class InvoiceTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $invoice = new Invoice();
        self::assertEquals(0, $invoice->getId());
        self::assertEquals('', $invoice->getNumber());
        self::assertEquals(InvoiceType::BILL, $invoice->getType());
        self::assertEquals(InvoiceStatus::DRAFT, $invoice->getStatus());
        self::assertInstanceOf('\DateTime', $invoice->getCreatedAt());
        self::assertEquals(null, $invoice->getSend());
        self::assertEquals(0, $invoice->getCreatedBy());
        self::assertEquals(ISO4217CharEnum::_EUR, $invoice->getCurrency());

        self::assertEquals('', $invoice->getShipTo());
        self::assertEquals('', $invoice->getShipFAO());
        self::assertEquals('', $invoice->getShipAddress());
        self::assertEquals('', $invoice->getShipCity());
        self::assertEquals('', $invoice->getShipZip());
        self::assertEquals('', $invoice->getShipCountry());

        self::assertEquals('', $invoice->getBillTo());
        self::assertEquals('', $invoice->getBillFAO());
        self::assertEquals('', $invoice->getBillAddress());
        self::assertEquals('', $invoice->getBillCity());
        self::assertEquals('', $invoice->getBillZip());
        self::assertEquals('', $invoice->getBillCountry());

        self::assertEquals(0, $invoice->getReferer());
        self::assertEquals('', $invoice->getRefererName());

        self::assertEquals('', $invoice->getTaxId());

        self::assertEquals(0, $invoice->getInsurance()->getInt());
        self::assertEquals(0, $invoice->getFreight()->getInt());
        self::assertEquals(0, $invoice->getNet()->getInt());
        self::assertEquals(0, $invoice->getGross()->getInt());
        self::assertEquals('', $invoice->getInfo());
        self::assertEquals(0, $invoice->getPayment());
        self::assertEquals(0, $invoice->getTerms());
        self::assertEquals('', $invoice->getTermsText());
        self::assertEquals(0, $invoice->getShipping());
        self::assertEquals('', $invoice->getShippingText());

        self::assertEquals([], $invoice->getTrackings());
        self::assertEquals([], $invoice->getElements());
    }

    public function testSetGet()
    {
        $invoice = new Invoice();

        $invoice->setNumber('123456');
        self::assertEquals('123456', $invoice->getNumber());

        $invoice->setType(InvoiceType::DELIVERY_NOTE);
        self::assertEquals(InvoiceType::DELIVERY_NOTE, $invoice->getType());
        
        $invoice->setStatus(InvoiceStatus::DONE);
        self::assertEquals(InvoiceStatus::DONE, $invoice->getStatus());

        $invoice->setSend(new \DateTime());
        self::assertEquals((new \DateTime())->format('Y-m-d'), $invoice->getSend()->format('Y-m-d'));

        $invoice->setCreatedBy(3);
        self::assertEquals(3, $invoice->getCreatedBy());

        $invoice->setCurrency(ISO4217CharEnum::_USD);
        self::assertEquals(ISO4217CharEnum::_USD, $invoice->getCurrency());

        $invoice->setShipTo('to');
        $invoice->setShipFAO('fao');
        $invoice->setShipAddress('address');
        $invoice->setShipCity('city');
        $invoice->setShipZip('zip');
        $invoice->setShipCountry('country');

        self::assertEquals('to', $invoice->getShipTo());
        self::assertEquals('fao', $invoice->getShipFAO());
        self::assertEquals('address', $invoice->getShipAddress());
        self::assertEquals('city', $invoice->getShipCity());
        self::assertEquals('zip', $invoice->getShipZip());
        self::assertEquals('country', $invoice->getShipCountry());

        $invoice->setBillTo('to');
        $invoice->setBillFAO('fao');
        $invoice->setBillAddress('address');
        $invoice->setBillCity('city');
        $invoice->setBillZip('zip');
        $invoice->setBillCountry('country');

        self::assertEquals('to', $invoice->getBillTo());
        self::assertEquals('fao', $invoice->getBillFAO());
        self::assertEquals('address', $invoice->getBillAddress());
        self::assertEquals('city', $invoice->getBillCity());
        self::assertEquals('zip', $invoice->getBillZip());
        self::assertEquals('country', $invoice->getBillCountry());

        $invoice->setReferer(4);
        self::assertEquals(4, $invoice->getReferer());
        
        $invoice->setRefererName('name');
        self::assertEquals('name', $invoice->getRefererName());

        $invoice->setTaxId('tax');
        self::assertEquals('tax', $invoice->getTaxId());

        $invoice->setInfo('info');
        self::assertEquals('info', $invoice->getInfo());

        $invoice->setPayment(5);
        self::assertEquals(5, $invoice->getPayment());

        $invoice->setTerms(6);
        self::assertEquals(6, $invoice->getTerms());

        $invoice->setTermsText('terms');
        self::assertEquals('terms', $invoice->getTermsText());

        $invoice->setShipping(7);
        self::assertEquals(7, $invoice->getShipping());

        $invoice->setShippingText('shipping');
        self::assertEquals('shipping', $invoice->getShippingText());
    }

}
