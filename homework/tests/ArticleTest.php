<?php
use PHPUnit\Framework\TestCase;
include_once(dirname(__FILE__).'/../Article.php');
include_once(dirname(__FILE__).'/../LogHelper.php');
class ArticleTest extends TestCase
{
    protected $ins;
    public function setUp() : void
    {
        $this->ins = new Article();
    }
    public function tearDown() : void
    {
        $this->ins = null;
    }

    public function testGetArticleById() : void
    {
        $arr = array(
            'id' => 'a001'
        );
        $res = $this->ins->getArticleById($arr);
        $this->assertNotEmpty($res['res']);
    }

    public function testAddArticle() : void
    {
        $data = array(
            'article_name' => 'unit_test_article',
            'user_id' => 'unit_test_user',
            'sort_id' => '1',
            'article_content' => 'unit test:article_content',
            'article_author' => 'unit_test'
        );
        $res = $this->ins->addArticle($data);
        $this->assertNotEmpty($res['res']);
    }
}
