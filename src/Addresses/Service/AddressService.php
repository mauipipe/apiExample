<?php

namespace Addresses\Service;
use Addresses\Repository\AddressDbInterface;

/**
 * @author davidcontavalli <david.contavalli@lovoo.com>
 */
class AddressService
{
    /**
     * @var AddressDbInterface
     */
    private $addressesRepo;

    /**
     * AddressService constructor.
     * @param AddressDbInterface $addressesRepo
     */
    public function __construct(AddressDbInterface $addressesRepo)
    {
        $this->addressesRepo = $addressesRepo;
    }

    public function getAddresses()
    {
        return $this->addressesRepo->fetchAddresses();
    }
}