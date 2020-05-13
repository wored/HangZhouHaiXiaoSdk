<h1 align="center">杭州海销跨境订单申报接口</h1>

## 安装

```shell
$ composer require wored/haixiao-sdk -vvv
```

## 使用
```php
<?php

use \Wored\HangZhouHaiXiaoSdk\HaiXiaoSdk;

$config = [
    'userid'   => 'testhxecm1',
    'password' => '0123456789012345',
    'rootUrl'  => 'http://183.134.101.40/ecmtest/omsinf/ecm1/receive',
    'debug'    => true,
];

// 实例化海销sdk
$haixiao = new HaiXiaoSdk($config);

```
> 创建发货单
```php
<?php
   $order['request'] = [
       'deliveryOrder' => [
           'deliveryOrderCode'    => time(),//出库单号/订单号, string (50) , 必填
           'preDeliveryOrderCode' => '',//原出库单号（ERP分配）, string (50) , 条件必填，条件为换货出库
           'preDeliveryOrderId'   => '',//原出库单号（WMS分配）, string (50) , 条件必填，条件为换货出库
           'orderType'            => 'JYCK',//出库单类型, string (50) , 必填, JYCK=一般交易出库单, HHCK=换货出库单, BFCK=补发出库单，QTCK=其他出库单
           'warehouseCode'        => 'OTHER',//仓库编码, string (50)，必填 ，统仓统配等无需ERP指定仓储编码的情况填OTHER
           'orderFlag'            => 'COD',//订单标记 ，用字符串格式来表示订单标记列表： 比如COD, 中间用“^”来隔开，string (200) ， COD =货到付款 , LIMIT=限时配送 , PRESELL=预售 , COMPLAIN=已投诉 , SPLIT=拆单,  EXCHANGE=换货,  VISIT=上门 ,  MODIFYTRANSPORT=是否可改配送方式,  是否可改配送方式 默认可更改 , CONSIGN =物流宝代理发货, 自动更改发货状态 SELLER_AFFORD =是否卖家承担运费 默认是, 即没 ,  FENXIAO=分销订单
           'expressCode'          => '',//运单号, string (50)
           'logisticsAreaCode'    => '',//快递区域编码, 大头笔信息, string (50)
           'senderInfo'           => [
               'company'       => '',//公司名称, string (200)
               'name'          => '',//姓名, string (50)
               'zipCode'       => '',//邮编, string (50)
               'tel'           => '',//固定电话, string (50)
               'mobile'        => '',//移动电话, string (50)
               'email'         => '',//电子邮箱, string (50)
               'countryCode'   => '',//国家二字码，string（50）
               'province'      => '',//省份, string (50)
               'city'          => '',//城市, string (50)
               'area'          => '',//区域, string (50)
               'town'          => '',//村镇, string (50)
               'detailAddress' => '',//详细地址, string (200)
           ],
           'receiverInfo'         => [
               'company'       => '',//公司名称, string (200)
               'name'          => 'test',//姓名, string (50) , 必填
               'zipCode'       => '',//邮编, string (50)
               'tel'           => '',//固定电话, string (50)
               'mobile'        => '13123456789',//移动电话, string (50) , 必填
               'idType'        => 1,//收件人证件类型，string (50)， 1-身份证 2-军官证 3-护照 4-其他
               'idNumber'      => '412829399933330293',//收件人证件号码，string (50)
               'email'         => '',//电子邮箱, string (50)
               'countryCode'   => '',//国家二字码，string（50）
               'province'      => '河南省',//省份, string (50) , 必填
               'city'          => '郑州市',//城市, string (50) , 必填
               'area'          => '郑东新区',//区域, string (50)  , 必填
               'town'          => '',//村镇, string (50)
               'detailAddress' => '',//详细地址, string (200) , 必填
           ],
           'isUrgency'            => '',//是否紧急, Y/N, 默认为N
           'invoiceFlag'          => '',//是否需要发票, Y/N, 默认为N
           'insuranceFlag'        => '',//是否需要保险, Y/N, 默认为N
           'buyerMessage'         => '',//买家留言, string (500)
           'sellerMessage'        => '',//卖家留言, string (500)
           'buyerName'            => 'test',//买家真实姓名 , 必填
           'buyerIdType'          => 1,//买家证件类型 , 必填，string (50)， 1-身份证 2-军官证 3-护照 4-其他
           'buyerIdNumber'        => '412829399933330293',//买家证件号码 , 必填，string (50)
           'orderTaxAmount'       => 9.1,//订单税款 , 必填
           'payCompanyCode'       => 'test',//支付公司编码 , 必填
           'remark'               => '',//备注，string（500）
       ],
       'orderLines'    => [
           'orderLine' => [
               'orderLineNo'        => 0,//单据行号，string（50）
               'sourceOrderCode'    => '',//交易平台订单, string (50)
               'subSourceOrderCode' => '',//交易平台子订单编码, string (50)
               'payNo'              => '',//支付平台交易号, string(50), 淘系订单传支付宝交易号
               'ownerCode'          => '',//货主编码, string (50)
               'itemCode'           => 'test',//商品编码, string (50) , 必填
               'itemId'             => 'test',//仓储系统商品编码, string (50) ,条件必填
               'inventoryType'      => '',//库存类型，string (50) , ZP=正品, CC=残次,JS=机损, XS= 箱损, ZT=在途库存，默认为查所有类型的库存
               'itemName'           => 'XXXXXX',//商品名称, string (200)
               'extCode'            => 'XXXXXX',//交易平台商品编码, string (50)
               'planQty'            => 1,//应发商品数量, int, 必填
               'retailPrice'        => 100,//零售价, double (18, 2) , 零售价=实际成交价+单件商品折扣金额
               'actualPrice'        => 100,//实际成交价, double (18, 2) , 必填，未税价
               'discountAmount'     => 0,//单件商品折扣金额, double (18, 2)
               'batchCode'          => '',//批次编码, string (50)
               'productDate'        => '',//生产日期，string(10)，YYYY-MM-DD
               'expireDate'         => '',//过期日期，string(10)，YYYY-MM-DD
           ]
       ]
   ];
   $haixiao->createOrder($order);  
```
> 取消订单
```php
<?php
   $refundOrder = [
       'request' => [
           'warehouseCode' => 'OTHER',//仓库编码, string (50)，必填 ，统仓统配等无需ERP指定仓储编码的情况填OTHER
           'ownerCode'     => '',//货主编码, string (50)
           'orderCode'     => time(),//单据编码, string (50) ，必填
           'orderId'       => 'test',//仓储系统单据编码,  string (50) ，条件必填
           'orderType'     => 'JYCK',//单据类型,  JYCK= 一般交易出库单，HHCK= 换货出库 ，BFCK= 补发出库 PTCK=普通出库单，DBCK=调拨出库 ，B2BRK=B2B入库，B2BCK=B2B出库，QTCK=其他出库， SCRK=生产入库，LYRK=领用入库，CCRK=残次品入库，CGRK=采购入库 ，DBRK= 调拨入库 ，QTRK= 其他入库 ，XTRK= 销退入库，THRK=退货入库，HHRK= 换货入库 ，CNJG= 仓内加工单 ，CGTH=采购退货出库单
           'cancelReason'  => '',//取消原因, string (500)
       ]
   ];
   $haixiao->refundOrder($refundOrder);  

```

## License

MIT