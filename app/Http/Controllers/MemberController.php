<?php

namespace App\Http\Controllers;

use App\Jobs\MemberDeleted;
use App\Jobs\MemberJob;
use App\Jobs\MemberUpdated;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\PDF;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.index');
    }

    public function data()
    {
        $member = Member::orderBy('kode_member')->get();

        return datatables()
            ->of($member)
            ->addIndexColumn()
            ->addColumn('select_all', function ($member) {
                return '
                    <input type="checkbox" class="form-check-input" name="id_member[]" value="' . $member->id_member . '">
                ';
            })
            ->addColumn('kode_member', function ($member) {
                return '<span class="badge bg-success">' . $member->kode_member . '</span>';
            })
            ->addColumn('aksi', function ($member) {
                return '
                <button type="button" onclick="editForm(`' . route('member.update', $member->id_member) . '`)" class="btn btn-primary"> <i class="bi bi-pencil-square"></i></button>
                <button type="button" onclick="deleteData(`' . route('member.destroy', $member->id_member) . '`)" class="btn btn-danger">  <i class="bi bi-trash"></i> </button>
                ';
            })
            ->rawColumns(['aksi', 'kode_member', 'select_all'])
            ->make(true);
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
    public function store(Request $request)
    {
        // $member = Member::latest()->first() ?? new Member();
        $member = Member::latest()->first() ?? new Member();
        $request['kode_member'] = 'M - ' . tambah_nol_didepan((int)$member->id_member + 1, 5);
        $member = Member::create($request->all());
        MemberJob::dispatch($member->toArray())->onQueue('master-pos');
        // $kode_member = (int) $member->kode_member + 1;

        // $member = new Member();
        // $member->kode_member = 'M - ' . tambah_nol_didepan($kode_member, 5);
        // $member->nama = $request->nama;
        // $member->telepon = $request->telepon;
        // $member->alamat = $request->alamat;
        // $member->save();


        return response()->json('Data Berhasil di Simpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::find($id);

        return response()->json($member);
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
        // $member = Member::find($id)->update($request->all());
        $member = Member::find($id);
        $member->nama = $request->nama;
        $member->telepon = $request->telepon;
        $member->alamat = $request->alamat;
        $member->update();

        MemberUpdated::dispatch($member->toArray())->onQueue('master-pos');

        return response()->json('Data berhasil di simpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $member = Member::find($id);
        // $member->delete();
        Member::destroy($id);
        MemberDeleted::dispatch($id)->onQueue('master-pos');
        return response(null, 204);
    }

    public function cetakMember(Request $request)
    {
        $datamember = collect(array());
        foreach ($request->id_member as $id) {
            $member = Member::find($id);
            $datamember[] = $member;
        }
        $datamember = $datamember->chunk(2);

        $setting = Setting::first();

        $no = 1;
        $pdf = PDF::loadView('member.cetak', compact('datamember', 'no', 'setting'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('member.pdf');
    }
}
