<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SearchController extends Controller{

    public function search(Request $request){
        $data = (object) $request->all();
        $response = array('status' => 1 , 'suggestions' => [] , 'query' => $data->query);
        try {
            $queryArr = explode(" ",trim($data->query));
            $searched_data = $this->getQuery($data->query);
            $response['suggestions'] = $searched_data ?? $this->search_each_word($data->query);
        } catch (\Exception $ex) {
            $response['status'] = 0;
            $response['suggestions'] = $ex->getMessage();
        }
        return $response;
    }
    private function search_each_word($query){
        $queryArr = explode(" ",$query);
        $suggestions = array();
        foreach ($queryArr as $value)  $suggestions = array_merge($suggestions,$this->getQuery($value));
        return array_keys(array_flip($suggestions));
    }
    private function getQuery($search_item){
        return DB::table("tbl_vehicles")->select("short_name")->where('short_name','LIKE','%'.$search_item.'%')->get()
        ->map(function($data){
            return $data->short_name;
        })->toArray();
    }
}