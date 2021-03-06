<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class YajraController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = User::take(1000)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" onclick="getEditUserData('. $data->id .')" data-id="' . $data->id . '">Edit</a>
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="deleteUserData(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function editData($id)
    {
        $user = new User;
        $data = $user::find($id);

        $html = '<div class="form-group">
                    <label for="Title">User Name:</label>
                    <input type="text" class="form-control" name="name" id="editName" value="' . $data->name . '">
                    <input type="hidden" class="form-control" id="editId" value="' . $data->id . '">
                </div>';
        return response()->json(['html' => $html]);
    }


    public function updateData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->update();
        return response()->json(['success' => 'User updated successfully']);
    }


    public function deleteData($id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json(['success' => 'User deleted successfully']);
    }


}
