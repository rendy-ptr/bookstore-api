<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Validator;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request)
    {
    // Validasi input
    $validator = Validator::make($request->all(), [
        'nik_tmu' => 'required',
        'name_tmu' => 'required',
        'role_tmu' => 'required|in:admin,user',
        'username_tmu' => 'required|email|unique:tbl_m_user,username_tmu',
        'password_tmu' => 'required|min:8',
        'created_by_tmu' => 'required'
        // 'email_validate' => 'required|email'
    ]);

    if ($validator->fails()) {
        return messageError($validator->messages()->toArray());
    }
    $user = $validator->validated();

    // Buat pengguna baru
    User::create($user);

    return response()->json([
        "data" => [
            'msg' => "Berhasil Register Melalui Admin",
            'nama' => $user['name_tmu'],
            'email' => $user['username_tmu'],
            'role' => $user['role_tmu'],
        ]
    ],200);
    }

    public function show_register() {

        $users = User::where('role_tmu','user')->get();

        return response()->json([
            "data" => [
                'msg' => "user registrasi",
                'data' => $users
            ]
        ],200);
    }

    public function show_register_by_id($id) {
        $user = User::where('id_tmu', $id)->first();
        return response()->json([
            "data" => [
                'msg' => "user dengan id: {$id}",
                'data' => $user
            ]
        ],200);
    }

    public function update_register(Request $request, $id) {
        $user = User::where('id_tmu', $id)->first();

        if($user) {
            $validator = Validator::make($request->all(),[
                'nik_tmu' => 'required',
                'name_tmu' => 'required',
                'role_tmu' => 'required|in:admin,user',
                'username_tmu' => 'required|email|unique:tbl_m_user,username_tmu',
                'password_tmu' => 'required|min:8',
                'created_by_tmu' => 'required'
            ]);
            if($validator->fails()) {
                return messageError($validator->messages()->toArray());
            }
            $data = $validator->validated();

            $data['password_tmu'] = Hash::make($data['password_tmu']);

            User::where('id_tmu',$id)->update($data);

            return response()->json([
                'data' => [
                    "msg" => "user dengan id: {$id} berhasil di update",
                    'nama' => $data['name_tmu'],
                    'email' => $user['username_tmu'],
                    'role' => $data['role_tmu'],
                ]
            ],200);
        }
        return response()->json([
            "data" => [
                'msg' => "user dengan id: {$id}, tidak ditemukan"
            ]
        ],422);
    }

    public function delete_register($id) {
        $user = User::where('id_tmu', $id)->first();
    
        if ($user) {
            $user->delete();
            return response()->json([
                "data" => [
                    'msg' => "User dengan id {$id}, berhasil dihapus"
                ]
            ], 200);
        }
    
        return response()->json([
            "data" => [
                'msg' => "User dengan id {$id}, tidak ditemukan"
            ]
        ], 422);
    }

    public function activation_account($id) {
        $user = User::find($id);

        if($user) {
            User::where('id_tmu', $id)->update(['status_deactive_tmu' => '0']);

            return response()->json([
                "data" => [
                    'msg' => 'user dengan id '.$id.' berhasil di aktifkan'
                ]
            ],200);
        }
        return response()->json([
            "data" => [
                'msg' => 'user dengan id '.$id.' tidak ditemukan'
            ]
        ],422);
    }
    
    public function deactivation_account($id) {
        $user = User::find($id);

        if($user) {
            User::where('id_tmu', $id)->update(['status_deactive_tmu' => '1']);

            return response()->json([
                "data" => [
                    'msg' => 'user dengan id '.$id.' berhasil di nonaktifkan'
                ]
            ],200);
        }
        return response()->json([
            "data" => [
                'msg' => 'user dengan id '.$id.' tidak ditemukan'
            ]
        ],422);
    }

    public function notdeleted_account($id) {
        $user = User::find($id);

        if($user) {
            User::where('id_tmu', $id)->update(['status_deleted_tmu' => '0']);

            return response()->json([
                "data" => [
                    'msg' => 'user dengan id '.$id.' berhasil tidak dihapus dari database'
                ]
            ],200);
        }
        return response()->json([
            "data" => [
                'msg' => 'user dengan id '.$id.' tidak ditemukan'
            ]
        ],422);
    }

    public function deleted_account($id) {
        $user = User::find($id);

        if($user) {
            User::where('id_tmu', $id)->update(['status_deleted_tmu' => '1']);

            return response()->json([
                "data" => [
                    'msg' => 'user dengan id '.$id.' berhasil di hapus dari database'
                ]
            ],200);
        }
        return response()->json([
            "data" => [
                'msg' => 'user dengan id '.$id.' tidak ditemukan'
            ]
        ],422);
    }


    // BAGIAN CREATE BOOK


    public function create_book(Request $request) {

        $validator = Validator::make($request->all(),[
            'name_book_tmb' => 'required|max:255',
            'price_book_tmb' => 'required',
            'picture_book_tmb' => 'required|mimes:png,jpg,jpeg|max:2048',
            'stock_tmb' => 'required'
        ]);
        if($validator -> fails()) {
            return messageError($validator->messages()->toArray());
        }

        $thumbnail = $request->file('picture_book_tmb');
        $filename = now()->timestamp."_".$request->picture_book_tmb->getClientOriginalName();
        $thumbnail->move('uploads',$filename);

        $bookData = $validator->validated();

        $book = Book::create([
            'name_book_tmb' => $bookData['name_book_tmb'],
            'price_book_tmb' => $bookData['price_book_tmb'],
            'picture_book_tmb' => 'uploads/'.$filename,
            'stock_tmb' => $bookData['stock_tmb']
        ]);

        return response()->json([
            "data" => [
                "msg" => "Buku Berhasil Disimpan",
                "buku" => $bookData['name_book_tmb']
            ]
        ]);
    }

    public function update_book(Request $request, $id) {
        $validator = Validator::make($request->all(),[
            'name_book_tmb' => 'required|max:255',
            'price_book_tmb' => 'required',
            'picture_book_tmb' => 'required|mimes:png,jpg,jpeg|max:2048',
            'stock_tmb' => 'required'
        ]);

        if($validator -> fails()) {
            return messageError($validator->messages()->toArray());
        }

        $thumbnail = $request->file('picture_book_tmb');
        $filename = now()->timestamp."_".$request->picture_book_tmb->getClientOriginalName();
        $thumbnail->move('uploads',$filename);

        $bookData = $validator->validated();

        Book::where('id_tmb', $id)->update([
            'name_book_tmb' => $bookData['name_book_tmb'],
            'price_book_tmb' => $bookData['price_book_tmb'],
            'picture_book_tmb' => 'uploads/'.$filename,
            'stock_tmb' => $bookData['stock_tmb']
        ]);

        return response()->json([
            "data" => [
                "msg" => "resep berhasil di update",
                "buku" => $bookData['name_book_tmb']
            ]
        ],200);
    }

    public function delete_book($id) {
        Book::where('id_tmb', $id)->delete();

        return response()->json([
            "data" => [
                "msg" => "buku berhasil dihapus",
                "buku_id" => $id
            ]
        ],200);
    }

    public function status_activation_book($id) {
        $books = Book::find($id);

        if($books) {
            Book::where('id_tmb', $id)->update(['status_deactive_tmb' => '0']);

            return response()->json([
                "data" => [
                    'msg' => 'buku dengan id '.$id.' berhasil di aktifkan'
                ]
            ],200);
        }
        return response()->json([
            "data" => [
                'msg' => 'buku dengan id '.$id.' tidak ditemukan'
            ]
        ],422);
    }

    public function status_deactive_book($id) {
        $books = Book::find($id);

        if($books) {
            Book::where('id_tmb', $id)->update(['status_deactive_tmb' => '1']);

            return response()->json([
                "data" => [
                    'msg' => 'buku dengan id '.$id.' berhasil di nonaktifkan'
                ]
            ],200);
        }
        return response()->json([
            "data" => [
                'msg' => 'buku dengan id '.$id.' tidak ditemukan'
            ]
        ],422);
    }


}
