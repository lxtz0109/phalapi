<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\Examples\CURD as DomainCURD;
use PhalApi\Response;

/**
 * 湖人家庭
 */
class Lakers extends Api {

	/**
	 * 湖人队接口
     * @desc这是一个测试湖人数据的接口
	 */
	public function world() {
        $domainCurd = new DomainCURD();
        $listItems = $domainCurd->getList(1,1,10);

        return $listItems;
        //设置状态码
        //\PhalApi\DI()->response->setRet(1000);
        //手动设置提示消息
        //\PhalApi\DI()->response->setMsg('手动设置提示消息');
		//return array('content' => '中国','data' => $listItems);
	}


}