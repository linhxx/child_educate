<?php

class BaseClass
{
    public function initMysqlConn($user, $pass, $host, $port, $db = '')
    {
        $link = mysqli_connect($host,$user,$pass,$db,$port);
        return $link;

        //连接数据库
        // return $conn;
    }
    
    // 根据sql获取查询结果
    protected function getInfoByQuery($conn, $sql)
    {
        //查询数据库获取数据库信息
        $res = $conn->query($sql);
        $resArr = array();
        while($row = $res->fetch_assoc())
        {
            $resArr[] = $row;
        }
        return $resArr;
    }
    
    // 写入数据库，返回影响的行数
    protected function modifyData($conn, $sql)
    {
        //查询数据库获取数据库信息
        $conn->query($sql);
        return $conn->affected_rows;
    }

    // 获取curl请求的data
    public static function getQueryString()
    {
        $res = file_get_contents("php://input");
        if (empty($res))
        {
            $res = $GLOBALS['HTTP_RAW_POST_DATA'];
        }
        return $res;
    }

    //获取curl请求的data--数组形式
    public static function getQueryArray()
    {
        $res = self::getQueryString();
        return json_decode($res, true);
    }

    //获取某一类型的id
    public static function generateId($type)
    {
        return $type . time() . rand(100, 999);
    }
}
