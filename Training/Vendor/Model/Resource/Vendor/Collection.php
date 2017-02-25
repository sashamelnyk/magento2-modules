<?php

namespace Training\Vendor\Model\Resource\Vendor;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Training\Vendor\Model\Vendor',
            'Training\Vendor\Model\Resource\Vendor'
        );
    }
}
