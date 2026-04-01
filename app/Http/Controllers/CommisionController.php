<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CommisionController extends Controller
{
    public function getAllCommission(){
        return view('backend.commission.all');
            }

        public function getAllCommissionData(){
                $Commission = Commission::all();
                return json_encode(['data' => $Commission]);
        }

        public function getaddCommission(){
            return view('backend.commission.add');
        }

        public function editCommission($id){
            $cat = Commission::find($id);
            return view('backend.commission.edit',compact('cat'));
        }

        public function postEdit(Request $request, $id){
            $cat = Commission::find($id);
            $cat->percentage = $request->c_name;
            $cat->save();
            if ($cat) {
                Session::flash('success','Commission Updated Successfully!');
                return redirect('admin/commission/all');
               }

               else{
                Session::flash('failure','Something Went Wrong');
                return redirect('admin/commission/all');
               }

        }

        public function postAddCommission(Request $request){
            $cat  = new Commission();
            $cat->percentage  = $request->c_name;
            $cat->save();
            if ($cat) {
                Session::flash('success','Commission Added Successfully!');
                return redirect('admin/commission/all');
               }

               else{
                Session::flash('failure','Something Went Wrong');
                return redirect('admin/commission/all');
               }


        }
}
