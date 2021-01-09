<?php

namespace App\Http\Controllers;

use App\company;
use App\designation;
use App\GoalType;
use App\Indicator;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PerformanceController extends Controller
{
    /*
    |----------------------------------------------------------
    | Goal Type
    |----------------------------------------------------------
    */
    public function indexGoalType(Request $request)
    {
        if ($request->ajax()) 
        {
            // $goal_types = GoalType::select('id','goal_type')->orderBy('id','DESC')->get();
            $goal_types = GoalType::orderBy('id','DESC')->get();
            return Datatables::of($goal_types)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" name="edit" data-id="'.$row->id.'" class="edit btn btn-success btn-sm">Edit</a> 
                                &nbsp;
                                <a href="javascript:void(0)" name="delete" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('performance.goal-type.index');
    }

    public function storeGoalType(Request $request)
    {
        if ($request->ajax()) 
        {
            $validator = Validator::make($request->only('goal_type'),
                            [ 'goal_type' => 'required|unique:goal_types']
                        );
            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $goal_type = new GoalType();
            $goal_type->goal_type = $request->goal_type;
            $goal_type->save();

            return response()->json(['success' => '<p><b>Data Saved Successfully.</b></p>']);
        }
    }

    public function editGoalType(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = GoalType::find($request->goal_type_id);

            return view('performance.goal-type.show-data',compact('data'));
        }
        
    }

    public function updateGoalType(Request $request)
    {

        if ($request->ajax()) 
        {
            $data = GoalType::find($request->goal_type_id);

            $validator = Validator::make($request->only('goal_type'),[ 
                            'goal_type' => 'required|unique:goal_types,goal_type,'.$data->id
                        ]);
            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            
            $data->goal_type = $request->goal_type;
            $data->update();

            return response()->json(['success' => '<p><b>Data Updated Successfully.</b></p>']);
        }
    }

    public function deleteGoalType(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = GoalType::find($request->goal_type_id);
            $data->delete();

            return response()->json(['success' => '<p><b>Data Deleted Successfully.</b></p>']);
        }
    }

    /*
    |----------------------------------------------------------
    | Goal Tracking
    |----------------------------------------------------------
    */

    public function indexGoalTracking()
    {

        return view('performance.goal-tracking.index');
    }

    /*
    |----------------------------------------------------------
    | Indicator
    |----------------------------------------------------------
    */

    public function indexIndicator(Request $request)
    {
        if ($request->ajax())
        {
            // $indicators = DB::table('indicators')
            //             ->join('designations','designations.id','=','indicators.designation_id')
            //             ->join('companies','companies.id','=','indicators.company_id')
            //             ->join('departments','departments.id','=','indicators.department_id')
            //             ->select('designations.designation_name','companies.company_name','departments.department_name','indicators.id','indicators.added_by','indicators.created_at')
            //             ->get();

            // $indicators = Indicator::with('designation','company','department')->get();
            $indicators = Indicator::with('designation:id,designation_name','company:id,company_name','department:id,department_name')->get();

            return Datatables::of($indicators)
                ->addIndexColumn()
            //------
                ->addColumn('designation_name', function ($row)
                {
                    return $row->designation->designation_name ?? ' ' ;
                })
                ->addColumn('company_name', function ($row)
                {
                    return $row->company->company_name ?? ' ' ;
                })
                ->addColumn('department_name', function ($row)
                {
                    return $row->department->department_name ?? '';
                })
            //-----
                ->addColumn('created_at', function ($row)
                {
                    return date("d M, Y", strtotime($row->created_at));
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" name="edit" data-id="'.$row->id.'" class="edit btn btn-success btn-sm">Edit</a> 
                                &nbsp;
                                <a href="javascript:void(0)" name="delete" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $companies = company::select('id','company_name')->get();

        return view('performance.indicator.index',compact('companies'));
    }

    public function getDesignationByComapny(Request $request)
    {
        if ($request->ajax()) 
        {
            $designations = designation::where('company_id',$request->company_id)
                                        ->orderBy('designation_name','ASC')
                                        ->get();
            return view('performance.indicator.get-designation',compact('designations'));
        }
    }

    public function storeIndicator(Request $request)
    {
        if ($request->ajax()){

            $validator = Validator::make($request->only('company_id','designation_id'),[ 
                            'company_id' => 'required',
                            'designation_id' => 'required'
                        ]);
            if ($validator->fails()){
                return response()->json(['errors' => "<b>Please fill the required Option</b>"]);
            }

            $designation = designation::find($request->designation_id);

            $indicator = new Indicator();
            $indicator->company_id     = $request->company_id;
            $indicator->designation_id = $designation->id;
            $indicator->department_id  = $designation->department->id;
            $indicator->customer_experience  = $request->customer_experience;
            $indicator->marketing      = $request->marketing;
            $indicator->administrator  = $request->administrator;
            $indicator->professionalism= $request->professionalism;
            $indicator->integrity      = $request->integrity;
            $indicator->attendance     = $request->attendance;
            $indicator->added_by       = Auth::user()->username;
            $indicator->save();

            return response()->json(['success' => '<p><b>Data Saved Successfully.</b></p>']);
        }
    }

    public function editIndicator(Request $request)
    {
        // return response()->json($request->indicator_id);
        $indicator = Indicator::find($request->indicator_id);
        $companies = company::all();

        return view('performance.indicator.show-data',compact('indicator','companies'));
    }

    public function updateIndicator(Request $request)
    {
        if ($request->ajax()) {
            $indicator = Indicator::find($request->indicator_id);
            $indicator->company_id     = $request->company_id;
            $indicator->designation_id = $request->designation_id;
            $indicator->customer_experience = $request->customer_experience;
            $indicator->marketing      = $request->marketing;
            $indicator->administrator  = $request->administrator;
            $indicator->professionalism= $request->professionalism;
            $indicator->integrity      = $request->integrity;
            $indicator->attendance     = $request->attendance;
            $indicator->update();

            return response()->json(['success' => '<p><b>Data Updated Successfully.</b></p>']);
        }
        
    }

    public function deleteIndicator(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = Indicator::find($request->indicator_id);
            $data->delete();

            return response()->json(['success' => '<p><b>Data Deleted Successfully.</b></p>']);
        }
    }

    /*
    |----------------------------------------------------------
    | Appraisal
    |----------------------------------------------------------
    */

    public function indexAppraisal()
    {
        // return view('performance.goal-type.index');
    }
}
