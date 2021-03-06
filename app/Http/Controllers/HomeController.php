<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;


class HomeController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->middleware('auth');
        $data = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>12]);
        $data2 = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>2]);
        $data3 = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>3]);
        $data4 = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>4]);
        $data5 = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>5]);
        $data6 = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>8]);
        $data7 = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>7]);
        $data8 = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>8]);
        $post2 = DB::select('select * from post');
        return view('home',compact('data','data2','data3','data4','data5','data6','data7','data8','post2'));
    }

    public function activity8(){
        $this->middleware('auth');
        $act = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>8]);
        $area = DB::select('select DISTINCT tick_price,type from program_seat where prog_id=:prog_id',['prog_id'=>8]);
        $user = Auth::user();
        $wallet = $user->wallet;
        return view('activity8',compact('act','area'));


    }

    // public function pay2(){
    //     $this->middleware('auth');
    //     $user = Auth::user();
    //     $wallet = $user->wallet;
    //     $act = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>8]);
    //     $area = DB::select('select tick_price, type, owner_id from program_seat where ticket_id=:ticket_id',['ticket_id'=>1]);
    //     return view('payment-step2',compact('act','area', 'wallet'));
    // }

    // public function updateOwner(){
    //     $this->middleware('auth');
    //     $user = Auth::user();
    //     // $wallet = $user->wallet;
    //     // $this->validate($request, ['wallet' => 'required']);
    //     // $area = DB::select('select tick_price, type, owner_id, status from program_seat where ticket_id=:ticket_id',['ticket_id'=>1]);
    //     $owner_id = $_POST["wallet"];
    //     DB::update('update program_seat set owner_id=?, status=\'sold\' where ticket_id=1',[(string)$owner_id]);
    //     // $area.save();
    // }

    // public function pay3(){
    //     $this->middleware('auth');
    //     $user = Auth::user();
    //     $wallet = $user->wallet;
    //     $act = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>8]);
    //     $area = DB::select('select tick_price, type from program_seat where ticket_id=:ticket_id',['ticket_id'=>1]);
    //     DB::table('program_seat')->where('ticket_id', 1)->update(['owner_id' => $wallet, 'status' => 'sold']);
    //     return view('payment-step3',compact('act','area'));
    // }

    public function personalorder(){
        $this->middleware('auth');
        $user = Auth::user();
        $id = $user->identity;
        $order = DB::select('select * from program_seat where owner_id=:owner_id',['owner_id'=>$id]);
        return view('order',compact('order'));
    }

    // public function resale(){
    //     $this->middleware('auth');
    //     $act = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>8]);
    //     $area = DB::select('select tick_price, type from program_seat where ticket_id=:ticket_id',['ticket_id'=>1]);
    //     $user = Auth::user();
    //     $wallet = $user->wallet;
    //     return view('resale-step1',compact('act','area'));
    // }

    // public function resale2(Request $request){
    //     $this->middleware('auth');
    //     $act = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>8]);
    //     $area = DB::select('select tick_price, type, owner_id from program_seat where ticket_id=:ticket_id',['ticket_id'=>1]);
    //     $user = Auth::user();
    //     $wallet = $user->wallet;
    //     return view('resale-step2',compact('act','area', 'wallet'));
    // }

    // public function resale3(){
    //     $this->middleware('auth');
    //     $user = Auth::user();
    //     $wallet = $user->wallet;
    //     $act = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>8]);
    //     $area = DB::select('select tick_price, type from program_seat where ticket_id=:ticket_id',['ticket_id'=>1]);
    //     DB::table('program_seat')->where('ticket_id', 1)->update(['owner_id' => $wallet, 'status' => 'sold']);
    //     return view('resale-step3',compact('act','area'));
    // }

    public function orders() {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $act = DB::select('select * from program where prog_id=:prog_id',['prog_id'=>8]);
        $area = DB::select('select * from program_seat where owner_id=?', [$wallet]);
        return view('orders',compact('act','area'));
    }

    public function buyOneTicket(Request $request) {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $progName = $request->input('prog_name');
        $act = DB::select('select * from program where prog_name=?',[$progName]);
        $section = DB::select('SELECT section FROM program WHERE prog_name=?',[$progName]);
        $check = DB::select('SELECT owner_id FROM program_seat WHERE prog_name=?', [$progName]);
        foreach($check as $checkStatus) {
            if ($checkStatus->owner_id == $user->wallet) {
                echo '<script>alert(\'您已擁有此票券\');</script>';
                return redirect()->back();
            }
        }
        // $var = is_string($section) ? 'Yes' : 'No';
        $section = (array)$section[0];
        $section = json_encode($section);
        $section = json_decode($section);
        $section = $section->{'section'};
        $sections = explode(",", $section);
        $sectionSize = sizeof($sections);
        foreach($act as $p) {
            $prog_id = $p->prog_id;
        }
        // $seat = DB::select('SELECT * FROM program_seat WHERE prog_name=?',[$progName]);
        // foreach($seat as $p) {
        //     if ($p->status != "sold" && $p->status != "resale") {
        //         $ticket_id = $p->ticket_id;
        //         $prog_id = $p->prog_id;
        //         $area = DB::select('select tick_price, type from program_seat where ticket_id=?',[$p->ticket_id]);
        //         break;
        //     } else {
        //         echo "<p>票已售罄</p>";
        //     }
        // }
        return view('payment-step1', compact('act', 'prog_id', 'sections', 'sectionSize'));
    }

    public function payment(Request $request) {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $prog_id = $request->input('prog_id');
        $section = $request->input('section');
        $act = DB::select('SELECT * FROM program WHERE prog_id=?',[$prog_id]);
        $seat = DB::select('SELECT * FROM program_seat WHERE prog_id=:prog_id AND section=:section',['prog_id'=>$prog_id, 'section'=>$section]);
        foreach($seat as $p) {
            if ($p->status != "sold" && $p->status != "resale") {
                $ticket_id = $p->ticket_id;
                $area = DB::select('select * from program_seat where ticket_id=?',[$ticket_id]);
                break;
            } else {
                echo "<p>票已售罄</p>";
            }
        }
        return view('payment-step2',compact('act','area', 'wallet', 'ticket_id', 'prog_id', 'section'));
    }

    public function updateOwner(Request $request) {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $ticket_id = $_POST['ticket_id'];
        $prog_id = $_POST['prog_id'];
        $act = DB::select('select * from program where prog_id=?',[$prog_id]);
        $area = DB::select('select * from program_seat where ticket_id=?',[$ticket_id]);
        DB::table('program_seat')->where('ticket_id', $ticket_id)->update(['owner_id' => $wallet, 'status' => 'sold']);
        return view('payment-step3', compact('act', 'area', 'wallet'));
    }

    public function resaleTicket(Request $request) {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $ticket_id = $request->input('ticket_id');
        $prog_id = $request->input('prog_id');
        $act = DB::select('select * from program where prog_id=?',[$prog_id]);
        $area = DB::select('select tick_price, type, section from program_seat where ticket_id=?',[$ticket_id]);
        $check = DB::select('SELECT owner_id, status FROM program_seat WHERE prog_id=?', [$prog_id]);
        foreach($check as $checkStatus) {
            if ($checkStatus->owner_id == $user->wallet && $checkStatus->status == 'sold') {
                echo '<script>alert(\'您已擁有此票券\');</script>';
                return redirect()->back();
            }
        }
        foreach($area as $p) {
            $price = $p->tick_price * 1.05;
        }
        return view('resale-step1', compact('act', 'area', 'ticket_id', 'prog_id', 'price'));
    }

    public function resalePayment(Request $request) {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $ticket_id = $request->input('ticket_id');
        $prog_id = $request->input('prog_id');
        $act = DB::select('select * from program where prog_id=?',[$prog_id]);
        $area = DB::select('select tick_price, type, owner_id, section from program_seat where ticket_id=?',[$ticket_id]);
        foreach($area as $p) {
            $price = $p->tick_price * 1.05;
            $orginalPrice = $p->tick_price;
            $fee = $p->tick_price * 0.05;
        }
        return view('resale-step2',compact('act','area', 'wallet', 'ticket_id', 'prog_id', 'price', 'orginalPrice', 'fee'));
    }

    public function changeOwner(Request $request) {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $ticket_id = $_POST['ticket_id'];
        $prog_id = $_POST['prog_id'];
        $act = DB::select('select * from program where prog_id=?',[$prog_id]);
        $area = DB::select('select * from program_seat where ticket_id=?',[$ticket_id]);
        DB::table('program_seat')->where('ticket_id', $ticket_id)->update(['owner_id' => $wallet, 'status' => 'sold']);
        DB::table('ledger')->where('ticket_id', $ticket_id)->update(['buyer' => $wallet]);
        foreach($area as $p) {
            $price = $p->tick_price * 1.05;
            $orginalPrice = $p->tick_price;
            $fee = $p->tick_price * 0.05;
        }
        return view('resale-step3', compact('act', 'area', 'wallet', 'price', 'orginalPrice', 'fee'));
    }

    public function resaleProcess(Request $request) {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $ticket_id = $_GET['ticket_id'];
        $prog_id = $_GET['prog_id'];
        $act = DB::select('select * from program where prog_id=?',[$prog_id]);
        $area = DB::select('select tick_price, type, section, tick_seat from program_seat where ticket_id=?',[$ticket_id]);
        foreach($area as $p){
            $price = $p->tick_price * 0.95;
        }
        return view('resaleProcess', compact('act', 'area', 'wallet', 'price', 'ticket_id', 'prog_id'));
    }

    public function resaleUpdate(Request $request) {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $ticket_id = $_POST['ticket_id'];
        $area = DB::select('select * from program_seat where ticket_id=?',[$ticket_id]);
        foreach($area as $p){
            DB::table('ledger')->insert(
                ['eventType' => '轉售',
                'ticket_id' => $ticket_id,
                'seller' => $p->owner_id,
                'amount' => $p->tick_price,
                'prog_id' => $p->prog_id,
                'date' => date("Y/m/d")
                ]
            );
        }
        DB::table('program_seat')->where('ticket_id', $ticket_id)->update(['status' => 'resale']);
        echo ("<script LANGUAGE='JavaScript'>
          window.location.replace('./orders');
          window.alert('此票券已發佈到二手票券中！');
        </script>");
    }

    // public function buyingTicket()
    // {
    //     $this->middleware('auth');
    //     // $user = Auth::user();
    //     // $email = $user->email;
    //     $emailQuery = DB::table('users') -> select('email') -> where('identity', '=', 'A789456123') -> get();
    //     $email = $emailQuery[0]->email;
    //     return view('buyingTicket')->with('email', $email);
    // }

    //confirm Ticket
    public function confirmTicket()
    {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        // $programQuery = DB::table('users')->where('wallet', $wallet)->select('program');
        $programQuery =  DB::select('select program from users where wallet = ? ', [$wallet]);
        if ($programQuery[0]->program == NULL){
            echo ("<script LANGUAGE='JavaScript'>
           window.location.replace('./home');
           window.alert('你憑什麼Confirm???');
         </script>");
        }
        // if(sizeof($programQuery) == 0){
        //     echo ("<script LANGUAGE='JavaScript'>
        //   window.location.replace('./home');
        //   window.alert('你憑什麼Confirm???');
        // </script>");
        //     // return view('home');
        // }
        // else{
        //     echo ("<script LANGUAGE='JavaScript'>
        //   window.alert('fuck you');
        // </script>");
        // }
        $program = $programQuery[0]->program;
        $seats = DB::select('select * from program_seat where owner_id=:owner_id and prog_name=:prog_name', ['owner_id' => '', 'prog_name' => '輔大音樂會']);
        
        $price = DB::select('select tick_price from program_seat where prog_name = ?', [$program]);
        foreach ($price as $amount) {
            if ($amount->tick_price != 0) {
                $price = $amount->tick_price;
                $price = intval($price);
            }
        }
        return view('confirmTicket', compact('wallet', 'program', 'seats', 'price'));
    }

    //buyticket blade
    public function buyTicket()
    {
        $this->middleware('auth');
        $user = Auth::user();
        $wallet = $user->wallet;
        $ownerFromDB = DB::select('SELECT owner_id FROM program_seat WHERE owner_id!="" AND prog_name=:prog_name', ['prog_name' => "輔大音樂會"]);
        $identityFromQuery = DB::select('SELECT identity FROM users WHERE wallet =? ',[$wallet]);
        $identity = $identityFromQuery[0]->identity;
        foreach ($ownerFromDB as $wal) {
            if ($wal->owner_id == $wallet) {
                echo "<script type=\"text/javascript\">alert(\"您已有此表演的票了\");</script>";
                return redirect('home');
            }
        }
        return view('/buyTicket', compact('wallet','identity'));
    }

    //confirm blade
    public function getTicket()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        $seat = $_POST['tick_seat'];
        $prog = $_POST['program'];
        DB::table('program_seat')->where('prog_name', $prog)->where('tick_seat', $seat)->update(['owner_id' => $wallet, 'status' => 'sold']);
        DB::table('users')->where('wallet', $wallet)->update(['program'=>NULL]);
        return view('home');
    }
}
