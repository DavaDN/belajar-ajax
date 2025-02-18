<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    // Menampilkan data dalam bentuk JSON
    public function index() {
        $data = Data::all();
        return response()->json($data);
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Data::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Data saved successfully']);
    }
    public function destroy($id) {
        $data = Data::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => 'Data not found'], 404);
    }
}
