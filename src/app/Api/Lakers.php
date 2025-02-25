<?php

namespace App\Api;

use PhalApi\Api;

/**
 * 湖人家庭
 */
class Lakers extends Api {

	/**
	 * 湖人队接口
     * @desc这是一个测试湖人数据的接口
	 */
	public function world() {
		return array('content' => 'Lakers');
	}
}