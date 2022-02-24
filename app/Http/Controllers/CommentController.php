<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function save_comment(Request $request){
        $request->validate([
            'name' => 'required|max:12',
            'comment' => 'required|min:10|max:150'
        ]);

        
        $data = $request->all();

        $comment = new Comment();
        $comment->product_id = $data['product_id'];
        $comment->name = $data['name'];
        $comment->comment = $data['comment'];
        $comment->status = 1;
        $comment->save();

        return redirect()->back()->with('msg', 'Thank you! Your review is being processed!');
    }

    public function list_comment(){
        return view('admin.list_comment');
    }

    public function comment_approval_ajax(Request $request){
        if($request->ajax()){
            $comment_status = $request->input('comment_status');
            $comment_id = $request->input('comment_id');

            $data = Comment::find($comment_id);
            $data->status = $comment_status;
            $data->save();

            if($comment_status == 0){
                $result ='<input type="button" comment_status="1" comment_id="'.$comment_id.'" class="btn-group btn-success btn-group-sm btn-comment" value="Approved">';

                // $val = [];
                // $val['val'] = $result;
                // echo json_encode($val);

                echo json_encode($result);
            }else{
                $result ='<input type="button" comment_status="0" comment_id="'.$comment_id.'" class="btn-group btn-warning btn-group-sm btn-comment" value="Unapproved">';

                // $val = [];
                // $val['val'] = $result;
                // echo json_encode($val);

                echo json_encode($result);
            }
        }
    }

    public function comment_search_ajax(Request $request){
        if($request->ajax()){
            $query = $request->get('query');
            if($query != ''){
                $data = Comment::where('comment','like','%'.$query.'%')->orderby('id','descd')->get();
            }else{
                $data = Comment::orderby('id','desc')->get();
            }

            $result = '';
            $dataCount = $data->count();
            if($dataCount > 0){
                foreach($data as $comment){
                    $result .='
                    <tr>
                        <td>';

                        if($comment->status == 0){
                            $result .= '<input type="button" comment_status="1" comment_id="'.$comment->id.'" class="btn-group btn-success btn-group-sm btn-comment" value="Approved">';
                        }else{
                            $result .= '<input type="button" comment_status="0" comment_id="'.$comment->id.'" class="btn-group btn-warning btn-group-sm btn-comment" value="Unapproved">';
                        }
                        
                        $result .='</td>
                        <td>'.$comment->name.'</td>
                        <td>'.$comment->comment.'</td>
                        <td><a href="'.url('/product-detail/'.$comment->product_id).'" target="_blank">link-product-'.$comment->product_id.'</a></td>
                        <td>
                            <!-- Edit and Delete buttons -->
                            <!-- <a href="" class="btn btn-primary">Edit</a> -->
                            <a onclick="return confirm(\'Do you want to delete?\')" href="'.route('custdelete',$comment->id).'" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>';
                }
            }else{
                $result = '
                <tr> 
                    <td align="center" colspan="5" class="fs-5 text-danger" >No data is found!!!</td>
                </tr>
            ';
            }

            $data = [];
            $data['data'] = $result;

            echo json_encode($data);
        }
    }


}
