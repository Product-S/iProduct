<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: liuyidi
 * Date: 16/3/31
 * Time: 04:08
 */
class Follow extends CB_Controller{

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model("follow_m");
        $this->load->model("user_m");
        $this->uid=$this->session->userdata('uid');
    }

    /*
     * 添加关注
     * ajax
     */
    public function addFollow(){
        if($this->uid == false){
            return;
        }

        if($this->input->is_ajax_request()){

            $data = array(
                'follower_id' => $this->uid,
                'followed_id' => $this->input->post('followed_id'),
                'add_time' => time()
            );
            //需判断是否已经关注
            $result = $this->follow_m->add_follow($data);
            if($result == true){
                $list["status"] = "关注成功";
                $list["code"] = "200";
                $list["result"] = $result;
            }
            return $this->output->set_content_type('application/json')->set_output(json_encode($list));
        }
    }

    /*
     * 取消关注
     * ajax
     */
    public function unFollow(){
        if($this->input->is_ajax_request()){
            $value = $this->follow_m->un_follow($this->uid,$this->input->post('followed_id'));
            if($value == true){
                $result["status"] = "取消关注成功";
                $result["code"] = "200";
                $result["value"] = $value;
            }
            return $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    /*
     * 得到用户所有的关注信息
     * ajax get
     */
    public function getAllFollowers(){
        if($this->input->is_ajax_request()){
            $query = $this->follow_m->get_followings_by_uid($this->input->post('page_id'),10);
//            if(int i = 0; i<$query.length; i++){
//                $result[i] = $this->user_m->get_user_by_id($query[i]);
//            }
            $result["code"] = "200";
            $result["meg"] = "查询信息成功";
            return $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    /*
     * 得到用户所有的粉丝信息
     * ajax get
     */
    public function getAllFollowings(){

    }

}