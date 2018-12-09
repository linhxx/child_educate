<?php
include_once(dirname(__FILE__) . '/BaseClass.php');
class LogHelper extends BaseClass
{
    private $conn;
    public function __construct()
    {
       $this->conn = $this->initMysqlConn('root','JUg623b08@#cw','39.105.213.219','3306','record'); 
    }

    public function getLogById($data)
    {
        $id = isset($data['id']) ? $data['id'] : 0;
        if (empty($id))
        {
             return array('res'=>'0','msg'=>'please find an id','info'=>array());
        }
        $sql = 'select * from log_info where log_id = "' . $id . '"';
        $res = array();
        $queryRes = $this->getInfoByQuery($this->conn, $sql);
        foreach($queryRes as $row)
        {
            $tmp = array(
                'log_id' => $row['log_id'],
                'user_id' => $row['user_id'],
                'article_id' => $row['article_id'],
                'log_type' => $row['log_type'],
                'log_operation' => $row['log_operation'],
                'log_createdate' => $row['log_createdate'],
                'remark' => $row['remark'],
            );
            $res[] = $tmp;
        }
        //发送http请求写日志
        return array('res'=>'1','msg'=>'','info'=>$res);

    }

    public function addLog($logInfo)
    {
        $userId = isset($logInfo['user_id']) ? $logInfo['user_id'] : '';
        $articleId = isset($logInfo['article_id']) ? $logInfo['article_id'] : '';
        $logType = isset($logInfo['log_type']) ? $logInfo['log_type'] : '';
        $logOperation = isset($logInfo['log_operation']) ? $logInfo['log_operation'] : '';
        $logCreatedate = date('Y-m-d H:i:s');
        $remark = isset($logInfo['remark']) ? $logInfo['remark'] : '';
        if (empty($userId) || empty($articleId) || empty($logOperation) || empty($logCreatedate))
        {
            return array('res'=>'0','msg'=>'some parameters lack');
        }
        $logId = $this->generateLogId();
        if (empty($logId))
        {
            return array('res'=>'0','msg'=>'can\'t get an avaiable log_id');
        }
        $sql = 'insert into log_info values("'.$logId.'","'.$userId.'","'.$articleId.'","'.$logType.'","'.$logOperation.'","'.$logCreatedate.'","'.$remark.'")';
        $affectRows = $this->modifyData($this->conn, $sql);
        if (empty($affectRows))
        {
            return array('res'=>'0','msg'=>'add log failed');    
         }
        return array('res'=>'1','msg'=>'add log succeed, affected row:' . $affectRows . ',log_id:' . $logId);
  }

  //生成log_info表的id
  private function generateLogId()
  {
    //确认获取到的log_id不存在
    $logId = $this->generateId('log');
    $log = $this->getLogById(array('id' => $logId));
    $retry = 0;
    while ($retry < 10 && false == empty($log['info']))
    {
        $retry++;
        $logId = $this->generateId('log');
        $log = $this->getLogById(array('id' => $logId));
    }
    if ($retry >= 10)
    {
        return '';
    }
    return $logId;
  }
    
}


