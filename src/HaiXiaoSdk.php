<?php

namespace Wored\HangZhouHaiXiaoSdk;


use Hanson\Foundation\Foundation;

/***
 * Class HaiXiaoSdk
 * @package \Wored\HangZhouHaiXiaoSdk
 *
 * @property \Wored\HangZhouHaiXiaoSdk\Api $api
 */
class HaiXiaoSdk extends Foundation
{
    protected $providers = [
        ServiceProvider::class
    ];

    public function __construct($config)
    {
        $config['debug'] = $config['debug'] ?? false;
        parent::__construct($config);
    }
    /**
     * 可调用该API接口创建发货单
     * @param array $order 以数组的信息拼装
     * @return mixed
     */
    public function createOrder(array $order)
    {
        return $this->api->request('ecm_deliveryorder_create', $order);
    }

    /**
     * 可调用该API接口ERP主动发起取消某些创建的单据, 如入库单、出库单、退货单等, 所有的场景
     * @param array $order
     * @return mixed
     */
    public function refundOrder(array $order)
    {
        return $this->api->request('ecm_order_cancel', $order);
    }

    /**
     * 仓库出库单发货完成后, 把出库单和包裹信息回传给ERP
     * @param array $order
     * @return mixed
     */
    public function deliveryOrderConfirm(array $order)
    {
        return $this->api->request('ecm_deliveryorder_confirm', $order);
    }

    /**
     * 可调用该API接口仓库把库存信息同步给ERP
     * @param array $order
     * @return mixed
     */
    public function inventorySynchronize(array $order)
    {
        return $this->api->request('ecm_inventory_synchronize', $order);
    }

    /**
     * 仓库在海关清单放行之后，把状态同步给erp
     * @param array $order
     * @return mixed
     */
    public function customsClearance(array $order)
    {
        return $this->api->request('ecm_customs_clearance', $order);
    }
}