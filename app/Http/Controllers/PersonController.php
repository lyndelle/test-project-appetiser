<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$name = $request->get('name');
		$age = $request->get('age');
		
		$person = new Person;
		$path = 'api/person/search';
		if($name) {
			$person = $person->search($name);
			$path .= '?name='.$name;
		}
		
		if(is_numeric($age)) {
			$person = $person->wherAge($age);
		 
			if($name) {
				$path .= '&age='.$age;
			} else {
				$path .= '?age='.$age;
			}
		}
		
		if(!$name && !is_numeric($age)) {
			$person->orderBy('id', 'desc');
		}
		
		return $person->paginate(3)->setPath($path);

       // return Person::paginate(3);
		// return response(Person::all()->jsonSerialize(), Response::HTTP_OK);
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
     
	   $person = new Person([
			'first_name' => $request->get('first_name'),
			'last_name'  => $request->get('last_name'),
			'birthday'   => \Carbon\Carbon::parse($request->get('birthday'))->format('Y-m-d')
		]);
		
		$person->save();
		
		return ''; //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Person::findOrFail($id);
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
    public function  update(Request $request, $id)
    {
         $person = Person::findOrFail($id);
		 $person->first_name = $request->get('first_name');
		 $person->last_name = $request->get('last_name');
		 $person->birthday = \Carbon\Carbon::parse($request->get('birthday'))->format('Y-m-d');
		 
		 $person->save();
         return $person;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();
        return '';
    }
}
