<?php

namespace App\Http\Controllers\Performance;

use App\GoalType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class GoalTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
            // $goal_types = GoalType::select('id','goal_type')->orderBy('id','DESC')->get();
            $goal_types = GoalType::orderBy('id','DESC')->get();
            return DataTables::of($goal_types)
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

    public function store(Request $request)
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

    public function edit(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = GoalType::find($request->goal_type_id);

            return view('performance.goal-type.show-data',compact('data'));
        }
        
    }

    public function update(Request $request)
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

    public function delete(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = GoalType::find($request->goal_type_id);
            $data->delete();

            return response()->json(['success' => '<p><b>Data Deleted Successfully.</b></p>']);
        }
    }
}
