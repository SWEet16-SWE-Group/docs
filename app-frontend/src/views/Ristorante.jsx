import {useParams} from "react-router-dom";
import {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";

function fetch(id,set) {
  axiosClient.get(`/ristorante/${id}`).then(
    data => { set(data.data) }
  )
}

function Bottoneprenota(a){
  const url = (id) => `/formprenotazione/${id}`;
  const {role} = useStateContext();
  if (role === 'CLIENTE') {
    return (<Link to={url(a.id)}>Prenota</Link>);
  }else{
    return (<div></div>);
  }
}

function ristorante(a){
  const url = (id) => `/menu/${id}`;
  return (
    <div key={a.id}>
      <h1> {a.nome} </h1>
      <p> {a.indirizzo} </p>
      <p> {a.telefono} </p>
      <p> {a.orario} </p>
      <Link to={url(a.id)}> Menù </Link>
      {Bottoneprenota(a)}
    </div>
  );
}

export default function Ristorante() {
    const {id} = useParams();
    const [r,sr] = useState(null);
    useEffect(() => fetch(id,sr) ,[]);
    return (<div>{r && ristorante(r)}</div>)
}
