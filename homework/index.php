<?php
ini_set('date.timezone','Asia/Shanghai');
include_once(dirname(__FILE__) . '/BaseClass.php');
include_once(dirname(__FILE__) . '/Article.php');
include_once(dirname(__FILE__) . '/LogHelper.php');


// 获取请求的内容，确认要分发的class、method
$queryString = $_SERVER['QUERY_STRING'];//control=article&method=getArticleById
$querys = explode('&', $queryString);
$controlInfo = explode('=', $querys[0]);//control=article
$controlClass = new $controlInfo[1]();//method=getArticleById
$methodInfo = explode('=', $querys[1]);
$method = $methodInfo[1];
// 获取curl -d的参数的数组形式，并且调用函数
$res = $controlClass->$method(BaseClass::getQueryArray());
// 输出处理的结果，作为返回
echo json_encode($res);

/*
//远程调用方式如下
curl http://39.105.213.219:8995/api/v1/account/check -H 'Content-Type: application/json' -H 'Cache-Control: no-cache' -d'{"id":"a001"}' [-X POST]
*/
