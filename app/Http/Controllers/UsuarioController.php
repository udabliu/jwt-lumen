<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UsuarioController extends Controller
{

  protected $jwt;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(JWTAuth $jwt)
  {
    $this->jwt = $jwt;
  }

  public function usuarioLogin(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email|max:255',
      'login' => 'required'
    ]);

    if (! $token = $this->jwt->attempt($request->only('email', 'password'))) 
    {
      return response()->json(['usuario não encontrado'], 404);
    }
    else {
      return response()->json(compact('token'));
    }
  }

  public function mostrarTodosUsuarios()
  {
    return response()->json(Usuario::all());
  }

  public function cadastrarUsuario(Request $request)
  {
    //validaçao
    $this->validate($request, [
      'usuario' => 'required|min:5|max:40',
      'email' => 'required|email|unique:usuarios,email',
      'password' => 'required|min:5'
    ]);

    //inserindo usuario
    //criei um array onde setei as mensagens 
    $return = [
      "código" => 500,
      "status" => false,
      "data" => [],
      "message" => ""
    ];

    $usuario = new Usuario();
    $usuario->email = $request->email;
    $usuario->usuario = $request->usuario;
    $usuario->password = Hash::make($request->password);

    //SALVAR registro no bd

    if ($usuario->save()) {

      $return = [
        "código" => 200,
        "status" => true,
        "data" => [],
        "message" => "dados inseridos com sucesso!"
      ];
    } else {
      $return["message"] = "Erro ao salvar dados";
    }
    return response()->json($return);
  }



  public function mostrarUmUsuario($id)
  {
    return response()->json(Usuario::find($id));
  }


  public function atualizarUsuario($id, Request $request)
  {
    //pega o usuario do banco
    $usuario = Usuario::find($id);

    $usuario->email = $request->email;
    $usuario->usuario = $request->usuario;
    $usuario->password = $request->password;

    $usuario->save();

    return response()->json($usuario);
  }

  public function deletarUsuario($id)
  {
    $usuario = Usuario::find($id);

    $usuario->delete();

    return response()->json("dado deletado com sucesso");
  }



  //
}
