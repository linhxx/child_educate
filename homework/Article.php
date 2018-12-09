<?php
include_once(dirname(__FILE__) . '/BaseClass.php');
class Article extends BaseClass
{
    private $conn;
    public function __construct()
    {
        $this->conn = $this->initMysqlConn('root','JUg623b08@#cw','39.105.213.219','3306','article');
    }

    public function getArticleById($data)
    {
        $id = isset($data['id']) ? $data['id'] : 0;
        if (empty($id))
        {
            return array('res'=>'0','msg'=>'please find an id','info'=>array());
        }
        $sql = 'select * from article_info where article_id = "' . $id . '"';
        $res = array();
        $queryRes = $this->getInfoByQuery($this->conn, $sql);
        foreach($queryRes as $row)
        {
            $tmp = array(
                'article_name' => $row['article_name'],
                'user_id' => $row['user_id'],
                'sort_id' => $row['sort_id'],
                'article_datetime' => $row['article_datetime'],
                'article_content' => $row['article_content'],
                'article_author' => $row['article_author'],
                'article_id' => $row['article_id'],
            );
            $res[] = $tmp;
        }
        return array('res'=>'1','msg'=>'','info'=>$res);
    }

    public function addArticle($data)
    {
        $articleName = isset($data['article_name']) ? $data['article_name'] : '';
        $userId = isset($data['user_id']) ? $data['user_id'] : '';
        $sortId = isset($data['sort_id']) ? $data['sort_id'] : '';
        $articleDatetime = date('Y-m-d H:i:s');
        $articleContent = isset($data['article_content']) ? $data['article_content'] : '';
        $articleAuthor = isset($data['article_author']) ? $data['article_author'] : '';
        if (empty($articleName) || empty($userId) || empty($sortId))
        {
            return array('res'=>'0','msg'=>'some parameters lack');
        }
        $articleId = $this->generateArticleId();
        if (empty($articleId))
        {
            return array('res'=>'0','msg'=>'can\'t get an available article_id');
        }
        $sql = 'insert into article_info values("'.$articleId.'","'.$articleName.'","'.$userId.'","'.$sortId.'","'.$articleDatetime.'","'.$articleContent.'","'.$articleAuthor.'")';
        $affectRows = $this->modifyData($this->conn, $sql);
        if (empty($affectRows))
        {
            return array('res'=>'0','msg'=>'add article failed');
        }
        // 发送http请求写日志
        $logData = array(
            'user_id' => $userId,
            'article_id' => $articleId,
            'log_type' => 'article',
            'log_operation' => 'insert',
            'remark' => 'article ' . $articleName . ' has been inserted at time: ' . $articleDatetime
        );
        $this->sendLog($logData);
        return array('res'=>'1','msg'=>'add article successfully, affected row:' . $affectRows . ', article_id:' . $articleId);
    }

    // 生成article_info表的id
    private function generateArticleId()
    {
        // 确认获取到的articleid不存在
        $articleId = $this->generateId('info');
        $article = $this->getArticleById(array('id' => $articleId));
        $retry = 0;
        while ($retry < 10 && false == empty($article['info']))
        {
            $retry++;
            $articleId = $this->generateId('info');
            $article = $this->getArticleById(array('id' => $articleId));
        }
        if ($retry >= 10)
        {
            return '';
        }
        return $articleId;
    }

    // 发送日志
    private function sendLog($data)
    {
        $ins = new LogHelper();
        $ins->addLog($data);
    }
}
