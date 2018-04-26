<?php
namespace App\Providers\DisplaySystem;

class DisplayService implements DisplayContract {

    public function getPageLayout($page_id){

        $news_obj = get_model_obj('PageEdit');

        $components = $news_obj->getPageLayout($page_id);

        return $components;

    }

    public function getList($Model,$skip,$limit,$opt=[]){//$opt为特殊条件项,其中 page 为所在页面，field = [] 定义为需要动态变化属性

        //这里的列表缓存利用 Model +  Page 与 $skip 与 $limit

        $news_obj = get_model_obj($Model);

        $func = 'get' . $Model . 'List';

        $newLists = $news_obj->$func($skip,$limit,$opt);

        if (!empty($opt['field'])&&is_array($opt['field'])){

            foreach ($opt['field'] as $field){

                $this->getCorrespond($Model,$field,$newLists);
            }
        }
        return $newLists;
    }

    public function getCorrespond($model,$field,&$newLists){

        $func = 'get'.$field;

        foreach ($newLists as $key=>$new){

            $field = uncamelize($field,$separator='_');

            if (is_array($new)) {
                $newLists[$key][$field] = $this->$func($model,$new['id']);
            }else{
                $newLists[$key]->$field = $this->$func($model,$new->id);
            }
        }
    }

    //下面为列表中实时会变得属性，为了保证数据实时更新，所以单独拿出来查询缓存

    public function getComment($model,$id){//获取评论数

        $news_obj = get_model_obj($model);

        $comment = $news_obj->getComment($id);

        return $comment;
    }
    public function getCommentList($model,$id){//获取评论列表

        $news_obj = get_model_obj($model);

        $comment_list = $news_obj->CommentList($id);

        return $comment_list;
    }
    public function getView($model,$id){//获取浏览量

        $news_obj = get_model_obj($model);

        $view = $news_obj->getView($id);

        return $view;
    }
    public function getCollection($model,$id){//获取收藏数量

        $news_obj = get_model_obj($model);

        $collection = $news_obj->getCollection($id);

        return $collection;
    }

    public function getTop($model,$id){//获取点赞的数量

        $news_obj = get_model_obj($model);

        $hot = $news_obj->getTop($id);

        return $hot;
    }
}