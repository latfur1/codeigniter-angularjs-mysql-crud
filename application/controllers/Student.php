<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student extends CI_Controller
{

    public function student_list(){
       $perpage=10;
       $page=$this->input->get('page', true);
       $page=($page-1)*$perpage;
       
       $search_input=$this->input->get('search_input', true);
       if($search_input!=''){
       
         $this->db->like('student_name', $search_input);
         $this->db->or_like('email_address', $search_input);
         $this->db->or_like('contact', $search_input);
         $this->db->or_like('gender', $search_input);
         $this->db->or_like('country', $search_input);
         
         
       }  
        $tempdb = clone $this->db;
        $total_row=  $tempdb->from('students')->count_all_results();
        $this->db->limit($perpage, $page); 
        $this->db->order_by("student_id", "desc");
        $result = $this->db->get('students')->result_array();
        $data=array();
        $data['student_data'] = $result;
        $data['total_row'] = $total_row;
        echo  json_encode($data);
    }
    
  public function create_student_info(){
         
        $post_data =(array) json_decode(file_get_contents("php://input"));
        $result= $this->db->insert( 'students', $post_data);
        if($result){
           $message['message']='Succefully Created Student Info';     
        }else{
            $message['message']='An error occurred while inserting data';     
        }    
       echo json_encode($message); 
        
    }
    
    public function view_student_by_student_id(){
        $student_id=  $this->input->get('student_id', true);
       if(isset($student_id)){
       $this->db->where('student_id',$student_id);
       $result = $this->db->get('students')->row_array();
       echo json_encode($result); 
    
       }  
    }
    
    
    public function update_student_info(){
        
      $update_data =(array) json_decode(file_get_contents("php://input"));
        
       if(isset($update_data['student_id'])){
            $student_id=$update_data['student_id'];
             unset($update_data['student_id']); 
    
           $this->db->where('student_id', $student_id);
            $result=$this->db->update('students', $update_data); 

        if($result){
                  $message['message']='Succefully Updated Student Info';     
               }else{
                   $message['message']='An error occurred while inserting data';     
               }
        echo json_encode($message);   

       }   
    }
    
    public function delete_student_info_by_id(){
           $student_id= $this->input->get('student_id', true);
       if(isset($student_id)){
        $this->db->where('student_id', $student_id);
        $result=$this->db->delete('students');
        
         if($result){
           $message['message']='Successfully Deleted Student Info';     
        }else{
            $message['message']='An error occurred while inserting data';     
        }
          echo json_encode($message);
           
       }
        
    }
}