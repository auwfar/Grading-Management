<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Grade;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $grades = DB::select('select * from grades');

        $scores = array();
        $scores[0] = 0;
        $scores[1] = 0;
        $scores[2] = 0;
        $scores[3] = 0;

        foreach($grades as $grade) {
            $averageScore = ($grade->quiz_score + $grade->task_score + $grade->presence_score + $grade->practice_score + $grade->exam_score) / 5;

            if ($averageScore <= 65) {
                $scores[3] += 1;
                $grade->result = 'D';
            } elseif ($averageScore <= 75) {
                $scores[2] += 1;
                $grade->result = 'C';
            } elseif ($averageScore <= 85) {
                $scores[1] += 1;
                $grade->result = 'B';
            } else {
                $scores[0] += 1;
                $grade->result = 'A';
            }
        }
        return view('home', ['grades' => $grades, 'scores' => $scores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'quiz_score' => 'required|integer|min_digits:0|max_digits:100',
            'task_score' => 'required|integer|min_digits:0|max_digits:100',
            'presence_score' => 'required|integer|min_digits:0|max_digits:100',
            'practice_score' => 'required|integer|min_digits:0|max_digits:100',
            'exam_score' => 'required|integer|min_digits:0|max_digits:100'
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return redirect('/')->withInput()->with('failed', $validator->errors()->first());
        } else {
            $data = $request->input();
            try{
                $grade = new Grade;
                $grade->student_name = $data['name'];
                $grade->quiz_score = $data['quiz_score'];
                $grade->task_score = $data['task_score'];
                $grade->presence_score = $data['presence_score'];
                $grade->practice_score = $data['practice_score'];
                $grade->exam_score = $data['exam_score'];
                $grade->save();
                return redirect('/')->with('success', "Data nilai Mahasiswa berhasil diinputkan");
            } catch(Exception $e){
                return redirect('/')->with('failed', "Input nilai Mahasiswa gagal !");
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
