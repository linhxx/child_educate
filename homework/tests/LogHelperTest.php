<?php
use PHPUnit\Framework\TestCase;
include_once(dirname(__FILE__).'/../LogHelper.php');
class LogHelperTest extends TestCase
{
    protected $ins;
    public function setUp() : void
    {
        $this->ins = new LogHelper();
    }
    public function tearDown() : void
    {
        $this->ins = null;
    }

    public function testGetLogById() : void
    {
        $arr = array(
            'id' => 'L001',
        );
        $res = $this->ins->getLogById($arr);

        $this->assertNotEmpty($res['res']);
    }
    public function testAddLog() : void
    {
        $data = array(
            'user_id' => 'unit_test_user',
            'article_id' => 'unit_test_article',
            'log_type' => 'unit_test_type',
            'log_operation' => 'unit_test_operation',
            'remark' => 'unit_test_remark'
        );
        $res = $this->ins->addLog($data);
        $this->assertNotEmpty($res['res']);
    }
}
