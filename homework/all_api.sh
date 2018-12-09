#!/bin/bash

case ${1} in
"get_article")
    # 获取文章详情
    article_id=${2} #a001
    curl http://39.105.213.219:8991/api/v1/article/getArticleById -d'{"id":"'${article_id}'"}' -H 'Content-Type: application/json' -H 'Cache-Control: no-cache';;
"add_article")
    # 新增文章
    user_id=${2}
    sort_id=${3}
    article_name=${4}
    article_content=${5}
    article_author=${6}
    res='{"user_id":"'${user_id}'","sort_id":"'${sort_id}'","article_name":"'${article_name}'","article_content":"'${article_content}'","article_author":"'${article_author}'"}'
    #curl http://39.105.213.219:8991/api/v1/article/addArticle -H 'Cache-Control: no-cache' -H 'Content-Type: application/json' -X POST -d "'"${res}"'"

    curl http://39.105.213.219:8991/api/v1/article/addArticle -H 'Cache-Control: no-cache' -H 'Content-Type: application/json' -X POST -d'{"user_id":"linhxx","sort_id":"10","article_name":"test insert","article_content":"this is an test article for insert","article_author":"linhxx"}';;
esac
    exit;
    curl http://39.105.213.219:8991/api/v1/article/addArticle -d'{"user_id":"'${user_id}'","sort_id":"'${sort_id}'","article_content":"'${article_content}'","article_author":"'${article_author}'"}' -H 'Content-Type: application/json' -H 'Cache-Control: no-cache'
