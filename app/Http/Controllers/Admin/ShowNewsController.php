<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\ShowNews;
use App\Models\AdminModels\Show;
use App\Models\AdminModels\News;

class ShowNewsController extends Controller
{
    protected $passField = [
        'sort','sid','nid','status'
    ];

    public function show_news_list($sid,Request $request){
        if($request->isMethod('post')){
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['title'] = array('like','%'.$sSearch.'%');
                $orOpt['content'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = ShowNews::getHasNews(0,10,true,$orOpt,$betweenOpt,$sid);
        }else{
            $object = array();
        }
        return view('Admin.show_news.show_news-list',compact('object','sid'));
    }

    public function show_news_ajax_list($sid,Request $request){
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = ShowNews::getHasNews($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt,array(),$sid);
        $ShowNews = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $ShowNews['iTotalDisplayRecords'] = count($object);
        } else {
            $count = ShowNews::getHasNewsCount($sid);
            $ShowNews['iTotalDisplayRecords'] = $count;
        }
        return json_encode($ShowNews);

        //dd($object['show_news']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function show_news_add($sid,Request $request){
        if($request->isMethod('post')){
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['title'] = array('like','%'.$sSearch.'%');
                $orOpt['content'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = News::getNotShow(0,10,true,$orOpt,$betweenOpt,$sid);
        }else{
            $object = array();
        }
        return view('Admin.show_news.show_news-add',compact('object','sid'));
    }

    public function show_news_ajax_add($sid,Request $request){
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = News::getNotShow($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt,array(),$sid);
        $ShowNews = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $ShowNews['iTotalDisplayRecords'] = count($object);
        } else {
            $count = News::getNotShowCount($sid);
            $ShowNews['iTotalDisplayRecords'] = $count;
        }
        return json_encode($ShowNews);

        //dd($object['show_news']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function show_news_insert(Show $obj,Request $request){
        $nidList = explode(',',$request->get('id_list'));
        if ($nidList){
            $data = array();
            foreach ($nidList as $val){
                $data[] = ['nid' => intval($val)];
            }
            $res = $obj->show_news()->createMany($data);
        }else{
            $res = array();
        }

        if($res){
            $return['code'] = 1;
        }else{
            $return['code'] = 0;
        }
        return json_encode($return);
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new ShowNews();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
