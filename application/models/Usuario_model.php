<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }
  function login($usuario, $password){
    $this->db->where('username',$usuario);
    $this->db->where('password',$password);
    $consulta = $this->db->get('usuario'); //get solo porque estamos consultando un solo valor
    if ($consulta->num_rows()>0){
      $consulta = $consulta->row();
      $this->session->set_userdata('usuario',$consulta->username);
      $this->session->set_userdata('tipo',$consulta->tipo);
      $this->session->set_userdata('nombre',$consulta->nombre);
      $this->session->set_userdata('ci',$consulta->cod_usuario);
      $this->session->set_userdata('parroquia','1');
      $this->session->set_userdata('religiosa','2');
      $this->session->set_userdata('educacion','3');
      $this->session->set_userdata('salud','4');
      $this->session->set_userdata('proteccion','5');
      $this->session->set_userdata('comunicacion','6');
      $this->session->set_userdata('encuentros','7');
      $this->session->set_userdata('administrativa','8');
      $this->session->set_userdata('movilidad','9');
      $this->session->set_userdata('productiva','10');
      $this->session->set_userdata('penitenciaria','11');
      return true;
    }
    else
    {
      return false;
    }
  }
  function guardar($data){
    $this->db->insert('usuario',$data);
    if ($this->db->affected_rows() > 0 ) {
      return true;
    }
    else {
      return false;
    }

  }

  function getCantidad(){
  $this->db->select('*');
    $this->db->from('obras_datos');
    return $this->db->get()->num_rows();
  }
  function cantidadObrasJurisdiccion(){
  $query = $this->db->query("SELECT b.sede, COUNT(b.sede) AS Cantidad
  FROM obras_datos a, sede_episcopal b
  WHERE b.cod_sede = a.cod_jurisdiccion
  GROUP BY b.sede;");
    return $query->result_array();
  }

  function datoUsuario($ci){
    $this->db->where('cod_usuario',$ci);
			$venta = $this->db->get('usuario');
			if ($venta -> num_rows() > 0) {
					foreach ($venta->result() as $key ) {
							$datos[] = $key;
					}
					return $datos;
			}
  }

  function getUsuarios(){
    $this->db->select('*');
    $this->db->from('usuario');
  return $query = $this->db->get()->result();
    }


    function getById($ci){
        $this->db->where('cod_usuario',$ci);
        $this->db->limit(1);
        return $this->db->get('usuario')->row();
    }

    function delete($a) {
    $this->db->delete('usuario', array('cod_usuario' => $a));
    return;
  }

  function edit($a) {
    $d = $this->db->get_where('usuario', array('cod_usuario' => $a))->row();
    return $d;
  }

  function update($cod_usuario) {
    $cod_usuario = $this->input->post('cod_usuario');
    $nombre = $this->input->post('nombre');
    $apellido = $this->input->post('apellido');
    $fecha_nacimiento = $this->input->post('fecha_nacimiento');
    $foto = $this->input->post('foto');
    $telefono = $this->input->post('telefono');
    $email = $this->input->post('email');
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $tipo = $this->input->post('tipo');
    $data1 = array(
      'nombre' => $nombre,
      'apellido' => $apellido,
      'fecha_nacimiento' => $fecha_nacimiento,
      'foto' => $foto,
      'telefono' => $telefono,
      'email' => $email,
      'username' => $username,
      'password' => $password,
      'tipo' => $tipo
      
    );
    $this->db->where('cod_usuario', $cod_usuario);
    $this->db->update('usuario', $data1);
  }
  function datoUsuario1($id){
      $this->db->select('usuario.*');
      $this->db->from('usuario');
      $this->db->where('cod_usuario',$id);
      return $query = $this->db->get()->result();



    }




}
