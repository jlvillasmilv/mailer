<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{Mail, Addressee};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\MailRequest;

use Yajra\DataTables\Facades\DataTables;

use Auth;

class MailController extends Controller
{
    /**
        * @author Jorge Villasmil.
        *
        *Controller CRUD send mail
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('mails.index')) {
            return abort(401);
        }

        return view('mails.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('mails.create')) {
            return abort(401);
        }

        return view('mails.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MailRequest $request)
    {
        if (! Gate::allows('mails.create')) {
            return abort(401);
        }

        $mail = new Mail;
        $mail->fill($request->all());
        $mail->user_id = auth()->user()->id;
        $mail->save();

        $addressee = Addressee::updateOrCreate(
                ['email'     => $request->input('email'),
                 'user_id'   => auth()->user()->id,
                ]
            );

        $mail->mailAddress()->sync($addressee->id);

        $details = [
            'id'      => $mail->id,
            'subject' => $mail->subject,
            'body'    => $mail->body,
        ];
        //send mail
        \Mail::to($addressee)->send(new \App\Mail\UserMail($details));

        $notification = array(
            'message'    => 'Correo enviado!',
            'alert_type' => 'success',);

            \Session::flash('notification', $notification);

        return view('mails.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (! Gate::allows('mails.show')) {
            return abort(401);
        }

        $mail = Mail::where([
            ['id', $id],
            ['user_id', auth()->user()->id]
        ])->firstorfail();
        
        return view('mails.show', compact('mail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(Mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mail $mail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mail $mail)
    {
        if (! Gate::allows('mails.destroy')) {
            return abort(401);
        }

        Mail::findOrFail($id)->delete();
        return response(null, 204);
    }

    /**
        * @author Jorge Villasmil.
        *
        * buld query data for datatble view
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
    */
    public function table(Request $request)
    {
        $query = Mail::where('user_id','=', Auth::user()->id);

        return Datatables::of($query)->addColumn('action', function ($dat) {

            return ' <a href="'.route("mails.show", $dat->id).'" class="btn btn-sm btn-primary"><i class="fas fa-eye" title="Show: '.$dat->name.'"></i></a>
                <button class="btn btn-sm btn-danger btn-delete" title="delete '.$dat->name.'" data-remote="'.route("mails.destroy", $dat->id).'"><i class="far fa-trash-alt"></i></button> ';
        })
        ->editColumn('created_at', function ($mail){
            return date('d-m-y H:m', strtotime($mail->created_at) );
        })
        ->editColumn('status', function ($mail){
            return $mail->status == 0 ? 'Por enviar' : 'enviado';
        })
        ->filterColumn('created_at', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(mails.created_at,'%m/%d/%y') like ?", ["%$keyword%"]);
        })
        ->addColumn('email', function ($mail) {
            return $mail->mailAddress->map(function($address) {
                return $address->email;
            })->implode('<br>');
        })
        ->rawColumns(['action','email'])
        ->make(true);
    }
}
