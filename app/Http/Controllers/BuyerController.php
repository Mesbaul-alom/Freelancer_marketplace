<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\buyer;
use App\Models\Bid;
use App\Models\Contest;
use Illuminate\Http\Request;
use App\Http\Requests\BuyerContestRequest;
use App\Http\Requests\BuyerProjectRequest;
use Validator;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req){
       
         return view('buyer.index');
             }
  public function dashboard(Request $req){
       
 return view('buyer.index');
             
   }
   
    
    public function profile(){
        $id = session('id');
         $users=User::where('id',$id)->first();
        return view('buyerProfile.index')->with('users',$users);
             
   }

     public function postProject(Request $req){
       $buyers = Buyer::all();
       return view('buyer.postproject')->with('buyers',$buyers);
   //     return view('buyer.postproject');
             
   }
public function store_project(BuyerProjectRequest $req){
    
  
    $newImageName=time().'-'.$req->name.'.'.$req->contest_file->extension();
    $test=$req->contest_file->move(public_path('protfolio_img'),$newImageName);
    $buyer=new Buyer;
    $buyer->contest_file=$newImageName;
    $buyer->title=$req->title;
    $buyer->price=$req->price;
    $buyer->description=$req->description;
    $buyer->time=$req->time;
    $id = session('id');
    $buyer->buyer_id=$id;
    $buyer->save();
 
     return redirect('/Buyer/postProject');  
 
 }



 public function postproject_details($id)
   {
        $buyer = Buyer::find($id);
   
        return view('buyer.postproject_details')->with('buyer',$buyer);
   }
   public function postproject_edit($id){
 
  $buyerProject = Buyer::find($id);
    return view('buyer.postproject_edit')->with('buyerProject', $buyerProject);
  }

  public function postproject_update(BuyerProjectRequest $req, $id){

    /*Accept all version*/
  $validation = Validator::make($req->all(), [
    'title' => 'required',
    'contest_file'=> 'required|mimes:jpeg,png,jpg,pdf',
    'price'=>'required',
    'time'=>'required',
     'description'=>'required'
  ]);

  if($validation->fails()){
         return back()
                   ->with('errors',$validation->errors())
                   ->withInput();              
    
  }


  
    $buyer = Buyer::find($id);
    $newImageName=time().'-'.$req->name.'.'.$req->contest_file->extension();
    $test=$req->contest_file->move(public_path('protfolio_img'),$newImageName);
    $buyer->contest_file=$newImageName;
    $buyer->title=$req->title;
    $buyer->price=$req->price;
    $buyer->description=$req->description;
    $buyer->time=$req->time;
    $id = session('id');
    $buyer->buyer_id=$id;
    $buyer->save();
    return view('buyer.postproject_details')->with('buyer', $buyer);
  }

  public function postcontest_details($id)
   {
        $contest = Contest::find($id);
   
        return view('buyer.postcontest_details')->with('contest',$contest);
   }

     public function postContest(Request $req){
      
       $contests = Contest::all();
       return view('buyer.postcontest')->with('contests',$contests);
       
   }

 public function store_contest(BuyerContestRequest $req){
    

    $newImageName=time().'-'.$req->name.'.'.$req->contest_file->extension();
    $test=$req->contest_file->move(public_path('protfolio_img'),$newImageName);
    $contest=new Contest;
    $contest->contest_file=$newImageName;
    $contest->title=$req->title;
    $contest->price=$req->price;
    $contest->description=$req->description;
    $contest->time=$req->time;
    $id = session('id');
    $contest->buyer_id=$id;
    $contest->save();
 
     return redirect('/Buyer/postContest');  
 
 }
 public function postcontest_edit($id){
 
  $buyerContest =Contest::find($id);
  return view('buyer.postcontest_edit')->with('buyerContest', $buyerContest);
}

public function postcontest_update(BuyerContestRequest $req, $id){

 
  /*Accept all version*/
  $validation = Validator::make($req->all(), [
    'title' => 'required',
    'contest_file'=> 'required|mimes:jpeg,png,jpg,pdf',
    'price'=>'required',
    'time'=>'required',
     'description'=>'required'
  ]);

  if($validation->fails()){
         return back()
                   ->with('errors',$validation->errors())
                   ->withInput();              
    // return redirect()->route('buyer.postcontest')->with('errors', $validation->errors());
  }
    /*Accept all version*/

  $contest =Contest::find($id);
  $newImageName=time().'-'.$req->name.'.'.$req->contest_file->extension();
  $test=$req->contest_file->move(public_path('protfolio_img'),$newImageName);
  $contest->contest_file=$newImageName;
  $contest->title = $req->title;
  $contest->price = $req->price;
  $contest->description = $req->description;
  $contest->time = $req->time;
  $contest->save();
  return view('buyer.postcontest_details')->with('contest', $contest);
 
}
          
   public function bidlist(Request $req){
        $buyers = Buyer::all();

     return view('buyer.bidlist')->with('buyers',$buyers);
          
   }
   public function bidlist_details($id)
   { 
        $buyerProject = Buyer::find($id);
        return view('buyer.bidlist_details')->with('buyerProject', $buyerProject);
   } 
    public function seller_bidingproject()
    {
          $bids = Bid::all();
       return view('buyer.seller_bidingproject')->with('bids',$bids);

    } 
   public function contestlist(Request $req){
       $contests = Contest::all();
     return view('buyer.contestlist')->with('contests',$contests);
          
   }
    public function contestlist_details($id)
    { 
         $buyerContest = Contest::find($id);
         
         return view('buyer.contestlist_details')->with('buyerContest',$buyerContest);
    } 
 public function download(Request $req,$file)
    {
        return response()->download(public_path('protfolio_img/'.$file));
    }
   
}
